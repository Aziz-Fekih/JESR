<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dons', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('type_action'); // Particuler ou Association
            $table->string('nom'); // Nom du Particulier ou Nom de l'association.
            $table->string('prenom')->nullable();
            $table->text('description')->nullable();
            $table->boolean('motorise')->default(false);
            $table->boolean('accord_utss')->default(false);
            $table->integer('municipalite_id'); // Peut etre changer selon le niveau du filtre
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dons');
    }
}
