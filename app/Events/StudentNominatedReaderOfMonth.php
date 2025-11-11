<?php

namespace App\Events;

use App\Models\Nomination;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class StudentNominatedReaderOfMonth
{
    use Dispatchable, SerializesModels;

    public Nomination $nomination;

    public function __construct(Nomination $nomination)
    {
        $this->nomination = $nomination;
    }
}
