<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use App\Models\Carpeta;

class Subcarpeta extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'nombre', 
        'ruta',
        'carpeta_id'
    ];

    public static function createSubcarpeta(Array $array)
    {
        $response = [
            'status' => false,
            'mensaje' => "",
            'subcarpeta' => [],
        ];

        if(!empty($array['nombre']) && !empty($array['id_carpeta'])){

            $Carpeta = self::getNameDirectoriobyId($array['id_carpeta']);
            
            if(!self::validateDirPath($Carpeta)){
                $response['mensaje'] = "No es posible crear la subcarpeta, por que la carpeta no existe.";
                return $response;
            }      
            $directory = Storage::disk('public')->makeDirectory($Carpeta."\\".$array['nombre']);
        
            $path = public_path()."\\storage".'\\'.$Carpeta."\\".$array['nombre'];
            if($directory){
                $array_aux = [
                    'nombre' => $array['nombre'],
                    'ruta' => $path,
                    'carpeta_id' => $array['id_carpeta'],
                    'activo' => true,
                ];
                $Subcarpeta = Subcarpeta::create($array_aux);
                $response = [
                    'status' => true,
                    'mensaje' => "Subcarpeta creada correctamente",
                    'subcarpeta' => $Subcarpeta
                ];
            }else{
                $response['mensaje'] =  "No fue posible crear la subcarpeta";
            }  
        }else{
            $response['mensaje'] = "El nombre de la subcarpeta y/o Id de carpeta vacio";
        }

        return $response;
    }

    public static function updateSubcarpeta(Array $array, Subcarpeta $subcarpeta)
    {
        $response = [
            'status' => false,
            'mensaje' => ""
        ];
        if(!empty($array['nombre'])){
            
            $nombre_dir_padre = self::getNameDirectoriobyId($subcarpeta->carpeta_id);
            
            $rename = Storage::disk('public')->move($nombre_dir_padre."\\".$subcarpeta->nombre,$nombre_dir_padre."\\".$array['nombre']);
            $path = public_path()."\\storage".'\\'.$nombre_dir_padre."\\".$array['nombre'];

            if($rename){
                $array_aux = [
                    'nombre' => $array['nombre'],
                    'ruta' => public_path()."\\storage".'\\'.$nombre_dir_padre."\\".$array['nombre'],
                    'activo' => true,
                ];
                $Subcarpeta = Subcarpeta::where('id', $subcarpeta->id)->update($array_aux);
                $response = [
                    'status' => true,
                    'mensaje' => "Subcarpeta actualizada correctamente",
                    'subcarpeta' => $Subcarpeta
                ];
            }else{
                $response['mensaje'] =  "No fue posible renombrar la subcarpeta";
            }  
        }else{
            $response['mensaje'] = "No se puede cambiar por un nombre vacio";
        }

        return $response;
    }

    public static function deleteSubcarpeta(Subcarpeta $subcarpeta)
    {
        $response = [
            'status' => false,
            'mensaje' => ""
        ];
        $nombre_dir_padre = self::getNameDirectoriobyId($subcarpeta->carpeta_id);
        $delete = Storage::disk('public')->deleteDirectory($nombre_dir_padre."\\".$subcarpeta->nombre);

        if($delete){
            $subcarpeta->activo = false;
            $subcarpeta->save();
            $response = [
                'status' => true,
                'mensaje' => "Subcarpeta eliminada correctamente",
                'carpeta' => $subcarpeta
            ];
        }else{
            $response['mensaje'] =  "No fue posible eliminar la subcarpeta";
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

    public static function getNameDirectoriobyId(int $id){
        $Carpeta = Carpeta::where('id', $id)->value('nombre');
        return $Carpeta;
    }

    public function carpeta()
    {
        return $this->belongsTo(Carpeta::class);
    }
}
