<?php

namespace App\Http\Controllers;

use  App\Models\Licence;
use App\Filters\LicenceFilters;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use DateTime;

class LicenceController extends Controller
{
    protected $model;

    public function index(Request $request, LicenceFilters $filters, Licence $model)
    {
        return User::filter($filters, $model)->get();
    }

    /**
     * Store a new Licence.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request, Licence $model)
    {
        //validate incoming request
        $this->validate($request, [
            'type' => 'required',
            'user_id' => 'required'
        ]);
        $request['licence'] = Str::uuid()->toString();

        return $this->defaultStore($model, $request->all());
    }

    /**
     * Pay Licence.
     *
     * @param Request $request
     * @return Response
     */
    public function pay(Request $request, Licence $model, $id)
    {
        //validate incoming request
        $this->validate($request, [
            'price' => 'required'
        ]);

        $request['payment_date'] = date("Y-m-d");
        $request['paid'] = true;

        return $this->defaultUpdate($model, $request->all(), $id);
    }

    /**
     * Activate Licence.
     *
     * @param Request $request
     * @return Response
     */
    public function activate(Request $request, Licence $model, $id)
    {
        try {
            //validate incoming request
            $this->validate($request, [
                'customer' => 'required'
            ]);

            $licence = $model->findOrFail($id)->get()->toArray()[0];

            if ($licence['activated_date']) {
                return response()->json(['message' => 'Licence was already activated!', 'success' => false], 404);
            }

            $request['activated_date'] = date("Y-m-d");
            $request['expiration_date'] = date("Y-m-d", strtotime(date("Y-m-d", strtotime($request['activated_date'])) . " + 1 year"));

            return $this->defaultUpdate($model, $request->all(), $id);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error trying to activate the licence'], 404);
        }
    }

    /**
     * Activate Licence.
     *
     * @param Request $request
     * @return Response
     */
    public function verify(Request $request, Licence $model)
    {
        //validate incoming request
        $this->validate($request, [
            'customer' => 'required',
            'licence' => 'required'
        ]);

        try {
            $licence = $model->where('customer', '=', $request['customer'])->where('licence', '=', $request['licence'])->get()->toArray()[0];

            if (!isset($licence['id'])) {
                return response()->json(['message' => 'Licence Not Found!', 'success' => false], 404);
            }

            $today = new DateTime();
            $expiration_date = new DateTime($licence['expiration_date']);

            if (!$licence['paid']) {
                return response()->json(['message' => "Licence is not paid yet contact sales", 'success' => false], 200);
            };

            if ($expiration_date < $today) {
                return response()->json(['message' => "Licence expired since " . $expiration_date->format('Y-m-d'), 'success' => false], 404);
            };

            return response()->json(['data' => $licence, 'message' => 'Valid Licence', 'success' => true], 200);

        } catch (\Exception $e) {
            return response()->json(['message' => 'Invalid Licence!'], 404);
        }
    }
}
