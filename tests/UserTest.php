<?php
/**
 * Created by PhpStorm.
 * User: sebastian
 * Date: 27/01/2019
 * Time: 16:42
 */

class UserTest extends TestCase
{
    /**
     * @test
     */
    public function to_get_a_list_of_users()
    {
        $this->get('/users')
            ->seeJsonStructure(
                [
                    '*' => [
                        'name',
                        'email',
                        'role_id'
                    ]
                ]
            );
        $this->seeStatusCode(200);
    }

    /**
     * @test
     */
    public function to_get_a_list_of_users_teams()
    {
        $this->get('/users/4/teams')
            ->seeJsonStructure(
                [
                    '*' => [
                        "id",
                        "title",
                        "owner_id"
                    ]
                ]
            );
        $this->seeStatusCode(200);
    }

    /** @test */
    public function create_a_and_delete_a_team()
    {
        $this->post('/users', [
            'name'    => 'Test Name',
            'email'   => 'someone@somewhere.com',
            'role_id' => 2,
        ]);

        $this->seeStatusCode(200);

        $user = \App\User::where('name', '=', 'Test Name')->first();

        $this->delete('/users/' . $user->id);

        $this->seeStatusCode(200);
    }

    /** @test */
    public function test_validation_by_forgetting_to_provide_email()
    {
        $this->post('/users', [
            'name'    => 'Test Name',
            'role_id' => 2,
        ]);

        $this->seeStatusCode(422);

    }

    /** @test */
    public function update_and_show_team()
    {
        $this->put('users/4', [
            'role_id' => 3
        ]);

        $this->seeStatusCode(200);

        $this->get('users/4')->seeJsonStructure(
            [
                'name',
                'email',
                'role_id'
            ]);
        $this->seeStatusCode(200);
    }
}