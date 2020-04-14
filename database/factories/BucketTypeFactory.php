<?php

namespace NZBCat\UserBuckets\Database\Factories;

use NZBCat\UserBuckets\Models\BucketType;
use Faker\Generator as Faker;
use Spatie\Permission\Models\Role;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(BucketType::class, function (Faker $faker) {
   $role = Role::findOrCreate('User');

   return [
      'name' => $faker->word,
      'role_granted' => $role->id,
      'weight' => $faker->numberBetween(0,50)
   ];
});