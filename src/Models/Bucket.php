<?php

namespace NZBCat\UserBuckets\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bucket extends Model
{
   use SoftDeletes;
   // Disable Laravel's mass assignment protection
   protected $guarded = [];

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