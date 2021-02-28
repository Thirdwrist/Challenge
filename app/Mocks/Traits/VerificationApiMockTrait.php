<?php

namespace App\Mocks\Traits;

use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Request;
use Illuminate\Validation\ValidationException;

/**
 *
 */
trait VerificationApiMockTrait
{
    private function validateRequest(Request $request) :void
    {
        $validate = Validator::make($request->data(), [
            'receipt'=>['required', 'integer']
        ]);

        if($validate->fails())
        {
            throw new ValidationException($validate);
        }
    }

    private function validateReceipt($int) :bool
    {
        $receipt = str_split($int);
        return (end($receipt) % 2) === 0;
    }

    private function rateLimitRequest($int) :bool
    {
        $rand = random_int(0,1);
        $receipt = str_split($int);
        $limit = (end($receipt) % 6) === 0;

        return $rand && $limit;
    }

    private function response(bool $status)
    {
        if($status)
            return $this->ok();
        return $this->badRequest();
    }

    private function ok()
    {
        return Http::response([
            'status'=>'success',
            'expires_on'=>now()->tz(config('services.apple.timezone'))->addYearNoOverflow()->format('Y-m-d H:i:s')
        ], Response::HTTP_OK);
    }

    private function badRequest()
    {
        return Http::response([
            'status'=>'invalid receipt'
        ], Response::HTTP_BAD_REQUEST);
    }
}

