<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Reply;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LikeController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt');
    }

    public function likeIt(Reply $reply)
    {
        $reply->likes()->create([
            // 'user_id' => auth()->id(),
            'user_id' => 1 // hardcoded temporary
        ]);
        return response()->json(null, Response::HTTP_CREATED);
    }

    public function unlikeIt(Reply $reply)
    {
        $reply->likes()->where('user_id', 1/*auth()->id()*/)->delete();
        return response()->json(null, Response::HTTP_OK);
    }
}
