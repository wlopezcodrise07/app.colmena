<?php

namespace App\Http\Controllers\Mantenimiento;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UsuariosController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
      $data = [
        'title' => 'Usuarios',
        'js' => 'mantenimiento/usuario'
      ];
        return view('mantenimiento.usuario',$data);
    }

    function store(Request $request)
    {
      try {
        User::updateOrCreate([
          'id' =>Auth::user()->id
        ],$request->all());

        return [
          'title' => 'Buen Trabajo',
          'text' => 'Se actualizó la información con éxito',
          'error' => null,
          'type' => 'success'
        ];
      } catch (\Exception $e) {
        return [
          'title' => 'Alerta',
          'text' => 'Hubo un error',
          'error' => $e->getMessage(),
          'type' => 'error'
        ];
      }

    }

    function changePass(Request $request){
      try {
        $validator = \Validator::make($request->all(), [
              'password' => ['required', 'string', 'min:8','max:15','confirmed']
          ], [
            'password.confirmed'=> 'La contraseña tiene que coincidir con la confirmación',
            'password.min'=> 'La contraseña tiene que tener como mínimo 8 caracteres y como máximo 15 caracteres',
          ]);

          if ($validator->fails()) {
            $mensaje = json_decode($validator->errors());
            return [
                'title' => 'Alerta',
                'text'  => $mensaje->password,
                'type'  => 'warning'
              ];
          }else {
            User::where('id',Auth::user()->id)->update([
              'password' => Hash::make($request->password)
            ]);
            return [
              'title' => 'Buen Trabajo',
              'text' => 'Se actualizó la clave con éxito',
              'error' => null,
              'type' => 'success'
            ];
          }

      } catch (\Exception $e) {
        return [
          'title' => 'Alerta',
          'text' => 'Hubo un error',
          'error' => $e->getMessage(),
          'type' => 'error'
        ];
      }

    }
}
