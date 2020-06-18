@extends('layout.main')
@section('title','Nuevo vehículo')

@push('styles')
<link href="{{ url('css/vehicles.css') }}" rel="stylesheet">
@endpush

@section('main')
<div class="main-content">
<h1 class="underline my-2">Agregar un nuevo vehículo.</h1>
<section>
<form action="{{ route('vehicle.create') }}" method="post" enctype="multipart/form-data">
@csrf
  <div class="form-group">
    <label for="brand">Marca</label>
    <select class="form-control" id="brand" name="id_brand">
      @foreach($brands as $brand)
      <option value="{{ $brand->id }}"{{ old('id_brand') == $brand->id ? 'selected' : '' }}
      >{{ $brand->brand }}</option>
      @endforeach
    </select>
            @if($errors->has('id_brand'))
                <div class="alert alert-danger"><p class="danger">{{ $errors->first('id_brand') }}</p></div>
            @endif
  </div>
  <div class="form-group">
    <label for="model">Modelo</label>
    <input type="text" class="form-control" id="model" name="model" value="{{ old('model') }}">
            @if($errors->has('model'))
                <div class="alert alert-danger"><p class="danger">{{ $errors->first('model') }}</p></div>
            @endif
  </div>
  <div class="form-group">
    <label for="patent">Patente</label>
    <input type="text" class="form-control" id="patent" name="patent" value="{{ old('patent') }}">
            @if($errors->has('patent'))
                <div class="alert alert-danger"><p class="danger">{{ $errors->first('patent') }}</p></div>
            @endif
  </div>
  <div class="form-group">
    <label for="year">Año</label>
    <input type="number" class="form-control" id="year" name="year" value="{{ old('year') }}">
            @if($errors->has('year'))
                <div class="alert alert-danger"><p class="danger">{{ $errors->first('year') }}</p></div>
            @endif
  </div>
  <div class="form-group">
    <label for="color">Color</label>
    <select class="form-control" id="color" name="id_color">
      @foreach($colors as $color)
      <option value="{{ $color->id }}" {{ old('id_color') == $color->id ? 'selected' : '' }}>{{ $color->color }}</option>
      @endforeach
    </select>
            @if($errors->has('id_color'))
                <div class="alert alert-danger"><p class="danger">{{ $errors->first('id_color') }}</p></div>
            @endif
  </div>
  <div class="form-group">
    <label for="picture">Imagen de perfil</label>
    <input type="file" class="form-control" id="picture" name="picture">
            @if($errors->has('picture'))
                <div class="alert alert-danger"><p class="danger">{{ $errors->first('picture') }}</p></div>
            @endif
  </div>
  <button type="submit" class="btn btn-primary">Agregar vehículo</button>
</form>
</section>

</section>
</div>
@endsection