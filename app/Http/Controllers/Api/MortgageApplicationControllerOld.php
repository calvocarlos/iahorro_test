<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MortgageApplication;
use Carbon\Carbon;

/**
 * Class MortgageApplicationControllerOld
 *
 * @package App\Http\Controllers\Api
 */
class MortgageApplicationControllerOld extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $mortgage_applications = MortgageApplication::all();

        return response()->json([
            'data' => $mortgage_applications->map(function (MortgageApplication $mortgage_application) {
                return [
                    'type' => 'mortgage_application',
                    'id' => (string) $mortgage_application->getRouteKey(),
                    'attributes' => [
                        'first_name' => $mortgage_application->first_name,
                        'last_name' => $mortgage_application->last_name,
                        'email' => $mortgage_application->email,
                        'phone_number' => $mortgage_application->phone_number,
                        'net_income' => (string) $mortgage_application->net_income,
                        'requested_amount' => (string) $mortgage_application->requested_amount,
                        'mortgage_expert_id' => (string) $mortgage_application->mortgage_expert_id,
                        'assignment_date' => $mortgage_application->assignment_date,
                        'start_time_slot' => (string) $mortgage_application->start_time_slot,
                        'end_time_slot' => (string) $mortgage_application->end_time_slot,
                        'created_at' => $mortgage_application->created_at,
                        'updated_at' => $mortgage_application->updated_at,
                    ],
                    'links' => [
                        'self' => url(route('api.v2.mortgage.applications.show', $mortgage_application)),
                    ],
                ];
            }),
            'links' => [
                'self' => route('api.v2.mortgage.applications.index')
            ],
            'meta' => [
                'count' => (string) $mortgage_applications->count()
            ]
        ]);
    }

    /**
     * @param $mortgage_application
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($mortgage_application)
    {
        /** @var MortgageApplication $mortgage_application */
        $mortgage_application = MortgageApplication::find($mortgage_application);

        return response()->json([
            'data' => [
                'type' => 'mortgage_application',
                'id' => (string) $mortgage_application->getRouteKey(),
                'attributes' => [
                    'first_name' => $mortgage_application->first_name,
                    'last_name' => $mortgage_application->last_name,
                    'email' => $mortgage_application->email,
                    'phone_number' => $mortgage_application->phone_number,
                    'net_income' => (string) $mortgage_application->net_income,
                    'requested_amount' => (string) $mortgage_application->requested_amount,
                    'mortgage_expert_id' => (string) $mortgage_application->mortgage_expert_id,
                    'assignment_date' => $mortgage_application->assignment_date,
                    'start_time_slot' => (string) $mortgage_application->start_time_slot,
                    'end_time_slot' => (string) $mortgage_application->end_time_slot,
                    'created_at' => $mortgage_application->created_at,
                    'updated_at' => $mortgage_application->updated_at,
                ],
                'links' => [
                    'self' => url(route('api.v2.mortgage.applications.show', $mortgage_application)),
                ],
            ],
        ]);
    }
}
