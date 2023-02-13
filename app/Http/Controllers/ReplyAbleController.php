<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use App\Models\Reply;

class ReplyAbleController extends Controller
{
    public function redirect($id, $type): RedirectResponse
    {
        $reply = Reply::where('replyable_id', $id)->where('replyable_type', $type)->firstOrFail();

        return redirect(route_to_reply_able($reply->replyAble()));
    }
}
