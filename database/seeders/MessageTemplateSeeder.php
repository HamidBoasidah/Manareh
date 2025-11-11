<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MessageTemplatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        $templates = [
            // 📘 Enrollment
            [
                'mosque_id' => null,
                'code' => 'STUDENT_ADDED_TO_CIRCLE',
                'channel' => 'inbox',
                'locale' => 'ar',
                'subject' => 'تم تسجيلك في الحلقة',
                'body' => "مرحبًا {student_name} 🌿،\n\nتم تسجيلك بنجاح في حلقة: {circle_name} في مسجد {mosque_name}. نرجو لك وقتًا مباركًا ومثمرًا مع معلمك {teacher_name}.",
                'is_active' => true,
                'is_core' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],

            [
                'mosque_id' => null,
                'code' => 'STUDENT_LEFT_CIRCLE',
                'channel' => 'inbox',
                'locale' => 'ar',
                'subject' => 'تم إنهاء ارتباطك بالحلقة',
                'body' => "عزيزي {student_name}،\n\nنُعلمك بأنه تم إنهاء ارتباطك بحلقة {circle_name} في مسجد {mosque_name}. نسأل الله لك التوفيق في مسيرتك القرآنية القادمة.",
                'is_active' => true,
                'is_core' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],

            // 👨‍🏫 Staff
            [
                'mosque_id' => null,
                'code' => 'TEACHER_ASSIGNED_TO_CIRCLE',
                'channel' => 'inbox',
                'locale' => 'ar',
                'subject' => 'تم تكليفك بالتدريس في الحلقة',
                'body' => "الأستاذ {teacher_name}،\n\nتم تكليفك بتدريس حلقة {circle_name} في مسجد {mosque_name}. نرجو لك التوفيق في أداء رسالتك التعليمية المباركة.",
                'is_active' => true,
                'is_core' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],

            [
                'mosque_id' => null,
                'code' => 'SUPERVISOR_ASSIGNED_TO_CIRCLE',
                'channel' => 'inbox',
                'locale' => 'ar',
                'subject' => 'تم تعيينك مشرفًا على الحلقة',
                'body' => "الأستاذ {supervisor_name}،\n\nتم تعيينك مشرفًا على حلقة {circle_name} في مسجد {mosque_name}. نأمل أن تسهم جهودك في تطوير الأداء التربوي والتعليمي.",
                'is_active' => true,
                'is_core' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],

            // 📅 Attendance
            [
                'mosque_id' => null,
                'code' => 'STUDENT_ABSENT_TODAY',
                'channel' => 'inbox',
                'locale' => 'ar',
                'subject' => 'غياب الطالب عن الحلقة',
                'body' => "تنبيه ⚠️\n\nالطالب {student_name} غاب عن حلقة {circle_name} بتاريخ {date_g}.\nيرجى متابعة سبب الغياب واتخاذ الإجراء المناسب.",
                'is_active' => true,
                'is_core' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],

            // 🏅 Nomination
            [
                'mosque_id' => null,
                'code' => 'STUDENT_NOMINATED_READER_MONTH',
                'channel' => 'inbox',
                'locale' => 'ar',
                'subject' => 'ترشيحك لقارئ الشهر',
                'body' => "مبارك 🎉\n\nتم ترشيحك يا {student_name} كقارئ الشهر في حلقة {circle_name}.\nنرجو لك مزيدًا من التفوق والإتقان في تلاوة كتاب الله.",
                'is_active' => true,
                'is_core' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],

            [
                'mosque_id' => null,
                'code' => 'NOMINATION_APPROVED',
                'channel' => 'inbox',
                'locale' => 'ar',
                'subject' => 'تم اعتماد الترشيح',
                'body' => "تهانينا 🎉\n\nتم اعتماد ترشيح {student_name} في فئة {nomination_type} من قِبل المشرف {supervisor_name}.",
                'is_active' => true,
                'is_core' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],

            // 🧮 Exams
            [
                'mosque_id' => null,
                'code' => 'EXAM_ASSIGNED',
                'channel' => 'inbox',
                'locale' => 'ar',
                'subject' => 'تم تحديد موعد اختبارك',
                'body' => "تنبيه 📘\n\nتم تحديد موعد اختبارك في حلقة {circle_name} بتاريخ {exam_date_g} ({exam_type}).\nالاختبار سيشمل الجزء {juzz_number}.\nيرجى الاستعداد وفق خطة المعلم.",
                'is_active' => true,
                'is_core' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],

            [
                'mosque_id' => null,
                'code' => 'EXAM_RESULT_PUBLISHED',
                'channel' => 'inbox',
                'locale' => 'ar',
                'subject' => 'نتيجة اختبارك متاحة الآن',
                'body' => "النتيجة 📊\n\nعزيزي {student_name}، نتيجتك في اختبار {exam_type} الذي أجري بتاريخ {exam_date_g} هي {total_points} نقطة، والتقدير {total_grade}.\nملاحظات المعلم: {remarks}.",
                'is_active' => true,
                'is_core' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],

            // 🕌 General / System
            [
                'mosque_id' => null,
                'code' => 'SYSTEM_ANNOUNCEMENT',
                'channel' => 'inbox',
                'locale' => 'ar',
                'subject' => 'إعلان عام',
                'body' => "📢 إعلان إداري:\n\n{message_body}",
                'is_active' => true,
                'is_core' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        DB::table('message_templates')->insert($templates);
    }
}
