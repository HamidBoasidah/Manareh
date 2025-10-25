<?php

namespace App\DTOs;

use App\Models\CertificateIssued;

class CertificateIssuedDTO extends BaseDTO
{
    public $id;
    public $certificate_template_id;
    public $issued_to_id;
    public $issued_at;
    public $notes;
    public $is_active;

    public function __construct($id, $certificate_template_id = null, $issued_to_id = null, $issued_at = null, $notes = null)
    {
        $this->id = $id;
        $this->certificate_template_id = $certificate_template_id;
        $this->issued_to_id = $issued_to_id;
        $this->issued_at = $issued_at;
        $this->notes = $notes;
    }

    public static function fromModel(CertificateIssued $m): self
    {
        return new self(
            $m->id,
            $m->certificate_template_id ?? null,
            $m->issued_to_id ?? null,
            $m->issued_at ?? null,
            $m->notes ?? null
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'certificate_template_id' => $this->certificate_template_id,
            'issued_to_id' => $this->issued_to_id,
            'issued_at' => $this->issued_at,
            'notes' => $this->notes,
        ];
    }

    public function toIndexArray(): array
    {
        return [
            'id' => $this->id,
            'issued_at' => $this->issued_at,
            'is_active' => $this->is_active ?? null,
        ];
    }
}
