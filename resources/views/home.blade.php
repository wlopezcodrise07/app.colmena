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
                <p class="lead mb-0 text-white-50">A professionally designed admin panel template built with Bootstrap 5</p>
            </div>
        </div>
    </header>
    <div class="container-xl px-4">
      <div class="row">
        <div class="col-md-12">
          <center>
            <img src="{{asset('img/colmena_logo.png')}}" alt="">
          </center>
        </div>
      </div>
    </div>
</main>
@endsection
