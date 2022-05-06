<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\User;
use Auth;
use DB;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(){
   $document_number = request('usuario');
   $password = request('password');
   $user= User::where('usuario',$document_number)->first();
   if( $user ){//El usuario ingresado existe
     if( $user->activo == 1 ){ //Si active es igual a 1
       $credentials = $this->validate(request(),[
           'usuario'=> 'required|string',
           'password'=> 'required|string'
       ]);
       if( Auth::attempt($credentials)){
         return redirect()->intended('home');
       }
       return back()->withInput()->withErrors(['usuario'=>'Las credenciales ingresadas son incorrectas']);
     }else{
        return back()->withInput()->withErrors(['usuario'=>'El Usuario ingresado se encuentra Inactivo']);
     }
   }else{ //El usuario ingresado no existe
       return back()->withInput()->withErrors(['usuario'=>'El Usuario ingresado no esta registrado en nuestra plataforma.']);
   }
}
}
