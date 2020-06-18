@extends('layout.main')
@section('title','Listado de choferes')
@push('styles')
<link href="{{ url('css/drivers.css') }}" rel="stylesheet">
@endpush

@section('main')
<div class="main-content">
<h1 class="underline mt-2">Listado de choferes</h1>
@if(Session::has('message'))
      <div class="alert alert-{{Session::get('message.class')}}">
                  <p class="{{Session::get('message.class')}}"><span class="title">{{Session::get('message.title')}}</span>{{Session::get('message.content')}}</p>
                  <a href="#" id="closeBtn">Close<i class="gg-close-r {{Session::get('message.class')}}"></i></a>
      </div>
@endif
<section>
    <div class="row">
      <div class="col col-xs-12 col-md-2">
      <a id="new-driver" href="{{ route('driver.formNew') }}" class="btn btn-primary">Nuevo chofer</a>
      </div>
      <div class="col col-xs-12 col-md-10">
          <form class="form-inline my-2 my-lg-0" action="{{route('driver.passport')}}" method="post">
              @csrf
              @method('GET')
              <input class="form-control mr-sm-2" type="search" placeholder="# Documento o Pasaporte" aria-label="Buscar" name="passport">
              <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Buscar</button>
          </form>
      </div>
    </div>
</section>

<section id="list">
<div class="table-responsive">
<table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">ID Chofer</th>
      <th scope="col">Nombre</th>
      <th scope="col">Apellido</th>
      <th scope="col">Acciones</th>
    </tr>
  </thead>
  <tbody>
    @foreach($drivers as $driver)
    <tr>
      <td>{{$driver->id}}</td>
      <td>{{$driver->first_name}}</td>
      <td>{{$driver->last_name}}</td>
      <td><a href="{{ route('driver.info',['id'=> $driver->id]) }}">Ver mas</a></td>
    </tr>
   @endforeach
  </tbody>
</table>
</div>
</section>
</div>
@endsection

