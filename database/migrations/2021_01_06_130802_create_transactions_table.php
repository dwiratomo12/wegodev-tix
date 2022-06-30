<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_id')->constrained('rooms');
            $table->string('nama_ruangan');
            $table->integer('nim');
            $table->string('nama_depan');
            $table->string('nama_belakang');
            $table->date('tanggal_pinjam');
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->string('unit_kerja');
            $table->longText('keterangan');
            $table->enum('status', ['proses', 'diterima', 'tidak diterima']);
            $table->softDeletes('deleted_at');
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
        Schema::dropIfExists('transactions');
    }
}