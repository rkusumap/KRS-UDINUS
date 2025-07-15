<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAllTables extends Migration
{
    public function up(): void
    {
        // Table: tahun_ajaran
        Schema::create('tahun_ajaran', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('kode')->unique();
            $table->string('tahun_awal');
            $table->string('tahun_akhir');
            $table->tinyInteger('jns_smt');
            $table->boolean('set_aktif');
            $table->tinyInteger('biku_tagih_jenis')->default(0);
            $table->dateTime('update_time')->nullable();
            $table->string('update_id', 18)->nullable();
            $table->string('update_host', 18)->nullable();
            $table->dateTime('added_time')->nullable();
            $table->string('added_id', 18)->nullable();
            $table->string('added_host', 18)->nullable();
            $table->date('tgl_masuk')->nullable();
        });

        // Table: mahasiswa_dinus
        Schema::create('mahasiswa_dinus', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nim_dinus', 50)->default('')->unique();
            $table->integer('ta_masuk')->nullable();
            $table->string('prodi', 5)->nullable();
            $table->string('pass_mhs', 128)->nullable();
            $table->tinyInteger('kelas');
            $table->char('akdm_stat', 2);
        });

        // Table: tagihan_mhs
        Schema::create('tagihan_mhs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ta', 255);
            $table->string('nim_dinus', 50);
            $table->string('spp_bank', 11)->nullable();
            $table->tinyInteger('spp_bayar')->default(0);
            $table->dateTime('spp_bayar_date')->nullable();
            $table->integer('spp_dispensasi')->nullable();
            $table->string('spp_host', 25)->nullable();
            $table->tinyInteger('spp_status');
            $table->string('spp_transaksi', 20)->nullable();
            $table->unique(['nim_dinus', 'ta'], 'nim');

            $table->foreign('ta')->references('kode')->on('tahun_ajaran');
            $table->foreign('nim_dinus')->references('nim_dinus')->on('mahasiswa_dinus');
        });

        // Table: matkul_kurikulum
        Schema::create('matkul_kurikulum', function (Blueprint $table) {
            $table->integer('kur_id');
            $table->string('kdmk');
            $table->string('nmmk');
            $table->string('nmen');
            $table->enum('tp', ['T', 'P', 'TP']);
            $table->integer('sks');
            $table->smallInteger('sks_t');
            $table->smallInteger('sks_p');
            $table->integer('smt');
            $table->tinyInteger('jns_smt');
            $table->boolean('aktif');
            $table->string('kur_nama');
            $table->enum('kelompok_makul', ['MPK', 'MKK', 'MKB', 'MKD', 'MBB', 'MPB']);
            $table->boolean('kur_aktif');
            $table->enum('jenis_matkul', ['wajib', 'pilihan']);
        });

        // Table: hari
        Schema::create('hari', function (Blueprint $table) {
            $table->tinyInteger('id')->primary();
            $table->string('nama', 6);
            $table->string('nama_en', 20);
        });

        // Table: sesi_kuliah
        Schema::create('sesi_kuliah', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('jam', 11);
            $table->tinyInteger('sks')->default(0);
            $table->time('jam_mulai')->nullable();
            $table->time('jam_selesai')->nullable();
            $table->integer('status')->default(1);
            $table->unique(['jam_mulai', 'jam_selesai'], 'jam_unik');
        });

        // Table: sesi_kuliah_bentrok
        Schema::create('sesi_kuliah_bentrok', function (Blueprint $table) {
            $table->unsignedSmallInteger('id');
            $table->unsignedSmallInteger('id_bentrok');

            $table->primary(['id', 'id_bentrok']);
            $table->foreign('id')->references('id')->on('sesi_kuliah')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_bentrok')->references('id')->on('sesi_kuliah')->onDelete('cascade')->onUpdate('cascade');
        });

        // Table: jadwal_input_krs
        Schema::create('jadwal_input_krs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ta', 255);
            $table->char('prodi', 3);
            $table->dateTime('tgl_mulai');
            $table->dateTime('tgl_selesai');
        });

        // Table: ip_semester
        Schema::create('ip_semester', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ta', 255);
            $table->string('nim_dinus', 50);
            $table->integer('sks');
            $table->string('ips', 5);
            $table->dateTime('last_update')->nullable();

            $table->unique(['ta', 'nim_dinus'], 'nim');
            $table->foreign('ta')->references('kode')->on('tahun_ajaran');
            $table->foreign('nim_dinus')->references('nim_dinus')->on('mahasiswa_dinus');
        });

        // Table: ruang
        Schema::create('ruang', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama');
            $table->string('nama2')->default('-');
            $table->integer('id_jenis_makul')->nullable();
            $table->string('id_fakultas', 5)->nullable();
            $table->integer('kapasitas')->default(0);
            $table->integer('kap_ujian')->default(0);
            $table->tinyInteger('status')->default(1);
            $table->string('luas', 5)->default('0');
            $table->string('kondisi')->nullable();
            $table->integer('jumlah')->nullable();
        });

        // Table: jadwal_tawar
        Schema::create('jadwal_tawar', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ta')->default(0);
            $table->string('kdmk', 15);
            $table->string('klpk', 15);
            $table->string('klpk_2', 15)->nullable();
            $table->integer('kdds');
            $table->integer('kdds2')->nullable();
            $table->integer('jmax')->default(0);
            $table->integer('jsisa')->default(0);
            $table->tinyInteger('id_hari1');
            $table->tinyInteger('id_hari2');
            $table->tinyInteger('id_hari3');
            $table->integer('id_sesi1');
            $table->integer('id_sesi2');
            $table->integer('id_sesi3');
            $table->integer('id_ruang1');
            $table->integer('id_ruang2');
            $table->integer('id_ruang3');
            $table->tinyInteger('jns_jam');
            $table->boolean('open_class')->default(1);
        });

        // Table: krs_record
        Schema::create('krs_record', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ta', 10);
            $table->string('kdmk', 255);
            $table->integer('id_jadwal');
            $table->string('nim_dinus', 50);
            $table->char('sts', 1);
            $table->integer('sks');
            $table->tinyInteger('modul')->default(0);
            $table->tinyInteger('allow_uji')->default(0);
        });

        // Table: krs_record_log
        Schema::create('krs_record_log', function (Blueprint $table) {
            $table->integer('id_krs')->nullable();
            $table->string('nim_dinus', 50)->nullable();
            $table->string('kdmk', 255)->nullable();
            $table->tinyInteger('aksi')->nullable();
            $table->integer('id_jadwal')->nullable();
            $table->string('ip_addr', 50)->nullable();
            $table->timestamp('lastUpdate')->useCurrent();
        });

        // Table: daftar_nilai
        Schema::create('daftar_nilai', function (Blueprint $table) {
            $table->increments('_id');
            $table->string('nim_dinus', 50)->nullable();
            $table->string('kdmk', 20)->nullable();
            $table->char('nl', 2)->nullable();
            $table->tinyInteger('hide')->default(0);
        });

        // Table: validasi_krs_mhs
        Schema::create('validasi_krs_mhs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nim_dinus', 50);
            $table->dateTime('job_date')->nullable();
            $table->string('job_host')->nullable();
            $table->string('job_agent')->nullable();
            $table->integer('ta')->nullable();
        });

        // Table: mhs_ijin_krs
        Schema::create('mhs_ijin_krs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ta')->nullable();
            $table->string('nim_dinus', 50)->nullable();
            $table->tinyInteger('ijinkan')->nullable();
            $table->timestamp('time')->useCurrent();
            $table->unique(['ta', 'nim_dinus'], 'nim');
        });

        // Table: herregist_mahasiswa
        Schema::create('herregist_mahasiswa', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nim_dinus', 50)->nullable();
            $table->string('ta', 5)->nullable();
            $table->dateTime('date_reg')->nullable();
        });

        // Table: mhs_dipaketkan
        Schema::create('mhs_dipaketkan', function (Blueprint $table) {
            $table->string('nim_dinus', 50)->primary();
            $table->integer('ta_masuk_mhs');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mhs_dipaketkan');
        Schema::dropIfExists('herregist_mahasiswa');
        Schema::dropIfExists('mhs_ijin_krs');
        Schema::dropIfExists('validasi_krs_mhs');
        Schema::dropIfExists('daftar_nilai');
        Schema::dropIfExists('krs_record_log');
        Schema::dropIfExists('krs_record');
        Schema::dropIfExists('jadwal_tawar');
        Schema::dropIfExists('ruang');
        Schema::dropIfExists('ip_semester');
        Schema::dropIfExists('jadwal_input_krs');
        Schema::dropIfExists('sesi_kuliah_bentrok');
        Schema::dropIfExists('sesi_kuliah');
        Schema::dropIfExists('hari');
        Schema::dropIfExists('matkul_kurikulum');
        Schema::dropIfExists('tagihan_mhs');
        Schema::dropIfExists('mahasiswa_dinus');
        Schema::dropIfExists('tahun_ajaran');
    }
}
