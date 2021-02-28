<?php



namespace App\Mocks;

use App\Mocks\Traits\VerificationApiMockTrait;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Request;
use Symfony\Component\HttpFoundation\Response;

class IOSApiMock implements MockInterface
{
    use VerificationApiMockTrait;

    public function mock()
    {
        Http::fake([
            'store.apple.com/api/verify'=> function(Request $request){
                if($request->method() == 'POST')
                {
                    $this->validateRequest($request);
                    $validateReceipt = $this->validateReceipt($request->data()['receipt']);
                    return $this->response($validateReceipt);
                }
            }
        ]);

        Http::fake([
            'store.apple.com/api/subscription/verify' =>function(Request $request){
                if($request->method() == 'POST')
                {
                    $this->validateRequest($request);
                    return Http::response([
                        'status'=>'success',
                        [
                            'subscription'=> [
                                'status'=>false
                            ]
                        ]
                    ], Response::HTTP_OK);
                }
            }
        ]);
    }
}
