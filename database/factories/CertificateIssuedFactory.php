<?php

namespace Database\Factories;

use App\Models\CertificateIssued;
use Illuminate\Database\Eloquent\Factories\Factory;

class CertificateIssuedFactory extends Factory
{
    protected $model = CertificateIssued::class;

    public function definition()
    {
        // No specific columns in migration; produce empty attributes
        return [];
    }
}
