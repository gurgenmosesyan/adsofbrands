<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\Commercial\CommercialCreditPerson;

class CreateCommercialCreditPersons extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commercial_credit_persons', function (Blueprint $table) {
            $table->integer('credit_id')->unsigned();
            $table->enum('type', [
                CommercialCreditPerson::TYPE_CREATIVE,
                CommercialCreditPerson::TYPE_BRAND,
                CommercialCreditPerson::TYPE_AGENCY
            ]);
            $table->integer('type_id')->unsigned();
            $table->string('name');
            $table->string('separator', 5);
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
        Schema::drop('commercial_credit_persons');
    }
}
