<?php

namespace App\Services;

use App\Ai\Agents\SpamModerator;
use App\Jobs\BanUser;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use Throwable;
use UnexpectedValueException;

final class ModerateForumContent
{
    public function check(User $author, string $body, ?string $subject = null): void
    {
        abort_if($author->fresh()->isBanned(), 403, 'This account is banned.');

        try {
            $response = SpamModerator::make()->prompt(
                json_encode(['subject' => $subject, 'body' => $body], JSON_THROW_ON_ERROR),
                provider: config('lio.moderation.provider'),
                model: config('lio.moderation.model'),
                timeout: config('lio.moderation.timeout'),
            );

            $isSpam = $response['is_spam'];

            if (! is_bool($isSpam)) {
                throw new UnexpectedValueException('The spam moderator did not return a boolean verdict.');
            }
        } catch (Throwable $exception) {
            report($exception);

            return;
        }

        if ($isSpam) {
            dispatch_sync(new BanUser($author, 'Spam - banned by AI'));

            throw ValidationException::withMessages([
                'body' => 'Your post was detected as spam and your account has been banned.',
            ]);
        }
    }
}
