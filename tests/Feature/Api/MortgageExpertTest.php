<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\MortgageExpert;
use Tests\TestCase;

class MortgageExpertTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_get_a_mortgage_expert_v1()
    {
        /** @var MortgageExpert $mortgage_expert */
        $mortgage_expert = MortgageExpert::factory()->create();

        $response = $this->getJson(route('api.v1.mortgage.experts.show', $mortgage_expert));

        $response->assertExactJson([
            'data' => [
                'type' => 'mortgage_expert',
                'id' => (string) $mortgage_expert->getRouteKey(),
                'attributes' => [
                    'first_name' => $mortgage_expert->first_name,
                    'last_name' => $mortgage_expert->last_name,
                    'created_at' => $mortgage_expert->created_at,
                    'updated_at' => $mortgage_expert->updated_at,
                ],
                'links' => [
                    'self' => url(route('api.v1.mortgage.experts.show', $mortgage_expert)),
                    'mortgage_applications' => url(route('api.v1.mortgage.applications.expert.index', ['mortgage_expert_id' => $mortgage_expert->id])),
                    'mortgage_experts' => url(route('api.v1.mortgage.experts.index')),
                ]
            ]
        ]);
    }

    /** @test */
    public function it_can_get_mortgage_experts_v1()
    {
        $number_of_mortgage_experts = 3;

        /** @var MortgageExpert $mortgage_expert */
        $mortgage_experts = MortgageExpert::factory()->times($number_of_mortgage_experts)->create();

        $response = $this->getJson(route('api.v1.mortgage.experts.index'));

        $response->assertExactJson([
            'author' => 'iAhorro - Carlos Calvo',
            'data' => [
                [
                    'type' => 'mortgage_expert',
                    'id' => (string) $mortgage_experts[0]->getRouteKey(),
                    'attributes' => [
                        'first_name' => $mortgage_experts[0]->first_name,
                        'last_name' => $mortgage_experts[0]->last_name,
                        'created_at' => $mortgage_experts[0]->created_at,
                        'updated_at' => $mortgage_experts[0]->updated_at,
                    ],
                    'links' => [
                        'self' => url(route('api.v1.mortgage.experts.show', $mortgage_experts[0])),
                        'mortgage_applications' => url(route('api.v1.mortgage.applications.expert.index', ['mortgage_expert_id' => $mortgage_experts[0]])),
                        'mortgage_experts' => url(route('api.v1.mortgage.experts.index')),
                    ]
                ],
                [
                    'type' => 'mortgage_expert',
                    'id' => (string) $mortgage_experts[1]->getRouteKey(),
                    'attributes' => [
                        'first_name' => $mortgage_experts[1]->first_name,
                        'last_name' => $mortgage_experts[1]->last_name,
                        'created_at' => $mortgage_experts[1]->created_at,
                        'updated_at' => $mortgage_experts[1]->updated_at,
                    ],
                    'links' => [
                        'self' => url(route('api.v1.mortgage.experts.show', $mortgage_experts[1])),
                        'mortgage_applications' => url(route('api.v1.mortgage.applications.expert.index', ['mortgage_expert_id' => $mortgage_experts[1]])),
                        'mortgage_experts' => url(route('api.v1.mortgage.experts.index')),
                    ]
                ],
                [
                    'type' => 'mortgage_expert',
                    'id' => (string) $mortgage_experts[2]->getRouteKey(),
                    'attributes' => [
                        'first_name' => $mortgage_experts[2]->first_name,
                        'last_name' => $mortgage_experts[2]->last_name,
                        'created_at' => $mortgage_experts[2]->created_at,
                        'updated_at' => $mortgage_experts[2]->updated_at,
                    ],
                    'links' => [
                        'self' => url(route('api.v1.mortgage.experts.show', $mortgage_experts[2])),
                        'mortgage_applications' => url(route('api.v1.mortgage.applications.expert.index', ['mortgage_expert_id' => $mortgage_experts[2]])),
                        'mortgage_experts' => url(route('api.v1.mortgage.experts.index')),
                    ]
                ]
            ],
            'links' => [
                'self' => url(route('api.v1.mortgage.experts.index'))
            ],
            'meta' => [
                'count' => (string) $number_of_mortgage_experts
            ],
            'version' => '1.0.0'
        ]);
    }
}
