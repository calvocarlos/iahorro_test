<?php

namespace Tests\Feature\Api;

use App\Models\MortgageApplication;
use App\Models\MortgageExpert;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Class MortgageApplicationTest
 *
 * @package Tests\Feature\Api\MortgageApplicationTest
 */
class MortgageApplicationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_get_a_mortgage_application_without_expert_v1()
    {
        /** @var MortgageApplication $mortgage_application */
        $mortgage_application = MortgageApplication::factory()->create();

        $response = $this->getJson(route('api.v1.mortgage.applications.show', $mortgage_application));

        $response->assertExactJson([
            'author' => 'iAhorro - Carlos Calvo',
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
                    'scoring' => (string) $mortgage_application->scoring,
                    'assignment_date' => $mortgage_application->assignment_date ?? "",
                    'start_time_slot' => (string) $mortgage_application->start_time_slot,
                    'end_time_slot' => (string) $mortgage_application->end_time_slot,
                    'created_at' => $mortgage_application->created_at,
                    'updated_at' => $mortgage_application->updated_at,
                ],
                'relationships' => [],
                'links' => [
                    'self' => url(route('api.v1.mortgage.applications.show', $mortgage_application)),
                    'mortgage_applications' => url(route('api.v1.mortgage.applications.index')),
                ]
            ],
            'version' => '1.0.0'
        ]);
    }

    /** @test */
    public function it_can_get_a_mortgage_application_with_expert_v1()
    {
        /** @var MortgageExpert $mortgage_expert */
        $mortgage_expert = MortgageExpert::factory()->create();
        /** @var MortgageApplication $mortgage_application */
        $mortgage_application = MortgageApplication::factory()->create();

        $mortgage_application->mortgage_expert_id = $mortgage_expert->id;
        $mortgage_application->assignment_date = now();
        $mortgage_application->save();

        $response = $this->getJson(route('api.v1.mortgage.applications.show', $mortgage_application));

        $response->assertExactJson([
            'author' => 'iAhorro - Carlos Calvo',
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
                    'scoring' => (string) $mortgage_application->scoring,
                    'assignment_date' => $mortgage_application->assignment_date ?? "",
                    'start_time_slot' => (string) $mortgage_application->start_time_slot,
                    'end_time_slot' => (string) $mortgage_application->end_time_slot,
                    'created_at' => $mortgage_application->created_at,
                    'updated_at' => $mortgage_application->updated_at,
                ],
                'relationships' => [
                    'mortgage_expert' => [
                        'data' => [
                            'type' => 'mortgage_expert',
                            'id' => (string) $mortgage_application->mortgage_expert->id,
                        ],
                        'links' => [
                            'self' => url(route('api.v1.mortgage.experts.show', $mortgage_application->mortgage_expert->id)),
                            'mortgage_applications' => route('api.v1.mortgage.applications.expert.index', ['mortgage_expert_id' => $mortgage_application->mortgage_expert->id])
                        ]
                    ],
                ],
                'links' => [
                    'self' => url(route('api.v1.mortgage.applications.show', $mortgage_application)),
                    'mortgage_applications' => url(route('api.v1.mortgage.applications.index')),
                ]
            ],
            'version' => '1.0.0'
        ]);
    }

    /** @test */
    public function it_can_post_a_mortgage_application_v1()
    {
        $response = $this->withHeaders([])
            ->json('POST', route('api.v1.mortgage.applications.store'), [
                'first_name' => 'Carlos',
                'last_name' => 'Calvo Fernandez',
                'email' => 'calvocarlos.es@gmail.com',
                'phone_number' => '+34692349002',
                'net_income' => '36000.00',
                'requested_amount' => '150000.00',
                'start_time_slot' => '11',
                'end_time_slot' => '17'
            ]);

        $response->assertStatus(201);
    }

    /** @test */
    public function it_can_get_mortgage_applications_v1()
    {
        $number_of_mortgage_applications = 3;

        /** @var MortgageApplication $mortgage_application */
        $mortgage_applications = MortgageApplication::factory()->times($number_of_mortgage_applications)->create();

        $response = $this->getJson(route('api.v1.mortgage.applications.index'));

        $response->assertExactJson([
            'author' => 'iAhorro - Carlos Calvo',
            'data' => [
                [
                    'type' => 'mortgage_application',
                    'id' => (string) $mortgage_applications[0]->getRouteKey(),
                    'attributes' => [
                        'first_name' => $mortgage_applications[0]->first_name,
                        'last_name' => $mortgage_applications[0]->last_name,
                        'email' => $mortgage_applications[0]->email,
                        'phone_number' => $mortgage_applications[0]->phone_number,
                        'net_income' => (string) $mortgage_applications[0]->net_income,
                        'requested_amount' => (string) $mortgage_applications[0]->requested_amount,
                        'mortgage_expert_id' => (string) $mortgage_applications[0]->mortgage_expert_id,
                        'scoring' => (string) $mortgage_applications[0]->scoring,
                        'assignment_date' => $mortgage_applications[0]->assignment_date ?? "",
                        'start_time_slot' => (string) $mortgage_applications[0]->start_time_slot,
                        'end_time_slot' => (string) $mortgage_applications[0]->end_time_slot,
                        'created_at' => $mortgage_applications[0]->created_at,
                        'updated_at' => $mortgage_applications[0]->updated_at,
                    ],
                    'relationships' => [],
                    'links' => [
                        'self' => url(route('api.v1.mortgage.applications.show', $mortgage_applications[0])),
                        'mortgage_applications' => url(route('api.v1.mortgage.applications.index')),
                    ]
                ],
                [
                    'type' => 'mortgage_application',
                    'id' => (string) $mortgage_applications[1]->getRouteKey(),
                    'attributes' => [
                        'first_name' => $mortgage_applications[1]->first_name,
                        'last_name' => $mortgage_applications[1]->last_name,
                        'email' => $mortgage_applications[1]->email,
                        'phone_number' => $mortgage_applications[1]->phone_number,
                        'net_income' => (string) $mortgage_applications[1]->net_income,
                        'requested_amount' => (string) $mortgage_applications[1]->requested_amount,
                        'mortgage_expert_id' => (string) $mortgage_applications[1]->mortgage_expert_id,
                        'scoring' => (string) $mortgage_applications[1]->scoring,
                        'assignment_date' => $mortgage_applications[1]->assignment_date ?? "",
                        'start_time_slot' => (string) $mortgage_applications[1]->start_time_slot,
                        'end_time_slot' => (string) $mortgage_applications[1]->end_time_slot,
                        'created_at' => $mortgage_applications[1]->created_at,
                        'updated_at' => $mortgage_applications[1]->updated_at,
                    ],
                    'relationships' => [],
                    'links' => [
                        'self' => url(route('api.v1.mortgage.applications.show', $mortgage_applications[1])),
                        'mortgage_applications' => url(route('api.v1.mortgage.applications.index')),
                    ]
                ],
                [
                    'type' => 'mortgage_application',
                    'id' => (string) $mortgage_applications[2]->getRouteKey(),
                    'attributes' => [
                        'first_name' => $mortgage_applications[2]->first_name,
                        'last_name' => $mortgage_applications[2]->last_name,
                        'email' => $mortgage_applications[2]->email,
                        'phone_number' => $mortgage_applications[2]->phone_number,
                        'net_income' => (string) $mortgage_applications[2]->net_income,
                        'requested_amount' => (string) $mortgage_applications[2]->requested_amount,
                        'mortgage_expert_id' => (string) $mortgage_applications[2]->mortgage_expert_id,
                        'scoring' => (string) $mortgage_applications[2]->scoring,
                        'assignment_date' => $mortgage_applications[2]->assignment_date ?? "",
                        'start_time_slot' => (string) $mortgage_applications[2]->start_time_slot,
                        'end_time_slot' => (string) $mortgage_applications[2]->end_time_slot,
                        'created_at' => $mortgage_applications[2]->created_at,
                        'updated_at' => $mortgage_applications[2]->updated_at,
                    ],
                    'relationships' => [],
                    'links' => [
                        'self' => url(route('api.v1.mortgage.applications.show', $mortgage_applications[2])),
                        'mortgage_applications' => url(route('api.v1.mortgage.applications.index')),
                    ]
                ]
            ],
            'included' => [],
            'links' => [
                'self' => url(route('api.v1.mortgage.applications.index'))
            ],
            'meta' => [
                'count' => (string) $number_of_mortgage_applications
            ],
            'version' => '1.0.0'
        ]);
    }

    /** @test */
    public function it_can_get_mortgage_applications_with_and_without_an_expert_v1()
    {
        /** @var MortgageExpert $mortgage_expert */
        $mortgage_expert = MortgageExpert::factory()->create();
        /** @var MortgageApplication $mortgage_application1 */
        $mortgage_application1 = MortgageApplication::factory()->create();

        $mortgage_application1->mortgage_expert_id = $mortgage_expert->id;
        $mortgage_application1->assignment_date = now();
        $mortgage_application1->save();

        /** @var MortgageApplication $mortgage_application2 */
        $mortgage_application2 = MortgageApplication::factory()->create();

        $response = $this->getJson(route('api.v1.mortgage.applications.index'));

        $response->assertExactJson([
            'author' => 'iAhorro - Carlos Calvo',
            'data' => [
                [
                    'type' => 'mortgage_application',
                    'id' => (string) $mortgage_application1->getRouteKey(),
                    'attributes' => [
                        'first_name' => $mortgage_application1->first_name,
                        'last_name' => $mortgage_application1->last_name,
                        'email' => $mortgage_application1->email,
                        'phone_number' => $mortgage_application1->phone_number,
                        'net_income' => (string) $mortgage_application1->net_income,
                        'requested_amount' => (string) $mortgage_application1->requested_amount,
                        'mortgage_expert_id' => (string) $mortgage_application1->mortgage_expert_id,
                        'scoring' => (string) $mortgage_application1->scoring,
                        'assignment_date' => $mortgage_application1->assignment_date ?? "",
                        'start_time_slot' => (string) $mortgage_application1->start_time_slot,
                        'end_time_slot' => (string) $mortgage_application1->end_time_slot,
                        'created_at' => $mortgage_application1->created_at,
                        'updated_at' => $mortgage_application1->updated_at,
                    ],
                    'relationships' => [
                        'mortgage_expert' => [
                            'data' => [
                                'type' => 'mortgage_expert',
                                'id' => (string) $mortgage_application1->mortgage_expert->id,
                            ],
                            'links' => [
                                'self' => url(route('api.v1.mortgage.experts.show', $mortgage_application1->mortgage_expert)),
                                'mortgage_applications' => route('api.v1.mortgage.applications.expert.index', ['mortgage_expert_id' => $mortgage_application1->mortgage_expert->id])
                            ]
                        ],
                    ],
                    'links' => [
                        'self' => url(route('api.v1.mortgage.applications.show', $mortgage_application1)),
                        'mortgage_applications' => url(route('api.v1.mortgage.applications.index')),
                    ]
                ],
                [
                    'type' => 'mortgage_application',
                    'id' => (string) $mortgage_application2->getRouteKey(),
                    'attributes' => [
                        'first_name' => $mortgage_application2->first_name,
                        'last_name' => $mortgage_application2->last_name,
                        'email' => $mortgage_application2->email,
                        'phone_number' => $mortgage_application2->phone_number,
                        'net_income' => (string) $mortgage_application2->net_income,
                        'requested_amount' => (string) $mortgage_application2->requested_amount,
                        'mortgage_expert_id' => (string) $mortgage_application2->mortgage_expert_id,
                        'scoring' => (string) $mortgage_application2->scoring,
                        'assignment_date' => $mortgage_application2->assignment_date ?? "",
                        'start_time_slot' => (string) $mortgage_application2->start_time_slot,
                        'end_time_slot' => (string) $mortgage_application2->end_time_slot,
                        'created_at' => $mortgage_application2->created_at,
                        'updated_at' => $mortgage_application2->updated_at,
                    ],
                    'relationships' => [],
                    'links' => [
                        'self' => url(route('api.v1.mortgage.applications.show', $mortgage_application2)),
                        'mortgage_applications' => url(route('api.v1.mortgage.applications.index')),
                    ]
                ]
            ],
            'included' => [
                [
                    'type' => 'mortgage_expert',
                    'id' => (string) $mortgage_expert->id,
                    'attributes' => [
                        'first_name' => $mortgage_expert->first_name,
                        'last_name' => $mortgage_expert->last_name,
                        'created_at' => $mortgage_expert->created_at,
                        'updated_at' => $mortgage_expert->updated_at,
                    ],
                    'links' => [
                        'self' => url(route('api.v1.mortgage.experts.show', $mortgage_expert->id)),
                        'mortgage_applications' => url(route('api.v1.mortgage.applications.expert.index', ['mortgage_expert_id' => $mortgage_expert->id])),
                        'mortgage_experts' => url(route('api.v1.mortgage.experts.index'))
                    ]
                ]
            ],
            'links' => [
                'self' => url(route('api.v1.mortgage.applications.index'))
            ],
            'meta' => [
                'count' => (string) 2
            ],
            'version' => '1.0.0'
        ]);
    }

    /** @test */
    public function it_can_get_a_mortgage_application_v2()
    {
        /** @var MortgageApplication $mortgage_application */
        $mortgage_application = MortgageApplication::factory()->create();

        $response = $this->getJson(route('api.v2.mortgage.applications.show', $mortgage_application));

        $response->assertExactJson([
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
                    'self' => url(route('api.v2.mortgage.applications.show', $mortgage_application))
                ]
            ]
        ]);
    }

    /** @test */
    public function it_can_get_mortgage_applications_v2()
    {
        $number_of_mortgage_applications = 3;

        /** @var MortgageApplication $mortgage_application */
        $mortgage_applications = MortgageApplication::factory()->times($number_of_mortgage_applications)->create();

        $response = $this->getJson(route('api.v2.mortgage.applications.index'));

        $response->assertExactJson([
            'data' => [
                [
                    'type' => 'mortgage_application',
                    'id' => (string) $mortgage_applications[0]->getRouteKey(),
                    'attributes' => [
                        'first_name' => $mortgage_applications[0]->first_name,
                        'last_name' => $mortgage_applications[0]->last_name,
                        'email' => $mortgage_applications[0]->email,
                        'phone_number' => $mortgage_applications[0]->phone_number,
                        'net_income' => (string) $mortgage_applications[0]->net_income,
                        'requested_amount' => (string) $mortgage_applications[0]->requested_amount,
                        'mortgage_expert_id' => (string) $mortgage_applications[0]->mortgage_expert_id,
                        'assignment_date' => $mortgage_applications[0]->assignment_date,
                        'start_time_slot' => (string) $mortgage_applications[0]->start_time_slot,
                        'end_time_slot' => (string) $mortgage_applications[0]->end_time_slot,
                        'created_at' => $mortgage_applications[0]->created_at,
                        'updated_at' => $mortgage_applications[0]->updated_at,
                    ],
                    'links' => [
                        'self' => url(route('api.v2.mortgage.applications.show', $mortgage_applications[0]))
                    ]
                ],
                [
                    'type' => 'mortgage_application',
                    'id' => (string) $mortgage_applications[1]->getRouteKey(),
                    'attributes' => [
                        'first_name' => $mortgage_applications[1]->first_name,
                        'last_name' => $mortgage_applications[1]->last_name,
                        'email' => $mortgage_applications[1]->email,
                        'phone_number' => $mortgage_applications[1]->phone_number,
                        'net_income' => (string) $mortgage_applications[1]->net_income,
                        'requested_amount' => (string) $mortgage_applications[1]->requested_amount,
                        'mortgage_expert_id' => (string) $mortgage_applications[1]->mortgage_expert_id,
                        'assignment_date' => $mortgage_applications[1]->assignment_date,
                        'start_time_slot' => (string) $mortgage_applications[1]->start_time_slot,
                        'end_time_slot' => (string) $mortgage_applications[1]->end_time_slot,
                        'created_at' => $mortgage_applications[1]->created_at,
                        'updated_at' => $mortgage_applications[1]->updated_at,
                    ],
                    'links' => [
                        'self' => url(route('api.v2.mortgage.applications.show', $mortgage_applications[1]))
                    ]
                ],
                [
                    'type' => 'mortgage_application',
                    'id' => (string) $mortgage_applications[2]->getRouteKey(),
                    'attributes' => [
                        'first_name' => $mortgage_applications[2]->first_name,
                        'last_name' => $mortgage_applications[2]->last_name,
                        'email' => $mortgage_applications[2]->email,
                        'phone_number' => $mortgage_applications[2]->phone_number,
                        'net_income' => (string) $mortgage_applications[2]->net_income,
                        'requested_amount' => (string) $mortgage_applications[2]->requested_amount,
                        'mortgage_expert_id' => (string) $mortgage_applications[2]->mortgage_expert_id,
                        'assignment_date' => $mortgage_applications[2]->assignment_date,
                        'start_time_slot' => (string) $mortgage_applications[2]->start_time_slot,
                        'end_time_slot' => (string) $mortgage_applications[2]->end_time_slot,
                        'created_at' => $mortgage_applications[2]->created_at,
                        'updated_at' => $mortgage_applications[2]->updated_at,
                    ],
                    'links' => [
                        'self' => url(route('api.v2.mortgage.applications.show', $mortgage_applications[2]))
                    ]
                ]
            ],
            'links' => [
                'self' => url(route('api.v2.mortgage.applications.index'))
            ],
            'meta' => [
                'count' => (string) $number_of_mortgage_applications
            ]
        ]);
    }
}
