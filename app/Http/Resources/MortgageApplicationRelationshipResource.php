<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class MortgageApplicationRelationshipResource
 *
 * @package App\Http\Resources
 */
class MortgageApplicationRelationshipResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  $request
     * @return array
     */
    public function toArray($request)
    {
        if(isset($this->resource->mortgage_expert))
            return [
                'mortgage_expert' => [
                    'links' => [
                        'self' => url(route('api.v1.mortgage.experts.show', $this->resource->mortgage_expert->id)),
                        'mortgage_applications' => route('api.v1.mortgage.applications.expert.index', ['mortgage_expert_id' => $this->resource->mortgage_expert->id]),
                    ],
                    'data' => new MortgageExpertIdentifierResource($this->resource->mortgage_expert),
                ]
            ];
        return null;
    }
}
