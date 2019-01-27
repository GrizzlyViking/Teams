<?php
/**
 * Created by PhpStorm.
 * User: sebastian
 * Date: 27/01/2019
 * Time: 16:42
 */

class TeamTest extends TestCase
{
    /**
     * @test
     */
    public function to_get_a_list_of_teams()
    {
        $this->get('/teams')
            ->seeJsonStructure(
            ['*' => [
                    'title',
                    'owner_id',
                    'created_at',
                    'updated_at'
                ]
            ]
        );
        $this->seeStatusCode(200);
    }

    /** @test */
    public function create_a_and_delete_a_team()
    {
        $this->post('/teams', [
            'title' => 'Test Title',
            'owner_id' => 2,
        ]);

        $this->seeStatusCode(200);

        $team = \App\Team::where('title', '=', 'Test Title')->first();

        $this->delete('/teams/'.$team->id);

        $this->seeStatusCode(200);
    }

    /** @test */
    public function update_and_show_team()
    {
        $this->put('teams/4', [
            'owner_id' => 3
        ]);

        $this->seeStatusCode(200);

        $this->get('teams/4')->seeJsonStructure(
            [
                'title',
                'owner_id',
                'created_at',
                'updated_at'
            ]);
        $this->seeStatusCode(200);
    }
}