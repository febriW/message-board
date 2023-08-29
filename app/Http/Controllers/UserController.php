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
     * @OA\Get(
     *     path="/api/user",
     *     tags={"user"},
     *     summary="Return list users",
     *     description="Sample Response",
     *     operationId="user",
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\MediaType(
     *            mediaType="application/json",
     *         )
     *     )
     * )
     */
    public function index()
    {   
        $users = User::all();
        return response()->json($users, Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
    * @param  \App\Http\Requests\StorePersonRequest  $request
    * @return \Illuminate\Http\Response
    */
    /**
     * @OA\Post(
     *     path="/api/user",
     *     tags={"user"},
     *     summary="Create users",
     *     description="A sample user to test out the API",
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\MediaType(
     *            mediaType="application/json",
     *         )
     *     )
     * )
     */
    public function store(StoreUserRequest $request)
    {
        $data = $request->validated();
        try{
            $check = User::where('email', $data['email'])->first();

            if($check != null){
                return response()->json($check, Response::HTTP_OK);
            }

            $user = User::create($data);
            return response()->json($user, Response::HTTP_CREATED);
        }catch (\Throwable $e){
            throw new DatabaseException($e->getMessage(), $e->getCode(), $e);
        }

    }
}
