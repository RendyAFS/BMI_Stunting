<?php

namespace App\Http\Controllers;

use App\Charts\DetailChart;
use App\Charts\DetailChart2;
use App\Charts\DetailChart3;
use App\Charts\DetailChart4;
use App\Models\Danak;
use App\Models\Dantrian;
use App\Models\Dbulan;
use App\Models\Dposyandu;
use App\Models\Riwayat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class KaderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function pposyandu()
    {

        $dposyandu = Dposyandu::all();
        return view('kader.pposyandu', compact('dposyandu'));
    }

    public function index(Request $request)
    {
        confirmDelete();

        // Mengambil nilai input dari form
        $id_posyandu = $request->input('id_posyandu');
        $nama_posyandu = $request->input('nama_posyandu');

        // Melakukan filter berdasarkan nilai input pada model Danak
        $danaks = Danak::when($id_posyandu, function ($query) use ($id_posyandu) {
            return $query->where('dposyandu_id', $id_posyandu);
        })
            ->get();

        // Melakukan filter berdasarkan nilai input pada model Dposyandu
        $dposyandu = Dposyandu::when($id_posyandu, function ($query) use ($id_posyandu) {
            return $query->where('id', $id_posyandu);
        })
            ->get();

        $dantrian = Dantrian::when($nama_posyandu, function ($query) use ($nama_posyandu) {
            return $query->where('t_posyandu', $nama_posyandu);
        })
            ->get();

        // Subquery to get the first record per danaks_id
        $subquery = DB::table('dbulans')
            ->select('dbulans.*')
            ->whereIn('id', function ($query) {
                $query->select(DB::raw('MIN(id)'))
                    ->from('dbulans')
                    ->groupBy('danaks_id');
            });

        // Main query to get data with the specified filters and order
        $dbulans = Dbulan::fromSub($subquery, 'dbulans')
            ->when($nama_posyandu, function ($query) use ($nama_posyandu) {
                return $query->where('nama_posyandu', $nama_posyandu);
            })
            ->orderBy('created_at', 'desc') // Mengurutkan berdasarkan kolom created_at secara descending
            ->get();

        return view('kader.index', compact('danaks', 'dposyandu', 'dantrian', 'nama_posyandu', 'dbulans'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Cek entri terakhir berdasarkan yang di input sama user
        $lastEntry = Dbulan::where('danaks_id', $request->danaks_id)
            ->where('nama_posyandu', $request->nama_posyandu)
            ->latest()
            ->first();

        // Cek entri terakhir dibuat dalam interval waktu 5 detil kalau misal spam, nanti muncul error
        if ($lastEntry && $lastEntry->created_at->gt(now()->subSeconds(5))) {
            Alert::success('Berhasil Menambahkan', 'Data Anak Berhasil Terinput.');
            return redirect()->route('kaders.index');
        }
        // Buat objek Mahal baru berdasarkan data yang diterima
        $dbulans = new Dbulan();
        $dbulans->users_id = $request->users_id;
        $dbulans->danaks_id = $request->danaks_id;
        $dbulans->umur_periksa = $request->umur_periksa;
        $dbulans->nama_posyandu = $request->nama_posyandu;
        $dbulans->umur_tahun = $request->umur_tahun;
        $dbulans->umur_bulan = $request->umur_bulan;
        $dbulans->bb_anak = $request->bb_anak;
        $dbulans->tb_anak = $request->tb_anak;
        $dbulans->lk_anak = $request->lk_anak;
        $dbulans->ll_anak = $request->ll_anak;

        $dbulans->st_anak = $request->st_anak;
        $dbulans->gz_anak = $request->gz_anak;
        $dbulans->c_ukur = $request->c_ukur;

        // Simpan objek Mahal ke dalam database
        $dbulans->save();
        Alert::success('Berhasil Menambahkan', 'Data Anak Berhasil Terinput.');

        // Redirect ke halaman yang sesuai setelah penyimpanan data
        return redirect()->back();
    }

    public function storekader(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // 'nik_anak' => 'required|numeric|digits:16',
            'nama_anak' => 'required|string|max:255',
            'nama_ortu' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jk' => 'required|in:L,P',
            'dposyandu_id' => 'required|string|max:255',
            // 'nik_ortu' => 'required|numeric|digits:16',
            'hp_ortu' => 'required|numeric', // Merubah maksimal digit menjadi 13
        ], [
            // 'nik_anak.required' => 'Kolom NIK anak harus diisi.',
            // 'nik_anak.numeric' => 'NIK anak harus berupa angka.',
            // 'nik_anak.digits' => 'NIK anak harus terdiri dari 16 digit.',
            'hp_ortu.required' => 'Kolom Nomor WA harus diisi.',
            'hp_ortu.numeric' => 'Nomor WA harus berupa angka.',
        ]);


        if ($validator->fails()) {
            Alert::error('Gagal Menambahkan', 'Perisksa kembali data yang diinputkan.');
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Cek entri terakhir berdasarkan yang di input sama user
        $lastEntry = Danak::where('nik_anak', $request->nik_anak)
            ->where('nik_ortu', $request->nik_ortu)
            ->latest()
            ->first();

        // Cek entri terakhir dibuat dalam interval waktu 5 detil kalau misal spam, nanti muncul error
        if ($lastEntry && $lastEntry->created_at->gt(now()->subSeconds(5))) {
            Alert::success('Berhasil Menambahkan', 'Data Anak Berhasil Terinput.');
            return redirect()->back();
        }

        $danak = new Danak;
        // $danak->users_id = $request->users_id;
        $danak->nik_anak = $request->nik_anak;
        $danak->nama_anak = $request->nama_anak;
        $danak->tanggal_lahir = $request->tanggal_lahir;
        $danak->dposyandu_id = $request->dposyandu_id;
        $danak->jk = $request->jk;


        $danak->nik_ortu = $request->nik_ortu;
        $danak->nama_ortu = $request->nama_ortu;
        $danak->hp_ortu = $request->hp_ortu;

        // Simpan objek Mahal ke dalam database
        $danak->save();
        Alert::success('Berhasil Menambahkan', 'Data Anak Berhasil Terinput.');

        // Redirect ke halaman yang sesuai setelah penyimpanan data
        return redirect()->back();
    }



    /**
     * Display the specified resource.
     */
    public function show(
        string $danaks_id,
        DetailChart $chart,
        DetailChart2 $chart2,
        DetailChart3 $chart3,
        DetailChart4 $chart4,
    ) {
        // ELOQUENT
        $title = "E-KMS Anak";
        $danak = Danak::findOrFail($danaks_id);

        $dbulanans = Dbulan::where('danaks_id', $danaks_id)->orderBy('created_at', 'asc')->get();
        $danaks = Danak::all();

        // Extract umur_tahun and umur_bulan values from dbulans
        $umur_tahun = $dbulanans->pluck('umur_tahun')->toArray();
        $umur_bulan = $dbulanans->pluck('umur_bulan')->toArray();
        $bb_anak = $dbulanans->pluck('bb_anak')->toArray();
        $tb_anak = $dbulanans->pluck('tb_anak')->toArray();
        $lk_anak = $dbulanans->pluck('lk_anak')->toArray();

        return view(
            'actions.detailbulanankader',
            compact('dbulanans', 'title', 'danaks'),
            [
                'chart' => $chart->build($danak->jk, $umur_tahun, $umur_bulan, $bb_anak),
                'chart2' => $chart2->build($danak->jk, $umur_tahun, $umur_bulan, $tb_anak),
                'chart3' => $chart3->build($danak->jk, $tb_anak, $bb_anak),
                'chart4' => $chart4->build($danak->jk, $umur_tahun, $umur_bulan, $lk_anak),
            ]
            // ['chart2' => $chart2->build()]
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id, Request $request)
    {
        // ELOQUENT
        $title = "Edit Data Bulanan Anak";
        $dbulanans = Dbulan::find($id);

        // Get danaks_id from the currently edited Dbulan
        $danaks_id = $dbulanans->danaks_id;

        // Fetch all Dbulans with the same danaks_id
        $relatedDbulanans = Dbulan::where('danaks_id', $danaks_id)->get();
        $danaks = Danak::all();

        // $id_posyandu = $request->input('id_posyandu');
        // $nama_posyandu = $request->input('nama_posyandu');
        return view(
            'actions.editbulanankader',
            compact('dbulanans', 'danaks', 'title', 'relatedDbulanans'),
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        $dbulanans = Dbulan::findOrFail($id);

        // Update data berdasarkan ID yang diterima
        $dbulanans->users_id = $request->users_id;
        $dbulanans->danaks_id = $request->danaks_id;

        $dbulanans->umur_periksa = $request->umur_periksa;
        $dbulanans->bb_anak = $request->bb_anak;
        $dbulanans->tb_anak = $request->tb_anak;
        $dbulanans->lk_anak = $request->lk_anak;
        $dbulanans->ll_anak = $request->ll_anak;
        $dbulanans->st_anak = $request->st_anak;
        $dbulanans->gz_anak = $request->gz_anak;
        $dbulanans->c_ukur = $request->c_ukur;

        $dbulanans->created_at = $request->created_at;
        $dbulanans->updated_at = $request->updated_at;
        // Simpan perubahan data ke dalam database

        $dbulanans->save();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Temukan data kader berdasarkan ID
        $kader = Dantrian::find($id);

        // Periksa apakah data kader ditemukan
        if ($kader) {
            // Hapus data dari database
            $kader->delete();
            Alert::success('Antrian Selesai');
        } else {
            Alert::success('Antrian Selesai');
        }

        return redirect()->back();
    }

    public function destroykader(string $id)
    {
        // Temukan data bulanan berdasarkan ID
        $dbulanan = Dbulan::find($id);

        // Periksa apakah data bulanan ditemukan
        if ($dbulanan) {
            // Hapus data dari database
            $dbulanan->delete();
            Alert::success('Berhasil Terhapus', 'Data Anak Terhapus.');
        } else {
            Alert::success('Berhasil Terhapus', 'Data Anak Terhapus.');
        }

        return redirect()->back();
    }

    public function storeriwayat(Request $request)
    {
        // Buat objek Mahal baru berdasarkan data yang diterima
        $riwayat = new Riwayat();
        $riwayat->dbulans_id = $request->dbulans_id;
        $riwayat->nama = $request->nama;
        $riwayat->aktivitas = $request->aktivitas;
        $riwayat->data = $request->data;

        // Simpan objek Mahal ke dalam database
        $riwayat->save();
        Alert::success('Berhasil Memperbarui', 'Data Anak Berhasil Diperbarui.');
    }
}
