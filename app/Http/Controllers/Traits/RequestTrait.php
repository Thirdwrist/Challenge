<?php

namespace App\Http\Controllers\Traits;

use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\Response;

trait RequestTrait{

    protected function response($status, $data= null,  $message = null)
    {
        $response = [
            'message'=> is_null($message)? Response::$statusTexts[$status] : $message
        ];

        if($data instanceof JsonResource){
            return $data->additional($response);
        }

        $response = !empty($data) ? array_merge($response, ["data"=>$data]) : $response;
        return response()->json($response,$status);
    }

}
