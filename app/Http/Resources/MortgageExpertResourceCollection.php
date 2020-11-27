<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * Class MortgageExpertResourceCollection
 *
 * @package App\Http\Resources
 */
class MortgageExpertResourceCollection extends ResourceCollection
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
            'data' => MortgageExpertResource::collection($this->collection),
            'links' => [
                'self' => route('api.v1.mortgage.experts.index'),
            ], 'meta' => [
                'count' => (string) $this->collection->count(),
            ],
        ];
    }

    /**
     * @param  $request
     * @return array|string[]
     */
    public function with($request)
    {
        return [
            'version' => '1.0.0', 'author' => 'iAhorro - Carlos Calvo',
        ];
    }
}
