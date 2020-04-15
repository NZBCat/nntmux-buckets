<?php

namespace NZBCat\Database\Seeds;

use Illuminate\Database\Seeder;
use NZBCat\UserBuckets\Models\BucketType;
use Spatie\Permission\Models\Role;

class BucketTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       // An example seeder class, update the roles as necessary for your application and run to create your
       // bucket types.
//       $vipRole = Role::findOrCreate('VIP');
//       $contribRole = Role::findOrCreate('Contributor');
//       $vipBucketOptions = [
//          'name' => 'VIP',
//          'role_granted' => $vipRole->id,
//          'weight' => 1
//        ];
//       $contribBucketOptions = [
//          'name' => 'Contributor',
//          'role_granted' => $contribRole->id,
//          'weight' => 5
//       ];
//
//       factory(BucketType::class)->create($vipBucketOptions);
//       factory(BucketType::class)->create($contribBucketOptions);
    }
}
