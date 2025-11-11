<?php

namespace App\Services;

use App\Models\MessageTemplate;
use App\Repositories\MessageTemplateRepository;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

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

    public function paginateWithFilters(array $filters = [], int $perPage = 15)
    {
        return $this->templates->paginateWithFilters($filters, $perPage);
    }

    public function find($id, array $with = [])
    {
        return $this->templates->findOrFail($id, $with);
    }

    public function create(array $attributes)
    {
        return $this->templates->create($this->prepareAttributes($attributes));
    }

    public function update($id, array $attributes)
    {
        return $this->templates->update($id, $this->prepareAttributes($attributes));
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

    public function channels(): array
    {
        return MessageTemplate::CHANNELS;
    }

    public function variableTypes(): array
    {
        return MessageTemplate::VARIABLE_TYPES;
    }

    protected function prepareAttributes(array $attributes): array
    {
        $data = $attributes;

        $data['code'] = strtoupper(Str::snake((string) ($data['code'] ?? '')));
        $data['channel'] = $data['channel'] ?? MessageTemplate::CHANNEL_IN_APP;
        $data['locale'] = $data['locale'] ?? config('app.locale');
        $data['mosque_id'] = $data['mosque_id'] ?? null;

        if ($data['mosque_id'] === '' || $data['mosque_id'] === 0) {
            $data['mosque_id'] = null;
        }

        foreach (['subject', 'description'] as $field) {
            if (array_key_exists($field, $data) && $data[$field] === '') {
                $data[$field] = null;
            }
        }

        $variables = $this->normalizeVariables($data['variables'] ?? [], (string) ($data['body'] ?? ''));
        $data['variables'] = $variables ?: null;

        $payload = $this->normalizeSamplePayload($data['sample_payload'] ?? null, $variables);
        $data['sample_payload'] = $payload ?: null;

        $extras = $this->normalizeExtras($data['extras'] ?? null);
        $data['extras'] = $extras ?: null;

        if (!array_key_exists('is_active', $data)) {
            $data['is_active'] = true;
        }

        return $data;
    }

    protected function normalizeVariables($variables, string $body): array
    {
        $normalized = [];

        if (is_array($variables)) {
            foreach ($variables as $variable) {
                if (!is_array($variable) || empty($variable['key'])) {
                    continue;
                }

                $key = MessageTemplate::normalizeVariableKey((string) $variable['key']);

                if ($key === '') {
                    continue;
                }

                $type = $variable['type'] ?? 'string';

                if (!in_array($type, MessageTemplate::VARIABLE_TYPES, true)) {
                    $type = 'string';
                }

                $normalized[$key] = [
                    'key' => $key,
                    'label' => $variable['label'] ?? Str::headline(str_replace('_', ' ', $key)),
                    'type' => $type,
                    'required' => (bool) ($variable['required'] ?? false),
                    'description' => $variable['description'] ?? null,
                ];
            }
        }

        if (empty($normalized) && $body !== '') {
            foreach ($this->extractVariablesFromBody($body) as $key) {
                $normalized[$key] = [
                    'key' => $key,
                    'label' => Str::headline(str_replace('_', ' ', $key)),
                    'type' => 'string',
                    'required' => false,
                    'description' => null,
                ];
            }
        }

        return array_values($normalized);
    }

    protected function normalizeSamplePayload($payload, array $variables): ?array
    {
        if (!is_array($payload)) {
            return null;
        }

        if (empty($variables)) {
            return $payload;
        }

        $keys = array_map(static fn ($item) => $item['key'], $variables);

        return Arr::only($payload, $keys);
    }

    protected function normalizeExtras($extras): ?array
    {
        if (!is_array($extras)) {
            return null;
        }

        $filtered = array_filter($extras, static function ($value) {
            if (is_array($value)) {
                return count(array_filter($value, static fn ($inner) => $inner !== null && $inner !== '')) > 0;
            }

            return $value !== null && $value !== '';
        });

        return empty($filtered) ? null : $filtered;
    }

    protected function extractVariablesFromBody(string $body): array
    {
    preg_match_all('/{{\s*([A-Za-z0-9_.\-]+)\s*}}/', $body, $matches);

        if (empty($matches[1])) {
            return [];
        }

        $keys = array_map(static fn ($key) => MessageTemplate::normalizeVariableKey((string) $key), $matches[1]);

        return array_values(array_unique(array_filter($keys)));
    }
}
