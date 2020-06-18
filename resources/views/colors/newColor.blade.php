@extends('layout.main')
@section('title')
Nueva color
@endsection

@section('main')
<h1>Agregar un nuevo color de vehículo.</h1>
<section id="addColor">
<form action="{{ route('color.create') }}" method="post">
@csrf
  <div class="form-group">
    <label for="color">Color</label>
    <input type="text" class="form-control" id="color" name="color" value="{{ old('color') }}">
            @if($errors->has('color'))
                <div class="alert alert-danger">{{ $errors->first('color') }}</div>
            @endif
  </div>
  <button type="submit" class="btn btn-primary">Agregar</button>
</form>
</section>

</section>
@endsection