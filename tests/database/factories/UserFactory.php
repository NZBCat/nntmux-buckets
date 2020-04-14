<?php

namespace NZBCat\UserBuckets\Tets\Database\Factories;

use Faker\Generator as Faker;
use Spatie\Permission\Models\Role;
use NZBCat\UserBuckets\Tests\Models\User;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(User::class, function (Faker $faker) {
   static $password;

   $role = Role::findOrCreate('User');

   return [
      'name' => $faker->name,
      'email' => $faker->unique()->safeEmail,
      'password' => $password ?: $password = bcrypt('secret'),
      'remember_token' => $faker->name,
      'role_id' => $role->id
   ];
});