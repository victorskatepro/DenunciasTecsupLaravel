<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Denuncia;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
class DenunciaController extends Controller
{
    public function index(){
        $denuncia = Denuncia::all();
        
        return $denuncia;
    }
    public function store(Request $request){
        try
        {
            if(!$request->has('titulo') || !$request->has('autor'))
            {
                throw new \Exception('Se esperaba campos mandatorios');
            }
            
            $denuncia = new Denuncia();
            $denuncia->titulo = $request->get('titulo');
    		$denuncia->autor = $request->get('autor');
    		$denuncia->latitud = $request->get('latitud');
    		$denuncia->longitud = $request->get('longitud');
    		$denuncia->direccion = $request->get('direccion');
    		$denuncia->usuario_id = $request->get('usuario_id');
    		$denuncia->descripcion = $request->get('descripcion');
    		
    		if($request->hasFile('imagen') && $request->file('imagen')->isValid())
    		{
        		$imagen = $request->file('imagen');
        		$filename = $request->file('imagen')->getClientOriginalName();
        		
        		Storage::disk('images')->put($filename,  File::get($imagen));
        		
        		$denuncia->imagen = $filename;
    		}
    		
    		$denuncia->save();
    	    
    	    return response()->json(['type' => 'success', 'message' => 'Registro completo'], 200);
    	    
        }catch(\Exception $e)
        {
            return response()->json(['type' => 'error', 'message' => $e->getMessage()], 500);
        }

    }
}
