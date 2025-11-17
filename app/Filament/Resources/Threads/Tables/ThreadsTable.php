<?php

namespace App\Filament\Resources\Threads\Tables;

use App\Models\Thread;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Table;

class ThreadsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('authorRelation.github_id')
                    ->label('Author')
                    ->circular()
                    ->defaultImageUrl(fn(?string $state): string => $state ? sprintf('https://avatars.githubusercontent.com/u/%s', $state) : asset('images/laravelio-icon-gray.svg')),

                TextColumn::make('authorRelation.name')
                    ->label('')
                    ->description(fn(Thread $thread): ?string => $thread->authorRelation->username)
                    ->searchable(),

                TextColumn::make('subject')
                    ->searchable(),

                TextColumn::make('last_activity_at')
                    ->dateTime()
                    ->sortable(),

                TextColumn::make('locked_at')
                    ->dateTime()
                    ->sortable(),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->recordActions([
                Action::make('view')
                    ->url(fn(Thread $thread): string => route('thread', $thread->slug()))
                    ->openUrlInNewTab()
                    ->icon('heroicon-s-eye'),

            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
