<?php

namespace NZBCat\UserBuckets\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use NZBCat\UserBuckets\Events\BucketWasCreated;
use NZBCat\UserBuckets\Events\BucketWasDeleted;
use NZBCat\UserBuckets\Events\BucketWasUpdated;
use NZBCat\UserBuckets\Listeners\AttachBucketTypeRole;
use NZBCat\UserBuckets\Listeners\DeleteEmptyBucket;
use NZBCat\UserBuckets\Listeners\DetachBucketTypeRole;

class EventServiceProvider extends ServiceProvider
{

   protected $listen = [
      BucketWasCreated::class => [
         AttachBucketTypeRole::class,
      ],
      BucketWasDeleted::class => [
         DetachBucketTypeRole::class
      ],
      BucketWasUpdated::class => [
         DeleteEmptyBucket::class
      ]
   ];

   /**
    * Register any events for your application.
    *
    * @return void
    */
   public function boot()
   {
      parent::boot();
   }
}