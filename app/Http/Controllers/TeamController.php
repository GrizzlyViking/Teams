<?php

namespace App\Http\Controllers;

use App\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TeamController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function index()
    {
        return response()->json(Team::all(), 200, [], JSON_UNESCAPED_UNICODE);
    }

    public function show($team_id)
    {
        try {
            /** @var Team $team */
            $team = Team::findOrFail($team_id);

            return response()->json($team, 200, [], JSON_UNESCAPED_UNICODE);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json('Team with id '.$team_id.' not found.', 404);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:teams,title|max:255',
            'owner_id' => 'nullable|integer|exists:users,id'
        ]);

        $validated = $validator->validate();

        Team::create($validated);

        return response()->json('success');
    }


    public function update(Request $request, $team_id)
    {
        try {
            /** @var Team $team */
            $team = Team::findOrFail($team_id);

            /** @var \Illuminate\Validation\Validator $validator */
            $validator = Validator::make($request->all(), [
                'title'    => 'max:255',
                'owner_id' => 'nullable|integer|exists:users,id'
            ]);

            $validated = $validator->validate();
            $team->update($validated);

            return response()->json('success');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // done in this way to force the response to be json, also to use the correct exception message
            return response()->json($e->errors(), $e->status);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json('Team with id '.$team_id.' not found.', 404);
        }
    }

    /**
     * @param integer $team_id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy($team_id)
    {
        try {
            /** @var Team $team */
            $team = Team::findOrFail($team_id);
            $team->delete();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json('Team with id '.$team_id.' not found.', 404);
        }
    }
}
