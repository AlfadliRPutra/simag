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
        Schema::create('interns', function (Blueprint $table) {
            $table->id();
            $table->string('nim', 10);
            $table->string('nama', 40);
            $table->string('no_handphone', 15);
            $table->string('kampus', 255);
            $table->enum('jenis_kelamin', ['laki-laki', 'perempuan']);
            $table->string('foto', 255);
            $table->string('alamat', 255);
            $table->timestamps();

            // Define the foreign key constraint
            $table->foreign('nim')->references('id_pengguna')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('interns');
    }
};
