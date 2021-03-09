<div class="flex items-center mr-8 mb-4 md:mb-8">
    <x-heroicon-o-document-report class="text-lio-500 h-12 w-12 mr-1"/>
    <p class="tex-xl uppercase">{{ $countedThreads = $user->countThreads() }} {{ Str::plural('thread', $countedThreads) }}</p>
</div>

<div class="flex items-center mr-8 mb-4 md:mb-8">
    <x-heroicon-o-chat-alt-2 class="text-lio-500 h-12 w-12 mr-2"/>
    <p class="tex-xl uppercase">{{ $countedReplies = $user->countReplies() }} {{ Str::plural('reply', $countedReplies) }}</p>
</div>

<div class="flex items-center mr-8 mb-4 md:mb-8">
    <x-heroicon-o-check-circle class="text-lio-500 h-12 w-12 mr-2"/>
    <p class="tex-xl uppercase">{{ $countedSolutions = $user->countSolutions() }} {{ Str::plural('solution', $countedSolutions) }}</p>
</div>

<div class="flex items-center mr-8 mb-4 md:mb-8">
    <x-heroicon-o-document-duplicate class="text-lio-500 h-12 w-12 mr-2"/>
    <p class="tex-xl uppercase">{{ $countedArticles = $user->countArticles() }} {{ Str::plural('article', $countedArticles) }}</p>
</div>
