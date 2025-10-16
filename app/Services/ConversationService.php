<?php

namespace App\Services;

use App\Repositories\ConversationRepository;

class ConversationService
{
    protected ConversationRepository $conversations;

    public function __construct(ConversationRepository $conversations)
    {
        $this->conversations = $conversations;
    }

    public function all(array $with = [])
    {
        return $this->conversations->all($with);
    }

    public function find($id, array $with = [])
    {
        return $this->conversations->findOrFail($id, $with);
    }

    public function create(array $attributes)
    {
        return $this->conversations->create($attributes);
    }

    public function update($id, array $attributes)
    {
        return $this->conversations->update($id, $attributes);
    }

    public function delete($id)
    {
        return $this->conversations->delete($id);
    }

    public function activate($id)
    {
        return $this->conversations->activate($id);
    }

    public function deactivate($id)
    {
        return $this->conversations->deactivate($id);
    }
}
