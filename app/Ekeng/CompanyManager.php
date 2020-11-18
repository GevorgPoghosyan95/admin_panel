<?php

namespace App\Ekeng;

use App\Models\Company;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Response;
use Webpatser\Uuid\Uuid;

class CompanyManager
{
    protected $company;

    public function __construct(Company $company = null)
    {
        $this->company = $company ? $company : new Company();
    }


    public function getCompanyByTaxID($taxid)
    {
        $uuid = Uuid::generate()->string;
        $client = new Client();
        $request = $client->post('https://eth.ekeng.am/api/eregister/json_rpc',
            [
                'headers' => [
                    'cache-control' => 'no-cache',
                    'content-type' => 'application/json',
                ],
                'json' => ['jsonrpc' => '2.0', 'method' => 'company_info', 'params' => ['tax_id' => $taxid], 'id' => $uuid]
            ]);

        $response = json_decode($request->getBody()->getContents());
        if (!property_exists($response, 'error')) {
            $company = $response->result->company;
            if ($company) {
                $result = [
                    'status' => 'OK',
                    'data' => [
                        'company_name' => $company->company_type . ' ' . $company->name_am,
                    ]
                ];
            }
            return Response::json($result);
        }

        return Response::json($response);
    }

    /** get this company payments */
    public function getPayments()
    {
        return $this->getCustomer()->payments;
    }

    /** get customer for this company */
    public function getCustomer()
    {
        return $this->company->customer;
    }

    /** get this company orders */
    public function getOrders()
    {
        return $this->getCustomer()->orders;
    }

    /** get this company persons */
    public function getPerson()
    {
        return $this->company->persons;
    }


}
