<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
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

class DashboardController extends Controller
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
        // $this->database = $factory->createDatabase();
    }

    public function index()
    {
        $getDoc1 = $this->db->collection('users')->documents();
        $getDoc2 = $this->db->collection('reminder')->documents();
        $getDoc3 = $this->db->collection('booking_service')->documents();
        $data = [
            'cs' => count($getDoc1->rows()),
            'sr' => count($getDoc2->rows()),
            'bs' => count($getDoc3->rows()),
        ];
        return view('dashboard-admin', $data);
    }

    public function chart()
    {
        $bulan = [
            "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus",
            "September", "Oktober", "November", "Desember"
        ];

        $total1 = [];
        $year = date('Y');
        for ($i = 1; $i <= 12; $i++) {
            $m = $i;
            if ($i < 10) {
                $m = '0' . $i;
            }
            $citiesRef = $this->db->collection('riwayat_service');
            $query = $citiesRef->where('tgl_service', '>=', $year . '-' . $m . '-01')->where('tgl_service', '<=', $year . '-' . $m . '-31');
            $documents = $query->documents();
            $total1[] = count($documents->rows());
        }


        $data['total1'] = $total1;
        $data['bulan'] = $bulan;
        $data['title1'] = 'Grafik Jumlah Service ' . date('Y');

        return response()->json(array('data' => $data));
    }
}
