<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class imagens extends Migration
{
    public function up(): void
    {
        Schema::create('imagens', function (Blueprint $table) {
            $table->id(); // Usa id() para definir la clave primaria como bigIncrements
            $table->unsignedBigInteger('user_id'); // Asegúrate de que este campo exista y sea de tipo unsignedBigInteger
            $table->string('imagen');
            $table->string('titulo');
            $table->string('autor');
            $table->string('duracion');
            $table->string('url');
            $table->boolean('active')->nullable();
            $table->timestamps();

            // Definición de la clave foránea
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }
    public function down()
    {
        Schema::dropIfExists('imagens');
    }
}
