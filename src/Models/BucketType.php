<?php

namespace NZBCat\UserBuckets\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Models\Role;

class BucketType extends Model {

   use SoftDeletes;
   // Disable Laravel's mass assignment protection
   protected $guarded = [];

   public function buckets() {
      return $this->hasMany(Bucket::class);
   }

   public function role() {
      return $this->belongsTo(Role::class, 'role_granted');
   }
}