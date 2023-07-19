<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use Illuminate\Http\Request;

class AlumnoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return  Alumno::all();
/*
 * podríamos retornar
  *     $alumnos = Alumnos::all();
        return response()->json($alumnos);
 * */

        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //Validamos datos
        $request->validate([
            'nombre'=>['required'],
            'email'=>['required'],
            'password'=>['required'],
        ]);

        $datos = $request->input();
        $datos['password'] = bcrypt($datos['password']);
        $alumno = new Alumno($datos);
        $alumno->save();

        //201 es un código de elemento creado
        return response()->json($alumno,201);

        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Alumno $alumno)
    {
        return $alumno;

        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Alumno $alumno)
    {

        //Diferenciamos entre PUT y PATHC siendo muy puristas
        $verbo=$request->method();
        if ($verbo =='PUT'){ //Put aporta todos los datos del elemento a modificar
            $datos = $request->input();
            $datos['password'] = bcrypt($datos['password']);
            $alumno->update($datos);
            return $alumno;
        }
        if ($verbo =='PATCH'){ //PATCH no aporta todos los datos
            $datos = $request->input();
            foreach ($datos as $campo => $valor) {
                if ($campo=="password")
                    $valor = bcrypt($valor);
                 $alumno->$campo=$valor;
            }
            $alumno->update();
            return $alumno;
        }
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Alumno $alumno)
    {
        $alumno->delete();
        return response()->json("null",204);

        //
    }
}
