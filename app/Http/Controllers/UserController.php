<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Http\Response;
use App\Exceptions\DatabaseException;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   
        $users = User::all();
        return response()->json($users, 200);
    }

    /**
     * Store a newly created resource in storage.
    * @param  \App\Http\Requests\StorePersonRequest  $request
    * @return \Illuminate\Http\Response
    */
    public function store(StoreUserRequest $request)
    {
        $data = $request->validated();
        $check = User::where('email',$data['email'])->first();

        try{
            $user = User::create($data);
        }catch (\Throwable $e){
            throw new DatabaseException($e->getMessage(), $e->getCode(), $e);
        }

        return response()->json($user, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    // public function show(User $user)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     */
    // public function update(UpdateUserRequest $request, User $user)
    // {
    //     $data = $request->validated();
    //     $user->update($data);
    //     return response()->json($user);
    // }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(User $user)
    // {
    //     //
    // }
}
