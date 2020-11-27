<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class MortgageExpertIdentifierResource
 *
 * @package App\Http\Resources
 */
class MortgageExpertIdentifierResource extends JsonResource
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
            'id' => (string) $this->getRouteKey()
        ];
    }
}
