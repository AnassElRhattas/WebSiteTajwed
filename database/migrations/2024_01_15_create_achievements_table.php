<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('achievements', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description');
            $table->string('icon')->nullable();
            $table->timestamps();
        });

        // Insérer les achievements de base
        DB::table('achievements')->insert([
            [
                'id' => 1,
                'name' => 'Première leçon',
                'description' => 'Vous avez terminé votre première leçon',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'name' => 'Apprenti dévoué',
                'description' => 'Vous avez terminé 5 leçons',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('achievements');
    }
};