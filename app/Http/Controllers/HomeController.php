<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function show()
    {
        $communityMembers = Cache::remember('communityMembers', now()->addMinutes(5), function () {
            return User::withCounts()
                ->hasActivity()
                ->inRandomOrder()
                ->take(100)
                ->get()
                ->chunk(20);
        });

        $totalUsers = Cache::remember('totalUsers', now()->addDay(), function () {
            return number_format(User::count());
        });

        $totalThreads = Cache::remember('totalThreads', now()->addDay(), function () {
            return number_format(Thread::count());
        });

        $totalReplies = Cache::remember('totalReplies', now()->addDay(), function () {
            return number_format(Reply::count());
        });

        $latestThreads = Cache::remember('latestThreads', now()->addHour(), function () {
            return Thread::whereNull('solution_reply_id')
                ->whereBetween('threads.created_at', [now()->subWeek(), now()])
                ->inRandomOrder()
                ->limit(3)
                ->get();
        });

        $latestArticles = Cache::remember('latestArticles', now()->addHour(), function () {
            return Article::published()
                ->trending()
                ->limit(4)
                ->get();
        });

        return view('home', [
            'communityMembers' => $communityMembers,
            'totalUsers' => $totalUsers,
            'totalThreads' => $totalThreads,
            'totalReplies' => $totalReplies,
            'latestThreads' => $latestThreads,
            'latestArticles' => $latestArticles,
        ]);
    }

    public function pastebin(string $hash = '')
    {
        return redirect()->away("https://paste.laravel.io/$hash");
    }
}
