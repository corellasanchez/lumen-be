<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    protected function respondWithToken($token)
    {
        return response()->json([
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60
        ], 200);
    }

    protected function defaultStore($repository, $data)
    {
        try {
            $results = $repository->create($data);
            if (isset($results['success']) && !$results['success']) {
                return response()->json($results);
            }
            /** 2 success scenarios
             * first is where ->create results in a object with bus obj in a data attr
             * second is where ->create results in the business object itself, which
             * is put into the 'data' attr of the eventual response.
             */
            if (isset($results['data'])) {
                $results['success'] = true;
            } else {
                $results = [
                    'success' => true,
                    'data' => $results
                ];
            }
            return response()->json($results, 201);
        } catch (ValidatorException $e) {
            return response()->json([
                'data' => [],
                'success' => false,
                'message' => 'Unable to create.',
                'errors' => $e->getMessageBag()
            ]);
        }
    }

    protected function defaultUpdate($repository, $data, $id)
    {
        $results = $repository->find($id);
        if (!isset($results['data']) && !isset($results['id'])) {
            return response()->json([
                'data' => [],
                'success' => false,
                'message' => 'Record not found.'
            ]);
        }
        try {
            $response = $results->update($data);
            if (isset($response['success']) && (!$response['success'] || isset($response['data']))) {
                return response()->json($response);
            }
            $results = $repository->find($id);
            $results['success'] = true;
            return response()->json($results);
        } catch (ValidatorException $e) {
            return response()->json([
                'data' => [],
                'success' => false,
                'message' => 'Unable to update.',
                'errors' => $e->getMessageBag()
            ]);
        }
    }
}
