# nntmux-buckets
![PHP Composer](https://github.com/NZBCat/nntmux-buckets/workflows/PHP%20Composer/badge.svg)

This package will add a `HasBuckets` trait you can attach to your user model and gain access to the ability to assign flexible 
buckets to your users. For example, say you have:

* Role VIP grants 5000 api calls, 1000 downloads.
* Role Contrib grants 1000 api calls, 500 downloads.
* Role User (the default) grants 50 api calls, 5 downloads.

Now:

1. `UserA` buys 30 days of Contrib time.
2. 15 days into their Contrib time they decide they want to upgrade to VIP, what do? 

With the default system:

3. Either wait for the Contrib role to expire before adding the VIP one (a.k.a. you have to manage delayed upgrades) or 
upgrade immediately and lose the 15 days of Contrib time they paid for.

With this package:

3. `UserA` goes ahead and buys the 30 days of VIP time, a new `UserBucket` is created, their role is updated immediately and their
contrib time is safe and sound in it's own contrib bucket; waiting around quietly until the VIP bucket is emptied when it will become
active again.

The end state would be `UserA` having two UserBuckets, one for VIP with 30 days left, and one for Contrib with 15 days left. 

During bucket type creation you set the `weight` of the bucket type and the system will automatically consume the buckets 
1 day at a time starting with the **lowest weighted bucket type first**.

To make this package work all you need to do is include this in your composer.json file and add the `HasBuckets` trait to your
user model as well as updating the config to point to your default fallback user role that you want to set on your user
when they have no buckets left. This exposes the following methods:

* `User->consumeActiveBucketDay()`
* `User->getActiveBucket()`
* `User->buckets()`

This package also provides the factories necessary to create buckets and bucket types. I recommend setting up your bucket types
with a seeder as they do not change very often.

