@extends('layouts.app')

@section('title', 'Ver Curso')

@section('content')

    @if ($curso == null)
        <h1>Crear Curso</h1>
        <form id="crearCursoForm">
            <label for="nombre">Nombre del Curso:</label>
            <input class="form-control" type="text" id="nombre" name="nombre" required><br><br>

            <label for="horario">Horario:</label>
            <input class="form-control" type="text" id="horario" name="horario" required><br><br>

            <label for="fecha_inicio">Fecha de Inicio:</label>
            <input class="form-control" type="date" id="fecha_inicio" name="fecha_inicio" required><br><br>

            <label for="fecha_fin">Fecha de Fin:</label>
            <input class="form-control" type="date" id="fecha_fin" name="fecha_fin" required><br><br>

            <button type="button" class="btn btn-outline-success" id="crearCursoBtn">Crear Curso</button>
        </form>

        <script>
            $(document).ready(function() {
                $('#crearCursoBtn').click(function() {
                    var data = {
                        nombre: $('#nombre').val(),
                        horario: $('#horario').val(),
                        fecha_inicio: $('#fecha_inicio').val(),
                        fecha_fin: $('#fecha_fin').val()
                    };

                    $.ajax({
                        url: '{{ env('API_DOMAIN') }}/api/cursos/create-course',
                        type: 'POST',
                        contentType: 'application/json',
                        data: JSON.stringify(data),
                        success: function(response) {
                            Swal.fire({
                                title: "Muy bien!",
                                text: 'El curso ha sido creado exitosamente.',
                                icon: 'success'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = "{{ env('APP_URL') }}/cursos";
                                }
                            });
                        },
                        error: function(error) {
                            Swal.fire({
                                title: 'Error',
                                text: 'Hubo un problema al crear el curso.',
                                icon: 'error'
                            });
                        }
                    });
                });
            });
        </script>
    @else
        <h1>Editar Curso</h1>
        <form id="crearCursoForm">
            <label for="nombre">Nombre del Curso:</label>
            <input class="form-control" type="text" id="nombre" value="{{ $curso[0]['nombre'] }}" name="nombre"
                required><br><br>

            <label for="horario">Horario:</label>
            <input class="form-control" type="text" id="horario" value="{{ $curso[0]['horario'] }}" name="horario"
                required><br><br>

            <label for="fecha_inicio">Fecha de Inicio:</label>
            <input class="form-control" type="date" id="fecha_inicio" value="{{ $curso[0]['fecha_inicio'] }}"
                name="fecha_inicio" required><br><br>

            <label for="fecha_fin">Fecha de Fin:</label>
            <input class="form-control" type="date" id="fecha_fin" value="{{ $curso[0]['fecha_fin'] }}" name="fecha_fin"
                required><br><br>

            <button type="button" class="btn btn-outline-success" id="crearCursoBtn">Editar Curso</button>
        </form>

        <script>
            $(document).ready(function() {
                $('#crearCursoBtn').click(function() {
                    var data = {
                        nombre: $('#nombre').val(),
                        horario: $('#horario').val(),
                        fecha_inicio: $('#fecha_inicio').val(),
                        fecha_fin: $('#fecha_fin').val()
                    };

                    $.ajax({
                        url: '{{ env('API_DOMAIN') }}/api/cursos/update-course?id={{ $curso[0]['id'] }}',
                        type: 'PUT',
                        contentType: 'application/json',
                        data: JSON.stringify(data),
                        success: function(response) {
                            Swal.fire({
                                title: "Muy bien!",
                                text: 'El curso ha sido Editado exitosamente.',
                                icon: 'success'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = "{{ env('APP_URL') }}/cursos";
                                }
                            });
                        },
                        error: function(error) {
                            console.log(error)
                            Swal.fire({
                                title: 'Error',
                                text: 'Hubo un problema al Editar el curso.',
                                icon: 'error'
                            });
                        }
                    });
                });
            });
        </script>
    @endif

@endsection
