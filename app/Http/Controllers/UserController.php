<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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

    public function store(Request $request)
    {

        try {
            $validator = Validator::make($request->all(), [
                'name'    => 'required|max:255',
                'email'   => 'required|unique:users,email|max:255',
                'role_id' => 'nullable|integer|exists:roles,id'
            ],[
                'exist' => 'role id does not exist.'
            ]);
            $validated = $validator->validate();
            User::create($validated);
            return response()->json('success');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // done in this way to force the response to be json, also to use the correct exception message
            return response()->json($e->errors(), $e->status);
        }
    }
}
