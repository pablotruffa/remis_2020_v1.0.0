@extends('layout.main')
@section('title','Cancelaciones')

@push('styles')
    <link href="{{ url('css/cancellation.css') }}" rel="stylesheet">
@endpush

@section('main')
<div class="main-content">
<h1>Cancelar reserva: #{{$reservation->confirmation_number}}</h1>
@if(Session::has('message'))
    <div class="alert alert-{{Session::get('message.class')}}">
                <p class="{{Session::get('message.class')}}"><span class="title">{{Session::get('message.title')}}</span>{{Session::get('message.content')}}</p>
                <a href="#" id="closeBtn">Close<i class="gg-close-r {{Session::get('message.class')}}"></i></a>
    </div>
@endif

<form action="{{ route('reservation.cancel',['id' => $reservation->id]) }}" method="post">
@csrf
@method('PUT')
<p class="my-1">Justificar:</p>
@foreach($cancellation_reasons as $reason)
<div class="form-check my-1">
  <input class="form-check-input" type="radio" name="reason_id" id="{{$reason->id}}" value="{{$reason->id}}"
  {{ (old('reason_id') == $reason->id)? 'checked':''}}
  >
  <label class="form-check-label" for="{{$reason->id}}">
  {{ $reason->reason}}
  </label>
</div>
@endforeach
      @if($errors->has('reason_id'))
          <div class="alert alert-danger"><p class="danger">{{ $errors->first('reason_id') }}</p></div>
      @endif
<div class="form-group">
<label for="remark">Observaciones:</label>
<textarea name="remark" id="remark" cols="10" rows="3" class="form-control">{{ old('remark') }}</textarea>
      @if($errors->has('remark'))
          <div class="alert alert-danger"><p class="danger">{{ $errors->first('remark') }}</p></div>
      @endif
</div>
<button class="btn mt-2">Cancelar reserva</button>
</form>
</div>
@endsection