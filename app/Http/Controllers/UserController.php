<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Role;

use App\Models\User;
use App\Models\Sorti;
use App\Models\Product;
use App\Models\Kurangura;
use Illuminate\Http\Request;
use App\Models\ProductArticle;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    //
    public function index(){

        return view('login');
    }
    public function dashboard(){
        $fromDate = Carbon::now()->toDateString();
        $endDate = Carbon::now()->toDateString();
        $warnCount=Product::all();
        $countStore=Product::all()->count();
        $product = Product::with('Produitname', 'Category')->get();
        $sorti = Sorti::with('Produitname')->whereBetween('date',[$fromDate,$endDate])->get();
        $userRole = User::with('roles')->where('id', '=', session()->get('loginId'))->first();
        $countKurangura=Kurangura::all()->count();
        $stockApro=Product::where('quantity','<=',2)->count();
        $numberBillCount = DB::table('sortis')->distinct()->count('numeroSorti');

        return view('dashboard',compact(
            'countStore',
            'countKurangura',
            'userRole',
            'numberBillCount',
            'warnCount',
            'sorti',
            'product'));
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
            $ck=$data->roles->name;
            if($ck=='Inactif'){
                return redirect()->back()->with('message', "Votre compte n'a pas droit de se connecter, veuiller contacter le Manager du Happy People Cosmetics");
            }else{
                return redirect()->route('dashboard');
            }

        }
    }
    public function addUserCreate(){
        $userRole = User::with('roles')->where('id', '=', session()->get('loginId'))->first();
        $user = User::with('roles')->get();
        $role=Role::all();
        $countKurangura=Kurangura::all()->count();
        $warnCount=Product::all();

        return view('addUser',compact('user','role','countKurangura','warnCount','userRole'));

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

    public function editerUserAdmin($id){
        $user=User::with('Roles')->where('id','=',$id)->first();
        $userRole = User::with('roles')->where('id', '=', session()->get('loginId'))->first();
        $role=Role::all();
        $countKurangura=Kurangura::all()->count();
        $warnCount=Product::all();

        return view('editUser',compact('user','role','countKurangura','warnCount','userRole'));
    }

    public function editerUserAdminStore(Request $request,$id)
    {
                $fname=$request->fname;
                $lname=$request->lname;
                $username=$request->username;
                $telephone=$request->telephone;
                $email=$request->email;
                $role=$request->role;

                $users = User::find($id);
                $users->fname = $fname;
                $users->lname = $lname;
                $users->username = $username;
                $users->telephone = $telephone;
                $users->email = $email;
                $users->role_id = $role;
                $users->save();

                if ($users->save()) {
                    return redirect()->route('addUserCreate')->with('messageEditUser', 'Utilisateur a été modifié avec succès !');
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
        $countKurangura=Kurangura::all()->count();
        $warnCount=Product::all();

        return view('profileUser',compact('userRole','role','countKurangura','warnCount'));

    }
        public function kurangura_pdf(){
            $item=Kurangura::all();
            $current=Carbon::now()->toDateString();
            $pdf = Pdf::loadView('PDF.kuranguraPdf',['item'=>$item,'current'=>$current]);
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

    public function billtest(){
        $pdf = Pdf::loadView('billtem');
            return $pdf->download('Hpc-kurangura.pdf');

    }

    public function errorC(){
        return view('Error400');
    }

}
