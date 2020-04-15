<?php

namespace NZBCat\UserBuckets\Listeners;

use NZBCat\UserBuckets\Events\BucketWasDeleted;
use Spatie\Permission\Models\Role;

class DetachBucketTypeRole
{
   public function handle(BucketWasDeleted $event)
   {
      if ($event->isLastBucket) {
         $role = Role::findByName(config('userbuckets.fallback_role_name'));
         $event->bucket->owner()->update(['role_id' => $role->id]);
      } else {
         $activeBucket = $event->bucket->owner->getActiveBucket();
         $activeBucket->owner()->update(['role_id' => $activeBucket->bucket_type->role->id]);
      }
   }
}