<?php

namespace App\Http\Controllers\Mantenimiento;

use App\Http\Controllers\Controller;
use App\Models\Influencer;
use App\Models\CategoriaRedSocial;
use App\Models\Accion;
use Illuminate\Http\Request;
use DB;
class InfluencerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
      if ($request->ajax()) {
        $result = Influencer::selectRaw("
          influencers.*,
          acciones.descripcion influencer_descripcion,
          acciones.codigo influencer_codigo
        ")->rightJoin('acciones',function($join){
          $join->on('acciones.codigo','=','influencers.influencer');
        })->where('acciones.estado',1)->get();
        return [
          'data' => $result
        ];
      }
      $data = [
        'title' => 'Influencers',
        'js' => 'mantenimiento/influencer',
        'categorias' => CategoriaRedSocial::where('estado',1)->get(),
        'influencers' => Accion::where('estado',1)->where('tipo',1)->get(),
      ];
        return view('mantenimiento.influencer',$data);
    }

    public function store(Request $request)
    {
      try {

        $data = [
          'influencer' => $request->influencer,
          "representacion" => $request->representacion,
          "celular" => $request->celular,
          "correo" => $request->correo,
          "categorias" =>  $request->categorias
        ];
        if (Influencer::where('influencer',$request->influencer)->first()) {
          Influencer::where('influencer',$request->influencer)->update($data);
        }else {
          Influencer::insert($data);
        }

        return [
          'title' => 'Buen Trabajo',
          'text' =>  'Se actualizó exitósamente los datos del influencers',
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
       return Influencer::selectRaw("
         influencers.*,
         acciones.descripcion influencer_descripcion,
         acciones.codigo influencer_codigo
       ")->rightJoin('acciones',function($join){
         $join->on('acciones.codigo','=','influencers.influencer');
       })->where('acciones.estado',1)->where('acciones.codigo',$request->id)->first();
     }

      public function editMetrica(Request $request)
      {
        try {
          $metricas = Influencer::selectRaw("
            acciones.codigo influencer_codigo,
            influencers.metricas
          ")->rightJoin('acciones',function($join){
            $join->on('acciones.codigo','=','influencers.influencer');
          })->where('acciones.estado',1)->where('acciones.codigo',$request->id)->first();
          $metricas_form = DB::table("metricas_redes_sociales")->get();

          $data = [
            'metricas_influencer' => $metricas,
            'metricas_form' => $metricas_form,
          ];
          return  view('mantenimiento.influencer.metricas',$data);
        } catch (\Exception $e) {
          return $e->getMessage();
        }
      }
      public function storeMetrica(Request $request)
      {
        try {

          $data = [
            "metricas" => $request->metricasArray
          ];
          Influencer::where('influencer',$request->influencer)->update($data);

          return [
            'title' => 'Buen Trabajo',
            'text' =>  'Se actualizó exitósamente las métricas del influencers',
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
    public function destroy(Influencer $influencer)
    {
        //
    }
}
