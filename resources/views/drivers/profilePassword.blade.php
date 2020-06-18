@extends('layout.main')
@section('title','Editar contraseña')
@push('styles')
<link href="{{ url('css/drivers.css') }}" rel="stylesheet">
@endpush
@section('main')
<div class="main-content">
<h1 class="underline mt-2">Editar contraseña</h1>
@if(Session::has('message'))
      <div class="alert alert-{{Session::get('message.class')}}">
                  <p class="{{Session::get('message.class')}}"><span class="title">{{Session::get('message.title')}}</span>{{Session::get('message.content')}}</p>
                  <a href="#" id="closeBtn">Close<i class="gg-close-r {{Session::get('message.class')}}"></i></a>
      </div>
@endif
<section>
    <form action="{{route('profile.editPassword')}}" method="post">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="current-password">Contraseña Actual</label>
            <input type="password" name="current-password" class="form-control" value="{{old('current-password')}}">
            @if($errors->has('current-password'))
                <div class="alert alert-danger"><p class="danger">{{ $errors->first('current-password') }}</p></div>
            @endif
        </div>
        <div class="form-group">
            <label for="new-password">Nueva contraseña</label>
            <input type="password" name="new-password" class="form-control">
            @if($errors->has('new-password'))
                <div class="alert alert-danger"><p class="danger">{{ $errors->first('new-password') }}</p></div>
            @endif
        </div>
        <div class="form-group">
            <label for="password_confirmation">Confirmar contraseña</label>
            <input type="password" name="new-password_confirmation" class="form-control">
            @if($errors->has('password_confirmation'))
                <div class="alert alert-danger"><p class="danger">{{ $errors->first('password_confirmation') }}</p></div>
            @endif
        </div>
        <button class="btn btn-remis-dark btn-block">Guardar</button>
        
    </form>
</section>
</div>
@endsection