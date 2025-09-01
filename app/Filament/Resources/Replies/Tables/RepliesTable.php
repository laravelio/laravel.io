<?php

namespace App\Filament\Resources\Replies\Tables;

use App\Models\Reply;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class RepliesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('updated_at', 'desc')
            ->openRecordUrlInNewTab()
            ->columns([
                ImageColumn::make('authorRelation.github_id')
                    ->label('Author')
                    ->circular()
                    ->defaultImageUrl(fn(?string $state): string => $state ? sprintf('https://avatars.githubusercontent.com/u/%s', $state) : asset('images/laravelio-icon-gray.svg')),

                TextColumn::make('authorRelation.name')
                    ->label('')
                    ->description(fn(Reply $record): ?string => $record->authorRelation->username),

                TextColumn::make('replyAbleRelation.subject')
                    ->label('Thread')
                    ->searchable(),

                TextColumn::make('body')
                    ->label('Content')
                    ->limit(250)
                    ->wrap()
                    ->searchable(),

                IconColumn::make('updated_by')
                    ->label('Updated')
                    ->boolean()
                    ->default(false),

                TextColumn::make('created_at')
                    ->label('Created on')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Last updated on')
                    ->dateTime()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TrashedFilter::make(),

                TernaryFilter::make('updated_by')
                    ->label('Updated')
                    ->nullable()
            ])
            ->recordActions([
                Action::make('view')
                    ->url(fn(Reply $record): string => route('thread', $record->replyAble()->slug()) . '#' . $record->id())
                    ->openUrlInNewTab()
                    ->icon('heroicon-s-eye'),

                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
