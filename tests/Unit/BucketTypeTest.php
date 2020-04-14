<?php

namespace NZBCat\UserBuckets\Tests\Unit;

use NZBCat\UserBuckets\Models\BucketType;
use NZBCat\UserBuckets\Tests\Models\User;
use NZBCat\UserBuckets\Tests\TestCase;
use NZBCat\UserBuckets\Models\Bucket;

class BucketTypeTest extends TestCase
{
   /** @test */
   function a_bucket_type_has_buckets()
   {
      $bucketType = factory(BucketType::class)->create();
      $user = factory(User::class)->create();
      $bucketType->buckets()->create([
         'initial_days'  => 60,
         'days_left' => 30,
         'owner_id' => $user->id,
         'owner_type' => get_class($user)
      ]);

      $this->assertCount(1, Bucket::all());
      $this->assertCount(1, $bucketType->buckets);

      tap($bucketType->buckets()->first(), function ($bucket) use ($bucketType) {
         $this->assertEquals($bucketType->id, $bucket->bucket_type->id);
         $this->assertEquals(60, $bucket->initial_days);
         $this->assertEquals(30, $bucket->days_left);
         $this->assertTrue($bucket->bucket_type->is($bucketType));
      });
   }
}