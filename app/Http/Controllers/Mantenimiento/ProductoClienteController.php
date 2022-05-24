<?php

namespace App\Http\Controllers\Mantenimiento;

use App\Http\Controllers\Controller;
use Auth;
use DB;
use App\Models\Cliente;
use Illuminate\Http\Request;

class ProductoClienteController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
      if ($request->ajax()) {
        $result = DB::table('productos_cliente')->selectRaw("
          productos_cliente.*,
          maecli.CNOMCLI
        ")
        ->join('maecli',function($join){
          $join->on('productos_cliente.cliente','=','maecli.CCODCLI');
        })->get();

        return [
          'data' => $result
        ];
      }
      $data = [
        'title' => 'Producto de Clientes',
        'js' => 'mantenimiento/producto_cliente',
        'clientes' => Cliente::where('active',1)->get(),
      ];
        return view('mantenimiento.producto_cliente',$data);
    }

    public function store(Request $request)
    {
      try {
        $user = Auth::user();
        
          $data = [
            "producto" => mb_strtoupper($request->producto,'UTF-8'),
            "cliente" => $request->cliente,
            "contacto" => mb_strtoupper($request->contacto,'UTF-8'),
            "estado" => $request->estado,
            "usuario" => $user->nombre.' '.$user->apepat.' '.$user->apemat,
          ];
          if (IS_NULL($request->id)) {
            DB::table('productos_cliente')->insert($data);
          }else {
            DB::table('productos_cliente')->where('id',$request->id)->update($data);
          }

          return [
            'title' => 'Buen Trabajo',
            'text' => IS_NULL($request->id) ? 'Se registró exitósamente el producto del cliente' : 'Se actualizó exitósamente el producto del cliente',
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
      return DB::table('productos_cliente')->where('id',$request->id)->first();
    }

    public function destroy(Cliente $cliente)
    {
      try {
        DB::table('productos_cliente')->where('id',$request->id)->update(['estado'=>0]);
        return [
          'title' => 'Buen Trabajo',
          'text' =>  'Se desactivó el producto',
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

    public function get_campana(Request $request){

      $data = DB::table('cronograma_producto')->selectRaw("
      id,
        case
        WHEN month(periodo)=1 THEN CONCAT('ENERO ',YEAR(periodo))
        WHEN month(periodo)=2 THEN CONCAT('FEBRERO ',YEAR(periodo))
        WHEN month(periodo)=3 THEN CONCAT('MARZO ',YEAR(periodo))
        WHEN month(periodo)=4 THEN CONCAT('ABRIL ',YEAR(periodo))
        WHEN month(periodo)=5 THEN CONCAT('MAYO ',YEAR(periodo))
        WHEN month(periodo)=6 THEN CONCAT('JUNIO ',YEAR(periodo))
        WHEN month(periodo)=7 THEN CONCAT('JULIO ',YEAR(periodo))
        WHEN month(periodo)=8 THEN CONCAT('AGOSTO ',YEAR(periodo))
        WHEN month(periodo)=9 THEN CONCAT('SEPTIEMBRE ',YEAR(periodo))
        WHEN month(periodo)=10 THEN CONCAT('OCTUBRE ',YEAR(periodo))
        WHEN month(periodo)=11 THEN CONCAT('NOVIEMBRE ',YEAR(periodo))
        WHEN month(periodo)=12 THEN CONCAT('DICIEMBRE ',YEAR(periodo)) END periodo,
        case
        WHEN DATEDIFF(periodo,NOW())>7 then '2'
        WHEN DATEDIFF(periodo,NOW())<=7 or DATEDIFF(periodo,NOW())>0  then '1'
        WHEN DATEDIFF(periodo,NOW())<=0  then '0' end condicion
      ")->where('producto',$request->producto)->orderBy('periodo','desc')->get();
      return [
        'data' => $data
      ];
    }

    public function storeCampaña(Request $request)
    {
      try {
          $condicion = DB::table('cronograma_producto')->where('producto',$request->id)->where('producto',$request->mes)->first();
          if ($condicion) {
            return [
              'title' => 'Alerta',
              'text' => 'La campaña ya está registrada para el producto',
              'type' => 'warning'
            ];
          }
          $data = [
            "producto" => $request->id,
            "periodo" => date("Y-m-01",strtotime($request->mes)),
          ];
          DB::table('cronograma_producto')->insert($data);

          return [
            'title' => 'Buen Trabajo',
            'text' =>  'Se registró exitósamente la campaña',
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

    public function destroyCampaña(Request $request)
    {
      try {
        DB::table('cronograma_producto')->where('id',$request->id)->delete();
        return [
          'title' => 'Buen Trabajo',
          'text' =>  'Se eliminó la campaña del producto',
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
