<?php

namespace NZBCat\UserBuckets\Listeners;

use NZBCat\UserBuckets\Events\BucketWasUpdated;

class DeleteEmptyBucket
{
   public function handle(BucketWasUpdated $event)
   {
      if ($event->bucket->days_left == 0) {
            $event->bucket->delete();
      }
   }
}