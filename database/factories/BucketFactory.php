<?php

namespace NZBCat\UserBuckets\Database\Factories;

use NZBCat\UserBuckets\Models\Bucket;
use Faker\Generator as Faker;
use NZBCat\UserBuckets\Models\BucketType;
use NZBCat\UserBuckets\Tests\Models\User;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Bucket::class, function (Faker $faker) {

   $type = factory(BucketType::class)->create();
   $user = factory(User::class)->create();
   $initialDays = $faker->numberBetween(30,365);

   return [
      'bucket_type_id' => $type->id,
      'owner_id' => $user->id,
      'owner_type' => get_class($user),
      'initial_days' => $initialDays,
      'days_left' => $faker->numberBetween(30, $initialDays)
   ];
});