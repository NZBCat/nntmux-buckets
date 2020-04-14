<?php

namespace NZBCat\UserBuckets\Traits;

use Illuminate\Database\Eloquent\Builder;
use NZBCat\UserBuckets\Models\Bucket;

trait HasBuckets
{
   public function buckets()
   {
      return $this->morphMany(Bucket::class, 'owner');
   }

   public function consumeActiveBucketDay() {
      return $this->getActiveBucket()->consumeDay();
   }

   public function getActiveBucket() {
      return $this->buckets()
         ->with('bucket_type')
         ->where(function (Builder $query) {
            return $query->where('days_left', '>', 0)
               ->orderBy('bucket_type.weight');
         })
         ->first();
   }
}