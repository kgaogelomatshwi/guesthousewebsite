<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pages', function (Blueprint $table): void {
            $table->longText('custom_html')->nullable()->after('seo_description');
            $table->longText('custom_css')->nullable()->after('custom_html');
            $table->longText('custom_js')->nullable()->after('custom_css');
        });
    }

    public function down(): void
    {
        Schema::table('pages', function (Blueprint $table): void {
            $table->dropColumn(['custom_html', 'custom_css', 'custom_js']);
        });
    }
};
