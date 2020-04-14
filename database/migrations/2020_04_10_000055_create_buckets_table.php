<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBucketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buckets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('bucket_type_id');
            $table->unsignedBigInteger('owner_id');
            $table->string('owner_type');
            $table->integer('initial_days');
            $table->integer('days_left');
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
        Schema::dropIfExists('buckets');
    }
}
