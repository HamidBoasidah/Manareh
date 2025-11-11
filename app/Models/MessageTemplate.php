<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;
use Illuminate\Support\Str;

class MessageTemplate extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'mosque_id',
        'code',
        'channel',
        'subject',
        'body',
        'locale',        // ✅ جديد
        'description',   // ✅ جديد
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /*-----------------------------------------
     | العلاقات (Relationships)
     *----------------------------------------*/
    public function mosque()
    {
        return $this->belongsTo(Mosque::class);
    }

    /*-----------------------------------------
     | الدوال المساعدة
     *----------------------------------------*/

    /**
     * 🔄 استبدال المتغيرات في النص باستخدام payload.
     * مثال:
     * body = "تم إضافتك إلى الحلقة {circle_name}"
     * payload = ['circle_name' => 'حلقة النور']
     */
    public function renderBody(array $payload = []): string
    {
        $body = $this->body ?? '';

        foreach ($payload as $key => $value) {
            $body = Str::replace('{' . $key . '}', e($value), $body);
        }

        return $body;
    }

    /**
     * نفس الفكرة لكن للعنوان (subject)
     */
    public function renderSubject(array $payload = []): string
    {
        $subject = $this->subject ?? '';

        foreach ($payload as $key => $value) {
            $subject = Str::replace('{' . $key . '}', e($value), $subject);
        }

        return $subject;
    }
}
