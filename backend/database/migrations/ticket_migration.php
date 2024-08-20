<?php
// database/migrations/xxxx_xx_xx_xxxxxx_create_tickets_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->string('platform');
            $table->string('subject');
            $table->string('status');
            $table->text('message');
            $table->timestamp('created_at')->useCurrent();
            $table->foreignId('created_by');
            $table->foreignId('updated_by');
        });
    }

    public function down()
    {
        Schema::dropIfExists('tickets');
    }
};