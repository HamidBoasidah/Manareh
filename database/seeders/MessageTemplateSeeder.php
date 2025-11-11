<?php

namespace Database\Seeders;

use App\Models\MessageTemplate;
use App\Models\Mosque;
use Illuminate\Database\Seeder;

class MessageTemplateSeeder extends Seeder
{
    public function run(): void
    {
        $templates = [
            [
                'code' => 'STUDENT_ABSENCE_ALERT',
                'name' => 'Student Absence Alert',
                'channel' => MessageTemplate::CHANNEL_SMS,
                'locale' => 'en',
                'subject' => null,
                'description' => 'Notifies guardians when a student misses their circle session.',
                'body' => 'Hello {{guardian_name}}, {{student_name}} missed the {{circle_name}} circle on {{date}}.',
                'variables' => [
                    ['key' => 'guardian_name', 'label' => 'Guardian Name', 'type' => 'string', 'required' => true],
                    ['key' => 'student_name', 'label' => 'Student Name', 'type' => 'string', 'required' => true],
                    ['key' => 'circle_name', 'label' => 'Circle Name', 'type' => 'string', 'required' => true],
                    ['key' => 'date', 'label' => 'Date', 'type' => 'date', 'required' => true],
                ],
                'sample_payload' => [
                    'guardian_name' => 'Ahmed',
                    'student_name' => 'Mohammed',
                    'circle_name' => 'Abu Bakr Circle',
                    'date' => now()->format('Y-m-d'),
                ],
            ],
            [
                'code' => 'STUDENT_ABSENCE_ALERT',
                'name' => 'تنبيه غياب طالب',
                'channel' => MessageTemplate::CHANNEL_SMS,
                'locale' => 'ar',
                'subject' => null,
                'description' => 'تنبيه ولي الأمر عند غياب الطالب عن الحصة.',
                'body' => 'مرحباً {{guardian_name}}، الطالب {{student_name}} تغيّب عن حلقة {{circle_name}} بتاريخ {{date}}.',
                'variables' => [
                    ['key' => 'guardian_name', 'label' => 'اسم ولي الأمر', 'type' => 'string', 'required' => true],
                    ['key' => 'student_name', 'label' => 'اسم الطالب', 'type' => 'string', 'required' => true],
                    ['key' => 'circle_name', 'label' => 'اسم الحلقة', 'type' => 'string', 'required' => true],
                    ['key' => 'date', 'label' => 'التاريخ', 'type' => 'date', 'required' => true],
                ],
                'sample_payload' => [
                    'guardian_name' => 'أحمد',
                    'student_name' => 'محمد',
                    'circle_name' => 'حلقة أبي بكر',
                    'date' => now()->format('Y-m-d'),
                ],
            ],
            [
                'code' => 'CIRCLE_WHATSAPP_REMINDER',
                'name' => 'WhatsApp Circle Reminder',
                'channel' => MessageTemplate::CHANNEL_WHATSAPP,
                'locale' => 'en',
                'subject' => null,
                'description' => 'Reminder sent via WhatsApp one day before a circle session.',
                'body' => 'Reminder: {{student_name}} is scheduled for {{circle_name}} tomorrow at {{time}}.',
                'variables' => [
                    ['key' => 'student_name', 'label' => 'Student Name', 'type' => 'string', 'required' => true],
                    ['key' => 'circle_name', 'label' => 'Circle Name', 'type' => 'string', 'required' => true],
                    ['key' => 'time', 'label' => 'Time', 'type' => 'time', 'required' => true],
                ],
                'sample_payload' => [
                    'student_name' => 'Aisha',
                    'circle_name' => 'Hifz Circle',
                    'time' => '17:00',
                ],
            ],
            [
                'code' => 'CIRCLE_WHATSAPP_REMINDER',
                'name' => 'تذكير حلقة عبر واتساب',
                'channel' => MessageTemplate::CHANNEL_WHATSAPP,
                'locale' => 'ar',
                'subject' => null,
                'description' => 'تذكير يُرسل عبر واتساب قبل الحلقة بيوم.',
                'body' => 'تذكير: الطالب {{student_name}} لديه حلقة {{circle_name}} غداً الساعة {{time}}.',
                'variables' => [
                    ['key' => 'student_name', 'label' => 'اسم الطالب', 'type' => 'string', 'required' => true],
                    ['key' => 'circle_name', 'label' => 'اسم الحلقة', 'type' => 'string', 'required' => true],
                    ['key' => 'time', 'label' => 'الوقت', 'type' => 'time', 'required' => true],
                ],
                'sample_payload' => [
                    'student_name' => 'عائشة',
                    'circle_name' => 'حلقة الحفظ',
                    'time' => '17:00',
                ],
            ],
            [
                'code' => 'WEEKLY_EMAIL_SUMMARY',
                'name' => 'Weekly Email Summary',
                'channel' => MessageTemplate::CHANNEL_EMAIL,
                'locale' => 'en',
                'subject' => 'Weekly progress summary for {{student_name}}',
                'description' => 'Weekly email summarising student progress and achievements.',
                'body' => "Dear {{guardian_name}},\n\nHere is the weekly summary for {{student_name}}:\n- Attendance: {{attendance_rate}}%\n- Memorisation progress: {{memorised_verses}} verses\n- Teacher notes: {{teacher_notes}}\n\nRegards,\n{{mosque_name}}",
                'variables' => [
                    ['key' => 'guardian_name', 'label' => 'Guardian Name', 'type' => 'string', 'required' => true],
                    ['key' => 'student_name', 'label' => 'Student Name', 'type' => 'string', 'required' => true],
                    ['key' => 'attendance_rate', 'label' => 'Attendance Rate', 'type' => 'number', 'required' => true],
                    ['key' => 'memorised_verses', 'label' => 'Memorised Verses', 'type' => 'number', 'required' => true],
                    ['key' => 'teacher_notes', 'label' => 'Teacher Notes', 'type' => 'text', 'required' => false],
                    ['key' => 'mosque_name', 'label' => 'Mosque Name', 'type' => 'string', 'required' => true],
                ],
                'sample_payload' => [
                    'guardian_name' => 'Sara',
                    'student_name' => 'Yusuf',
                    'attendance_rate' => 95,
                    'memorised_verses' => 12,
                    'teacher_notes' => 'Excellent focus this week.',
                    'mosque_name' => 'An-Nour Mosque',
                ],
            ],
        ];

        Mosque::all()->each(function (Mosque $mosque) use ($templates) {
            foreach ($templates as $template) {
                MessageTemplate::updateOrCreate(
                    [
                        'mosque_id' => $mosque->id,
                        'code' => $template['code'],
                        'channel' => $template['channel'],
                        'locale' => $template['locale'],
                    ],
                    array_merge($template, ['mosque_id' => $mosque->id])
                );
            }
        });

        // seed generic templates (mosque agnostic) if none exist
        foreach ($templates as $template) {
            MessageTemplate::firstOrCreate(
                [
                    'mosque_id' => null,
                    'code' => $template['code'],
                    'channel' => $template['channel'],
                    'locale' => $template['locale'],
                ],
                array_merge($template, ['mosque_id' => null])
            );
        }
    }
}
