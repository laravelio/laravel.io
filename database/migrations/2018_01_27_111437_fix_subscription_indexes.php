<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            if (DB::getDriverName() != 'sqlite') {
                $table->dropForeign('subscriptions_user_id_foreign');
            }
            $table->dropIndex(['user_id', 'uuid']);
            $table->index('uuid');
            $table->index('user_id');
            $table->unique('uuid');
            $table->unique(['user_id', 'subscriptionable_id', 'subscriptionable_type'], 'subscriptions_are_unique');
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('CASCADE');
        });
    }
};
