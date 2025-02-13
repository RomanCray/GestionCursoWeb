@extends('layouts.app')

@section('title', 'Lista de Estudiantes')

@section('content')
    <h1 class="mb-4">Lista de Estudiantes</h1>

    <br>
    <a href="{{ route('estudiante.create-update', ['id' => 0]) }}" type="button" class="btn btn-outline-primary">
        Crear Estudiante
    </a>
    <br>
    <br>

    @if (empty($estudiantes))
        <div class="alert alert-warning">No hay estudiantes registrados.</div>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Edad</th>
                    <th>Correo Electrónico</th>
                    <th>Cursos Inscritos</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                {{-- @dd($estudiantes) --}}
                @foreach ($estudiantes["estudiantes"] as $estudiante)
                    <tr>
                        <td>{{ $estudiante['nombre'] }}</td>
                        <td>{{ $estudiante['apellido'] }}</td>
                        <td>{{ $estudiante['edad'] }}</td>
                        <td>{{ $estudiante['correo_electronico'] }}</td>
                        <td>{{ count($estudiante['cursos']) }}</td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    Acciones
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item"
                                            href="{{ route('estudiante.ver-estudiante', ['id' => $estudiante['id']]) }}">
                                            Ver Cursos Inscritos
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item"
                                            href="{{ route('estudiante.create-update', ['id' => $estudiante['id']]) }}">
                                            Editar Estudiante
                                        </a>
                                    </li>
                                    <button type="button" class="btn btn-outline-danger" id="EliminarEstudianteBtn"
                                        onclick="EliminarEstudiante({{ $estudiante['id'] }})">
                                        Eliminar Estudiante
                                    </button>
                                </ul>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <script>
            function EliminarEstudiante(id) {
                $.ajax({
                    url: ' {{ env('API_DOMAIN') }}/api/estudiante/delete-student?id=' + id,
                    type: 'DELETE',
                    success: function(response) {
                        Swal.fire({
                            title: "Muy bien!",
                            text: 'El estudiante ha sido eliminado exitosamente.',
                            icon: 'success'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = '{{ env('APP_URL') }}/estudiante';
                            }
                        });
                    },
                    error: function(error) {
                        Swal.fire({
                            title: 'Error',
                            text: 'Hubo un problema al eliminar el estudiante.',
                            icon: 'error'
                        });
                    }
                });
            }
        </script>
    @endif
@endsection
