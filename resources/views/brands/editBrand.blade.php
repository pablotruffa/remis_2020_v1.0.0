@extends('layout.main')
@section('title')
Editar Marca
@endsection

@section('main')
<h1>Editar marca de vehículo.</h1>
<section>
<form action="{{ route('brand.edit', ['id' => $brand->id ]) }}" method="post">
@csrf
@method('PUT')
  <div class="form-group">
    <label for="brand">Editando la marca <strong>{{$brand->brand}}.</strong></label>
    <input type="text" class="form-control" id="brand" name="brand" value="{{ old('brand') ?? $brand->brand}}">
            @if($errors->has('brand'))
                <div class="alert alert-danger">{{ $errors->first('brand') }}</div>
            @endif
  </div>
  <button type="submit" class="btn btn-primary">Editar y guardar</button>
</form>
</section>

</section>
@endsection