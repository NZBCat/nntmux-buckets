<?php

namespace NZBCat\UserBuckets\Tests\Unit;

use Spatie\Permission\Models\Role;
use NZBCat\UserBuckets\Models\BucketType;
use NZBCat\UserBuckets\Tests\TestCase;
use NZBCat\UserBuckets\Models\Bucket;
use NZBCat\UserBuckets\Tests\Models\User;
use Illuminate\Support\Arr;

class BucketTest extends TestCase
{

   /** @test */
   function a_bucket_belongs_to_an_owner()
   {
      // Given we have an author
      $owner = factory(User::class)->create();
      $bucketType = factory(BucketType::class)->create(['name' => 'VIP']);
      // And this author has a Post
      $owner->buckets()->create([
         'bucket_type_id' => $bucketType->id,
         'initial_days'  => 60,
         'days_left' => 30
      ]);

      $this->assertCount(1, Bucket::all());
      $this->assertCount(1, $owner->buckets);

      // Using tap() to alias $author->posts()->first() to $post
      // To provide cleaner and grouped assertions
      tap($owner->buckets()->first(), function ($bucket) use ($owner, $bucketType) {
         $this->assertEquals($bucketType->id, $bucket->bucket_type->id);
         $this->assertEquals(60, $bucket->initial_days);
         $this->assertEquals(30, $bucket->days_left);
         $this->assertTrue($bucket->owner->is($owner));
      });
   }

   /** @test */
   function an_owner_can_retrieve_the_active_bucket() {
      $owner = factory(User::class)->create();

      $primaryBucketType = factory(BucketType::class)->create(['weight' => 5]);
      $secondaryBucketType = factory(BucketType::class)->create(['weight' => 10]);

      $bucketOptions = [
         'owner_id' => $owner->id,
         'owner_type' => get_class($owner)
      ];

      $primaryBucket = factory(Bucket::class)->create( Arr::add($bucketOptions, 'bucket_type_id', $primaryBucketType->id));
      factory(Bucket::class)->create(Arr::add($bucketOptions, 'bucket_type_id', $secondaryBucketType->id));

      tap($owner->getActiveBucket(), function($bucket) use ($primaryBucket) {
         $this->assertTrue($bucket->is($primaryBucket),'Returned bucket does not match primary bucket');
         $this->assertGreaterThan(0, $bucket->initial_days);
      });

   }

   /** @test */
   function a_bucket_can_be_emptied_incrementally() {
      $bucket = factory(Bucket::class)->create();
      $initial_days = $bucket->initial_days;
      $days_left = $bucket->days_left;
      $intended_days_left = $days_left - 1;

      $bucket->consumeDay();

      $this->assertEquals($intended_days_left, $bucket->days_left);
      $this->assertEquals($initial_days, $bucket->initial_days);

   }

   /** @test */
   function a_bucket_is_deleted_when_empty() {
      $bucket = factory(Bucket::class)->create(['days_left' => 1]);

      $bucket->consumeDay();

      $this->assertSoftDeleted($bucket);

   }

   /** @test */
   function bucket_hand_off_happens() {
      $owner = factory(User::class)->create();

      $primaryBucketType = factory(BucketType::class)->create(['weight' => 5]);
      $secondaryBucketType = factory(BucketType::class)->create(['weight' => 10]);

      $bucketOptions = [
         'owner_id' => $owner->id,
         'owner_type' => get_class($owner),
         'days_left' => 1
      ];

      $primaryBucket = factory(Bucket::class)->create( Arr::add($bucketOptions, 'bucket_type_id', $primaryBucketType->id));
      $secondaryBucket = factory(Bucket::class)->create(Arr::add($bucketOptions, 'bucket_type_id', $secondaryBucketType->id));

      $primaryBucket->consumeDay();

      tap($owner->getActiveBucket(), function($bucket) use ($secondaryBucket) {
         $this->assertTrue($bucket->is($secondaryBucket),'Returned bucket does not match secondary bucket');
         $this->assertGreaterThan(0, $bucket->initial_days);
      });
   }

   /** @test */
   function the_proper_role_is_assigned() {
      $userRole = Role::findOrCreate('User');
      $owner = factory(User::class)->create(['role_id' => $userRole]);
      $vipRole = Role::findOrCreate('VIP');
      $contribRole = Role::findOrCreate('Contributor');

      $vipBucketType = factory(BucketType::class)->create([
         'name' => 'VIP',
         'weight' => 5,
         'role_granted' => $vipRole->id
      ]);
      $contribBucketType = factory(BucketType::class)->create([
         'name' => 'Contributor',
         'weight' => 10,
         'role_granted' => $contribRole->id
      ]);

      $bucketOptions = [
         'owner_id' => $owner->id,
         'owner_type' => get_class($owner),
         'days_left' => 1
      ];

      $vipBucket = factory(Bucket::class)->create( Arr::add($bucketOptions, 'bucket_type_id', $vipBucketType->id));
      $contribBucket = factory(Bucket::class)->create(Arr::add($bucketOptions, 'bucket_type_id', $contribBucketType->id));

      $owner->refresh();

      $this->assertEquals($vipRole->id, $owner->role_id, 'The proper role was not assigned');

      $owner->consumeActiveBucketDay();
      $owner->refresh();

      $this->assertEquals($contribRole->id, $owner->role_id, 'The contrib role was not applied');

      $contribBucket->consumeDay();
      $owner->refresh();

      $this->assertEquals($userRole->id, $owner->role_id, 'The default role was not applied');

   }
}