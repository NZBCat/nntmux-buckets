<?php

namespace NZBCat\UserBuckets\Tests;

use NZBCat\UserBuckets\UserBucketsServiceProvider;
use Spatie\Permission\PermissionServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
   public function setUp(): void
   {
      parent::setUp();
      // additional setup
      $this->withFactories(__DIR__.'/../database/factories');
      $this->withFactories(__DIR__.'/database/factories');
      $this->artisan('vendor:publish', ['--provider' => 'Spatie\Permission\PermissionServiceProvider']);
      $this->artisan('migrate');
      $this->loadLaravelMigrations();
      $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
   }

   protected function getPackageProviders($app)
   {
      return [
         UserBucketsServiceProvider::class,
         PermissionServiceProvider::class
      ];
   }

   protected function getEnvironmentSetUp($app)
   {
      // perform environment setup
//      $app['config']->set('database.default', 'testing');
   }
}