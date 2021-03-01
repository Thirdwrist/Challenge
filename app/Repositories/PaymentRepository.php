<?php

namespace  App\Repositories;

use App\Models\Payment;
use Illuminate\Support\Facades\DB;

class PaymentRepository {
    public function create($data)
    {
        DB::transaction(function () use($data, &$payment){
           $payment =  Payment::create([
                'device_id'=>$data['device_id'],
                'receipt'=> $data['receipt'],
                'status'=> $data['status']
            ]);
        });

        return $payment;
    }
}
