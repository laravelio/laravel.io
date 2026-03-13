<?php

use App\Markdown\MarkdownServiceProvider;
use App\Providers\AppServiceProvider;
use App\Providers\Filament\AdminPanelProvider;

return [
    MarkdownServiceProvider::class,
    AppServiceProvider::class,
    AdminPanelProvider::class,
];
