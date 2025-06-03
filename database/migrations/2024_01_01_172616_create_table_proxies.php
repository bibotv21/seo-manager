<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('proxies', function (Blueprint $table) {
            $table->id();
            $table->string('user_name')->nullable();
            $table->string('password')->nullable();
            $table->string('ip')->nullable();
            $table->string('port')->nullable();
            $table->string('is_usable')->default(0);
            $table->integer('number_request')->default(0);
            $table->string('provider')->nullable();            
            $table->timestamp('created_at')->default(now()->timezone('Asia/Bangkok'));
            $table->timestamp('updated_at')->nullable();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proxies');
    }
};
