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
        Schema::table('form_responses', function (Blueprint $table) {
            $table->foreignId('snapshot_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->json('response');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('form_responses', function (Blueprint $table) {
            $table->dropForeign(['snapshot_id']);
            $table->dropColumn('snapshot_id');
            $table->dropColumn('response');
        });
    }
};
