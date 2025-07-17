<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ResponseApi;
use App\Models\KrsRecord;
use App\Models\TahunAjaran;
use App\Models\JadwalTawar;
use App\Models\DaftarNilai;
use App\Models\MatkulKurikulum;
use App\Models\ValidasiKrsMhs;
use App\Models\IpSemester;
use DB;

use Carbon\Carbon;

class KRSController
{
    public function krs_current($nim) {

        $nim = md5($nim);

        if ($nim != auth('api')->user()->nim_dinus) {
            return response()->json(['error' => 'Unauthorized, Token expired or invalid'], 401);
        }

        $tahunAjaran = TahunAjaran::where('set_aktif','1')->first();

        $krs = KrsRecord::where('nim_dinus', $nim)->where('ta', $tahunAjaran->kode)->with('jadwal_tawar', 'matkul_kurikulum')->get();

        $response = array(
            'krs_record' => $krs
        );
        return ResponseApi::success($response);
    }

    public function courses_available($nim) {
        $nim = md5($nim);

        if ($nim != auth('api')->user()->nim_dinus) {
            return response()->json(['error' => 'Unauthorized, Token expired or invalid'], 401);
        }

        $prodi = auth('api')->user()->prodi;

        $perPage = request()->get('per_page', 50);
        $data = JadwalTawar::where('klpk','like', '%'.$prodi.'%')->where('open_class','1')->paginate($perPage);
        $responses  = $data->map(function ($response) use ($nim) {
                        $daftarNilai = DaftarNilai::where('nim_dinus',$nim)->where('kdmk',$response->kdmk)->first();
                        $add_permission = true;
                        if ($daftarNilai && $daftarNilai->nl == 'A') {
                            $add_permission = false;
                        }
                        return [
                            'id' => $response->id,
                            'ta' => $response->ta,
                            'kdmk' => $response->kdmk,
                            'klpk' => $response->klpk,
                            'klpk_2' => $response->klpk_2,
                            'kdds' => $response->kdds,
                            'kdds2' => $response->kdds2,
                            'jmax' => $response->jmax,
                            'jsisa' => $response->jsisa,
                            'id_hari1' => $response->id_hari1,
                            'id_hari2' => $response->id_hari2,
                            'id_hari3' => $response->id_hari3,
                            'id_sesi1' => $response->id_sesi1,
                            'id_sesi2' => $response->id_sesi2,
                            'id_sesi3' => $response->id_sesi3,
                            'id_ruang1' => $response->id_ruang1,
                            'id_ruang2' => $response->id_ruang2,
                            'id_ruang3' => $response->id_ruang3,
                            'jns_jam' => $response->jns_jam,
                            'open_class' => $response->open_class,
                            'add_permission' => $add_permission,

                            'matkul_kurikulum' => $response->matkul_kurikulum

                        ];
                    })
                    ;

        if (!empty($data)) {
            return ResponseApi::success([
                'list' => $responses, // Data transaksi yang sudah di-mapping

                'current_page' => $data->currentPage(),
                'last_page' => $data->lastPage(),
                'per_page' => $data->perPage(),
                'total' => $data->total(),
                'change_page' => '?page=number',
                'change_item_per_page' => '?per_page=number',
                'change_first_page' => '?page=1',
                'change_next_page' => '?page='.$data->currentPage() + 1,
                'change_last_page' => '?page='.$data->lastPage(),
            ], 'Success');
        } else {
            return ResponseApi::error('Error','Data Tidak ditemukan',404);
        }
    }

    public function krs_courses($nim){
        DB::beginTransaction();
        try {
            $nim = md5($nim);

            if ($nim != auth('api')->user()->nim_dinus) {
                DB::rollBack();
                return response()->json(['error' => 'Unauthorized, Token expired or invalid'], 401);
            }

            $prodi = auth('api')->user()->prodi;

            $idJadwal = request()->id_jadwal;

            $jadwalTawar = JadwalTawar::where('id', $idJadwal)->first();

            //apabila jadwal tidak ada
            if (!$jadwalTawar) {
                DB::rollBack();
                return ResponseApi::error('Error','Data Tidak ditemukan',404);
            }

            // apabila prodi tidak sesuai
            if (!str_contains($jadwalTawar->klpk, $prodi)) {
                DB::rollBack();
                return ResponseApi::error('Error','Prodi Tidak Sesuai',404);
            }

            // apabila kelas penuh
            if ($jadwalTawar->jsisa == 0) {
                DB::rollBack();
                return ResponseApi::error('Error','Kelas Penuh',404);
            }

            // apabila nilai sudah A
            $daftarNilai = DaftarNilai::where('nim_dinus',$nim)->where('kdmk',$jadwalTawar->kdmk)->first();
            if ($daftarNilai && $daftarNilai->nl == 'A') {
                DB::rollBack();
                return ResponseApi::error('Error','Nilai Sudah A, Tidak Bisa Mengambil Kelas',404);
            }

            // apabila krs sudah divalidasi
            $tahunAjaran = TahunAjaran::where('set_aktif','1')->first();
            $validasiKrsMhs = ValidasiKrsMhs::where('nim_dinus', $nim)->where('ta', $tahunAjaran->kode)->first();
            if ($validasiKrsMhs) {
                DB::rollBack();
                return ResponseApi::error('Error','KRS Sudah Divalidasi, Tidak Bisa Mengambil Kelas',404);
            }

            // jadwal sama
            $krsSama = KrsRecord::where('nim_dinus', $nim)->where('ta', $tahunAjaran->kode)->where('id_jadwal', $idJadwal)->first();
            if ($krsSama) {
                DB::rollBack();
                return ResponseApi::error('Error','KRS Sudah Ada, Tidak Bisa Mengambil Kelas',404);
            }

            //pengecekan hari dan sesi
            $krsRecords = KrsRecord::where('nim_dinus', $nim)->where('ta', $tahunAjaran->kode)->get();
            $arrayHariKrsRecord = array();
            $arraySesiKrsRecord = array();
            foreach ($krsRecords as $krsRecord) {
                if ($krsRecord->jadwal_tawar->id_hari1 != 0) {
                    $arrayHariKrsRecord[] = $krsRecord->jadwal_tawar->id_hari1;
                }
                if ($krsRecord->jadwal_tawar->id_hari2 != 0) {
                    $arrayHariKrsRecord[] = $krsRecord->jadwal_tawar->id_hari2;
                }
                if ($krsRecord->jadwal_tawar->id_hari3 != 0) {
                    $arrayHariKrsRecord[] = $krsRecord->jadwal_tawar->id_hari3;
                }

                if ($krsRecord->jadwal_tawar->id_sesi1 != 0) {
                    $arraySesiKrsRecord[] = $krsRecord->jadwal_tawar->id_sesi1;
                }
                if ($krsRecord->jadwal_tawar->id_sesi2 != 0) {
                    $arraySesiKrsRecord[] = $krsRecord->jadwal_tawar->id_sesi2;
                }
                if ($krsRecord->jadwal_tawar->id_sesi3 != 0) {
                    $arraySesiKrsRecord[] = $krsRecord->jadwal_tawar->id_sesi3;
                }
            }

            $arrayHariJadwalTawar = array();
            if ($jadwalTawar->id_hari1 != 0) {
                $arrayHariJadwalTawar[] = $jadwalTawar->id_hari1;
            }
            if ($jadwalTawar->id_hari2 != 0) {
                $arrayHariJadwalTawar[] = $jadwalTawar->id_hari2;
            }
            if ($jadwalTawar->id_hari3 != 0) {
                $arrayHariJadwalTawar[] = $jadwalTawar->id_hari3;
            }

            $arraySesiJadwalTawar = array();
            if ($jadwalTawar->id_sesi1 != 0) {
                $arraySesiJadwalTawar[] = $jadwalTawar->id_sesi1;
            }
            if ($jadwalTawar->id_sesi2 != 0) {
                $arraySesiJadwalTawar[] = $jadwalTawar->id_sesi2;
            }
            if ($jadwalTawar->id_sesi3 != 0) {
                $arraySesiJadwalTawar[] = $jadwalTawar->id_sesi3;
            }

            foreach ($arrayHariJadwalTawar as $valueHari) {
                if (in_array($valueHari, $arrayHariKrsRecord)) {
                    foreach ($arraySesiJadwalTawar as $valueSesi) {
                        if (in_array($valueSesi, $arraySesiKrsRecord)) {
                            DB::rollBack();
                            return ResponseApi::error('Error','KRS Bertabrakan, Tidak Bisa Mengambil Kelas',404);
                        }
                    }
                }
            }

            //insert ke krs_record
            $insertKrsRecord = KrsRecord::create([
                'ta' => $tahunAjaran->kode,
                'kdmk' => $jadwalTawar->kdmk,
                'id_jadwal' => $jadwalTawar->id,
                'nim_dinus' => $nim,
                'sts' => 'B',
                'sks' => $jadwalTawar->matkul_kurikulum->sks,
                'modul' => '0',
                'allow_uji'=> '0'
            ]);

            $idKrsRecord = $insertKrsRecord->id;

            // update jadwal tawar
            $updateJadwalTawar = JadwalTawar::where('id', $idJadwal)->first();
            $updateJadwalTawar->jsisa = $updateJadwalTawar->jsisa - 1;
            $updateJadwalTawar->save();

            // input record log
            DB::table('krs_record_log')->insert([
                'id_krs' => $idKrsRecord,
                'nim_dinus' => $nim,
                'kdmk' => $jadwalTawar->kdmk,
                'aksi'=> '1',
                'id_jadwal' => $jadwalTawar->id,
                'lastUpdate' => date('Y-m-d H:i:s')
            ]);

            $krs = KrsRecord::where('nim_dinus', $nim)->where('ta', $tahunAjaran->kode)->with('jadwal_tawar', 'matkul_kurikulum')->get();

            $response = array(
                'krs_record' => $krs
            );
            DB::commit();
            return ResponseApi::success($response);
        }catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return ResponseApi::validationError($e->errors());
        }
    }

    public function krs_courses_delete($nim, $schedule_id) {
        DB::beginTransaction();
        try {
            $nim = md5($nim);

            if ($nim != auth('api')->user()->nim_dinus) {
                return response()->json(['error' => 'Unauthorized, Token expired or invalid'], 401);
            }

            $tahunAjaran = TahunAjaran::where('set_aktif','1')->first();

            // apabila krs sudah divalidasi
            $validasiKrsMhs = ValidasiKrsMhs::where('nim_dinus', $nim)->where('ta', $tahunAjaran->kode)->first();
            if ($validasiKrsMhs) {
                DB::rollBack();
                return ResponseApi::error('Error','KRS Sudah Divalidasi, Tidak Bisa Hapus Kelas',404);
            }

            $krs = KrsRecord::where('nim_dinus', $nim)->where('ta', $tahunAjaran->kode)->where('id_jadwal', $schedule_id)->first();
            if (!$krs) {
                DB::rollBack();
                return ResponseApi::error('Error','KRS Tidak Ditemukan',404);
            }

            // update jadwal tawar
            $updateJadwalTawar = JadwalTawar::where('id', $schedule_id)->first();
            $updateJadwalTawar->jsisa = $updateJadwalTawar->jsisa + 1;
            $updateJadwalTawar->save();

            // input record log
            $jadwalTawar = $updateJadwalTawar;
            DB::table('krs_record_log')->insert([
                'id_krs' => $krs->id,
                'nim_dinus' => $nim,
                'kdmk' => $jadwalTawar->kdmk,
                'aksi'=> '3',
                'id_jadwal' => $jadwalTawar->id,
                'lastUpdate' => date('Y-m-d H:i:s')
            ]);

            $krs->delete();

            DB::commit();
            return ResponseApi::success();
        }catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return ResponseApi::validationError($e->errors());
        }
    }

    public function krs_status($nim){
        $nim = md5($nim);

        if ($nim != auth('api')->user()->nim_dinus) {
            return response()->json(['error' => 'Unauthorized, Token expired or invalid'], 401);
        }

        $tahunAjaran = TahunAjaran::where('set_aktif','1')->first();

        $countSKS = IpSemester::where('nim_dinus', $nim)->sum('sks');
        $countIP = IpSemester::where('nim_dinus', $nim)->sum('ips');
        $countIpSemester = IpSemester::where('nim_dinus', $nim)->get()->count();
        $ips = $countIP / $countIpSemester;


        $statusValidasiKrsMhs = false;
        // apabila krs sudah divalidasi
        $validasiKrsMhs = ValidasiKrsMhs::where('nim_dinus', $nim)->where('ta', $tahunAjaran->kode)->first();
        if ($validasiKrsMhs) {
            $statusValidasiKrsMhs = true;
        }

        $response = array(
            'status_validasi_krs_mhs' => $statusValidasiKrsMhs,
            'sks' => $countSKS,
            'ips' => number_format($ips, 2)
        );
        return ResponseApi::success($response);
    }

}
