<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;
use App\Models\Subcarpeta;

class Carpeta extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'nombre', 
        'ruta',
        'peso',
        'permisos'
    ];

    public static function createCarpeta(Array $array)
    {
        $response = [
            'status' => false,
            'mensaje' => "",
            'carpeta' => [],
        ];
        if(!empty($array['nombre'])){
            
            if(self::validateDirPath($array['nombre'])){
                $response['mensaje'] = "No es posible crear una carpeta con el mismo nombre.";
                return $response;
            }      
            $directory = Storage::disk('public')->makeDirectory($array['nombre']);

            if($directory){
                $array_aux = [
                    'nombre' => $array['nombre'],
                    'ruta' => public_path()."\\storage".'\\'.$array['nombre'],
                    'activo' => true,
                ];
                $Carpeta = Carpeta::create($array_aux);
                $response = [
                    'status' => true,
                    'mensaje' => "Carpeta creada correctamente",
                    'carpetpa' => $Carpeta
                ];
            }else{
                $response['mensaje'] =  "No fue posible crear la carpeta";
            }  
        }else{
            $response['mensaje'] = "El nombre de la carpeta no puede ser vacio";
        }

        return $response;
    }

    public static function updateCarpeta(Array $array, Carpeta $carpeta)
    {
        $response = [
            'status' => false,
            'mensaje' => ""
        ];
        if(!empty($array['nombre'])){
            
            if(self::validateDirPath($array['nombre'])){
                $response['mensaje'] = "No es posible crear una carpeta con el mismo nombre.";
                return $response;
            }
            
            $rename = Storage::disk('public')->move($carpeta->nombre,$array['nombre']);

            if($rename){
                $array_aux = [
                    'nombre' => $array['nombre'],
                    'ruta' => public_path()."\\storage".'\\'.$array['nombre'],
                    'activo' => true,
                ];
                $Carpeta = Carpeta::where('id', $carpeta->id)->update($array_aux);
                $response = [
                    'status' => true,
                    'mensaje' => "Carpeta actualizada correctamente",
                    'carpeta' => $Carpeta
                ];
            }else{
                $response['mensaje'] =  "No fue posible renombrar la carpeta";
            }  
        }else{
            $response['mensaje'] = "No se puede cambiar por un nombre vacio";
        }

        return $response;
    }

    public static function deleteCarpeta(Carpeta $carpeta)
    {
        $response = [
            'status' => false,
            'mensaje' => ""
        ];

        $delete = Storage::disk('public')->deleteDirectory($carpeta->nombre);
        
        if($delete){
            foreach ($carpeta->subcarpetas as $subcarpeta) {
                $subcarpeta->activo = false;
                $subcarpeta->save();
            }
            $carpeta->activo = false;
            $carpeta->save();
            $response = [
                'status' => true,
                'mensaje' => "Carpeta eliminada correctamente",
                'carpeta' => $carpeta
            ];
        }else{
            $response['mensaje'] =  "No fue posible eliminar la carpeta";
        }  
        

        return $response;
    }


    public static function validateDirPath(String $path){
        if(is_dir(public_path()."\\storage".'\\'.$path)){
            return true;
        }else{
            return false;
        }
    }

    public function subcarpetas()
    {
        return $this->hasMany(Subcarpeta::class);
    }
    
}
