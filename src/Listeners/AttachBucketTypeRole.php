<?php

namespace NZBCat\UserBuckets\Listeners;

use NZBCat\UserBuckets\Events\BucketWasCreated;

class AttachBucketTypeRole
{
   public function handle(BucketWasCreated $event)
   {
      if ($event->isActiveBucket) {
         $event->bucket->owner()->update(['role_id' => $event->bucket->bucket_type->role_granted]);
      }
   }
}