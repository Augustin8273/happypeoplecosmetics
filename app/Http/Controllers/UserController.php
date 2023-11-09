<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Role;

use App\Models\User;
use App\Models\Product;
use App\Models\Kurangura;
use Illuminate\Http\Request;
use App\Models\ProductArticle;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    //
    public function index(){

        return view('login');
    }
    public function dashboard(){
        $countStore=Product::all()->count();
        $userRole = User::with('roles')->where('id', '=', session()->get('loginId'))->first();
        $countKurangura=Kurangura::all()->count();

        return view('dashboard',compact('countStore','countKurangura','userRole'));
    }

    public function login(Request $request){


        $fields = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);
        // check email if exist in database

        $champs = 'email';
        if (!filter_var($fields['email'], FILTER_VALIDATE_EMAIL)) {

            $champs = 'username';
        }

        $user = User::where($champs, $fields['email'])->first();

        // check password
        if (!$user || !Hash::check($fields['password'], $user->password)) {
            return redirect()->back()->with('message', 'Email ou Mot de passe est incorrect');
        } else {
            $request->session()->put('loginId', $user->id);
            $data = User::with('roles')->where('id', '=', session()->get('loginId'))->first();

                return redirect()->route('dashboard');
        }
    }
    public function addUserCreate(){
        $userRole = User::with('roles')->where('id', '=', session()->get('loginId'))->first();
        $role=Role::all();

        return view('addUser',compact('userRole','role'));

    }

        public function addUser(Request $request)
    {

        $fields = $request->validate([
            'fname' => 'required',
            'lname' => 'required',
            'telephone' => 'required',
            'email' => 'required',
            'role' => 'required',
        ]);

        $rol = $fields['role'];

        if ($rol == '--select--') {
            return redirect()->back()->with('messageAddUserRol', 'Veuillez selectionner le role !');
        } else {
            $chkemail = User::where('email', '=', $fields['email'])->first();

            if ($chkemail) {

                return redirect()->back()->with('messageAddUserEmail', 'votre adresse e-mail est déjà utilisée, veuillez utiliser un autre');
            } else {
                $users = new User();
                $users->fname = $fields['fname'];
                $users->lname = $fields['lname'];
                $users->username = $fields['fname'];
                $users->telephone = $fields['telephone'];
                $users->email = $fields['email'];
                $users->role_id = $fields['role'];
                $users->password = Hash::make('0000');
                $users->save();

                if ($users->save()) {
                    return redirect()->back()->with('messageAddUser', 'Utilisateur a été créé avec succès !');
                }
            }
        }

    }

    public function editerUser(Request $request,$id)
    {

        $fields = $request->validate([
            'fname' => 'required',
            'lname' => 'required',
            'username' => 'required',
            'telephone' => 'required',
            'email' => 'required',
            'role' => 'required',
        ]);
                $users = User::find($id);
                $users->fname = $fields['fname'];
                $users->lname = $fields['lname'];
                $users->username = $fields['username'];
                $users->telephone = $fields['telephone'];
                $users->email = $fields['email'];
                $users->role_id = $fields['role'];
                $users->save();

                if ($users->save()) {
                    return redirect()->back()->with('messageEditUser', 'Utilisateur a été modifié avec succès !');
                }


    }

    public function changePassword(Request $request, $id)
    {
        $data = User::where('id', '=', $id)->first();
        $passHashed = $data->password;
        $userPassWritten = $request->password;
        $userNewPass = $request->newpassword;
        $userNewPassConf = $request->confpassword;

        if (Hash::check($userPassWritten, $passHashed)) {
            if ($userNewPass == $userNewPassConf) {
                $data->password = Hash::make($userNewPass);
                $data->save();
                if ($data->save()) {
                    return redirect()->back()->with('messPassChange', 'Félicitation, Votre mot de passe a été changé avec succès!');
                }
            } else {
                return redirect()->back()->with('messPassNotMatch', 'Desolé, Les nouveaux mots de passe ne se ressemblent pas, Réessayer encore !');
            }
        } else {
            return redirect()->back()->with('messPassIncorrect', 'Desolé, Votre mot de passe est incorrect, Réessayer un autre!');
        }
    }

    public function Profile($id){
        $userRole = User::with('roles')->where('id', '=', session()->get('loginId'))->first();
        $role=Role::all();
        return view('profileUser',compact('userRole','role'));

    }
        public function kurangura_pdf(){
            $item=Kurangura::all();
            $current=Carbon::now()->toDateString();
            $pdf = Pdf::loadView('kuranguraPdf',['item'=>$item,'current'=>$current]);
            return $pdf->download('Hpc-kurangura-Le-'.$current.'.pdf');
        }


        public function logout()
    {
        if (session()->has('loginId')) {
            Session()->pull('loginId');
            Session()->pull('message');
            Session()->pull('wellmessage');
            return redirect()->route('loginCreate');
        }
    }




}
