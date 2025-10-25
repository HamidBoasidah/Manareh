<?php

return [

    /*
    |--------------------------------------------------------------------------
    | ACL Master Config (Fixed Permissions / Dynamic Roles)
    |--------------------------------------------------------------------------
    |
    | - هذا الملف هو "مصدر الحقيقة" لتعريف الموارد (resources) وأفعالها (actions)
    |   وتسميات واجهتها (labels) بلغات متعددة.
    | - تُستخدم هذه البيانات في:
    |   1) Seeder: لمزامنة أذونات Spatie (permissions) إلى قاعدة البيانات.
    |   2) الواجهة (Vue/Inertia): لبناء جدول الاختيار وعناوين الموارد/الأفعال.
    | - الأدوار Roles ديناميكية في DB مع display_name مترجم (spatie/laravel-translatable).
    |
    */

    // اللغات المدعومة (اختياري للتوحيد في الواجهة)
    'locales' => ['en', 'ar'],

    // الحارس الافتراضي
    'guard' => 'web',

    // أفعال افتراضية يمكن استخدامها مستقبلًا لتقليل التكرار (غير مستخدمة الآن)
    'default_actions' => ['view', 'create', 'update', 'delete'],

    /*
    |--------------------------------------------------------------------------
    | Resources & Actions (ثابتة عبر الكود)
    |--------------------------------------------------------------------------
    | المفتاح = اسم المورد (kebab-case مفضل)
    | القيمة = مصفوفة الأفعال المسموحة لهذا المورد
    */
    'resources' => [
        'dashboard'    => ['view'],
        'areas'        => ['view', 'create', 'update', 'delete'],
        'districts'    => ['view', 'create', 'update', 'delete'],
        'governorates' => ['view', 'create', 'update', 'delete'],

        // backend management resources
        'users'        => ['view', 'create', 'update', 'delete'],
        'roles'        => ['view', 'create', 'update', 'delete'],
        'permissions'  => ['view'],
        'profile'      => ['view'],
        'activitylogs' => ['view'],

        // application domain resources
        'mosques' => ['view', 'create', 'update', 'delete'],
        'programs' => ['view', 'create', 'update', 'delete'],
        'plans' => ['view', 'create', 'update', 'delete'],
        'academic_years' => ['view', 'create', 'update', 'delete'],
        'terms' => ['view', 'create', 'update', 'delete'],

        'students' => ['view', 'create', 'update', 'delete'],
        'guardians' => ['view', 'create', 'update', 'delete'],
        'enrollments' => ['view', 'create', 'update', 'delete'],

        'circles' => ['view', 'create', 'update', 'delete'],
        'circle_classifications' => ['view', 'create', 'update', 'delete'],
        'staff_assignments' => ['view', 'create', 'update', 'delete'],

        'daily_study_sessions' => ['view', 'create', 'update', 'delete'],
        'daily_studies' => ['view', 'create', 'update', 'delete'],

        'quran_suras' => ['view', 'create', 'update', 'delete'],

        'student_attendances' => ['view', 'create', 'update', 'delete'],
        'teacher_attendances' => ['view', 'create', 'update', 'delete'],

        'exams' => ['view', 'create', 'update', 'delete'],
        'exam_items' => ['view', 'create', 'update', 'delete'],
        'exam_types' => ['view', 'create', 'update', 'delete'],

        'nominations' => ['view', 'create', 'update', 'delete'],

        'activities' => ['view', 'create', 'update', 'delete'],
        'activity_media' => ['view', 'create', 'update', 'delete'],

        'message_templates' => ['view', 'create', 'update', 'delete'],
        'notifications' => ['view', 'create', 'update', 'delete'],

        'certificate_templates' => ['view', 'create', 'update', 'delete'],
        'certificate_issued' => ['view', 'create', 'update', 'delete'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Resource Labels (واجهة المستخدم)
    |--------------------------------------------------------------------------
    | ترجمة أسماء الموارد للعرض فقط (لا تُخزن في DB).
    */
    'resource_labels' => [
        'dashboard'    => ['en' => 'Dashboard',          'ar' => 'لوحة التحكم'],
        'areas'        => ['en' => 'Areas',         'ar' => 'المناطق'],
        'districts'    => ['en' => 'Districts',     'ar' => 'المديريات'],
        'governorates' => ['en' => 'Governorates',  'ar' => 'المحافظات'],

        'users'        => ['en' => 'Users',         'ar' => 'المستخدمون'],
        'roles'        => ['en' => 'Roles',         'ar' => 'الأدوار'],
        'permissions'  => ['en' => 'Permissions',   'ar' => 'الصلاحيات'],
        'profile'      => ['en' => 'Profile',            'ar' => 'الملف الشخصي'],
        'activitylogs' => ['en' => 'Activity Logs',       'ar' => 'سجل التغييرات'],

        // application domain labels
        'mosques' => ['en' => 'Mosques', 'ar' => 'المساجد'],
        'programs' => ['en' => 'Programs', 'ar' => 'البرامج'],
        'plans' => ['en' => 'Plans', 'ar' => 'الخطط'],
        'academic_years' => ['en' => 'Academic Years', 'ar' => 'السنوات الدراسية'],
        'terms' => ['en' => 'Terms', 'ar' => 'الفصول الدراسية'],

        'students' => ['en' => 'Students', 'ar' => 'الطلاب'],
        'guardians' => ['en' => 'Guardians', 'ar' => 'الأوصياء'],
        'enrollments' => ['en' => 'Enrollments', 'ar' => 'الالتحاقات'],

        'circles' => ['en' => 'Circles', 'ar' => 'الحلقات'],
        'circle_classifications' => ['en' => 'Circle Classifications', 'ar' => 'تصنيفات الحلقات'],
        'staff_assignments' => ['en' => 'Staff Assignments', 'ar' => 'تعيينات الموظفين'],

        'daily_study_sessions' => ['en' => 'Daily Study Sessions', 'ar' => 'جلسات الدراسة اليومية'],
        'daily_studies' => ['en' => 'Daily Studies', 'ar' => 'الدراسات اليومية'],

        'quran_suras' => ['en' => 'Quran Suras', 'ar' => 'السور'],

        'student_attendances' => ['en' => 'Student Attendances', 'ar' => 'حضور الطلاب'],
        'teacher_attendances' => ['en' => 'Teacher Attendances', 'ar' => 'حضور المعلمين'],

        'exams' => ['en' => 'Exams', 'ar' => 'الاختبارات'],
        'exam_items' => ['en' => 'Exam Items', 'ar' => 'عناصر الاختبار'],
        'exam_types' => ['en' => 'Exam Types', 'ar' => 'أنواع الاختبارات'],

        'nominations' => ['en' => 'Nominations', 'ar' => 'الترشيحات'],

        'activities' => ['en' => 'Activities', 'ar' => 'الأنشطة'],
        'activity_media' => ['en' => 'Activity Media', 'ar' => 'وسائط النشاط'],

        'message_templates' => ['en' => 'Message Templates', 'ar' => 'قوالب الرسائل'],
        'notifications' => ['en' => 'Notifications', 'ar' => 'الإشعارات'],

        'certificate_templates' => ['en' => 'Certificate Templates', 'ar' => 'قوالب الشهادات'],
        'certificate_issued' => ['en' => 'Issued Certificates', 'ar' => 'الشهادات المصدرة'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Action Labels (واجهة المستخدم)
    |--------------------------------------------------------------------------
    | ترجمة أسماء الأفعال للعرض فقط (لا تُخزن في DB).
    */
    'action_labels' => [
        'view'   => ['en' => 'View',   'ar' => 'عرض'],
        'create' => ['en' => 'Create', 'ar' => 'إنشاء'],
        'update' => ['en' => 'Update', 'ar' => 'تعديل'],
        'delete' => ['en' => 'Delete', 'ar' => 'حذف'],
    ],

];
