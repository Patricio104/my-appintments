@extends('layouts.panel')

@section('content')

<div class="card shadow">
    <div class="card-header border-0">
      <div class="row align-items-center">
        <div class="col">
          <h3 class="mb-0">Registrar nueva cita</h3>
        </div>
        <div class="col text-right">
          <a href="{{ url('patients') }}" class="btn btn-sm btn-default">Cancelar y volver</a>
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
        <form action="{{ url('appointments') }}" method="post">
          @csrf
          <div class="form-group">
            <label for="description">Descripción</label>
            <input type="text" value="{{ old('description') }}" name="description" id="description" class="form-control" placeholder="Describe brevemente la consulta" required>
          </div>
        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="speciality">Especialidad</label>
              <select name="speciality_id" id="speciality" class="form-control" required>
                <option value="">Seleccionar especialidad</option>
                @foreach ($specialities as $speciality)
                  <option value="{{ $speciality->id }}" @if(old('speciality_id') == $speciality->id) selected @endif>{{ $speciality->name }}</option>
                @endforeach  
              </select>
          </div>
          <div class="form-group col-md-6">
           <label for="email">Médico</label>
            <select name="doctor_id" id="doctor" class="form-control" required>
              @foreach ($doctors as $doctor)
                  <option value="{{ $doctor->id }}" @if(old('doctor_id') == $doctor->id) selected @endif>{{ $doctor->name }}</option>
                @endforeach 
            </select>
          </div>
        </div>
        <div class="form-group">
          <label for="dni">Fecha</label>
          <div class="input-group">
          <div class="input-group-prepend">
              <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
          </div>
          <input class="form-control datepicker" placeholder="Seleccionar fecha" 
            id="date" name="scheduled_date" 
            type="text" value="{{ old('scheduled_date', date('Y-m-d')) }}" 
            data-date-format="yyyy-m-d" 
            data-date-start-date="{{ date('Y-m-d') }}" 
            data-date-end-date="+30d">
          </div>
        </div>
        <div class="form-group">
          <label for="address">Hora de atención</label>
          <div id="hours">
            @if($intervals)
              @foreach ($intervals['morning'] as $key => $interval)
                <div class="custom-control custom-radio mb-3">
                  <input type="radio" id="intervalMorning{{ $key }}" name="scheduled_time" class="custom-control-input" value="{{ $interval['start'] }}" required>
                  <label class="custom-control-label" for="intervalMorning{{ $key}}">{{ $interval['start'] }} - {{ $interval['end'] }}</label>
                </div>
              @endforeach

              @foreach ($intervals['afternoon'] as $key => $interval)
                <div class="custom-control custom-radio mb-3">
                  <input type="radio" id="intervalAfternoon{{ $key }}" name="scheduled_time" class="custom-control-input" value="{{ $interval['start'] }}" required>
                  <label class="custom-control-label" for="intervalAfternoon{{ $key }}">{{ $interval['start'] }} - {{ $interval['end'] }}</label>
                </div>
              @endforeach

            @else
              <div class="alert alert-info" role="alert">
                  Selecciona un médico y una fecha, para ver sus horas disponibles
              </div>
            @endif
          </div>
        </div>
        <div class="form-group">
          <label for="type">Tipo de consulta</label>
          <div class="custom-control custom-radio mb-3">
            <input type="radio" id="type1" name="type" class="custom-control-input"
              @if(old('type', 'Consulta') == 'Consulta') checked @endif value="Consulta">
            <label class="custom-control-label" for="type1">Consulta</label>
          </div>
          <div class="custom-control custom-radio mb-3">
            <input type="radio" id="type2" name="type" class="custom-control-input"
            @if(old('type', 'Examen') == 'Examen') checked @endif value="Examen">
            <label class="custom-control-label" for="type2">Examen</label>
          </div>
          <div class="custom-control custom-radio mb-3">
            <input type="radio" id="type3" name="type" class="custom-control-input" 
            @if(old('type', 'Operación') == 'Operación') checked @endif value="Operación">
            <label class="custom-control-label" for="type3">Operación</label>
          </div>
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
  <script src="{{ asset('/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
  <script src="{{ asset('/js/appointments/create.js') }}"></script>
@endsection
