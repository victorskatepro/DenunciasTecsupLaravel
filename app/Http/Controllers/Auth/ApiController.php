<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\Usuario;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
class ApiController extends Controller
{
    
    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');
        
        if (Auth::once($credentials)) 
        {
         $user = Auth::user();
        return $user;
            
        }
      return response()->json(['error' => 'Usuario y/o clave inválido'], 401); 

    }
    
     public function register(Request $request){
     try{
         if(!$request->has('username') || !$request->has('password'))
            {
                throw new \Exception('Se esperaba campos mandatorios');
            }
            $user = new Usuario();
            $user->username = $request->get('username');
    		$user->password = bcrypt($request->get('password'));
    		$user->correo = $request->get('correo');
    		
            if($request->hasFile('imagen')&& $request->file('imagen')->isValid())
            {
                $imagen = $request->file('imagen');
                $filename = $request->file('imagen')->getClientOriginalName();
                Storage::disk('usuarios')->put($filename, File::get($imagen));
                $user->imagen = $filename;
            }
         $user->save();
     return response()->json(['type' => 'success', 'message' => 'Registro completo'], 200);
     }catch(\Exception $e)
        {
            return response()->json(['type' => 'error', 'message' =>'Registro incorrecto'], 200);
        }    
    }
    
}
