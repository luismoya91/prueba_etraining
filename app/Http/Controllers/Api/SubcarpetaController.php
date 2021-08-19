<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subcarpeta;

class SubcarpetaController extends Controller
{
    public function index()
    { 
        return Subcarpeta::where('activo',1)->with('carpeta')->get();
    }

    public function show(Subcarpeta $Subcarpeta)
    {
        if($Subcarpeta->activo){
            
            return Subcarpeta::where('id',$Subcarpeta->id)->with('carpeta')->get();;
        }
    }

    public function store(Request $request)
    {
        $Subcarpeta = Subcarpeta::createSubcarpeta($request->all());
        
        return response()->json($Subcarpeta, 201);
    }

    public function update(Request $request, Subcarpeta $Subcarpeta)
    {
        $Subcarpeta = Subcarpeta::updateSubcarpeta($request->all(),$Subcarpeta);

        return response()->json($Subcarpeta, 200);
    }

    public function delete(Subcarpeta $Subcarpeta)
    {
        $Subcarpeta = Subcarpeta::deleteSubcarpeta($Subcarpeta);

        return response()->json($Subcarpeta, 204);
    }
}
