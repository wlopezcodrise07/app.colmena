<?php

namespace App\Http\Controllers\Mantenimiento;

use App\Http\Controllers\Controller;
use App\Models\FormaPago;
use Illuminate\Http\Request;

class FormaPagoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
      if ($request->ajax()) {
        $result = FormaPago::get();

        return [
          'data' => $result
        ];
      }
      $data = [
        'title' => 'Formas de Pago',
        'js' => 'mantenimiento/forma_pago'
      ];
        return view('mantenimiento.forma_pago',$data);
    }

    public function store(Request $request)
    {
        try {
          $data = [
            "descripcion" => $request->descripcion,
            "estado" => $request->estado,
          ];
          FormaPago::updateOrCreate([
            'id' => $request->id
          ],  $data);

          return [
            'title' => 'Buen Trabajo',
            'text' => IS_NULL($request->id) ? 'Se registró exitósamente la forma de pago' : 'Se actualizó exitósamente la forma de pago',
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
      return FormaPago::where('id',$request->id)->first();
    }

    public function destroy(Request $request)
    {
      try {
        FormaPago::where('id',$request->id)->update(['estado'=>0]);
        return [
          'title' => 'Buen Trabajo',
          'text' =>  'Se desactivó la forma de pago',
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
