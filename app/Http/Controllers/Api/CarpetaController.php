<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Carpeta;

class CarpetaController extends Controller
{
    public function index()
    { 
        return Carpeta::where('activo',1)->with('subcarpetas')->get();
    }

    public function show(Carpeta $Carpeta)
    {
        if($Carpeta->activo){
            return Carpeta::where('id',$Carpeta->id)->with('subcarpetas')->get();
        }
    }

    public function store(Request $request)
    {
        $Carpeta = Carpeta::createCarpeta($request->all());
        
        return response()->json($Carpeta, 201);
    }

    public function update(Request $request, Carpeta $Carpeta)
    {
        $Carpeta = Carpeta::updateCarpeta($request->all(),$Carpeta);

        return response()->json($Carpeta, 200);
    }

    public function delete(Carpeta $Carpeta)
    {
        $Carpeta = Carpeta::deleteCarpeta($Carpeta);

        return response()->json($Carpeta, 204);
    }
}
