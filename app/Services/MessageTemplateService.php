<?php

namespace App\Services;

use App\Repositories\MessageTemplateRepository;

class MessageTemplateService
{
    protected MessageTemplateRepository $templates;

    public function __construct(MessageTemplateRepository $templates)
    {
        $this->templates = $templates;
    }

    public function all(array $with = [])
    {
        return $this->templates->all($with);
    }

    public function paginate(int $perPage = 15, array $with = [])
    {
        return $this->templates->paginate($perPage, $with);
    }

    public function find($id, array $with = [])
    {
        return $this->templates->findOrFail($id, $with);
    }

    public function create(array $attributes)
    {
        return $this->templates->create($attributes);
    }

    public function update($id, array $attributes)
    {
        return $this->templates->update($id, $attributes);
    }

    public function delete($id)
    {
        return $this->templates->delete($id);
    }

    public function activate($id)
    {
        return $this->templates->activate($id);
    }

    public function deactivate($id)
    {
        return $this->templates->deactivate($id);
    }
}
