@if ($thread->isSolved())
    <a class="label label-primary text-center mt-4 sm:mt-0"
       href="{{ route('thread', $thread->slug()) }}#{{ $thread->solution_reply_id }}">
        <i class="fa fa-check mr-2"></i>
        View solution
    </a>
@endif

