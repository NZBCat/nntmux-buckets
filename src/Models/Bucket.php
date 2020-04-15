<?php

namespace NZBCat\UserBuckets\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use NZBCat\UserBuckets\Events\BucketWasCreated;
use NZBCat\UserBuckets\Events\BucketWasDeleted;
use NZBCat\UserBuckets\Events\BucketWasUpdated;

class Bucket extends Model
{
   use SoftDeletes;
   // Disable Laravel's mass assignment protection
   protected $guarded = [];

   protected $dispatchesEvents = [
      'created' => BucketWasCreated::class,
      'deleted' => BucketWasDeleted::class,
      'updated' => BucketWasUpdated::class
   ];

   public function bucket_type() {
      return $this->belongsTo(BucketType::class);
   }

   public function owner() {
      return $this->morphTo();
   }

   public function consumeDay($autoSave = true) {
      if ($this->days_left > 0) {
         $this->days_left -= 1;
         if ($autoSave) {
            $this->save();
         }
      }
      return $this;
   }

}