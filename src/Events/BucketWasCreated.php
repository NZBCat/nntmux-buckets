<?php

namespace NZBCat\UserBuckets\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use NZBCat\UserBuckets\Models\Bucket;

class BucketWasCreated
{
   use Dispatchable, SerializesModels;

   public $bucket;
   public $isActiveBucket;

   public function __construct(Bucket $bucket)
   {
      $this->isActiveBucket = ($bucket->is($bucket->owner->getActiveBucket()));
      $this->bucket = $bucket;
   }
}