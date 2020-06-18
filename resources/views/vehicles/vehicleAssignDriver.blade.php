@extends('layout.main')
@section('title')
Asignación de choferes
@endsection

@section('main')
<h1>Asignación de choferes</h1>
@if(Session::has('message'))
        <div class="alert alert-{{ Session::get('message.class') }} alert-dismissible fade show" role="alert">
          <strong>{{ Session::get('message.title') }}</strong> {{ Session::get('message.content') }}
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
@endif


<p>{{ $vehicle->brand->brand.' '.$vehicle->model.' '. $vehicle->patent }}</p>
<form action="{{ route('vehicle.assign_driver',['id' => $vehicle->id]) }}" method="post">
@csrf
@method('PUT')
@foreach($available_drivers as $ad)
<div class="form-check">
  <input class="form-check-input" type="radio" name="driver" id="{{$ad->id}}" value="{{$ad->id}}">
  <label class="form-check-label" for="{{$ad->id}}">
  {{ $ad->first_name.' '.$ad->last_name.' '.$ad->license }}
  </label>
</div>
@endforeach
<button>Asignar</button>
</form>


@endsection