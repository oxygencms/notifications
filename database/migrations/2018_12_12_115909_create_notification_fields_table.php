<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notification_fields', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('notification_id');
            $table->foreign('notification_id')
                ->references('id')
                ->on('notifications');

            $table->string('name')->nullable();
            $table->text('value')->nullable();
            $table->json('placeholders')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notification_fields');
    }
}
