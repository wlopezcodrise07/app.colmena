<?php
namespace App\Http\Controllers\Procesos;

use App\Http\Controllers\Controller;
use App\Models\Cotizacion;
use App\Models\Cliente;
use App\Models\Accion;
use App\Models\FormaPago;
use App\Models\Influencer;
use App\Models\RedSocial;
use Illuminate\Http\Request;
use Auth;
use DB;

class CotizacionController extends Controller
{

  public function __construct()
  {
      $this->middleware('auth');
  }

  function index(){
    $correlativo = Cotizacion::orderBy('CCNUMDOC','desc')->value('CCNUMDOC');
    $clientes = Cliente::where('active',1)->orderBy('CNOMCLI','asc')->get();
    $producto_cliente = DB::table('productos_cliente')->where('estado',1)->get();
    $acciones = Accion::where('estado',1)->get();
    $formas_pago = FormaPago::where('estado',1)->get();
    if (!isset($correlativo)) {
      $correlativo = 0;
    }
    $data = [
      'title' => 'Generar Cotizacion',
      'js' => 'procesos/cotizacion',
      'clientes' => $clientes,
      'acciones' => $acciones,
      'formas_pago' => $formas_pago,
      'producto_cliente' => $producto_cliente,
      'correlativo' => $correlativo+1
    ];
      return view('procesos.cotizacion.cotizacion',$data);
  }

  function create(Request $request){
    try {
      $cliente = Cliente::where('CCODCLI',$request->CCCODCLI)->first();
      $data = [
        'CCVERSION' => 1,
        'CCFECDOC' => date('Y-m-d'),
        'CCFECVEN' => date('Y-m-d',strtotime(date('Y-m-d').' + 1 months')),
        'CCCODCLI' => $request->CCCODCLI,
        'CCNOMBRE' => $cliente->CNOMCLI,
        'CCRUC' => $cliente->CNUMRUC,
        'CCIMPORTE' => $request->total_sinigv_pen,
        'CCIMPORTEUSD' => $request->total_sinigv_usd,
        'CCFORVEN' => $request->CCFORVEN,
        'CCTIPCAM' => $request->CCTIPCAM,
        'CCUSER' => Auth::user()->documento,
        'CCESTADO' => 0,
        'CCGLOSA' => $request->CCGLOSA,
        'CCIGV' => $request->total_sinigv_pen*0.18,
        'CCIGVUSD' => $request->total_sinigv_usd*0.18,
        'CCFEEPOR' => $request->fee,
        'CCIMPORTEVTA' => $request->total_venta,
        'CCRETENCION' => $request->retencion,
        'CCFECSYS' => date('Y-m-d H:i:s')
      ];
      $id = Cotizacion::insert($data);
      $item=1;
      foreach (json_decode($request->detalle) as $key) {
        $data_detalle = [
          'CDNUMDOC' => $id ,
          'CDVERSION' => 1 ,
          'CDSECUEN' => $item ,
          'CDPRODUCTO' => $key->producto_cliente,
          'CDCODIGO' => $key->codigo ,
          'CDDESCRI' => trim($key->descripcion) ,
          'CDGLOSA' => trim($key->glosa) ,
          'CDCANJE' => $key->canje ,
          'CDPREUNIT' => $key->precio ,
          'CDMONEDA' => $key->moneda ,
          'CDCANTID' => $key->cantidad ,
          'CDTOTVEN' => $key->total ,
          'CDREDSOCIAL' => $key->red_social ,
          'CDINPUT' => $key->input ,
          'CDESTADO' => 0
        ];
        DB::table('cotdet')->insert($data_detalle);
        $item++;
      }
      return [
          'title' => 'Buen Trabajo',
          'text'  => 'Se gener?? la cotizaci??n # '.str_pad($id,7,"0",STR_PAD_LEFT),
          'type'  => 'success'
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

  function createVersion(Request $request){
    try {
      $cliente = Cliente::where('CCODCLI',$request->CCCODCLI)->first();
      $data = [
        'CCNUMDOC' => $request->CCNUMDOC,
        'CCVERSION' => $request->CCVERSION+1,
        'CCFECDOC' => date('Y-m-d'),
        'CCFECVEN' => date('Y-m-d',strtotime(date('Y-m-d').' + 1 months')),
        'CCCODCLI' => $request->CCCODCLI,
        'CCNOMBRE' => $cliente->CNOMCLI,
        'CCRUC' => $cliente->CNUMRUC,
        'CCIMPORTE' => $request->total_sinigv_pen,
        'CCIMPORTEUSD' => $request->total_sinigv_usd,
        'CCFORVEN' => $request->CCFORVEN,
        'CCTIPCAM' => $request->CCTIPCAM,
        'CCUSER' => Auth::user()->documento,
        'CCESTADO' => 0,
        'CCGLOSA' => $request->CCGLOSA,
        'CCIGV' => $request->total_sinigv_pen*0.18,
        'CCIGVUSD' => $request->total_sinigv_usd*0.18,
        'CCFEEPOR' => $request->fee,
        'CCIMPORTEVTA' => $request->total_venta,
        'CCRETENCION' => $request->retencion,
        'CCFECSYS' => date('Y-m-d H:i:s')
      ];
      Cotizacion::insert($data);
      $item=1;
      foreach (json_decode($request->detalle) as $key) {
        $data_detalle = [
          'CDNUMDOC' => $request->CCNUMDOC,
          'CDVERSION' => $request->CCVERSION+1 ,
          'CDSECUEN' => $item ,
          'CDPRODUCTO' => $key->producto_cliente,
          'CDCODIGO' => $key->codigo ,
          'CDDESCRI' => trim($key->descripcion) ,
          'CDGLOSA' => trim($key->glosa) ,
          'CDCANJE' => $key->canje ,
          'CDPREUNIT' => $key->precio ,
          'CDMONEDA' => $key->moneda ,
          'CDCANTID' => $key->cantidad ,
          'CDTOTVEN' => $key->total ,
          'CDREDSOCIAL' => $key->red_social ,
          'CDINPUT' => $key->input ,
          'CDESTADO' => 0
        ];
        DB::table('cotdet')->insert($data_detalle);
        $item++;
      }
      return [
          'title' => 'Buen Trabajo',
          'text'  => 'Se gener?? la versi??n #'.($request->CCVERSION+1).' de la cotizaci??n # '.str_pad($request->CCNUMDOC,7,"0",STR_PAD_LEFT),
          'type'  => 'success'
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

  function edit(Request $request){
    $cabecera = Cotizacion::where('CCNUMDOC',$request->numero)->where('CCVERSION',$request->version)->first();
    $detalle = DB::table('cotdet')->where('CDNUMDOC',$request->numero)->where('CDVERSION',$request->version)->get();
    $productos= DB::table('cotdet')->selectRaw(
      "
      CDPRODUCTO,
      producto
      "
      )->join('productos_cliente',function($join){
        $join->on('productos_cliente.id','=','CDPRODUCTO');
      })->where('CDNUMDOC',$request->numero)->where('CDVERSION',$request->version)->groupByRaw('CDPRODUCTO,producto')->get();
    $clientes = Cliente::where('active',1)->orderBy('CNOMCLI','asc')->get();
    $producto_cliente = DB::table('productos_cliente')->where('estado',1)->get();
    $acciones = Accion::where('estado',1)->get();
    $formas_pago = FormaPago::where('estado',1)->get();
    $data = [
      'title' => 'Generar Cotizacion',
      'js' => 'procesos/cotizacion',
      'clientes' => $clientes,
      'acciones' => $acciones,
      'formas_pago' => $formas_pago,
      'producto_cliente' => $producto_cliente,
      'cabecera' => $cabecera,
      'detalle' => $detalle,
      'productos' => $productos,
    ];
      return view('procesos.cotizacion.cotizacion_edit',$data);

  }
  function versionar(Request $request){
    if ($request->ajax()) {
      $result = Cotizacion::selectRaw("
        cotcab.CCNUMDOC,
        cotcab.CCVERSION,
        cotcab.CCFECDOC,
        cotcab.CCNOMBRE,
        (CASE WHEN cotcab.CCIMPORTEVTA=cotcab.CCRETENCION THEN round(cotcab.CCIMPORTEVTA,2) ELSE round(cotcab.CCRETENCION,2) END) AS CCIMPORTEVTA,
        CONCAT(users.nombre,' ',users.apepat,' ',users.apemat) usuario,
        cotcab.CCESTADO
      ")->join('users',function($join){
        $join->on('users.documento','=','cotcab.CCUSER');
      })->where('CCVERSION',1)->whereYear('cotcab.CCFECDOC',$request->periodo)->orderBy('CCNUMDOC','desc')->get();

      return [
        'data' => $result
      ];
    }
    $data = [
      'title' => 'Versionar Cotizacion',
      'js' => 'procesos/versionar_cotizacion'
    ];
      return view('procesos.cotizacion.versionar_cotizacion',$data);

  }
  function getVersiones(Request $request){
    if ($request->ajax()) {
      $result = Cotizacion::selectRaw("
        cotcab.CCNUMDOC,
        cotcab.CCVERSION,
        cotcab.CCFECDOC,
        cotcab.CCNOMBRE,
        cotcab.CCFECSYS,
        (CASE WHEN cotcab.CCIMPORTEVTA=cotcab.CCRETENCION THEN round(cotcab.CCIMPORTEVTA,2) ELSE round(cotcab.CCRETENCION,2) END) AS CCIMPORTEVTA,
        CONCAT(users.nombre,' ',users.apepat,' ',users.apemat) usuario,
        cotcab.CCESTADO
      ")->join('users',function($join){
        $join->on('users.documento','=','cotcab.CCUSER');
      })->where('CCNUMDOC',$request->cotizacion)->orderBy('CCVERSION','asc')->get();

      return [
        'data' => $result
      ];
    }
    $data = [
      'title' => 'Versionar Cotizacion',
      'js' => 'procesos/versionar_cotizacion'
    ];
      return view('procesos.cotizacion.versionar_cotizacion',$data);

  }
  function getMetrica(Request $request){
    try {
      $metricas = Influencer::selectRaw("
        acciones.codigo influencer_codigo,
        influencers.metricas
      ")->rightJoin('acciones',function($join){
        $join->on('acciones.codigo','=','influencers.influencer');
      })->where('acciones.estado',1)->where('acciones.codigo',$request->influencer)->first();
      $metricas_form = RedSocial::where('estado',1)->get();

      $data = [
        'metricas_influencer' => $metricas,
        'metricas_form' => $metricas_form,
      ];
      return  view('procesos.cotizacion.modal.metricas',$data);
    } catch (\Exception $e) {
      return $e->getMessage();
    }
  }

  function mantenimiento(Request $request){
    if ($request->ajax()) {
      $result = Cotizacion::selectRaw("
        cotcab.CCNUMDOC,
        cotcab.CCVERSION,
        cotcab.CCFECDOC,
        cotcab.CCNOMBRE,
        (CASE WHEN cotcab.CCIMPORTEVTA=cotcab.CCRETENCION THEN round(cotcab.CCIMPORTEVTA,2) ELSE round(cotcab.CCRETENCION,2) END) AS CCIMPORTEVTA,
        CONCAT(users.nombre,' ',users.apepat,' ',users.apemat) usuario,
        cotcab.CCESTADO
      ")->join('users',function($join){
        $join->on('users.documento','=','cotcab.CCUSER');
      })->where('CCVERSION',0)->whereYear('cotcab.CCFECDOC',$request->periodo)->orderBy('CCNUMDOC','desc')->get();

      return [
        'data' => $result
      ];
    }
    $data = [
      'title' => 'Editar Cotizacion',
      'js' => 'procesos/mantenimiento_cotizacion'
    ];
      return view('procesos.cotizacion.versionar_cotizacion',$data);

  }

  function update(Request $request){
    try {
      $cliente = Cliente::where('CCODCLI',$request->CCCODCLI)->first();
      $data = [
        //'CCNUMDOC' => $request->CCNUMDOC,
        //'CCVERSION' => $request->CCVERSION+1,
        'CCFECDOC' => date('Y-m-d'),
        'CCFECVEN' => date('Y-m-d',strtotime(date('Y-m-d').' + 1 months')),
        'CCCODCLI' => $request->CCCODCLI,
        'CCNOMBRE' => $cliente->CNOMCLI,
        'CCRUC' => $cliente->CNUMRUC,
        'CCIMPORTE' => $request->total_sinigv_pen,
        'CCIMPORTEUSD' => $request->total_sinigv_usd,
        'CCFORVEN' => $request->CCFORVEN,
        'CCTIPCAM' => $request->CCTIPCAM,
        'CCUSER' => Auth::user()->documento,
        'CCESTADO' => 0,
        'CCGLOSA' => $request->CCGLOSA,
        'CCIGV' => $request->total_sinigv_pen*0.18,
        'CCIGVUSD' => $request->total_sinigv_usd*0.18,
        'CCFEEPOR' => $request->fee,
        'CCIMPORTEVTA' => $request->total_venta,
        'CCRETENCION' => $request->retencion,
        'CCFECSYS' => date('Y-m-d H:i:s')
      ];
      Cotizacion::where('CCNUMDOC',$request->CCNUMDOC)->where('CCVERSION',$request->CCVERSION)->update($data);
      $item=1;

      DB::table('cotdet')->where('CDNUMDOC',$request->CCNUMDOC)->where('CDVERSION',$request->CCVERSION)->delete();

      foreach (json_decode($request->detalle) as $key) {
        $data_detalle = [
          'CDNUMDOC' => $request->CCNUMDOC,
          'CDVERSION' => $request->CCVERSION+1 ,
          'CDSECUEN' => $item ,
          'CDPRODUCTO' => $key->producto_cliente,
          'CDCODIGO' => $key->codigo ,
          'CDDESCRI' => trim($key->descripcion) ,
          'CDGLOSA' => trim($key->glosa) ,
          'CDCANJE' => $key->canje ,
          'CDPREUNIT' => $key->precio ,
          'CDMONEDA' => $key->moneda ,
          'CDCANTID' => $key->cantidad ,
          'CDTOTVEN' => $key->total ,
          'CDREDSOCIAL' => $key->red_social ,
          'CDINPUT' => $key->input ,
          'CDESTADO' => 0
        ];
        DB::table('cotdet')->insert($data_detalle);
        $item++;
      }
      return [
          'title' => 'Buen Trabajo',
          'text'  => 'Se actualiz?? la cotizaci??n # '.str_pad($request->CCNUMDOC,7,"0",STR_PAD_LEFT),
          'type'  => 'success'
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
