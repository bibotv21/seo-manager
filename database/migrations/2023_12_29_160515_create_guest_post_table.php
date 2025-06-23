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
        Schema::create('guest_posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('domain_id')->constrained('domains');
            $table->foreignId('ctv_id')->constrained('ctv');
            $table->string('target_domain');
            $table->date('impl_date');
            $table->boolean('status')->default(false);
            $table->bigInteger('amount');
            $table->string('source_link');
            $table->string('post_link');
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
        Schema::dropIfExists('guest_posts');
    }
};
