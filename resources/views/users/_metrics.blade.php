<div class="flex items-center mr-8 mb-4 md:mb-8">
    <x-heroicon-o-document-report class="text-green-500 h-12 w-12 mr-1"/>
    <p class="tex-xl uppercase">{{ $user->countThreads() }} {{ Str::plural('thread', $user->countThreads()) }}</p>
</div>

<div class="flex items-center mr-8 mb-4 md:mb-8">
    <x-heroicon-o-chat-alt-2 class="text-green-500 h-12 w-12 mr-2"/>
    <p class="tex-xl uppercase">{{ $user->countReplies() }} {{ Str::plural('reply', $user->countReplies()) }}</p>
</div>

<div class="flex items-center mr-8 mb-4 md:mb-8">
    <x-heroicon-o-check-circle class="text-green-500 h-12 w-12 mr-2"/>
    <p class="tex-xl uppercase">{{ $user->countSolutions() }} {{ Str::plural('solution', $user->countSolutions()) }}</p>
</div>

<div class="flex items-center mr-8 mb-4 md:mb-8">
    <x-heroicon-o-document-duplicate class="text-green-500 h-12 w-12 mr-2"/>
    <p class="tex-xl uppercase">{{ $user->countArticles() }} {{ Str::plural('article', $user->countArticles()) }}</p>
</div>
