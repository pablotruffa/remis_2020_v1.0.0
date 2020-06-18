@extends('layout.main')
@section('title')
Nueva Marca
@endsection

@section('main')
<h1>Agregar una nueva marca de vehículo.</h1>
<section id="addBrand">
<form action="{{ route('brand.create') }}" method="post">
@csrf
  <div class="form-group">
    <label for="brand">Marca</label>
    <input type="text" class="form-control" id="brand" name="brand" value="{{ old('brand') }}">
            @if($errors->has('brand'))
                <div class="alert alert-danger">{{ $errors->first('brand') }}</div>
            @endif
  </div>
  <button type="submit" class="btn btn-primary">Agregar</button>
</form>
</section>

</section>
@endsection