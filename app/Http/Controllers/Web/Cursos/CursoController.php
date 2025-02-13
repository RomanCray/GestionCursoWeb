<?php

namespace App\Http\Controllers\Web\Cursos;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CursoController extends Controller
{
    public function index()
    {
        $response = Http::get(env('API_DOMAIN').'/api/cursos/get-all-courses');

        if ($response->successful()) {
            $cursos = $response->json();
            if (!isset($cursos["message"])) {
                $cursos = array_filter($cursos["cursos"], function ($curso) {
                    $fechaInicio = new \DateTime($curso['fecha_inicio']);
                    $fechaLimite = new \DateTime('-6 months');
                    return $fechaInicio >= $fechaLimite;
                });

                usort($cursos, function ($a, $b) {
                    return count($b['estudiante']) - count($a['estudiante']);
                });

                $topCursos = $cursos;
            } else {
                $topCursos = [];
            }
        } else {
            $topCursos = [];
        }

        return view('cursos.index', compact('topCursos'));

    }

    public function verCurso(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $id = $request->input('id');

        $response = Http::get(''. env('API_DOMAIN').'/api/cursos/get-course?id=' . $id);

        if ($response->successful()) {
            $curso = $response->json();
        } else {
            $curso = null;
        }

        return view('cursos.verCurso', compact('curso'));
    }

    public function createUpdateCurso(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $id = $request->input('id');

        if ($id == 0) {
            $curso = null;
        } else {
            $response = Http::get(''. env('API_DOMAIN').'/api/cursos/get-course?id=' . $id);

            if ($response->successful()) {
                $curso = $response->json();
            } else {
                $curso = null;
            }
        }

        return view('Cursos.createUpdate', compact('curso'));
    }
}
