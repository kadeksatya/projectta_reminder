<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\DataTables;
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

class CustomerController extends Controller
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

    public function index()
    {
        return view('user.index');
    }

    public function riwayat($uid = null)
    {
        $data['uid'] = $uid;
        $data['nama'] = ucwords($this->db->collection('users')->document($uid)->snapshot()->data()['nama']);
        $data['email'] = ucwords($this->db->collection('users')->document($uid)->snapshot()->data()['email']);
        return view('user.riwayat', $data);
    }
}
