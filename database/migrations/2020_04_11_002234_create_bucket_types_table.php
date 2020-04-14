<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBucketTypesTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('bucket_types', function (Blueprint $table) {
         $table->bigIncrements('id');
         $table->string('name');
         $table->integer('role_granted');
         $table->unsignedInteger('weight')->default(0);
         $table->timestamps();
         $table->softDeletes();
      });
   }

   /**
    * Reverse the migrations.
    *
    * @return void
    */
   public function down()
   {
      Schema::dropIfExists('bucket_types');
   }
}
