<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserController extends Controller
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
        return response()->json(User::all(), 200, [], JSON_UNESCAPED_UNICODE);
    }

    public function show($user_id)
    {
        try {
            /** @var User $user */
            $user = User::with('teams')->findOrFail($user_id);

            return response()->json($user, 200, [], JSON_UNESCAPED_UNICODE);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json('User with id '.$user_id.' not found.', 404);
        }
    }

    public function store(Request $request)
    {

        try {
            /** @var \Illuminate\Validation\Validator $validator */
            $validator = Validator::make($request->all(), [
                'name'    => 'required|max:255',
                'email'   => 'required|unique:users,email|max:255',
                'role_id' => 'nullable|integer|exists:roles,id',
                'team_ids' => 'nullable|array'
            ],[
                'exist' => 'role id does not exist.'
            ]);

            $validated = $validator->validate();
            $user = User::create($validated);
            if (!empty($validated['team_ids'])) {
                $user->teams()->attach($validated['team_ids']);
            }
            return response()->json('success');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // done in this way to force the response to be json, also to use the correct exception message
            return response()->json($e->errors(), $e->status);
        }
    }

    public function update(Request $request, $user_id)
    {
        try {
            /** @var User $user */
            $user = User::findOrFail($user_id);

            /** @var \Illuminate\Validation\Validator $validator */
            $validator = Validator::make($request->all(), [
                'name'    => 'max:255',
                'email'   => 'email|max:255',
                'role_id' => 'nullable|integer|exists:roles,id',
                'team_ids' => 'nullable|array'
            ],[
                'exist' => 'role id does not exist.'
            ]);

            $validated = $validator->validate();
            $user->update($validated);
            if (!empty($validated['team_ids'])) {
                $user->teams()->sync($validated['team_ids']);
            }
            return response()->json('success');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // done in this way to force the response to be json, also to use the correct exception message
            return response()->json($e->errors(), $e->status);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json('User with id '.$user_id.' not found.', 404);
        }
    }

    /**
     * @param integer $user_id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy($user_id)
    {
        try {
            /** @var User $user */
            $user = User::findOrFail($user_id);
            $user->delete();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json('User with id '.$user_id.' not found.', 404);
        }
    }

    public function teams($user_id)
    {
        try {
            /** @var User $user */
            $user = User::findOrFail($user_id);

            return response()->json($user->teams->toArray(), 200, [], JSON_UNESCAPED_UNICODE);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json('User with id '.$user_id.' not found.', 404);
        }
    }
}
