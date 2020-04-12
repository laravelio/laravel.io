<div class="flex items-center mr-8 mb-4 md:mb-8">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="icon-document-notes h-12 w-12 mr-1"><path class="primary" d="M6 2h6v6c0 1.1.9 2 2 2h6v10a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V4c0-1.1.9-2 2-2zm2 11a1 1 0 0 0 0 2h8a1 1 0 0 0 0-2H8zm0 4a1 1 0 0 0 0 2h4a1 1 0 0 0 0-2H8z"/><polygon class="secondary" points="14 2 20 8 14 8"/></svg>
    <p class="tex-xl uppercase">{{ $user->countThreads() }} {{ Str::plural('thread', $user->countThreads()) }}</p>
</div>

<div class="flex items-center mr-8 mb-4 md:mb-8">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="icon-chat-group h-12 w-12 mr-2"><path class="primary" d="M20.3 12.04l1.01 3a1 1 0 0 1-1.26 1.27l-3.01-1a7 7 0 1 1 3.27-3.27zM11 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/><path class="secondary" d="M15.88 17.8a7 7 0 0 1-8.92 2.5l-3 1.01a1 1 0 0 1-1.27-1.26l1-3.01A6.97 6.97 0 0 1 5 9.1a9 9 0 0 0 10.88 8.7z"/></svg>
    <p class="tex-xl uppercase">{{ $user->countReplies() }} {{ Str::plural('reply', $user->countReplies()) }}</p>
</div>

<div class="flex items-center mr-8 mb-4 md:mb-8">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="icon-check h-12 w-12 mr-2"><circle cx="12" cy="12" r="10" class="primary"/><path class="secondary" d="M10 14.59l6.3-6.3a1 1 0 0 1 1.4 1.42l-7 7a1 1 0 0 1-1.4 0l-3-3a1 1 0 0 1 1.4-1.42l2.3 2.3z"/></svg>
    <p class="tex-xl uppercase">{{ $user->countSolutions() }} {{ Str::plural('solution', $user->countSolutions()) }}</p>
</div>

<div class="flex items-center mr-8 mb-4 md:mb-8">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="icon-edit h-12 w-12 mr-2"><path class="primary" d="M4 14a1 1 0 0 1 .3-.7l11-11a1 1 0 0 1 1.4 0l3 3a1 1 0 0 1 0 1.4l-11 11a1 1 0 0 1-.7.3H5a1 1 0 0 1-1-1v-3z"/><rect width="20" height="2" x="2" y="20" class="secondary" rx="1"/></svg>
    <p class="tex-xl uppercase">{{ $user->countArticles() }} {{ Str::plural('article', $user->countArticles()) }}</p>
</div>