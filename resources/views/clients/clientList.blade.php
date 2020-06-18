@extends('layout.main')
@section('title','Listado de clientes')
@push('styles')
<link href="{{ url('css/clients.css') }}" rel="stylesheet">
@endpush


@section('main')
<div class="main-content">
  <h1 class="underline mt-2">Listado de clientes</h1>
  @if(Session::has('message'))
      <div class="alert alert-{{Session::get('message.class')}}">
                  <p class="{{Session::get('message.class')}}"><span class="title">{{Session::get('message.title')}}</span>{{Session::get('message.content')}}</p>
                  <a href="#" id="closeBtn">Close<i class="gg-close-r {{Session::get('message.class')}}"></i></a>
      </div>
  @endif
<section>
    <div class="row">
      <div class="col col-xs-12 col-md-2">
          <a href="{{ route('client.formNew') }}" class="btn" id="new-client">Nuevo cliente</a>
      </div>
      <div class="col col-xs-12 col-md-10">
          <form class="form-inline my-2 my-lg-0" action="{{route('client.passport')}}" method="post">
              @csrf
              @method('GET')
              <input class="form-control mr-sm-2" type="search" placeholder="# Documento o Pasaporte" aria-label="Buscar" name="passport">
              <button>Buscar por documento</button>
          </form>
      </div>
    </div>
    
    
    
</section>

<section id="list">
  <p>Listado de clientes</p>
<div class="table-responsive">
<table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">ID Cliente</th>
      <th scope="col">Nombre</th>
      <th scope="col">Apellido</th>
      <th scope="col">Acciones</th>
    </tr>
  </thead>
  <tbody>
    @foreach($clients as $client)
    <tr>
      <td>{{$client->id}}</td>
      <td>{{$client->first_name}}</td>
      <td>{{$client->last_name}}</td>
      <td>
      <a href="{{ route('client.info',['id'=> $client->id]) }}">Ver mas</a> |
      <a href="{{ route('client.book',['id'=> $client->id]) }}">Reservar viaje</a>
      </td>

    </tr>
   @endforeach
  </tbody>
</table>
</div>
</section>
</div>
@endsection

