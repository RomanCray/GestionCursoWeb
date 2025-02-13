@extends('layouts.app')

@section('title', 'Detalles del Curso')

@section('content')
    <h1 class="mb-4">Detalles del Curso</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (is_null($curso[0]))
        <div class="alert alert-warning">No se encontró el curso.</div>
    @else
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h3>{{ $curso[0]['nombre'] }}</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>ID</th>
                        <td>{{ $curso[0]['id'] }}</td>
                    </tr>
                    <tr>
                        <th>Descripción</th>
                        <td>{{ $curso[0]['descripcion'] ?? 'No disponible' }}</td>
                    </tr>
                    <tr>
                        <th>Horario</th>
                        <td>{{ $curso[0]['horario'] }}</td>
                    </tr>
                    <tr>
                        <th>Fecha de Inicio</th>
                        <td>{{ $curso[0]['fecha_inicio'] }}</td>
                    </tr>
                    <tr>
                        <th>Fecha de Fin</th>
                        <td>{{ $curso[0]['fecha_fin'] }}</td>
                    </tr>
                    <tr>
                        <th>Estudiantes Inscritos</th>
                        <td>
                            <strong>Total: {{ count($curso[0]['estudiante']) }}</strong>
                            <ul class="list-group mt-2">
                                @foreach ($curso[0]['estudiante'] as $estudiante)
                                    <li class="list-group-item">
                                        <strong>{{ $estudiante['nombre'] }} {{ $estudiante['apellido'] }}</strong> <br>
                                        <small>📧 {{ $estudiante['correo_electronico'] }} | 🎂 Edad: {{ $estudiante['edad'] }}</small>
                                    </li>
                                @endforeach
                            </ul>
                        </td>
                    </tr>
                </table>
                {{-- <a href="{{ route('cursos.list') }}" class="btn btn-outline-secondary mt-3">Volver a la Lista de Cursos</a> --}}
            </div>
        </div>
    @endif
@endsection
