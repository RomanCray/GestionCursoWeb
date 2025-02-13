@extends('layouts.app')

@section('title', $estudiante == null ? 'Crear Estudiante' : 'Editar Estudiante')

@section('content')

    @if ($estudiante == null)
        <h1>Crear Estudiante</h1>
        <form id="estudianteForm">
            <label for="nombre">Nombre:</label>
            <input class="form-control" type="text" id="nombre" name="nombre" required><br>

            <label for="apellido">Apellido:</label>
            <input class="form-control" type="text" id="apellido" name="apellido" required><br>

            <label for="edad">Edad:</label>
            <input class="form-control" type="number" id="edad" name="edad" required><br>

            <label for="correo_electronico">Correo Electrónico:</label>
            <input class="form-control" type="email" id="correo_electronico" name="correo_electronico" required><br>
            @if (count($cursosDisponibles))

                <label>Selecciona al menos un curso:</label>
                <div class="row">

                    @foreach ($cursosDisponibles['cursos'] as $curso)
                        <div class="col-md-4 col-sm-6 col-12">
                            <div class="form-check">
                                <input class="form-check-input curso-checkbox" type="checkbox"
                                    id="curso_{{ $curso['id'] }}" name="cursos[]" value="{{ $curso['id'] }}">
                                <label class="form-check-label"
                                    for="curso_{{ $curso['id'] }}">{{ $curso['nombre'] }}</label>
                            </div>
                        </div>
                    @endforeach
                </div>
                <br>

                <button type="button" class="btn btn-outline-success" id="guardarEstudianteBtn">Crear Estudiante</button>
            @else
                <div class="alert alert-warning">No hay cursos disponibles. Primero cree algun curso</div>
            @endif
        </form>

        <script>
            $(document).ready(function() {
                $('#guardarEstudianteBtn').click(function() {
                    var cursosSeleccionados = $('.curso-checkbox:checked').map(function() {
                        return $(this).val();
                    }).get();

                    if (cursosSeleccionados.length === 0) {
                        Swal.fire({
                            title: "Error",
                            text: 'Debe seleccionar al menos un curso.',
                            icon: 'error'
                        });
                        return;
                    }

                    var data = {
                        nombre: $('#nombre').val(),
                        apellido: $('#apellido').val(),
                        edad: $('#edad').val(),
                        correo_electronico: $('#correo_electronico').val(),
                        cursos: cursosSeleccionados
                    };

                    console.log(data);
                    console.log(JSON.stringify(data));

                    $.ajax({
                        url: ' {{ env('API_DOMAIN') }}/api/estudiante/create-student',
                        type: 'POST',
                        contentType: 'application/json',
                        data: JSON.stringify(data),
                        success: function(response) {
                            Swal.fire({
                                title: "Muy bien!",
                                text: 'El estudiante ha sido creado exitosamente.',
                                icon: 'success'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href =
                                        "{{ env('APP_URL') }}/estudiante";
                                }
                            });
                        },
                        error: function(error) {
                            console.log(error.responseJSON);
                            console.log(responseJSON.errors);
                            var errorMessage = 'Hubo un problema al actualizar el curso.';
                            if (error.responseJSON && error.responseJSON.errors) {
                                errorMessage = Object.values(error.responseJSON.errors).flat().join(
                                    ', ');
                            }
                            console.log(errorMessage);
                            Swal.fire({
                                title: 'Error',
                                text: 'Hubo un problema al crear el estudiante.',
                                icon: 'error'
                            });
                        }
                    });
                });
            });
        </script>
    @else
        <h1>Editar Estudiante</h1>
        <form id="estudianteForm">
            <label for="nombre">Nombre:</label>
            <input class="form-control" type="text" id="nombre" value="{{ $estudiante[0]['nombre'] }}" name="nombre"
                required><br>

            <label for="apellido">Apellido:</label>
            <input class="form-control" type="text" id="apellido" value="{{ $estudiante[0]['apellido'] }}"
                name="apellido" required><br>

            <label for="edad">Edad:</label>
            <input class="form-control" type="number" id="edad" value="{{ $estudiante[0]['edad'] }}" name="edad"
                required><br>

            <label for="correo_electronico">Correo Electrónico:</label>
            <input class="form-control" type="email" id="correo_electronico"
                value="{{ $estudiante[0]['correo_electronico'] }}" name="correo_electronico" required><br>

            <label>Cursos Inscritos:</label>

            <div class="row">
                @foreach ($cursosDisponibles['cursos'] as $curso)
                    <div class="col-md-4 col-sm-6 col-12">
                        <div class="form-check">
                            <input class="form-check-input curso-checkbox" type="checkbox" id="curso_{{ $curso['id'] }}"
                                name="cursos[]" value="{{ $curso['id'] }}"
                                @if (in_array($curso['id'], $cursosInscritos)) checked @endif>
                            <label class="form-check-label" for="curso_{{ $curso['id'] }}">{{ $curso['nombre'] }}</label>
                        </div>
                    </div>
                @endforeach
            </div>

            <br>

            <button type="button" class="btn btn-outline-success" id="guardarEstudianteBtn">Editar Estudiante</button>
        </form>

        <script>
            $(document).ready(function() {
                $('#guardarEstudianteBtn').click(function() {
                    var cursosSeleccionados = $('.curso-checkbox:checked').map(function() {
                        return $(this).val();
                    }).get();

                    if (cursosSeleccionados.length === 0) {
                        Swal.fire({
                            title: "Error",
                            text: 'Debe seleccionar al menos un curso.',
                            icon: 'error'
                        });
                        return;
                    }

                    var data = {
                        nombre: $('#nombre').val(),
                        apellido: $('#apellido').val(),
                        edad: $('#edad').val(),
                        correo_electronico: $('#correo_electronico').val(),
                        cursos: cursosSeleccionados
                    };

                    console.log(data);
                    console.log(JSON.stringify(data));

                    $.ajax({
                        url: ' {{ env('API_DOMAIN') }}/api/estudiante/update-student?id={{ $estudiante[0]['id'] }}',
                        type: 'PUT',
                        contentType: 'application/json',
                        data: JSON.stringify(data),
                        success: function(response) {
                            Swal.fire({
                                title: "Muy bien!",
                                text: 'El estudiante ha sido actualizado exitosamente.',
                                icon: 'success'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href =
                                        "{{ env('APP_URL') }}/estudiante";
                                }
                            });
                        },
                        error: function(error) {
                            console.log(error.responseJSON);
                            console.log(responseJSON.errors);
                            var errorMessage = 'Hubo un problema al actualizar el curso.';
                            if (error.responseJSON && error.responseJSON.errors) {
                                errorMessage = Object.values(error.responseJSON.errors).flat().join(
                                    ', ');
                            }
                            console.log(errorMessage);
                            Swal.fire({
                                title: 'Error',
                                text: 'Hubo un problema al actualizar el estudiante.',
                                icon: 'error'
                            });
                        }
                    });
                });
            });
        </script>
    @endif

@endsection
