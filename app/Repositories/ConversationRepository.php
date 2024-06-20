<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class ConversationRepository
{
    const int LIMIT = 25;

    /**
     * @return Collection<Conversation>
     */
    public function getUsingMax(?User $user = null): Collection
    {
        $model = app(Conversation::class);

        return Conversation::orderByRaw('GREATEST(
                ' . $model->qualifyColumn('created_at') . ', (SELECT MAX(`m`.`created_at`) FROM ' . app(Message::class)->getTable() . ' AS m WHERE m.conversation_id = ' . $model->qualifyColumn('id') .')
            ) DESC')

            ->filterAndLimit($user, self::LIMIT)
            ->get();
    }

    public function getUsingJoinAndMax(?User $user = null): Collection
    {
        $model = app(Conversation::class);

        return Conversation::select('conversations.*')
            ->leftJoin('messages', function($join) use ($model) {
                $join->on('messages.conversation_id', '=', $model->qualifyColumn('id'))
                    ->whereRaw('messages.id = (
                 SELECT MAX(m.id)
                 FROM messages AS m
                 WHERE m.conversation_id = '. $model->qualifyColumn('id') .'
             )');
            })
            ->orderBy('messages.id', 'desc')

            ->filterAndLimit($user, self::LIMIT)
            ->get();

        /**
         * SELECT c.*, m.*
         * FROM `conversations` AS c
         * LEFT JOIN `messages` AS m ON m.`conversation_id` = c.`id`
         * WHERE m.`id` = (
         * SELECT MAX(`id`)
         * FROM `messages`
         * WHERE `conversation_id` = c.`id`
         * )
         * AND EXISTS (
         * SELECT *
         * FROM `participants`
         * WHERE c.`id` = `participants`.`conversation_id`
         * AND `participants`.`user_id` IN (1)
         * )
         * ORDER BY m.`id` DESC
         * LIMIT 5;
         */
    }

    public function getUsingEloquentSubQuery(?User $user = null): Collection
    {
        $model = app(Conversation::class);

        return Conversation::orderByDesc(
            Message::select('created_at')
                ->whereColumn('conversation_id', $model->qualifyColumn('id'))
                ->orderByDesc('created_at')
                ->limit(1)
        )
            ->filterAndLimit($user, self::LIMIT)
            ->get();
    }
}
