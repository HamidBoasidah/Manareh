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
    |
    | ملاحظة: dashboard و profile "عرض فقط" كما هو مطلوب.
    */
    'resources' => [
        'dashboard'                    => ['view'],
        'medical-facilities'           => ['view', 'create', 'update', 'delete'],
        'medical-services'             => ['view', 'create', 'update', 'delete'],
        'working-periods'              => ['view', 'create', 'update', 'delete'],
        'medical-facility-categories'  => ['view', 'create', 'update', 'delete'],
        'facility-ownerships'          => ['view', 'create', 'update', 'delete'],
        'areas'                        => ['view', 'create', 'update', 'delete'],
        'districts'                    => ['view', 'create', 'update', 'delete'], // قد تفضّل "المديريات"
        'governorates'                 => ['view', 'create', 'update', 'delete'],
    'specialties'                  => ['view', 'create', 'update', 'delete'],
        'content-blocks'               => ['view', 'create', 'update', 'delete'],
        'users'                        => ['view', 'create', 'update', 'delete'],
        // backend management resources
        'roles'                        => ['view', 'create', 'update', 'delete'],
        'permissions'                  => ['view'],
        'profile'                      => ['view'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Resource Labels (واجهة المستخدم)
    |--------------------------------------------------------------------------
    | ترجمة أسماء الموارد للعرض فقط (لا تُخزن في DB).
    */
    'resource_labels' => [
        'dashboard'                    => ['en' => 'Dashboard',          'ar' => 'لوحة التحكم'],
        'medical-facilities'           => ['en' => 'Medical Facilities', 'ar' => 'المنشآت الطبية'],
        'medical-services'             => ['en' => 'Medical Services',   'ar' => 'الخدمات الطبية'],
        'working-periods'              => ['en' => 'Working Periods',    'ar' => 'فترات العمل'],
        'medical-facility-categories'  => ['en' => 'Facility Categories','ar' => 'تصنيفات المنشآت الطبية'], // كانت: تصنيفات المنشآت
        'facility-ownerships'          => ['en' => 'Facility Ownerships','ar' => 'ملكية المنشآت'],
        'areas'                        => ['en' => 'Areas',              'ar' => 'المناطق'],
        'districts'                    => ['en' => 'Districts',          'ar' => 'المديريات'], // كانت: الأحياء
        'governorates'                 => ['en' => 'Governorates',       'ar' => 'المحافظات'],
        'specialties'                  => ['en' => 'Specialties',        'ar' => 'التخصصات'],
        'content-blocks'               => ['en' => 'Content Blocks',     'ar' => 'مكوّنات المحتوى'], // كانت: كتل المحتوى
        'users'                        => ['en' => 'Users',              'ar' => 'المستخدمون'],
        'roles'                        => ['en' => 'Roles',              'ar' => 'الأدوار'],
        'permissions'                  => ['en' => 'Permissions',        'ar' => 'الصلاحيات'],
        'profile'                      => ['en' => 'Profile',            'ar' => 'الملف الشخصي'],
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
