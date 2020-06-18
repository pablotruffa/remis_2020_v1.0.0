@extends('layout.main')
@section('title','Usuarios')
@push('styles')
<link href="{{ url('css/remisUsers.css') }}" rel="stylesheet">
@endpush
@section('main')
<div class="main-content">
<h1 class="underline my-2">Lista de usuarios con acceso al panel</h1>
@if(Session::has('message'))
    <div class="alert alert-{{Session::get('message.class')}}">
                <p class="{{Session::get('message.class')}}"><span class="title">{{Session::get('message.title')}}</span>{{Session::get('message.content')}}</p>
                <a href="#" id="closeBtn">Close<i class="gg-close-r {{Session::get('message.class')}}"></i></a>
    </div>
@endif
<div class="table-responsive">
<table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">Usuario</th>
      <th scope="col">Nivel</th>
      <th scope="col">Acceso al Panel</th>
      <th scope="col">Acciones</th>
    </tr>
  </thead>
  <tbody>
    @foreach($users as $user)
    <tr>
      <form action="{{route('users.edit',['id'=>$user->id])}}" method="post">
      @csrf
      @method('PUT')
      <td>{{ $user->email }}</td>
      <td>
        <select name="level" id="" class="custom-select custom-select-sm">
        @foreach($levels as $level)
        <option value="{{$level->id}}"
        {{$user->level_id == $level->id ? 'selected':''}}
        >{{$level->level}}</option>
        @endforeach
        </select>
      </td>
      <td>
        <select name="permit" id="" class="custom-select custom-select-sm">
          <option value="202" {{ $user->deleted_at ? '':'selected'}}>Permitido</option>
          <option value="403" {{ $user->deleted_at ? 'selected':''}}>Denegado</option>
        </select>
      </td>
      <td><button class="btn btn-sm btn-secondary">Guardar</button></td>
      </form>
    </tr>
   @endforeach
  </tbody>
</table>
</div>
</div>
@endsection