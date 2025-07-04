<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('text_links')->update(['target_domain' => DB::raw("LOWER(target_domain)")]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('text_links')->update(['target_domain' => DB::raw("LOWER(target_domain)")]);
    }
};
