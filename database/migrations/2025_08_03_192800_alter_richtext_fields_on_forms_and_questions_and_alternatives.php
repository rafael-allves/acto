<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('forms', function (Blueprint $table) {
            $table->longText('description')->change();
        });

        Schema::table('form_questions', function (Blueprint $table) {
            $table->longText('text')->change();
        });

        Schema::table('form_question_alternatives', function (Blueprint $table) {
            $table->longText('text')->change();
        });
    }

    public function down(): void
    {
        Schema::table('forms', function (Blueprint $table) {
            $table->string('description')->change();
        });

        Schema::table('form_questions', function (Blueprint $table) {
            $table->string('text')->change();
        });

        Schema::table('form_question_alternatives', function (Blueprint $table) {
            $table->string('text')->change();
        });
    }
};
