<?php

namespace App\Http\Controllers\Web\Estudiantes;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EstudianteController extends Controller
{
    public function index()
    {
        $response = Http::get('' . env('API_DOMAIN') . '/api/estudiante/get-all-students');

        if ($response->successful()) {
            if (!isset($response->json()["message"])) {
                $estudiantes = $response->json();
            } else {
                $estudiantes = [];
            }
        } else {
            $estudiantes = [];
        }

        return view('estudiantes.index', compact('estudiantes'));
    }

    public function verEstudiante(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $id = $request->input('id');

        $response = Http::get(env('API_DOMAIN') . '/api/estudiante/get-student?id=' . $id);

        if ($response->successful()) {
            $estudiante = $response->json();
        } else {
            $estudiante = null;
        }

        return view('estudiantes.verEstudiante', compact('estudiante'));
    }

    public function createUpdateEstudiante(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $id = $request->input('id');
        $estudiante = null;
        $cursosDisponibles = [];

        $responseCursos = Http::get(env('API_DOMAIN') . '/api/cursos/get-all-courses');
        if ($responseCursos->successful()) {
            if (!isset($responseCursos->json()["message"])) {
                $cursosDisponibles = $responseCursos->json();
            } else {
                $cursosDisponibles = [];
            }
        }

        if ($id != 0) {
            $response = Http::get(env('API_DOMAIN') . '/api/estudiante/get-student?id=' . $id);

            if ($response->successful()) {
                $estudiante = $response->json();
            }
        }

        $cursosInscritos = isset($estudiante[0]['cursos']) ? array_column(array_column($estudiante[0]['cursos'], 'pivot'), 'curso_id') : [];

        return view('estudiantes.createUpdate', compact('estudiante', 'cursosDisponibles', 'cursosInscritos'));
    }
}
