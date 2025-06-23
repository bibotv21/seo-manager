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
        Schema::create('text_links', function (Blueprint $table) {
            $table->id();
            $table->foreignId('domain_id')->constrained('domains');
            $table->foreignId('ctv_id')->constrained('ctv');
            $table->string('target_domain');
            $table->date('impl_date');
            $table->date('expired_date');
            $table->string('text_link_full')->nullable();
            $table->string('anchor_text');
            $table->bigInteger('amount');
            $table->boolean('status')->default(false);
            $table->string('rel_tag')->nullable();
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
        Schema::dropIfExists('text_links');
    }
};
