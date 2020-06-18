@extends('layout.main')
@section('title')
Listado de marcas
@endsection

@section('main')
<h1>Listado de marcas</h1>
<section>
    <p>Agregar una nueva Marca de vehículo. <br><a href="<?= route('brand.new')?>" class="btn btn-primary">Nueva Marca</a></p>
</section>
@if(Session::has('message'))
        <div class="alert alert-{{ Session::get('message.class') }} alert-dismissible fade show" role="alert">
          <strong>{{ Session::get('message.title') }}</strong> {{ Session::get('message.content') }}
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
@endif
<section id="list">
<table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">#</th>
      <th scope="col">Marca</th>
      <th scope="col">Editar</th>
      <th scope="col">Eliminar</th>
    </tr>
  </thead>
  <tbody>
    @foreach($brands as $brand)
    <tr>
      <td>{{$brand->id}}</td>
      <td>{{$brand->brand}}</td>
      <td><a href=" {{ route('brand.formEdit', ['id' => $brand->id]) }}">Editar</a></td>
      <td>
      <form action="{{ route('brand.delete', ['id' => $brand->id]) }}" method="post">
        @csrf
        @method('DELETE')
        <button>Eliminar</button>
      </form>
      </td>
    </tr>
   @endforeach
  </tbody>
</table>
</section>

@endsection

