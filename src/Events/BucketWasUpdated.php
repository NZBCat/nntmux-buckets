<?php

namespace NZBCat\UserBuckets\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use NZBCat\UserBuckets\Models\Bucket;

class BucketWasUpdated
{
   use Dispatchable, SerializesModels;

   public $bucket;

   public function __construct(Bucket $bucket)
   {
      $this->bucket = $bucket;
   }
}