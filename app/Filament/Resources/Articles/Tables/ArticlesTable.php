<?php

namespace App\Filament\Resources\Articles\Tables;

use App\Models\Article;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ArticlesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('submitted_at', 'desc')
            ->openRecordUrlInNewTab()
            ->columns([
                ImageColumn::make('authorRelation.github_id')
                    ->label('Author')
                    ->circular()
                    ->width('1%')
                    ->defaultImageUrl(fn(?string $state): string => $state ? sprintf('https://avatars.githubusercontent.com/u/%s', $state) : asset('images/laravelio-icon-gray.svg')),

                TextColumn::make('authorRelation.name')
                    ->label('')
                    ->description(fn(Article $article): ?string => $article->authorRelation->username),

                TextColumn::make('title')
                    ->searchable(['title', 'slug', 'body']),

                TextColumn::make('submitted_at')
                    ->label('Submitted on')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Filter::make('awaiting_approvals')
                    ->query(fn(Builder $query): Builder => $query->awaitingApproval())
                    ->default()
            ])
            ->recordActions([
                Action::make('view')
                    ->url(fn(Article $article): string => route('articles.show', $article->slug()))
                    ->openUrlInNewTab()
                    ->icon('heroicon-s-eye'),
            ])
            ->toolbarActions([
                //
            ]);
    }
}
