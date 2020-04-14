<?php

namespace NZBCat\UserBuckets\Observers;

use Spatie\Permission\Models\Role;
use NZBCat\UserBuckets\Models\Bucket;

class BucketObserver
{
    /**
     * Handle the bucket "created" event.
     *
     * @param Bucket $bucket
     * @return void
     */
    public function created(Bucket $bucket)
    {
       $activeBucket = $bucket->owner->getActiveBucket();

        if ($bucket->is($activeBucket)) {
           $bucket->owner()->update(['role_id' => $bucket->bucket_type->role_granted]);
        }
    }

   /**
    * Handle the bucket "updated" event.
    *
    * @param Bucket $bucket
    * @return void
    * @throws \Exception
    */
    public function updated(Bucket $bucket)
    {
        if ($bucket->days_left == 0) {
           $bucket->delete();
        }
    }

    /**
     * Handle the bucket "deleted" event.
     *
     * @param  Bucket  $bucket
     * @return void
     */
    public function deleted(Bucket $bucket)
    {
       $activeBucket = $bucket->owner->getActiveBucket();

       if (! $activeBucket instanceof Bucket) {
          $role = Role::findByName(config('userbuckets.fallback_role_name'));
          $bucket->owner()->update(['role_id' => $role->id]);
       } else {
         $activeBucket->owner()->update(['role_id' => $activeBucket->bucket_type->role->id]);
       }
    }

    /**
     * Handle the bucket "restored" event.
     *
     * @param  Bucket  $bucket
     * @return void
     */
    public function restored(Bucket $bucket)
    {
        //
    }

    /**
     * Handle the bucket "force deleted" event.
     *
     * @param  Bucket  $bucket
     * @return void
     */
    public function forceDeleted(Bucket $bucket)
    {
        //
    }
}
