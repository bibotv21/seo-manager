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
        Schema::create('redirect_action', function (Blueprint $table) {
            $table->id();
            $table->foreignId('from_domain_id')->constrained('domains');
            $table->foreignId('to_domain_id')->constrained('domains');
            $table->date('impl_date');
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
        Schema::dropIfExists('redirect_action');
    }
};
