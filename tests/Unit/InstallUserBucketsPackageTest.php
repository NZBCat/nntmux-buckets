<?php

namespace NZBCat\UserBuckets\Tests\Unit;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use NZBCat\UserBuckets\Tests\TestCase;

class InstallUserBucketsPackageTest extends TestCase
{
   /** @test */
   function the_install_command_copies_the_configuration()
   {
      // make sure we're starting from a clean state
      if (File::exists(config_path('userbuckets.php'))) {
         unlink(config_path('userbuckets.php'));
      }

      $this->assertFalse(File::exists(config_path('userbuckets.php')));

      Artisan::call('userbuckets:install');

      $this->assertTrue(File::exists(config_path('userbuckets.php')));
   }
}