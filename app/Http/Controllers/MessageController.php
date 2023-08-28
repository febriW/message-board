<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use App\Http\Requests\StoreMessageRequest;
use App\Http\Requests\UpdateMessageRequest;
use App\Http\Requests\SearchMessageRequest;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Exceptions\DatabaseException;

class MessageController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/message",
     *     tags={"message"},
     *     summary="Returns a message API response",
     *     description="A sample message to test out the API",
     *     operationId="message",
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
        $message = Message::all();
        return response()->json($message, Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMessageRequest $request)
    {
        $data = $request->validated();
        try{
            $message = Message::create($data);
        }catch (\Throwable $e){
            throw new DatabaseException($e->getMessage(), $e->getCode(), $e);
        }

        return response()->json($message, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Message $message)
    {
        return response()->json($message);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMessageRequest $request, Message $message)
    {
        $data = $request->validated();
        try{
            $message->update($data);
        }catch (\Throwable $e){
            throw new DatabaseException($e->getMessage(), $e->getCode(), $e);
        }

        return response()->json($message->refresh(), Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Message $message)
    {
        try{
            $message->delete();
        }catch (\Throwable $e){
            throw new DatabaseException($e->getMessage(), $e->getCode(), $e);
        }

        return response()->noContent();
    }

    public function search(SearchMessageRequest $request)
    {
       $terms = $request->params;
       try {
        $result = User::select('users.name', 'users.email', 'messages.message')
            ->LeftJoin('messages', 'users.id', '=', 'messages.user_id')
            ->whereRaw("CONCAT_WS('', msg_users.name, msg_messages.message, msg_users.email) LIKE '%".$terms."%'")
            ->get();
       }catch (\Throwable $e){
            echo $e->getMessage();
            throw new DatabaseException($e->getMessage(), $e->getCode(), $e);
       }

       return response()->json($result, Response::HTTP_OK);
    }
}
