<?php

namespace App\Filament\Resources\Threads;

use App\Filament\Resources\Threads\Pages\ListThreads;
use App\Filament\Resources\Threads\Tables\ThreadsTable;
use App\Models\Thread;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ThreadResource extends Resource
{
    protected static ?string $model = Thread::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedChatBubbleLeftRight;

    protected static ?string $recordTitleAttribute = 'Threads';

    public static function table(Table $table): Table
    {
        return ThreadsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListThreads::route('/'),
        ];
    }
}
