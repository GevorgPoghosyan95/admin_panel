<?php

namespace App\Ekeng;

use App\Models\Customer;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Response;

class CustomerManager
{
    public function create($data){
         return Customer::create($data);
    }

}
