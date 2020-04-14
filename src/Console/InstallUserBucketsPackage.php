<?php

namespace NZBCat\UserBuckets\Console;

use Illuminate\Console\Command;

class InstallUserBucketsPackage extends Command
{
   protected $signature = 'userbuckets:install';

   protected $description = 'Install the UserBuckets Package';

   public function handle()
   {
      $this->info('Installing UserBuckets...');

      $this->info('Publishing configuration...');

      $this->call('vendor:publish', [
         '--provider' => "NZBCat\UserBuckets\UserBucketsServiceProvider",
         '--tag' => "config"
      ]);

      $this->info('Installed UserBuckets');
   }
}