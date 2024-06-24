<?php

namespace App\Charts;

use App\Models\Dbulan;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class GrafikdashboardChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\barChart
    {
        $tgl_periksa = [
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];

        $jmlh_data1 = [];
        $jmlh_data2 = [];
        $jmlh_data3 = [];
        $jmlh_data4 = [];
        $jmlh_data5 = [];

        foreach ($tgl_periksa as $index => $bulan) {
            // Ambil data berdasarkan bulan, tahun saat ini, dan posyandu yang dipilih
            $total_normal = Dbulan::whereMonth('created_at', $index + 1)
                ->whereYear('created_at', date('Y'))
                ->where('gz_anak', 'Normal')
                // ->whereHas('danaks.dposyandu', function ($query) use ($selectedPosyandu) {
                //     $query->where('nama_posyandu', $selectedPosyandu);
                // })
                ->count();

            $total_gizi_kurang = Dbulan::whereMonth('created_at', $index + 1)
                ->whereYear('created_at', date('Y'))
                ->where('gz_anak', 'Gizi Kurang')
                // ->whereHas('danaks.dposyandu', function ($query) use ($selectedPosyandu) {
                //     $query->where('nama_posyandu', $selectedPosyandu);
                // })
                ->count();
            $total_gizi_buruk = Dbulan::whereMonth('created_at', $index + 1)
                ->whereYear('created_at', date('Y'))
                ->where('gz_anak', 'Gizi Buruk')
                // ->whereHas('danaks.dposyandu', function ($query) use ($selectedPosyandu) {
                //     $query->where('nama_posyandu', $selectedPosyandu);
                // })
                ->count();
            $total_kelebihan_bb = Dbulan::whereMonth('created_at', $index + 1)
                ->whereYear('created_at', date('Y'))
                ->where('gz_anak', 'Kelebihan Berat Badan')
                // ->whereHas('danaks.dposyandu', function ($query) use ($selectedPosyandu) {
                //     $query->where('nama_posyandu', $selectedPosyandu);
                // })
                ->count();
            $total_obesitas = Dbulan::whereMonth('created_at', $index + 1)
                ->whereYear('created_at', date('Y'))
                ->where('gz_anak', 'Obesitas')
                // ->whereHas('danaks.dposyandu', function ($query) use ($selectedPosyandu) {
                //     $query->where('nama_posyandu', $selectedPosyandu);
                // })
                ->count();

            $jmlh_data1[] = $total_normal;
            $jmlh_data2[] = $total_gizi_kurang;
            $jmlh_data3[] = $total_gizi_buruk;
            $jmlh_data4[] = $total_kelebihan_bb;
            $jmlh_data5[] = $total_obesitas;
        }

        return $this->chart->barChart()
            ->setTitle('Data Gizi Baik dan Gizi Buruk di ' . date('Y') . '.')
            ->setSubtitle('Pada Posyandu Kabupaten Mojokerto')
            ->addData('Normal', $jmlh_data1)
            ->addData('Gizi Kurang', $jmlh_data2)
            ->addData('Gizi Buruk', $jmlh_data3)
            ->addData('Kelebihan Berat Badan', $jmlh_data4)
            ->addData('Obesitas', $jmlh_data5)
            ->setColors(['#3CB371', '#FF942D', "#FB4E32" , "#04098f", "#051E51"])
            ->setXAxis($tgl_periksa)
            ->setGrid('#3F51B5', 0.01);
        // ->setMarkers(['#FF6464', '#2EB086'], 6, 8);
    }
}
