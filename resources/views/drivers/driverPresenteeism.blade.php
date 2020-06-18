@extends('layout.main')
@section('title','Presentismo de choferes')
@push('styles')
<link href="{{ url('css/presenteeism.css') }}" rel="stylesheet">
@endpush
@section('main')
<div class="main-content">
<h1 class="underline mt-2">Presentismo.</h1>
<p>Seleccione los choferes que estan presentes (con vehículo asignado) para tomar reservas. <br> Los que no se seleccionen pasarán a estar ausentes.</p>
@if(Session::has('message'))
      <div class="alert alert-{{Session::get('message.class')}}">
                  <p class="{{Session::get('message.class')}}"><span class="title">{{Session::get('message.title')}}</span>{{Session::get('message.content')}}</p>
                  <a href="#" id="closeBtn">Close<i class="gg-close-r {{Session::get('message.class')}}"></i></a>
      </div>
@endif


<section id="list">
<form action="{{ route('presenteeism.attendance')}}" method="post">
@csrf
@method('PUT')
@foreach($available_drivers as $ad)
<div class="form-check my-1">
  <input class="form-check-input" type="checkbox" name="driver[]" id="{{$ad->id}}" value="{{$ad->id}}"
  {{ ($ad->presenteeism == 1)? 'checked':''}}
  >
  <label class="form-check-label" for="{{$ad->id}}" {{ (in_array($ad->id,$active)) ? 'style=color:red':'' }}>
  {{ $ad->first_name.' '.$ad->last_name}} {{ (in_array($ad->id,$active)) ? '(Tiene reservas activas)':'' }}
  </label>
</div>
@endforeach
<button class="btn mt-2">Pasar lista.</button>
</form>
</section>
</div>
@endsection

