<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Snippet;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class SnippetController extends Controller
//class TodosController extends Controller
{
    /**
     * index para mostrar todos los todos
     * store para guardar un todo
     * update para actualizar un todo
     * destroy para eliminar un todo
     * edit para mostrar el formulario de edición
    */

    public function store(Request $request) {
        
        $request->validate([
            'titulo' => 'required',
            'isPublic' => 'required',
            'snippet' => 'required',
        ]);

        $snippet = new Snippet;
        $snippet->titulo = $request->titulo;
        $snippet->isPublic = $request->isPublic;
        $snippet->snippet = $request->snippet;
        $snippet->user_id = auth()->id();
        $snippet->save();

        return response()->json([
            "status" => 1,
            "msg" => "Snippet creat correctament"
        ]);

        /*$receiver = DB::table('users')
        ->where('id', '=', $request->user_id)
        ->select('email')
        ->get();
        }*/      

        //return Todo::create($request->all());
    }

    public function index() {

        $id = auth()->id();

        $snippets = DB::table('snippets')
        ->where('isPublic', '=', true)
        ->orWhere('user_id', '=', $id)
        ->get();
    
        return $snippets;
    }

    public function show($id) {

        $user_id = auth()->id();

        $snippet = Snippet::find($id);

        if($snippet->user_id != $user_id && $snippet->isPublic == false) {
            return response()->json([
                "status" => 0,
                "msg" => "No tens accés a aquest snippet"
            ]);
        } else {
            return $snippet;
        }
    }

    public function update(Request $request, $id) {

        $user_id = auth()->id();

        $snippet = Snippet::find($id);

        if($snippet->user_id != $user_id) {
            return response()->json([
                "status" => 0,
                "msg" => "No pots actualitzar aquest snippet"
            ]);
        } else {
            $snippet->titulo = $request->titulo;
            $snippet->isPublic = $request->isPublic;
            $snippet->snippet = $request->snippet;
            $snippet->save();

            return response()->json([
                "status" => 1,
                "msg" => "Snippet actualitzat correctament"
            ]);
        }
    }

    public function destroy($id) {
        $snippet = Snippet::find($id);
        $snippet->delete();

        //return Todo::destroy($id);

        return response()->json([
            "status" => 1,
            "msg" => "Tasca eliminada correctament"
        ]);    }
}
