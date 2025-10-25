<?php

namespace Database\Factories;

use App\Models\CertificateTemplate;
use Illuminate\Database\Eloquent\Factories\Factory;

class CertificateTemplateFactory extends Factory
{
    protected $model = CertificateTemplate::class;

    public function definition()
    {
        $ar = \Faker\Factory::create('ar_SA');
        return [
            'name' => $ar->word(),
            'purpose' => $ar->word(),
            'html_template' => '<h1>' . $ar->sentence() . '</h1>',
            'variables' => json_encode(['name','date']),
        ];
    }
}
