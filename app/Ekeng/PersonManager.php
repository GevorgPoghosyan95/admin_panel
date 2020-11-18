<?php

namespace App\Ekeng;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Response;
use Session;
use Illuminate\Support\Facades\Request;
use App\Models\Person;

class PersonManager
{
    protected $person;

    public function __construct(Person $person = null)
    {
        $this->person = $person ? $person : new Person();
    }


    public function getSelectFields()
    {
        return [
            'id',
            'first_name',
            'last_name',
            'ssn',
            'email',
            'phone',
        ];
    }

    public function persons_table($request)
    {
        $columns = $this->getSelectFields();
        $totalData = Person::count();
        $session = [];
        $totalFiltered = $totalData;
        Session::put('persons', $session);
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $persons = Person::select($columns)
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');

            $persons = Person::select($columns)
                ->where('id', 'LIKE', "%{$search}%")
                ->orWhere('first_name', 'LIKE', "%{$search}%")
                ->orWhere('last_name', 'LIKE', "%{$search}%")
                ->orWhere('ssn', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
            $totalFiltered = Person::where('id', 'LIKE', "%{$search}%")
                ->orWhere('first_name', 'LIKE', "%{$search}%")
                ->orWhere('last_name', 'LIKE', "%{$search}%")
                ->orWhere('ssn', 'LIKE', "%{$search}%")
                ->count();
        }
        $token = csrf_token();
        $data = $this->create_data($persons, $token);

        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );
        return json_encode($json_data);
    }

    public function search($request)
    {
        $token = csrf_token();
        $columns = $this->getSelectFields();
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        $params = $request->input('params');
        $totalData = Person::count();
        $query = Person::select($this->getSelectFields());
        $session = [];
        foreach ($params as $key => $param) {
            if (isset($param['value'])) {
                $query->where($param['name'], 'like', '%' . $param['value'] . '%');
                $session[$param['name']] = $param['value'];
            }
        }
        Session::put('persons', $session);

        $totalFiltered = $query->count();
        $persons = $query->offset($start)
            ->limit($limit)
            ->orderBy($order, $dir)
            ->get();

        $data = $this->create_data($persons, $token);
        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );

        return json_encode($json_data);
    }

    public function create_data($persons, $token)
    {
        $data = array();
        if (!empty($persons)) {
            foreach ($persons as $person) {
                $delete = route('persons.destroy', $person->id);
                $edit = route('persons.edit', $person->id);

                $nestedData['id'] = $person->id;
                $nestedData['first_name'] = $person->first_name;
                $nestedData['last_name'] = $person->last_name;
                $nestedData['email'] = $person->email;
                $nestedData['ssn'] = $person->ssn;
                $nestedData['phone'] = $person->phone;
                $nestedData['options'] = <<<EOD
                                            <div class="btn-group">
                                                <button class="btn btn-xs green dropdown-toggle" type="button"
                                                        data-toggle="dropdown"
                                                        aria-expanded="false"> Actions
                                                    <i class="fa fa-angle-down"></i>
                                                </button>
                                                <ul class="dropdown-menu pull-left" role="menu">
                                                    <li>
                                                        <a href="#">
                                                            <i class="icon-docs"></i>
                                                            <form method="POST" style="display:inline;" action="$delete">
                                                                <input type="hidden" name="_method" value="DELETE"/>
                                                                <input type="hidden" name="_token" value="$token">
                                                                <input type="submit" value="Delete" class="btn btn-danger btn-xs">
                                                            </form>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#">
                                                            <i class="icon-tag"></i>
                                                                <form method="GET" style="display:inline;" action="$edit">
                                                                        <input type="submit" value="Edit" class="btn btn-primary btn-xs">
                                                                </form>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
<script src="/js/sweetAlert.js"></script>
EOD;
                $data[] = $nestedData;

            }
        }
        return $data;
    }
    /** get person by ssn */
    public function getPersonBySSN($ssn)
    {
        $client = new Client();
        $request = $client->post('https://eth.ekeng.am/api/avv/search',
            [
                'headers' => [
                    'cache-control' => 'no-cache',
                    'content-type' => 'application/x-www-form-urlencoded',
                ],
                'form_params' => [
                    'psn' => $ssn,
                ]
            ]);

        $response = json_decode($request->getBody()->getContents());
        if (!empty($response)) {
            if ($response->status == "ok") {
                $person = $response->result[0]->AVVDocuments->Document[0]->Person;
                $result = [
                    'status' => $response->status,
                    'data' => [
                        'First_Name' => $person->First_Name,
                        'Last_Name' => $person->Last_Name,
                        'Patronymic_Name' => $person->Patronymic_Name
                    ]
                ];
            } else {
                $result = $response;
            }

            return Response::json($result);
        }
        return;
    }
    /** get this person payments */
    public function getPayments()
    {
        return $this->getCustomer()->payments;
    }
    /** get customer for this persons */
    public function getCustomer()
    {
        return $this->person->customer;
    }
    /** get this person orders */
    public function getOrders()
    {
        return $this->getCustomer()->orders;
    }
    /** get this person companies */
    public function getCompany()
    {
        return $this->person->companies;
    }


}
