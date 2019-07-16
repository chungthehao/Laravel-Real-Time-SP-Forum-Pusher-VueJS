<?php

namespace App\Http\Controllers;

use App\Events\DeleteReplyEvent;
use App\Models\Question;
use App\Models\Reply;
use App\Http\Resources\Reply as ReplyResource;
use App\Notifications\NewReplyNotification;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ReplyController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt', ['except' => ['index', 'show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Question $question)
    {
        try {
            return response()->json(ReplyResource::collection($question->replies()->latest()->get()), Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong!'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Question $question, Request $request)
    {
        $reply = $question->replies()->create($request->all());

        // Notification
        $askUser = $question->user;
        if ($reply->user_id !== $question->user_id) { // Nó tự trả lời câu hỏi của nó thì khỏi báo nó
            $askUser->notify(new NewReplyNotification($reply)); // Sẽ thêm 1 record trong bảng notifications
        }

        return response()->json(new ReplyResource($reply), Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question, Reply $reply)
    {
        return response()->json(new ReplyResource($reply), Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Question $question, Reply $reply)
    {
        $reply->update($request->all());
        return response()->json(new ReplyResource($reply), Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question, Reply $reply)
    {
        try {
            $reply->delete();

            // Broadcast để việc delete reply ở 1 trang sẽ real time đến tất cả nơi khác cùng đang ở trang đó
            broadcast(new DeleteReplyEvent($reply->id))->toOthers();

            return response()->json($reply, Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong!'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
