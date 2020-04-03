<?php

namespace App\Http\Controllers\Item;

use App\Item;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;


class ItemController extends ApiController
{
    use ApiResponser;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Item::all();

        return $this->showAll($items);
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
            'name' => 'required',
        ];

        $this->validate($request, $rules);

        $campos = $request->all();

        if ($request->has('description')) {
            $campos->desciption = $request->description;
        }

        // Se crea la instancia con el metodo create
        $item = Item::create($campos);

        // Envia respuesta en formato json con codigo
        return $this->showOne($item, 201);
        // return response()->json(['data' => $item], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = Item::findOrFail($id);

        return $this->showOne($item, 200);
        // return response()->json(['data' => $item], 200);
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
        $item = Item::findOrFail($id);

        $rules = [
            'name' => 'string',
            'description' => 'string'
        ];

        $this->validate($request, $rules);

        if ($request->has('name')) {
            $item->name = $request->name;
        }

        if ($request->has('description')) {
            $item->description = $request->description;
        }

        if (!$item->isDirty()) {
            return response()->json(['error' => 'Tiene que enviar al menos un valor diferente para actualizar', 'code' => 422], 422);
        }

        $item->save();
        
        return $this->showOne($item, 200);
        // return response()->json(['data' => $item], 200);
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Item::findOrFail($id);

        return $this->showOne($item, 200);
        // return response()->json(['data' => $item], 200);
    }
}
