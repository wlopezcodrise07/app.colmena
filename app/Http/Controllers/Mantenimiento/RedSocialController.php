<?php

namespace App\Http\Controllers\Mantenimiento;

use App\Http\Controllers\Controller;
use App\Models\RedSocial;
use Illuminate\Http\Request;

class RedSocialController extends Controller
{
  public function __construct()
  {
      $this->middleware('auth');
  }
    public function index(Request $request)
    {
      if ($request->ajax()) {
        $result = RedSocial::get();

        return [
          'data' => $result
        ];
      }
      $data = [
        'title' => 'Redes Sociales',
        'js' => 'mantenimiento/redsocial'
      ];
        return view('mantenimiento.redsocial',$data);
    }

    public function store(Request $request)
    {
        try {
          $user = Auth::user();
          $data = [
            "red_social" => $request->red_social,
            "estado" => $request->estado,
            "usuario" => $user->nombre.' '.$user->apepat.' '.$user->apemat,
          ];
          RedSocial::updateOrCreate([
            'id' => $request->id
          ],  $data);

          return [
            'title' => 'Buen Trabajo',
            'text' => IS_NULL($request->id) ? 'Se registró exitósamente la red social' : 'Se actualizó exitósamente la red social',
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
    public function edit(Request $request)
    {
      return RedSocial::where('id',$request->id)->first();
    }

}
