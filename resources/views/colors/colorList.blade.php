@extends('layout.main')
@section('title')
Listado de colores
@endsection

@section('main')
<h1>Listado de colores</h1>
<section>
    <p>Agregar un nuevo colore de vehículo. <br><a href="{{ route('color.new')}}" class="btn btn-primary">Nuevo color</a></p>
</section>
@if(Session::has('message'))
        <div class="alert alert-{{ Session::get('message.class') }} alert-dismissible fade show" role="alert">
          <strong>{{ Session::get('message.title') }}</strong> {{ Session::get('message.content') }}
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
@endif
<section>
<table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">#</th>
      <th scope="col">Color</th>
      <th scope="col">Editar</th>
      <th scope="col">Eliminar</th>
    </tr>
  </thead>
  <tbody>
    @foreach($colors as $color)
    <tr>
      <td>{{$color->id}}</td>
      <td>{{$color->color}}</td>
      <td><a href="{{ route('color.formEdit',['id' => $color->id]) }}">Editar</a></td>
      <td>
      <form action="{{ route('color.delete',['id'=>$color->id])}}" method="post">
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

