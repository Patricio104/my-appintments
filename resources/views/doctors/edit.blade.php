@extends('layouts.panel')

@section('styles')
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
@endsection

@section('content')

<div class="card shadow">
    <div class="card-header border-0">
      <div class="row align-items-center">
        <div class="col">
          <h3 class="mb-0">Editar médico</h3>
        </div>
        <div class="col text-right">
          <a href="{{ url('doctors') }}" class="btn btn-sm btn-default">Cancelar y volver</a>
        </div>
      </div>
    </div>
    <div class="table-responsive">
      <div class="card-body">
        @if ($errors->any())
        <div class="alert alert-danger" role="alert">
              <ul>
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul> 
        </div>
        @endif
        <form action="{{ url('doctors/' .$doctor->id) }}" method="post">
          @csrf
          @method('PUT')
          <div class="form-group">
          <label for="name">Nombre del médico</label>
          <input type="text" name="name" class="form-control" value="{{ old('name', $doctor->name) }}" required>
        </div>
        <div class="form-group">
          <label for="email">E-mail</label>
          <input type="text" name="email" class="form-control" value="{{ old('email', $doctor->email) }}">
        </div>
        <div class="form-group">
          <label for="dni">DNI</label>
          <input type="text" name="dni" class="form-control" value="{{ old('dni', $doctor->dni) }}">
        </div>
        <div class="form-group">
          <label for="address">Dirección</label>
          <input type="text" name="address" class="form-control" value="{{ old('address', $doctor->address) }}">
        </div>
        <div class="form-group">
          <label for="phone">Teléfono / Móvil</label>
          <input type="text" name="phone" class="form-control" value="{{ old('phone', $doctor->phone) }}">
        </div>
        <div class="form-group">
          <label for="password">Contraseña</label>
          <input type="text" name="password" class="form-control" value="">
          <p>Ingrese un valor solo si desea modificar la contraseña</p>
        </div>
        <div class="form-group">
          <label for="specialities">Especialidades</label>
          <select name="specialities[]" id="specialities" class="form-control selectpicker" data-style="btn-default" multiple title="Seleccione una o varias">
            @foreach ($specialities as $speciality)
              <option value="{{ $speciality->id }}">{{ $speciality->name }}</option>
            @endforeach  
          </select>
        </div>
        <button type="submit" class="btn btn-primary">
          Guardar
        </button>
      </form>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
  <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
  <script>
    $(document).ready(() =>{
      $('#specialities').selectpicker('val', @json($speciality_ids));
    });
  </script>
@endsection  