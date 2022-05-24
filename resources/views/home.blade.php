@extends('layouts.app')
@section('title')
{{$title}}
@endsection
@section('js')
{{$js}}
@endsection
@section('content')
<main>
    <header class="py-10 mb-4 bg-gradient-primary-to-secondary">
        <div class="container-xl px-4">
            <div class="text-center">
                <h1 class="text-white">Bienvenido a COLMENA DIGITAL</h1>
                <p class="lead mb-0 text-white-50">Somos una agencia especializada en influencer marketing. Amamos ser una fuente de soluciones digitales y creativas para construir conexiones duraderas con nuestros aliados estratégicos.</p>
            </div>
        </div>
    </header>
    <div class="container-xl px-4">
      <div class="row">
        <div class="col-md-12">
          <center>
            <img src="{{asset('img/colmena_logo.png')}}" width="60%" alt="">
          </center>
        </div>
      </div>
    </div>
</main>
@endsection
