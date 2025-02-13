@extends('layouts.app')

@section('title', 'Detalles del Estudiante')

@section('content')
    <h1 class="mb-4">Detalles del Estudiante</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (is_null($estudiante) || empty($estudiante))
        <div class="alert alert-warning">No se encontró el estudiante.</div>
    @else
        <div class="card">
            <div class="card-header bg-info text-white">
                <h3>{{ $estudiante[0]['nombre'] }} {{ $estudiante[0]['apellido'] }}</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>ID</th>
                        <td>{{ $estudiante[0]['id'] }}</td>
                    </tr>
                    <tr>
                        <th>Nombre Completo</th>
                        <td>{{ $estudiante[0]['nombre'] }} {{ $estudiante[0]['apellido'] }}</td>
                    </tr>
                    <tr>
                        <th>Correo Electrónico</th>
                        <td>{{ $estudiante[0]['correo_electronico'] }}</td>
                    </tr>
                    <tr>
                        <th>Edad</th>
                        <td>{{ $estudiante[0]['edad'] }}</td>
                    </tr>
                    <tr>
                        <th>Cursos Inscritos</th>
                        <td>
                            @if (!empty($estudiante[0]['cursos']))
                                <ul class="list-group">
                                    @foreach ($estudiante[0]['cursos'] as $curso)
                                        <li class="list-group-item">
                                            📚 <strong>{{ $curso['nombre'] }}</strong> <br>
                                            ⏰ Horario: {{ $curso['horario'] }} <br>
                                            📅 Inicio: {{ $curso['fecha_inicio'] }} | Fin: {{ $curso['fecha_fin'] }}
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <span class="text-muted">No está inscrito en ningún curso.</span>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    @endif
@endsection
