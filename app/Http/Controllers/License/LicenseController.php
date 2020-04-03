<?php

namespace App\Http\Controllers\License;

use App\License;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class LicenseController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $license = License::all();

        return $this->showAll($license, 200);
        // return response()->json(['data' => $license], 200);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $license = License::findOrFail($id);

        return $this->showOne($license, 200);
        // return response()->json(['data' => $license], 200);
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
        $license = License::findOrFail($id);

        $license->delete();

        return $this->showOne($license, 200);
        // return response()->json(['data' => $license], 200);
    }
}
