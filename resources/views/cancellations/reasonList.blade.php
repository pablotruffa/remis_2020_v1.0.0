@extends('layout.main')
@section('title')
Listado razones de cancelamiento
@endsection

@section('main')
<h1>Listado de razones para cancelar una reserva.</h1>

<section id="list">
<table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">#</th>
      <th scope="col">Razón</th>
    </tr>
  </thead>
  <tbody>
    @foreach($reasons as $reason)
    <tr>
      <td>{{$reason->id}}</td>
      <td>{{$reason->reason}}</td>
      </td>
    </tr>
   @endforeach
  </tbody>
</table>
</section>

@endsection

