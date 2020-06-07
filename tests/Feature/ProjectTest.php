<?php

namespace Tests\Feature;

use App\Project;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;
use Nuwave\Lighthouse\Testing\MakesGraphQLRequests;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;
    use MakesGraphQLRequests;

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testIndexProject()
    {
        #prepare
        $user = factory(User::class)->create();
        Passport::actingAs($user);
        factory(Project::class,1)->create();
        #execution
        $response = $this->graphQL("{
                                            project(id: 1){
                                                id
                                                name
                                                budget
                                            }
                                          }");

        #assertions
        $response->assertJson([
            'data' => [
                'project' => [
                    'id' => 1
                ]
            ]
        ]);
    }


    public function testReadProjects()
    {
        #prepare
        $user = factory(User::class)->create();
        Passport::actingAs($user);
        factory(Project::class,5)->create();
        #execution
        $response = $this->graphQL("{
                                            projects {
                                                id
                                                name
                                                budget
                                            }
                                          }");

        #assertions
        $response->assertJson([
            'data' => [
                'projects' => []
            ]
        ]);

    }

    public function testUpdateProject()
    {
        #prepare
        $user = factory(User::class)->create();
        Passport::actingAs($user);
        factory(Project::class,1)->create();
        #execution
        $response = $this->graphQL('mutation {
                                            updateProject(
                                            id:1
                                            input:	{
                                              name: "Project Rename"
                                            }
                                          ) {
                                            id
                                            name
                                            budget
                                          }
                                        }');

        #assertions
        $response->assertJson([
            'data' => [
                'updateProject' => [
                    'id' => 1,
                    'name' => "Project Rename"
                ]
            ]
        ]);
    }

    public function testDeleteProject()
    {
        #prepare
        $user = factory(User::class)->create();
        Passport::actingAs($user);
        factory(Project::class,1)->create();
        #execution
        $response = $this->graphQL('mutation {
                                            deleteProject(id:1 ) {
                                                id
                                                name
                                                budget
                                            }
                                         }');

        #assertions
        $response->assertJson([
            'data' => [
                'deleteProject' => [
                    'id' => 1
                ]
            ]
        ]);
    }
}
