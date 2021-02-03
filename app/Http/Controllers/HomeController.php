<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function show()
    {
        $totalUsers = Cache::remember('totalUsers', now()->addDay(), function () {
            return number_format(User::count());
        });

        $totalThreads = Cache::remember('totalThreads', now()->addDay(), function () {
            return number_format(Thread::count());
        });

        $resolutionTime = Cache::remember('resolutionTime', now()->addDay(), function () {
            return number_format(Thread::resolutionTime());
        });

        $latestThreads = Cache::remember('latestThreads', now()->addHour(), function () {
            return Thread::whereNull('solution_reply_id')
                ->whereBetween('threads.created_at', [now()->subWeek(), now()])
                ->inRandomOrder()
                ->limit(3)
                ->get();
        });

        return view('home', [
            'totalUsers' => $totalUsers,
            'totalThreads' => $totalThreads,
            'resolutionTime' => $resolutionTime,
            'latestThreads' => $latestThreads,
        ]);
    }

    public function rules()
    {
        return view('rules');
    }

    public function terms()
    {
        return view('terms');
    }

    public function privacy()
    {
        return view('privacy');
    }

    public function pastebin(string $hash = '')
    {
        return redirect()->away("https://paste.laravel.io/$hash");
    }
}
