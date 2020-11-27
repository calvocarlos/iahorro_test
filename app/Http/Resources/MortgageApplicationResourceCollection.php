<?php

namespace App\Http\Resources;

use App\Models\MortgageExpert;
use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * Class MortgageApplicationResourceCollection
 *
 * @package App\Http\Resources
 */
class MortgageApplicationResourceCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => MortgageApplicationResource::collection($this->collection),
            'links' => [
                'self' => route('api.v1.mortgage.applications.index')
            ],
            'meta' => [
                'count' => (string) $this->collection->count()
            ]
        ];
    }

    /**
     * @param  $request
     * @return array|string[]
     */
    public function with($request)
    {
        $mortgage_experts = $this->collection->map(
            function ($mortgage_application) {
                return $mortgage_application->mortgage_expert;
            }
        );
        $included = $mortgage_experts->merge($mortgage_experts)
            ->unique()
            ->reject(function ($name) {
                return empty($name);
            })
            ->flatten()
            ->all();

        return [
            'included' => $this->withIncluded($included),
            'version' => '1.0.0',
            'author' => 'iAhorro - Carlos Calvo'
        ];
    }

    /**
     * @param $included
     * @return array
     */
    private function withIncluded($included)
    {
        $included_array = [];
        foreach ($included as $include){
            if ($include instanceof MortgageExpert) {
                array_push($included_array, new MortgageExpertResource($include));
            }
        }
        return $included_array;

        /*return $included->map(
            function ($include) {
                if ($include instanceof MortgageExpert) {
                    return new MortgageExpertResource($include);
                }
            }
        );*/
    }
}
