<?php

namespace App\Http\Controllers\Mantenimiento;

use App\Http\Controllers\Controller;
use App\Models\CategoriaRedSocial;
use Illuminate\Http\Request;
use Auth;

class CategoriaRedSocialController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
      if ($request->ajax()) {
        $result = CategoriaRedSocial::get();

        return [
          'data' => $result
        ];
      }
      $data = [
        'title' => 'Categoria de Redes Sociales',
        'js' => 'mantenimiento/categoria_redsocial'
      ];
        return view('mantenimiento.categoria_redsocial',$data);
    }

    public function store(Request $request)
    {
        try {
          $user = Auth::user();
          $data = [
            "descripcion" => $request->descripcion,
            "estado" => $request->estado,
            "usuario" => $user->nombre.' '.$user->apepat.' '.$user->apemat,
          ];
          CategoriaRedSocial::updateOrCreate([
            'id' => $request->id
          ],  $data);

          return [
            'title' => 'Buen Trabajo',
            'text' => IS_NULL($request->id) ? 'Se registró exitósamente la categoria' : 'Se actualizó exitósamente la categoria',
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
      return CategoriaRedSocial::where('id',$request->id)->first();
    }

    public function destroy(Request $request)
    {
      try {
        CategoriaRedSocial::where('id',$request->id)->update(['estado'=>0]);
        return [
          'title' => 'Buen Trabajo',
          'text' =>  'Se desactivó la categoria',
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
}
