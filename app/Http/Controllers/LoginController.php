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
use Kreait\Firebase\Auth\SignInResult\SignInResult;
use Kreait\Firebase\Auth;
use Firebase\Auth\Token\Exception\InvalidToken;
use Kreait\Firebase\Exception\Auth\RevokedIdToken;

class LoginController extends Controller
{
    protected $auth, $database;

    public function __construct()
    {
        $factory = (new Factory)
            ->withServiceAccount(__DIR__ . '/config-firebase.json')
            ->withDatabaseUri('https://aqualifeta-44622-default-rtdb.firebaseio.com/');
        $firestore = $factory->createFirestore();
        $this->database = $firestore->database();
        $this->auth = $factory->createAuth();
        $this->middleware('guest')->except('logout');
    }
    /** fungsi login */
    public function getLogin()
    {
        // dd($this->userCheck());
        return view('login');
    }

    public function postLogin(Request $request)
    {
        $email = $request->email;
        $pass = $request->password;
        $status = false;
        $message = '';
        try {
            $signInResult = $this->auth->signInWithEmailAndPassword($email, $pass);
            $docRef = $this->database->collection('admin')->document($signInResult->firebaseUserId());
            $snapshot = $docRef->snapshot();
            if ($snapshot->exists()) {
                Session::put('firebaseUserId', $signInResult->firebaseUserId());
                Session::put('idToken', $signInResult->idToken());
                Session::put('email', $signInResult->data()['email']);
                Session::put('displayName', $signInResult->data()['displayName']);
                Session::save();
                $status = true;
                $message = 'Success';
            } else {
                $status = false;
                $message = 'Anda tidak memiliki akses login!';
            }
        } catch (\Throwable $e) {
            switch ($e->getMessage()) {
                case 'INVALID_PASSWORD':
                    $status = false;
                    $message = 'Kata sandi salah!';
                    break;
                case 'EMAIL_NOT_FOUND':
                    $status = false;
                    $message = 'Email tidak ditemukan!';
                    break;
                default:
                    dd($e->getMessage());
                    break;
            }
        }

        return response()->json([
            'status' => $status,
            'message' => $message,
        ]);
    }

    public function signUp()
    {
        $email = "admin@gmail.com";
        $pass = "admin12345";

        try {
            // $newUser = $this->auth->createUserWithEmailAndPassword($email, $pass);
            // dd($newUser);
            $userProperties = [
                'email' => 'admin@gmail.com',
                'emailVerified' => false,
                'phoneNumber' => '+628129912912',
                'password' => 'admin12345',
                'displayName' => 'Admin',
                'photoUrl' => 'http://www.example.com/12345678/photo.png',
                'disabled' => false,
            ];

            $createdUser = $this->auth->createUser($userProperties);
            $data = [
                'nama' => 'Admin Ganteng',
                'noHp' => '+6285899823923',
            ];
            $insert = $this->database->collection('admin')->document($createdUser->uid)->set($data);
            // untuk mendapatkan iduser
            dd($insert);
        } catch (\Throwable $e) {
            switch ($e->getMessage()) {
                case 'The email address is already in use by another account.':
                    dd("Email sudah digunakan.");
                    break;
                case 'A password must be a string with at least 6 characters.':
                    dd("Kata sandi minimal 6 karakter.");
                    break;
                default:
                    dd($e->getMessage());
                    break;
            }
        }
    }

    public function userCheck()
    {
        if (Session::has('firebaseUserId') && Session::has('idToken')) {
            return 1;
        } else {
            return 0;
        }
    }

    public function logout()
    {
        if (Session::has('firebaseUserId') && Session::has('idToken')) {
            // dd("User masih login.");
            $this->auth->revokeRefreshTokens(Session::get('firebaseUserId'));
            Session::forget('firebaseUserId');
            Session::forget('idToken');
            Session::forget('email');
            Session::save();
            return redirect('login')->with('info', 'Anda baru saja logout');
        } else {
            return redirect('login')->with('info', 'Anda belum melakukan login!');
        }
    }
}
