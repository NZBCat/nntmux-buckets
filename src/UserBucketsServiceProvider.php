<?php

namespace NZBCat\UserBuckets;

use Illuminate\Support\ServiceProvider;
use NZBCat\UserBuckets\Console\InstallUserBucketsPackage;
use NZBCat\UserBuckets\Models\Bucket;
use NZBCat\UserBuckets\Observers\BucketObserver;

class UserBucketsServiceProvider extends ServiceProvider
{
   public function register()
   {
      $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'userbuckets');
   }

   public function boot()
   {
      $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
      $this->loadFactoriesFrom(__DIR__.'/../database/factories');

      if ($this->app->runningInConsole()) {
         // publish config file
         $this->publishes([
            __DIR__.'/../config/config.php' => config_path('userbuckets.php'),
         ], 'config');
         $this->publishes([
            __DIR__.'/../database/seeds/' => database_path('seeds')
         ], 'seeds');
//         if (! class_exists('CreateBucketsTable')) {
//            $this->publishes([
//               __DIR__ . '/../database/migrations/create_buckets_table.php.stub' => database_path('migrations/' . date('Y_m_d_His', time()) . '_create_buckets_table.php'),
//               // you can add any number of migrations here
//            ], 'migrations');
//         }

         $this->commands([
            InstallUserBucketsPackage::class,
         ]);
      }

      Bucket::observe(BucketObserver::class);
   }
}