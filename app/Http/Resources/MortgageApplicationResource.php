<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class MortgageApplicationResource
 *
 * @package App\Http\Resources
 */
class MortgageApplicationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  $request
     * @return array
     */
    public function toArray($request)
    {
        /*$mortgage_application_resource = [
            'type' => 'mortgage_application',
            'id' => (string) $this->getRouteKey(),
            'attributes' => [
                'first_name' => $this->resource->first_name,
                'last_name' => $this->resource->last_name,
                'email' => $this->resource->email,
                'phone_number' => $this->resource->phone_number,
                'net_income' => (string) $this->resource->net_income,
                'requested_amount' => (string) $this->resource->requested_amount,
                'mortgage_expert_id' => (string) $this->resource->mortgage_expert_id,
                'scoring' => (string) $this->resource->scoring,
                'assignment_date' => $this->resource->assignment_date ?? "",
                'start_time_slot' => (string) $this->resource->start_time_slot,
                'end_time_slot' => (string) $this->resource->end_time_slot,
                'created_at' => $this->resource->created_at,
                'updated_at' => $this->resource->updated_at,
            ]
        ];

        if (isset($this->resource->mortgage_expert))
            array_push($mortgage_application_resource, [
                'relationships' => new MortgageApplicationRelationshipResource($this)
            ]);

        array_

        array_push($mortgage_application_resource, [
            'links' => [
                'self' => url(route('api.v1.mortgage.applications.show', $this)),
                'mortgage_applications' => url(route('api.v1.mortgage.applications.index')),
            ]
        ]);

        return $mortgage_application_resource;*/
        return [
            'type' => 'mortgage_application',
            'id' => (string) $this->getRouteKey(),
            'attributes' => [
                'first_name' => $this->resource->first_name,
                'last_name' => $this->resource->last_name,
                'email' => $this->resource->email,
                'phone_number' => $this->resource->phone_number,
                'net_income' => (string) $this->resource->net_income,
                'requested_amount' => (string) $this->resource->requested_amount,
                'mortgage_expert_id' => (string) $this->resource->mortgage_expert_id,
                'scoring' => (string) $this->resource->scoring,
                'assignment_date' => $this->resource->assignment_date ?? "",
                'start_time_slot' => (string) $this->resource->start_time_slot,
                'end_time_slot' => (string) $this->resource->end_time_slot,
                'created_at' => $this->resource->created_at,
                'updated_at' => $this->resource->updated_at,
            ],
            'relationships' => new MortgageApplicationRelationshipResource($this),
            'links' => [
                'self' => url(route('api.v1.mortgage.applications.show', $this)),
                'mortgage_applications' => url(route('api.v1.mortgage.applications.index')),
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
            'version' => '1.0.0',
            'author' => 'iAhorro - Carlos Calvo'
        ];
    }
}
