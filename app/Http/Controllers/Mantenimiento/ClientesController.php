<?php

namespace App\Http\Controllers\Mantenimiento;

use App\Http\Controllers\Controller;
use Auth;
use App\Models\Cliente;
use Illuminate\Http\Request;

class ClientesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
      if ($request->ajax()) {
        $result = Cliente::get();

        return [
          'data' => $result
        ];
      }
      $data = [
        'title' => 'Clientes',
        'js' => 'mantenimiento/cliente'
      ];
        return view('mantenimiento.cliente',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      try {
        $validator = \Validator::make($request->all(), [
              'CCODCLI' => ['required', 'string', 'min:1','max:20','unique:maecli'],
              'CNUMRUC' => ['required', 'string', 'min:8','max:20','unique:maecli'],
          ], [
            'CCODCLI.required'=> 'El campo CÓDIGO no puede estar vacio',
            'CCODCLI.unique'=> 'el valor CÓDIGO registrado ya está asignado a otro cliente',
            'CNUMRUC.required'=> 'El campo RUC no puede estar vacio',
            'CNUMRUC.unique'=> 'el RUC CÓDIGO registrado ya está asignado a otro cliente',
          ]);

          if (IS_NULL($request->id)) {
            if ($validator->fails()) {
              $mensaje = json_decode($validator->errors());
              if ($mensaje->CCODCLI) {
                return [
                    'title' => 'Alerta',
                    'text'  => 'CODIGO CLIENTE : '.$mensaje->CCODCLI,
                    'type'  => 'warning'
                  ];
              }
              if ($mensaje->CNUMRUC) {
                return [
                    'title' => 'Alerta',
                    'text'  => 'RUC CLIENTE : '.$mensaje->CNUMRUC,
                    'type'  => 'warning'
                  ];
              }

            }
          }

          $data = [
            "CCODCLI" => $request->CCODCLI,
            "CNOMCLI" => mb_strtoupper($request->CNOMCLI,'UTF-8'),
            "CDIRCLI" => mb_strtoupper($request->CDIRCLI,'UTF-8'),
            "CNUMRUC" => $request->CNUMRUC,
            "CTELEFO" => $request->CTELEFO,
            "DIRFB" => $request->DIRFB,
            "DIRTWITTER" => $request->DIRTWITTER,
            "DIRINSTAGRAM" => $request->DIRINSTAGRAM,
            "DIRTIKTOK" => $request->DIRTIKTOK,
            "active" => $request->active,
          ];
          Cliente::updateOrCreate([
            'id' => $request->id
          ],  $data);

          return [
            'title' => 'Buen Trabajo',
            'text' => IS_NULL($request->id) ? 'Se registró exitósamente el cliente' : 'Se actualizó exitósamente el cliente',
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

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function show(Cliente $cliente)
    {
        //
    }


    public function edit(Request $request)
    {
      return Cliente::where('id',$request->id)->first();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cliente $cliente)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
      try {
        Cliente::where('id',$request->id)->update(['active'=>0]);
        return [
          'title' => 'Buen Trabajo',
          'text' =>  'Se desactivó el cliente',
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
