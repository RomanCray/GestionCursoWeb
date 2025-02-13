@extends('layouts.app')

@section('title', 'Lista de Cursos')

@section('content')
    <h1 class="mb-4">Lista de Cursos</h1>

    <br>
    <a href="{{ route('cursos.create-update', ['id' => 0]) }}" type="button" class="btn btn-outline-primary">
        Crear Curso
    </a>
    <br>
    <br>

    @if (empty($topCursos))
        <div class="alert alert-warning">No hay cursos disponibles.</div>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Ranking</th>
                    <th>Nombre</th>
                    <th>Horario</th>
                    <th>Fecha Inicio</th>
                    <th>Fecha Fin</th>
                    <th>Estudiantes</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($topCursos as $index => $curso)
                    <tr>
                        <td>
                            @if ($index == 0)
                                ⭐⭐⭐
                            @elseif ($index == 1)
                                ⭐⭐
                            @elseif ($index == 2)
                                ⭐
                            @endif
                        </td>
                        <td>{{ $curso['nombre'] }}</td>
                        <td>{{ $curso['horario'] }}</td>
                        <td>{{ $curso['fecha_inicio'] }}</td>
                        <td>{{ $curso['fecha_fin'] }}</td>
                        <td>{{ count($curso['estudiante']) }}</td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    Acciones
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item"
                                            href="{{ route('cursos.ver-curso', ['id' => $curso['id']]) }}">
                                            Ver Alumnos Inscritos
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item"
                                            href="{{ route('cursos.create-update', ['id' => $curso['id']]) }}">
                                            Editar Curso
                                        </a>
                                    </li>
                                    <button type="button" class="btn btn-outline-danger" id="EliminarCursoBtn"
                                        onclick="EliminarCurso({{ $curso['id'] }})">
                                        Eliminar Curso
                                    </button>
                                </ul>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <script>
            function EliminarCurso(id) {
                $.ajax({
                    url: ' {{ env('API_DOMAIN') }}/api/cursos/delete-course?id=' + id,
                    type: 'DELETE',
                    success: function(response) {
                        Swal.fire({
                            title: "Muy bien!",
                            text: 'El curso ha sido eliminado exitosamente.',
                            icon: 'success'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = document.referrer;
                            }
                        });
                    },
                    error: function(error) {
                        Swal.fire({
                            title: 'Error',
                            text: 'Hubo un problema al eliminar el curso.',
                            icon: 'error'
                        });
                    }
                });
            }
        </script>
    @endif
@endsection
