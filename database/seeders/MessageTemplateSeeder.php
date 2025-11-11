<?php

namespace Database\Seeders;

use App\Models\MessageTemplate;
use App\Models\Mosque;
use Illuminate\Database\Seeder;

class MessageTemplateSeeder extends Seeder
{
    public function run(): void
    {
        // قائمة القوالب الأساسية
        $templates = [
            [
                'code' => 'STUDENT_ADDED_TO_CIRCLE',
                'channel' => 'inbox',
                'locale' => 'ar',
                'subject' => 'تم إضافتك إلى {circle_name}',
                'body' => 'مرحبًا {student_name}، تم إضافتك إلى الحلقة "{circle_name}" بإشراف {teacher_name}.',
                'description' => 'إشعار عند إضافة الطالب إلى حلقة جديدة.',
            ],
            [
                'code' => 'STUDENT_ABSENT_TODAY',
                'channel' => 'inbox',
                'locale' => 'ar',
                'subject' => 'غيابك اليوم عن الحلقة',
                'body' => 'عزيزي {student_name}، لوحِظ غيابك اليوم ({date_g}) عن الحلقة "{circle_name}". نأمل التواصل مع المعلم {teacher_name}.',
                'description' => 'إشعار عند تسجيل غياب الطالب في الجلسة اليومية.',
            ],
            [
                'code' => 'STUDENT_NOMINATED_READER_OF_MONTH',
                'channel' => 'inbox',
                'locale' => 'ar',
                'subject' => 'ترشيحك كقارئ الشهر 🎉',
                'body' => 'مبارك يا {student_name}! تم ترشيحك من قبل المشرف {supervisor_name} لتكون قارئ الشهر في "{circle_name}".',
                'description' => 'يُرسل عند ترشيح الطالب لجائزة قارئ الشهر.',
            ],
            [
                'code' => 'STUDENT_EXAM_INVITATION',
                'channel' => 'inbox',
                'locale' => 'ar',
                'subject' => 'تم ترشيحك لاختبار {exam_type}',
                'body' => 'عزيزي {student_name}، تم ترشيحك لأداء اختبار {exam_type} بتاريخ {exam_date_g}. الرجاء الحضور في الموعد المحدد.',
                'description' => 'إشعار ترشيح الطالب للاختبار.',
            ],
            [
                'code' => 'STUDENT_EXAM_RESULT',
                'channel' => 'inbox',
                'locale' => 'ar',
                'subject' => 'نتيجة اختبارك متاحة الآن',
                'body' => 'مرحبًا {student_name}، نتيجتك في اختبار {exam_type} هي {total_points} درجة ({total_grade}).',
                'description' => 'يُرسل بعد تسجيل نتيجة الاختبار للطالب.',
            ],
        ];

        // تكرار لكل مسجد
        Mosque::all()->each(function ($mosque) use ($templates) {
            foreach ($templates as $tpl) {
                MessageTemplate::firstOrCreate(
                    [
                        'mosque_id' => $mosque->id,
                        'code' => $tpl['code'],
                    ],
                    [
                        'channel' => $tpl['channel'],
                        'locale' => $tpl['locale'],
                        'subject' => $tpl['subject'],
                        'body' => $tpl['body'],
                        'description' => $tpl['description'],
                        'is_active' => true,
                    ]
                );
            }
        });
    }
}
