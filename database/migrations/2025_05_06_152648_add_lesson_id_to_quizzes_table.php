<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::table('quizzes', function (Blueprint $table) {
        $table->foreignId('lesson_id')
              ->constrained()
              ->onDelete('cascade')
              ->after('id'); // ou après une autre colonne existante
    });
}

public function down(): void
{
    Schema::table('quizzes', function (Blueprint $table) {
        $table->dropForeign(['lesson_id']);
        $table->dropColumn('lesson_id');
    });
}

};
