<?php

namespace App\Http\Controllers\Person;

use App\Person;
use App\License;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class PersonController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $persons = Person::all();


        return $this->showAll($persons, 200);
        // return response()->json(['data' => $persons], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'person_object' => 'required|string|unique:people',
            'dni' => 'required|numeric|unique:people',
            'name' => 'required|string',
            'lastname' => 'required|string',
            'blood_type' => 'required|string',
            'address' => 'required|string',
            'business' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|email',
            'image' => 'string',
        ];

        $this->validate($request, $rules);

        $campo = $request->all();
        
        // Se crea la instancia con el metodo create
        $person = Person::create($campo);

        $fecha = date('Y-m-d H:i:s');
        
        $license = new License();
        $license['person_id'] = $person->id;
        $license['date_awarded'] = $fecha;
        $license['date_expiration'] = date('Y-m-d H:i:s', strtotime($fecha . '+2 years'));

        $license->save();

        $person['license'] = [
            'id'               =>  $license->id,
            'person_id'        =>  $license['person_id'],
            'date_awarded'     =>  $license['date_awarded'],
            'date_expiration'  =>  $license['date_expiration'],
        ];

        // Envia respuesta en formato json con codigo
        return $this->showOne($person, 200);
        // return response()->json(['data' => $person], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $person = Person::findOrFail($id);

        return $this->showOne($person, 200);
        // return response()->json(['data' => $person], 200);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $person = Person::findOrFail($id);

        $person->delete();

        return $this->showOne($person, 200);
        // return response()->json(['data' => $person], 200);
    }
}
