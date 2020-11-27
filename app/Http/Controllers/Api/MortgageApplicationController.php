<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CreateMortgageApplicationRequest;
use App\Http\Resources\MortgageApplicationResource;
use App\Http\Resources\MortgageApplicationResourceCollection;
use App\Models\MortgageApplication;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Symfony\Component\Translation\Exception\InvalidResourceException;

/**
 * Class MortgageApplicationController
 *
 * @package App\Http\Controllers\Api
 */
class MortgageApplicationController extends Controller
{
    /**
     * @return \App\Http\Resources\MortgageApplicationResourceCollection
     * @throws Exception
     */
    public function index()
    {
        try {
            //with('mortgage_expert')
            return MortgageApplicationResourceCollection::make(MortgageApplication::all());
        } catch (Exception $exception) {
            throw new Exception("It was not possible to get all the mortgage applications. ".$exception->getMessage(), 500);
        }
    }

    /**
     * @param $id
     * @return \App\Http\Resources\MortgageApplicationResource
     * @throws Exception
     */
    public function show($id)
    {
        try {
            //with('mortgage_expert')
            $mortgage_application = MortgageApplication::findOrFail($id);
            return MortgageApplicationResource::make($mortgage_application);
        } catch (ModelNotFoundException $exception) {
            throw $exception;
        } catch (Exception $exception) {
            throw new Exception("It was not possible to get the mortgage application with ID: $id. ".$exception->getMessage(), 500);
        }
    }

    /**
     * @param  \App\Http\Requests\Api\CreateMortgageApplicationRequest  $request
     * @return \App\Http\Resources\MortgageApplicationResource
     * @throws Exception
     */
    public function store(CreateMortgageApplicationRequest $request)
    {
        try {
            $mortgage_application = new MortgageApplication();
            $mortgage_application->first_name = $request->input('first_name');
            $mortgage_application->last_name = $request->input('last_name');
            $mortgage_application->email = $request->input('email');
            $mortgage_application->phone_number = $request->input('phone_number');
            $mortgage_application->net_income = $request->input('net_income');
            $mortgage_application->requested_amount = $request->input('requested_amount');
            $mortgage_application->start_time_slot = $request->input('start_time_slot');
            $mortgage_application->end_time_slot = $request->input('end_time_slot');
            if ($mortgage_application->save())
                return MortgageApplicationResource::make($mortgage_application);
            throw new Exception("It was not possible to save the mortgage application.", 500);
        } catch (Exception $exception) {
            throw new Exception("It was not possible to create the mortgage application. ".$exception->getMessage(), 500);
        }
    }

    /**
     * @param  int  $mortgage_expert_id
     * @return \App\Http\Resources\MortgageApplicationResourceCollection
     * @throws \Exception
     */
    public function getMortgageApplicationsByMortgageExpertId(int $mortgage_expert_id)
    {
        try {
            $mortgage_applications = MortgageApplication::getMortgageApplicationsByMortgageExpertId($mortgage_expert_id);

            $mortgage_applications = $mortgage_applications->sortByDesc('scoring')
                ->filter(function(MortgageApplication $mortgage_application) {
                    if ($mortgage_application->isInTimeSlot()) {
                        return $mortgage_application;
                    }
                });

            return MortgageApplicationResourceCollection::make($mortgage_applications);
        } catch (\Exception $exception) {
            throw new Exception("It was not possible to get the mortgage applications of the mortgage expert: $mortgage_expert_id. ".$exception->getMessage(), 500);
        }
    }
}
