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

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:teams,title|max:255',
        ]);

        $validated = $validator->validate();

        Team::create($validated);

        return response()->json('success');
    }

    /**
     * @param Team $team
     * @throws \Exception
     */
    public function destroy(Team $team)
    {
        $team->delete();
    }
}
