<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        // سنفترض أن لديك مستخدمين فعليين في قاعدة البيانات
        // يمكنك تعديل الأرقام بحسب user_id الموجود عندك
        $students = DB::table('users')->where('is_active', true)->limit(3)->get();
        $teacher = DB::table('users')->where('name', 'like', '%معلم%')->first();
        $supervisor = DB::table('users')->where('name', 'like', '%مشرف%')->first();

        // إذا لم توجد حسابات فعلية، سنضع fallback IDs افتراضية:
        $student_id = $students[0]->id ?? 1;
        $teacher_id = $teacher->id ?? 2;
        $supervisor_id = $supervisor->id ?? 3;

        $notifications = [
            [
                'user_id' => $student_id,
                'channel' => 'inbox',
                'subject' => 'تم تسجيلك في الحلقة',
                'body' => "مرحبًا بك 🌿\n\nتم تسجيلك بنجاح في حلقة «الفرقان» بمسجد النور، مع معلمك الأستاذ محمد.\nنرجو لك وقتًا مباركًا ومثمرًا.",
                'payload' => json_encode([
                    'circle_id' => 1,
                    'circle_name' => 'الفرقان',
                    'mosque_name' => 'مسجد النور',
                    'teacher_name' => 'محمد بن عبدالله',
                    'joined_at' => '2025-11-01',
                ]),
                'status' => 'sent',
                'sent_at' => $now,
                'read_at' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],

            [
                'user_id' => $student_id,
                'channel' => 'inbox',
                'subject' => 'نتيجة اختبارك متاحة الآن',
                'body' => "النتيجة 📊\n\nعزيزي الطالب، نتيجتك في اختبار الجزء 29 هي 94 نقطة، والتقدير ممتاز.\nملاحظات المعلم: تلاوة متقنة جدًا واستيعاب متميز.",
                'payload' => json_encode([
                    'exam_type' => 'juzz',
                    'juzz_number' => 29,
                    'total_points' => 94,
                    'total_grade' => 'ممتاز',
                    'exam_date_g' => '2025-11-05',
                ]),
                'status' => 'sent',
                'sent_at' => $now->copy()->subDay(),
                'read_at' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],

            [
                'user_id' => $teacher_id,
                'channel' => 'inbox',
                'subject' => 'غياب طالب في حلقتك',
                'body' => "تنبيه ⚠️\n\nالطالب خالد صالح غاب اليوم عن الحلقة «النور» بتاريخ {date_g}.\nيرجى المتابعة واتخاذ الإجراء المناسب.",
                'payload' => json_encode([
                    'student_name' => 'خالد صالح',
                    'circle_name' => 'النور',
                    'date_g' => '2025-11-10',
                ]),
                'status' => 'sent',
                'sent_at' => $now,
                'read_at' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],

            [
                'user_id' => $supervisor_id,
                'channel' => 'inbox',
                'subject' => 'ترشيح قارئ الشهر',
                'body' => "تم ترشيح الطالب أحمد عبدالله كقارئ الشهر في حلقة {circle_name}.\nيرجى مراجعة الترشيح واعتماده.",
                'payload' => json_encode([
                    'student_name' => 'أحمد عبدالله',
                    'circle_name' => 'الفرقان',
                    'nomination_type' => 'reader_of_month',
                    'nominated_by' => 'الأستاذ محمد',
                ]),
                'status' => 'sent',
                'sent_at' => $now,
                'read_at' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],

            [
                'user_id' => $student_id,
                'channel' => 'inbox',
                'subject' => 'إعلان عام',
                'body' => "📢 نذكّر طلاب حلقات القرآن بفعالية التكريم الأسبوعي يوم الخميس القادم في جامع النور.\nننتظركم جميعًا إن شاء الله.",
                'payload' => json_encode([
                    'program' => 'تكريم أسبوعي',
                    'mosque_name' => 'جامع النور',
                    'date_g' => '2025-11-13',
                ]),
                'status' => 'sent',
                'sent_at' => $now,
                'read_at' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        DB::table('notifications')->insert($notifications);
    }
}
