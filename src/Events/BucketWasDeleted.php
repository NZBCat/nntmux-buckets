<?php

namespace NZBCat\UserBuckets\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use NZBCat\UserBuckets\Models\Bucket;

class BucketWasDeleted
{
   use Dispatchable, SerializesModels;

   public $bucket;
   public $isLastBucket;

   public function __construct(Bucket $bucket)
   {
      $this->isLastBucket = (! $bucket->owner->getActiveBucket() instanceof Bucket);
      $this->bucket = $bucket;
   }
}