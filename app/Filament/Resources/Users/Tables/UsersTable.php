<?php

namespace App\Filament\Resources\Users\Tables;

use App\Jobs\BanUser;
use App\Jobs\DeleteUserThreads;
use App\Jobs\UnbanUser;
use App\Jobs\UnVerifyAuthor;
use App\Jobs\VerifyAuthor;
use App\Models\User;
use App\Policies\UserPolicy;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->openRecordUrlInNewTab()
            ->columns([
                ImageColumn::make('github_id')
                    ->label('Name')
                    ->circular()
                    ->width('0%')
                    ->defaultImageUrl(fn(?string $state): string => $state ? sprintf('https://avatars.githubusercontent.com/u/%s', $state) : asset('images/laravelio-icon-gray.svg')),

                TextColumn::make('username')
                    ->label('')
                    ->searchable()
                    ->formatStateUsing(fn(User $user): ?string => $user->name)
                    ->description(fn(User $user): ?string => $user->username),

                TextColumn::make('email')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('type')
                    ->label('Role')
                    ->badge()
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        '1' => 'User',
                        '2' => 'Moderator',
                        '3' => 'Admin',
                    }),

                IconColumn::make('banned_at')
                    ->label('Banned')
                    ->boolean()
                    ->default(false),

                TextColumn::make('created_at')
                    ->label('Joined on')
                    ->dateTime()
                    ->sortable()
            ])
            ->filters([
                SelectFilter::make('type')
                    ->options([
                        '1' => 'User',
                        '2' => 'Moderator',
                        '3' => 'Admin',
                    ]),

                TernaryFilter::make('banned_at')
                    ->label('Banned')
                    ->nullable()
            ])
            ->recordActions([
                Action::make('view')
                    ->url(fn(User $user): string => route('profile', $user->username))
                    ->openUrlInNewTab()
                    ->icon('heroicon-s-eye'),

                ActionGroup::make([
                    Action::make('verify_author')
                        ->action(function (User $user) {
                            VerifyAuthor::dispatchSync($user);

                            Notification::make()
                                ->title($user->name . ' is now a verified author.')
                                ->success()
                                ->send();
                        })
                        ->openUrlInNewTab()
                        ->color('primary')
                        ->icon('heroicon-s-check-circle')
                        ->requiresConfirmation()
                        ->visible(fn(User $user): bool => auth()->user()->can(UserPolicy::ADMIN, $user) && ! $user->isVerifiedAuthor()),

                    Action::make('unverify_author')
                        ->action(function (User $user) {
                            UnVerifyAuthor::dispatchSync($user);

                            Notification::make()
                                ->title($user->name . '\'s threads have been deleted.')
                                ->success()
                                ->send();
                        })
                        ->openUrlInNewTab()
                        ->color('danger')
                        ->icon('heroicon-s-x-circle')
                        ->requiresConfirmation()
                        ->visible(fn(User $user): bool => auth()->user()->can(UserPolicy::ADMIN, $user) && $user->isVerifiedAuthor()),

                    Action::make('ban_author')
                        ->schema([
                            TextInput::make('reason')
                                ->label('Reason')
                                ->required()
                                ->placeholder('Provide a reason for banning this user...'),

                            Checkbox::make('delete_threads')
                                ->label('Delete all threads')
                                ->default(false),
                        ])
                        ->action(function (User $user, array $data) {
                            BanUser::dispatchSync($user, $data['reason']);

                            if ($data['delete_threads']) {
                                DeleteUserThreads::dispatchSync($user);
                            }

                            Notification::make()
                                ->title(
                                    $user->name . ' is now banned.' . ($data['delete_threads'] ? ' And all his threads are now deleted.' : '')
                                )
                                ->success()
                                ->send();
                        })
                        ->modalDescription('Are you sure you\'d like to ban this user? This will prevent him from logging in, posting threads and replying to threads.')
                        ->openUrlInNewTab()
                        ->color('danger')
                        ->icon('heroicon-s-check-circle')
                        ->requiresConfirmation()
                        ->visible(fn(User $user): bool => auth()->user()->can(UserPolicy::BAN, $user) && ! $user->isBanned()),

                    Action::make('unban_author')
                        ->action(function (User $user) {

                            UnbanUser::dispatchSync($user);

                            Notification::make()
                                ->title($user->name . ' is no longer a banned user.')
                                ->success()
                                ->send();
                        })
                        ->openUrlInNewTab()
                        ->color('primary')
                        ->icon('heroicon-s-x-circle')
                        ->requiresConfirmation()
                        ->visible(fn(User $user): bool => auth()->user()->can(UserPolicy::BAN, $user) && $user->isBanned()),

                    Action::make('delete_threads')
                        ->action(function (User $user) {
                            DeleteUserThreads::dispatchSync($user);

                            Notification::make()
                                ->title($user->name . '\'s threads have been deleted.')
                                ->success()
                                ->send();
                        })
                        ->openUrlInNewTab()
                        ->color('danger')
                        ->icon('heroicon-s-archive-box-x-mark')
                        ->requiresConfirmation()
                        ->visible(fn(User $user): bool => auth()->user()->can(UserPolicy::DELETE, $user)),

                    DeleteAction::make()
                        ->visible(fn(User $user): bool => auth()->user()->can(UserPolicy::DELETE, $user)),
                ]),
            ])
            ->toolbarActions([
                // 
            ]);
    }
}
