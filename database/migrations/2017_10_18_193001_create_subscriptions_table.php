<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->uuid('uuid');
            $table->primary('uuid');
            $table->integer('user_id')->unsigned();
            $table->integer('subscriptionable_id');
            $table->string('subscriptionable_type')->default('');
            $table->timestamps();
        });

        Schema::table('subscriptions', function (Blueprint $table) {
            $table->index(['user_id', 'uuid']);
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('CASCADE');
        });
    }
};
