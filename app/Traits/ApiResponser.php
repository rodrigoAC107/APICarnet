<?php

namespace App\Traits;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

trait ApiResponser{

    private function successResponse($data, $code){
        return response()->json($data, $code);
    }

    protected function errorResponse($message, $code){
        return response()->json(['message' => $message, 'code' => $code], $code);
    }

    protected function showAll(Collection $colection, $code = 200){
        return response()->json(['data' => $colection], $code);
    }

    protected function showOne(Model $model, $code = 200){
        return response()->json(['data' => $model], $code);
    }



    
}