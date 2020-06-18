@extends('layout.login')
@section('title','Iniciar sesión')

@section('main')
<h1>Iniciar sesión</h1>
@if(Session::has('message'))
        <div class="alert alert-{{ Session::get('message.class') }} alert-dismissible fade show" role="alert">
          <strong>{{ Session::get('message.title') }}</strong> {{ Session::get('message.content') }}
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
@endif
<section>
  <form action="{{route('auth.doLogin')}}" method="post">
    @csrf
    <div class="form-group">
    <label for="user">Usuario</label>
    <input type="text" name="email" class="form-control">
    </div>
    <div class="form-group">
    <label for="user">Contraseña</label>
    <input type="password" name="password" class="form-control">
    </div>
    <button class="btn btn-primary">Iniciar Sesión</button>
  </form>
</section>

@endsection

