<?php

namespace NZBCat\UserBuckets\Tests\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use NZBCat\UserBuckets\Traits\HasBuckets;

class User extends Model implements AuthorizableContract, AuthenticatableContract
{
   use HasBuckets, Authorizable, Authenticatable;

   protected $guarded = [];

}