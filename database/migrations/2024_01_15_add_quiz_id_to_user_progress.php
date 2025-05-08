<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('user_progress', function (Blueprint $table) {
            $table->foreignId('quiz_id')->nullable()->constrained()->onDelete('set null');
            $table->boolean('quiz_completed')->default(false);
            $table->integer('quiz_score')->nullable();
            $table->timestamp('quiz_completed_at')->nullable();
        });
    }

    public function down()
    {
        Schema::table('user_progress', function (Blueprint $table) {
            $table->dropForeign(['quiz_id']);
            $table->dropColumn(['quiz_id', 'quiz_completed', 'quiz_score', 'quiz_completed_at']);
        });
    }
};