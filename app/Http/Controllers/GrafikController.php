<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Carbon;
use Carbon\CarbonPeriod;
// firestore
use Google\Cloud\Firestore\FirestoreClient;
use Kreait\Laravel\Firebase\Facades\Firebase;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Kreait\Firebase\Database;
// auth
use Kreait\Firebase\Auth;
use Firebase\Auth\Token\Exception\InvalidToken;
use Kreait\Firebase\Exception\Auth\RevokedIdToken;

class GrafikController extends Controller
{
    protected $auth, $db;
    public function __construct()
    {
        $factory = (new Factory)
            ->withServiceAccount(__DIR__ . '/config-firebase.json')
            ->withDatabaseUri('https://aqualifeta-44622-default-rtdb.firebaseio.com/');
        $firestore = $factory->createFirestore();
        $this->db = $firestore->database();

        $this->auth = $factory->createAuth();
    }

    public function label_service()
    {
        $data['bulan'] = [
            "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus",
            "September", "Oktober", "November", "Desember"
        ];
        return view('grafik.label', $data);
    }

    public function jumlah_service()
    {
        return view('grafik.jumlah_service');
    }

    function chart_label(Request $request)
    {
        $bulan = [
            "Minggu 1", "Minggu 2", "Minggu 3", "Minggu 4"
        ];

        $val_bulan = $request->bulan;

        $start_date = Carbon::createFromFormat('Y-m-d', date('Y') . '-' . $val_bulan . '-01');
        $end_date = Carbon::createFromFormat('Y-m-d', date('Y-m-d', strtotime($start_date)))->endOfMonth();

        $period = new CarbonPeriod($start_date, '1 day', $end_date);

        $total1 = [];
        $total2 = [];
        $total_rutin = 0;
        $total_urgent = 0;
        foreach ($period as $dt) {
            if ($dt->format("l") == "Sunday") {
                $tgl_min = date('Y-m-d', strtotime(date('Y') . '-' . $val_bulan . '-01'));
                $tgl_max = date("Y-m-t", strtotime($tgl_min));
                $tgl = $dt->format("Y-m-d");
                // minggu ke 1
                if (($this->weekOfMonth($tgl) - 1) == 1) {
                    $citiesRef = $this->db->collection('riwayat_service');
                    $query = $citiesRef
                        // ->where('label_service', '=', 'rutin')
                        ->where('tgl_service', '>=', $tgl_min)
                        ->where('tgl_service', '<=', $tgl);
                    $documents = $query->documents();
                    $i = 0;
                    $x = 0;
                    foreach ($documents as $document) {
                        if ($document->exists()) {
                            $label = $document->data()['label_service'];
                            if ($label == "rutin") {
                                $i++;
                            } else {
                                $x++;
                            }
                        }
                    }
                    $total1[] = $i;
                    $total2[] = $x;
                    $total_rutin += $i;
                    $total_urgent += $x;
                }
                // minggu ke 4
                elseif (($this->weekOfMonth($tgl) - 1) == 4) {
                    $citiesRef = $this->db->collection('riwayat_service');
                    $query = $citiesRef
                        // ->where('label_service', '=', 'rutin')
                        ->where('tgl_service', '>', date('Y-m-d', strtotime("$tgl -7 day")))
                        ->where('tgl_service', '<=', $tgl_max);
                    $documents = $query->documents();
                    $i = 0;
                    $x = 0;
                    foreach ($documents as $document) {
                        if ($document->exists()) {
                            $label = $document->data()['label_service'];
                            if ($label == "rutin") {
                                $i++;
                            } else {
                                $x++;
                            }
                        }
                    }
                    $total1[] = $i;
                    $total2[] = $x;
                    $total_rutin += $i;
                    $total_urgent += $x;
                }
                // minggu ke 2 & 3
                else {
                    $citiesRef = $this->db->collection('riwayat_service');
                    $query = $citiesRef
                        // ->where('label_service', '=', 'rutin')
                        ->where('tgl_service', '>', date('Y-m-d', strtotime("$tgl -7 day")))
                        ->where('tgl_service', '<=', $tgl);
                    $documents = $query->documents();
                    $i = 0;
                    $x = 0;
                    foreach ($documents as $document) {
                        if ($document->exists()) {
                            $label = $document->data()['label_service'];
                            if ($label == "rutin") {
                                $i++;
                            } else {
                                $x++;
                            }
                        }
                    }
                    $total1[] = $i;
                    $total2[] = $x;
                    $total_rutin += $i;
                    $total_urgent += $x;
                }
            }
        }
        $total_semua = $total_rutin + $total_urgent;

        $data['awal'] = $end_date;
        $data['total_rutin'] = $total_rutin;
        $data['total_urgent'] = $total_urgent;
        $data['total_semua'] = $total_semua;
        $data['total1'] = $total1;
        $data['total2'] = $total2;
        $data['bulan'] = $bulan;
        $data['title1'] = 'Rutin';
        $data['title2'] = 'Urgent';
        return response()->json(array('data' => $data));
    }

    function chart_jumlah_service(Request $request)
    {
        $bulan = [
            "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus",
            "September", "Oktober", "November", "Desember"
        ];

        $total = [];
        $year = ($request->tahun == null) ? date('Y') : $request->tahun;
        for ($i = 1; $i <= 12; $i++) {
            $m = $i;
            if ($i < 10) {
                $m = '0' . $i;
            }
            $citiesRef = $this->db->collection('riwayat_service');
            $query = $citiesRef->where('tgl_service', '>=', $year . '-' . $m . '-01')->where('tgl_service', '<=', $year . '-' . $m . '-31');
            $documents = $query->documents();
            $total[] = count($documents->rows());
        }


        $data['total'] = $total;
        $data['bulan'] = $bulan;
        $data['title'] = "Grafik Jumlah Service Tahun $year";

        return response()->json(array('data' => $data));
    }

    // untuk cek tanggal itu berada di minggu keberapa
    function weekOfMonth($qDate)
    {
        $dt = strtotime($qDate);
        $day  = date('j', $dt);
        $month = date('m', $dt);
        $year = date('Y', $dt);
        $totalDays = date('t', $dt);
        $weekCnt = 1;
        $retWeek = 0;
        for ($i = 1; $i <= $totalDays; $i++) {
            $curDay = date("N", mktime(0, 0, 0, $month, $i, $year));
            if ($curDay == 7) {
                if ($i == $day) {
                    $retWeek = $weekCnt + 1;
                }
                $weekCnt++;
            } else {
                if ($i == $day) {
                    $retWeek = $weekCnt;
                }
            }
        }
        return $retWeek;
    }
}
