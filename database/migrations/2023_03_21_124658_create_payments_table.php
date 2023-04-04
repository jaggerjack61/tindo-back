<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('reference');
            $table->string('email');
            $table->string('status')->default('pending');
            $table->string('phone')->nullable();
            $table->float('amount',total: 12,places: 2)->default(0.00);
            $table->string('poll_url')->nullable();
            $table->string('redirect_url')->nullable();
            $table->string('paynow_reference')->nullable();
            $table->float('paynow_amount',total: 12,places: 2)->default(0.00);
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
        Schema::dropIfExists('payments');
    }
};
