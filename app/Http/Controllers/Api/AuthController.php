<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    //
    public function register(Request $request){

        //validacion de datos
        $validacion = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed'
        ], [
            'name.required' => 'El campo nombre es obligatorio.',
            'email.required' => 'El campo correo electrónico es obligatorio.',
            'email.email' => 'El correo electrónico debe ser una dirección de correo válida.',
            'email.unique' => 'El correo electrónico ya está registrado.',
            'password.required' => 'El campo contraseña es obligatorio.',
            'password.confirmed' => 'La confirmación de la contraseña no coincide.',
        ]);

        if ($validacion->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Hay errores en los datos proporcionados.',
                'errors' => $validacion->errors(),
            ], 422);
        }
        //guardado
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        
        return response([
            "status" => true,
            "user" => $user,
            "token" => $user->createToken('toke')->plainTextToken,
        ], Response::HTTP_CREATED);
    }

    public function login(Request $request){
        
        $datosIngreso = Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required'
        ],[
            'email.required' => 'El campo correo electrónico es obligatorio.',
            'email.email' => 'El correo electrónico debe ser una dirección de correo válida.',
            'password.required' => 'El campo contraseña es obligatorio.'
        ]);

        if($datosIngreso->fails()){
            return response()->json([
                'success' => false,
                'message' => 'hay errores en el incio de session',
                'errores' => $datosIngreso->errors(),
            ], 422);
        }

        if(Auth::attempt($request->all())){
            $user = Auth::user();
            $token = $user->createToken('toke')->plainTextToken;
            $cookie = cookie('cookie_token', $token, 60 *24);
            return response(["token"=>$token], Response::HTTP_OK)->withCookie($cookie);
        }else{
            return response(["err"=>"datos incorrectos"],Response::HTTP_UNAUTHORIZED);
        }

    }

    public function userProfiles(Request $request){
        return response()->json([
            "message" => "userProfiles ok",
            "userdata" => auth()->user()
        ], Response::HTTP_OK);
    }


    public function logout(){
        auth()->user()->tokens()->delete();
        return response()->json([
            'status' => true,
            'message' => 'inicio de session cerrado'
        ]);
    }


    public function list(){
        $user = User::all();
        return response()->json($user, Response::HTTP_OK);
    }

    public function update(Request $request, $id){
        
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id, 
            'password' => 'sometimes|nullable|string|min:8|confirmed', 
        ]);

        $user = User::findOrFail($id);

        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];

        if ($request->filled('password')) {
            $user->password = Hash::make($validatedData['password']);
        }

        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Usuario actualizado correctamente.',
            'user' => $user
        ], 200);
    }

    public function delete(string $id){

        return response()->json(User::destroy($id), Response::HTTP_OK);
        
    }
}
