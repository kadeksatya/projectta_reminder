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

class KatalogController extends Controller
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
        return view('katalog.index');
    }

    public function upload(Request $request)
    {
        $file = "";
        if ($request->has('file')) {
            if ($request->fileold != null) {
                $path = public_path() . "/katalog/" . $request->fileold;
                if (file_exists($path)) {
                    unlink($path);
                }
            }
            $uniqueFileName = uniqid() . "_" . $request->jenis . '.' . $request->file('file')->getClientOriginalExtension();
            $request->file('file')->move(public_path('katalog'), $uniqueFileName);
            $file = $uniqueFileName;
        } else {
            $file = $request->fileold;
        }
        return response()->json([
            'status' => true,
            'filename' => $file,
        ]);
    }
}
