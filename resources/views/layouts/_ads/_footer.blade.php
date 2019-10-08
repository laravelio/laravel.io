@unless ($disableAds ?? false)
    <a 
        href="https://flareapp.io/?ref=laravelio" 
        target="_blank" 
        rel="noopener noreferrer"
    >
        <!-- Show the banner on bigger displays. -->
        <img class="hidden md:block my-4 mx-auto w-full" style="max-width:1200px" src="/images/flare-1200x90-dark.svg">
        <!-- Show the square on mobile. -->
        <img class="md:hidden my-4 mx-auto w-full" style="max-width:300px" src="/images/flare-300x250-dark.svg">        
    </a>
@endif
