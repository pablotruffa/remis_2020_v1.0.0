@extends('layout.main')
@section('title')
Editar color
@endsection

@section('main')
<h1>Editar color de vehículo.</h1>
<section>
<form action="{{ route('color.edit',['id'=>$color->id]) }}" method="post">
@csrf
@method('PUT')
  <div class="form-group">
    <label for="brand">Editando el color <strong>{{$color->color}}.</strong></label>
    <input type="text" class="form-control" id="color" name="color" value="{{ old('color') ?? $color->color}}">
            @if($errors->has('color'))
                <div class="alert alert-danger">{{ $errors->first('color') }}</div>
            @endif
  </div>
  <button type="submit" class="btn btn-primary">Editar y guardar</button>
</form>
</section>

</section>
@endsection