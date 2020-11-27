<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MortgageExpertResource;
use App\Http\Resources\MortgageExpertResourceCollection;
use App\Models\MortgageExpert;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Class MortgageExpertController
 *
 * @package App\Http\Controllers\Api
 */
class MortgageExpertController extends Controller
{
    /**
     * @return \App\Http\Resources\MortgageExpertResourceCollection
     * @throws Exception
     */
    public function index()
    {
        try {
            return MortgageExpertResourceCollection::make(MortgageExpert::all());
        } catch (Exception $exception) {
            throw new Exception("It was not possible to get all the mortgage experts. ".$exception->getMessage(), 500);
        }
    }

    /**
     * @param $id
     * @return \App\Http\Resources\MortgageExpertResource
     * @throws Exception
     */
    public function show($id)
    {
        try {
            $mortgage_expert = MortgageExpert::findOrFail($id);

            return MortgageExpertResource::make($mortgage_expert);
        } catch (ModelNotFoundException $exception) {
            throw $exception;
        } catch (Exception $exception) {
            throw new Exception("It was not possible to get the mortgage expert with ID: $id. ".$exception->getMessage(),
                500);
        }
    }
}
