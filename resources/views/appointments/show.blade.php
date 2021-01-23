@extends('layouts.panel')

@section('content')

<div class="card shadow">
    <div class="card-header border-0">
      <div class="row align-items-center">
        <div class="col">
          <h3 class="mb-0">cita #{{ $appointment->id }}</h3>
        </div>
      </div>
    </div>
    <div class="card body">
      <ul>
        <li>
          <strong>Fecha:</strong>{{ $appointment->scheduled_date }}
        </li>
        <li>
          <strong>Hora:</strong>{{ $appointment->scheduled_time_12 }}
        </li>
        @if($role == 'patient' || $role == 'admin')
        <li>
          <strong>Médico:</strong>{{ $appointment->doctor->name }}
        </li>
        @endif

        @if($role == 'doctor' || $role == 'admin')
        <li>
          <strong>Paciente:</strong>{{ $appointment->patient->name }}
        </li>
        @endif
        <li>
          <strong>Especialidad:</strong>{{ $appointment->speciality->name }}
        </li>

        <li>
          <strong>Tipo:</strong>{{ $appointment->type }}
        </li>
        <li>
          <strong>Estado:</strong>
           @if($appointment->status == 'Cancelada')
            <span class="badge badge-danger">Cancelada</span>
           @else
            <span class="badge badge-success">{{ $appointment->status }}</span>
           @endif 
        </li>
        @if($appointment->status == 'Cancelada')
          <div class="alert alert-warning">
            @if($appointment->cancellation)
            <li><Strong>Fecha de cancelación</Strong>
              {{ $appointment->cancellation->created_at }}
            </li>
            <li><Strong>¿Quién canceló la cita?</Strong>
              @if(auth()->id() == $appointment->cancellation->cancelled_by_id)
                Tú
              @else  
              {{ $appointment->cancellation->cancelled_by->name }}
              @endif
            </li>
            <li><Strong>Justificación: </Strong>
              {{ $appointment->cancellation->justification }}
            </li>
            @else
              <li>* Esta cita fue cancelada antes de su confirmación</li>
            @endif
          </div>
        @endif  
      </ul>

      <a href="{{ url('/appointments') }}" class="btn btn-default">
      Volver
      </a>
    </div>
  </div>
@endsection
 