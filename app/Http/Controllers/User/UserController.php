<?php

namespace App\Http\Controllers\User;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class UserController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();

        return $this->showAll($users, 200);
        // return response()->json(['data' => $usuarios], 200);

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Se crea fecha actual para luego cambiar el formato
        $fecha_actual = Carbon::now();

        // Se realizan validaciones de campos enviados
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed'
        ];

        // Se implementan las validaciones con los campos enviados
        $this->validate($request, $rules);
        
        // Se construye la instancia para poder crearla
        $campos = $request->all();
        $campos['password'] = bcrypt($request->password);
        $campos['email_verified_at'] = Carbon::createFromFormat('Y-m-d H:i:s', $fecha_actual)->toDateTimeString();
        $campos['remember_token'] = User::generarVerificacionToken();
        $campos['role_id'] = User::USUARIO_REGULAR;

        // Se crea la instancia con el metodo create
        $user = User::create($campos);

        // Envia respuesta en formato json con codigo
        // return response()->json(['data' => $usuario], 201);
        return $this->showOne($user, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id); // findOrFail dispara una excepcion 404 que no existe.

        // return response()->json(['data' => $usuario], 200);
        return $this->showOne($user, 200);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    { 
        $user = User::findOrFail($id);
        
        $rules = [
            'email' => 'email|unique:users,email,'.$user->id,
            'password' => 'min:6|confirmed',
            'role_id' => 'in:' . User::USUARIO_ADMINISTRADOR . ',' . User::USUARIO_REGULAR . ',' . User::USUARIO_JEFE,
        ];

        $this->validate($request, $rules);

        if($request->has('name')){
            $user->name = $request->name;
        }

        if($request->has('email') && $user->email != $request->email){
            $user->remember_token = User::generarVerificacionToken();
            $user->email = $request->email;
        }
        
        if($request->has('password')){
            $user->password = bcrypt($request->password);
        }

        if($request->has('role_id')){
            $user->role_id = $request->role_id;
        }

        if (!$user->isDirty()) {
            // return response()->json(['error' => 'Tiene que enviar al menos un valor diferente para actualizar', 'code' => 422], 422);
            return $this->errorResponse('Tiene que enviar al menos un valor diferente para actualizar', 422);
        }

        $user->save();


        return $this->showOne($user, 200);
        // return response()->json(['data' => $user], 200);

        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        $user->delete();

        return $this->showOne($user, 200);
        // return response()->json(['data' => $user], 200);
    }
}
