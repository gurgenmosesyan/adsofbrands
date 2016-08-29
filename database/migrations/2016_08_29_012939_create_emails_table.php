<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Email\Email;

class CreateEmailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emails', function (Blueprint $table) {
            $table->increments('id');
            $table->string('to');
            $table->string('to_name');
            $table->string('from');
            $table->string('from_name');
            $table->string('reply_to');
            $table->string('subject');
            $table->longText('body');
            $table->timestamps();
            $table->enum('status', [Email::STATUS_PENDING, Email::STATUS_SENT, Email::STATUS_FAILED]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('emails');
    }
}
