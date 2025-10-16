<?php

namespace App\Repositories;

use App\Models\Conversation;
use App\Repositories\Eloquent\BaseRepository;

class ConversationRepository extends BaseRepository
{
    public function __construct(Conversation $model)
    {
        parent::__construct($model);
    }
}
