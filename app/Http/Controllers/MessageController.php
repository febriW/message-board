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
     *     summary="Return 12 latest record",
     *     description="Endpoint latest message record",
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
        try {
            $result = User::select('users.name', 'users.email', 'messages.message', 'messages.id')
                ->LeftJoin('messages', 'users.id', '=', 'messages.user_id')
                ->orderBy('messages.created_at', 'desc')
                ->take(12)
                ->get();
        }catch (\Throwable $e){
            echo $e->getMessage();
            throw new DatabaseException($e->getMessage(), $e->getCode(), $e);
        }
        return response()->json(['data' => $result], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    /**
     * @OA\Post(
     *     path="/api/message",
     *     tags={"message"},
     *     summary="Create Message",
     *     description="Endpoint to create new message",
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\MediaType(
     *            mediaType="application/json",
     *         )
     *     )
     * )
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
    /**
     * @OA\Get(
     *     path="/api/message/{params}",
     *     tags={"message"},
     *     summary="Get Message",
     *     description="Endpoint get spesific message using key",
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\MediaType(
     *            mediaType="application/json",
     *         )
     *     )
     * )
     */
    public function show(Message $message)
    {
        return response()->json($message);
    }

    /**
     * @OA\Patch(
     *     path="/api/message/{params}",
     *     tags={"message"},
     *     summary="Update data message",
     *     description="Endpoint to update message",
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\MediaType(
     *            mediaType="application/json",
     *         )
     *     )
     * )
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
     * @OA\Delete(
     *     path="/api/message/{params}",
     *     tags={"message"},
     *     summary="Delete data message",
     *     description="Endpoint to delete message",
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\MediaType(
     *            mediaType="application/json",
     *         )
     *     )
     * )
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

    /**
     * @OA\Post(
     *     path="/api/message/search",
     *     tags={"message"},
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
    public function search(SearchMessageRequest $request)
    {
       $terms = $request->params;
       $page = $request->page ? $request->page : 1;

       try {
            $query = User::query()
                ->select('users.name', 'users.email', 'messages.message')
                ->LeftJoin('messages', 'users.id', '=', 'messages.user_id')
                ->whereRaw("CONCAT_WS('', msg_users.name, msg_messages.message, msg_users.email) LIKE '%".$terms."%'")
                ->orderBy('messages.created_at', 'desc');

            $data = $query->skip(($page - 1)* 8)
                ->take(8)
                ->get();
       }catch (\Throwable $e){
            echo $e->getMessage();
            throw new DatabaseException($e->getMessage(), $e->getCode(), $e);
       }
       return response()->json(['data' => $data], Response::HTTP_OK);
    }
}
