<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class MortgageExpertResource
 *
 * @package App\Http\Resources
 */
class MortgageExpertResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'type' => 'mortgage_expert',
            'id' => (string) $this->getRouteKey(),
            'attributes' => [
                'first_name' => $this->resource->first_name,
                'last_name' => $this->resource->last_name,
                'created_at' => $this->resource->created_at,
                'updated_at' => $this->resource->updated_at,
            ],
            'links' => [
                'self' => url(route('api.v1.mortgage.experts.show', $this)),
                'mortgage_applications' => route('api.v1.mortgage.applications.expert.index', ['mortgage_expert_id' => $this]),
                'mortgage_experts' => url(route('api.v1.mortgage.experts.index')),
            ],
        ];
    }
}
