<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\RequestTrait;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpFoundation\Response;

class SubscriptionController extends Controller
{
    use RequestTrait;

    public function status(Request $request)
    {
        $status = $request->user()->subscriptions()->where('expires_on' ,'>=', now())->exists();
        $data = [
            'subscription'=> [
                'status'=> $status
            ]
        ];

        return $this->response(Response::HTTP_OK, $data);
    }
}
