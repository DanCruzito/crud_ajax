<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CursoController extends Controller
{
    public function index(){
        return view('curso.index');
    }

    public function listar_cursos(Request $request){
     if($request->ajax()){
        //$cursos = Curso::all(); Eloquent
        $cursos = DB::table('cursos')->select('*')->get();
        //dd($cursos);
        $html = view('curso.parent.ajax_lista_cursos',compact('cursos'))
               ->render();
        return response()->json([
            'code' => 200,
            'html' => $html,
            'msg' => 'success',
           ],200); 
     }else{
       return response()->json([
        'code' => 404,
        'msg' => 'error',
        'message' => ' Error, no se puede acceder a la página'
       ],404); 
     }
    }

    public function registrar_curso(Request $request){
     if($request->ajax()){
         $curso = Curso::create([
            'nombre_curso' => $request->nombre_curso,
            'descripcion' => $request->descripcion
         ]);

        // dd($curso);
         if($curso){
            return response()->json([
                'code' => 200,
                'msg' => 'success',
                'message' => 'Curso registrado exitosamente!'
               ],200); 
         }else{
            return response()->json([
                'code' => 404,
                'msg' => 'error',
                'message' => 'Error, no se pudo registrar'
               ],404); 
         }

        
     }else{
        return response()->json([
            'code' => 404,
            'msg' => 'error',
            'message' => 'Error, no se puede acceder a la página'
           ],404); 
     }
    }
}
