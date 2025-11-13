<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\AreaController;
use App\Http\Controllers\Admin\DistrictController;
use App\Http\Controllers\Admin\GovernorateController;
use App\Http\Controllers\Admin\MosqueController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\NotificationController as AdminNotificationController;
use App\Http\Controllers\Admin\ProgramController;
use App\Http\Controllers\Admin\PlanController;
use App\Http\Controllers\Admin\AcademicYearController;
use App\Http\Controllers\Admin\TermController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\GuardianController;
use App\Http\Controllers\Admin\EnrollmentController;
use App\Http\Controllers\Admin\CircleController;
use App\Http\Controllers\Admin\CircleClassificationController;
use App\Http\Controllers\Admin\StaffAssignmentController;
use App\Http\Controllers\Admin\DailyStudySessionController;
use App\Http\Controllers\Admin\DailyStudyController;
use App\Http\Controllers\Admin\QuranSuraController;
use App\Http\Controllers\Admin\StudentAttendanceController;
use App\Http\Controllers\Admin\TeacherAttendanceController;
use App\Http\Controllers\Admin\ExamController;
use App\Http\Controllers\Admin\ExamItemController;
use App\Http\Controllers\Admin\ExamTypeController;
use App\Http\Controllers\Admin\NominationController;
use App\Http\Controllers\Admin\ActivityController;
use App\Http\Controllers\Admin\ActivityMediaController;
use App\Http\Controllers\Admin\CertificateTemplateController;
use App\Http\Controllers\Admin\CertificateIssuedController;
use App\Support\RoutePermissions;
use App\Http\Controllers\User\InboxController;
use App\Http\Controllers\LocaleController;


Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/', fn () => Inertia('Dashboard'))
        ->name('dashboard')
        ->middleware(RoutePermissions::can('dashboard.view'));

    // Profile
    Route::get('/profile', fn () => Inertia('Others/UserProfile'))
        ->name('admin.profile')
        ->middleware(RoutePermissions::can('profile.view'));

    // Governorates
    Route::resource('governorates', GovernorateController::class)
        ->names('admin.governorates');

    Route::patch('governorates/{id}/activate', [GovernorateController::class, 'activate'])
        ->name('admin.governorates.activate')
        ->middleware(RoutePermissions::can('governorates.update'));

    Route::patch('governorates/{id}/deactivate', [GovernorateController::class, 'deactivate'])
        ->name('admin.governorates.deactivate')
        ->middleware(RoutePermissions::can('governorates.update'));

    // Districts
    Route::resource('districts', DistrictController::class)
        ->names('admin.districts');

    Route::patch('districts/{id}/activate', [DistrictController::class, 'activate'])
        ->name('admin.districts.activate')
        ->middleware(RoutePermissions::can('districts.update'));

    Route::patch('districts/{id}/deactivate', [DistrictController::class, 'deactivate'])
        ->name('admin.districts.deactivate')
        ->middleware(RoutePermissions::can('districts.update'));

    // Areas
    Route::resource('areas', AreaController::class)
        ->names('admin.areas');

    Route::patch('areas/{id}/activate', [AreaController::class, 'activate'])
        ->name('admin.areas.activate')
        ->middleware(RoutePermissions::can('areas.update'));

    Route::patch('areas/{id}/deactivate', [AreaController::class, 'deactivate'])
        ->name('admin.areas.deactivate')
        ->middleware(RoutePermissions::can('areas.update'));

    // Users
    Route::resource('users', UserController::class)
        ->names('admin.users');

    Route::patch('users/{id}/activate', [UserController::class, 'activate'])
        ->name('admin.users.activate')
        ->middleware(RoutePermissions::can('users.update'));

    Route::patch('users/{id}/deactivate', [UserController::class, 'deactivate'])
        ->name('admin.users.deactivate')
        ->middleware(RoutePermissions::can('users.update'));

    // Roles
    Route::resource('roles', RoleController::class)
        ->names('admin.roles');

    Route::patch('roles/{id}/activate', [RoleController::class, 'activate'])
        ->name('admin.roles.activate')
        ->middleware(RoutePermissions::can('roles.update'));

    Route::patch('roles/{id}/deactivate', [RoleController::class, 'deactivate'])
        ->name('admin.roles.deactivate')
        ->middleware(RoutePermissions::can('roles.update'));

    // Permissions
    Route::get('permissions', [PermissionController::class, 'index'])
        ->name('admin.permissions.index');

    // Activity Log
    Route::resource('activitylogs', ActivityLogController::class)
        ->only(['index', 'show' , 'destroy'])
        ->names('admin.activitylogs');

    // Notifications (admin)
    Route::get('admin/notifications', [AdminNotificationController::class, 'index'])
        ->name('admin.notifications.index');
    Route::get('admin/notifications/{notification}', [AdminNotificationController::class, 'show'])
        ->name('admin.notifications.show');
    Route::delete('admin/notifications/{notification}', [AdminNotificationController::class, 'destroy'])
        ->name('admin.notifications.destroy');
    Route::post('admin/notifications/{notification}/mark-read', [AdminNotificationController::class, 'markRead'])
        ->name('admin.notifications.mark-read');
    Route::post('admin/notifications/{notification}/mark-unread', [AdminNotificationController::class, 'markUnread'])
        ->name('admin.notifications.mark-unread');
    Route::post('admin/notifications/mark-all-read', [AdminNotificationController::class, 'markAllRead'])
        ->name('admin.notifications.mark-all-read');

    // Mosques
    Route::resource('mosques', MosqueController::class)
        ->names('admin.mosques');

    Route::patch('mosques/{id}/activate', [MosqueController::class, 'activate'])
        ->name('admin.mosques.activate')
        ->middleware(RoutePermissions::can('mosques.update'));

    Route::patch('mosques/{id}/deactivate', [MosqueController::class, 'deactivate'])
        ->name('admin.mosques.deactivate')
        ->middleware(RoutePermissions::can('mosques.update'));

    
    // Programs
    Route::resource('programs', ProgramController::class)
        ->names('admin.programs');

    Route::patch('programs/{id}/activate', [ProgramController::class, 'activate'])
        ->name('admin.programs.activate')
        ->middleware(RoutePermissions::can('programs.update'));

    Route::patch('programs/{id}/deactivate', [ProgramController::class, 'deactivate'])
        ->name('admin.programs.deactivate')
        ->middleware(RoutePermissions::can('programs.update'));

    // Plans
    Route::resource('plans', PlanController::class)
        ->names('admin.plans');

    Route::patch('plans/{id}/activate', [PlanController::class, 'activate'])
        ->name('admin.plans.activate')
        ->middleware(RoutePermissions::can('plans.update'));

    Route::patch('plans/{id}/deactivate', [PlanController::class, 'deactivate'])
        ->name('admin.plans.deactivate')
        ->middleware(RoutePermissions::can('plans.update'));

    // Academic Years
    Route::resource('academic_years', AcademicYearController::class)
        ->names('admin.academic_years');

    Route::patch('academic_years/{id}/activate', [AcademicYearController::class, 'activate'])
        ->name('admin.academic_years.activate')
        ->middleware(RoutePermissions::can('academic_years.update'));

    Route::patch('academic_years/{id}/deactivate', [AcademicYearController::class, 'deactivate'])
        ->name('admin.academic_years.deactivate')
        ->middleware(RoutePermissions::can('academic_years.update'));

    // Terms
    Route::resource('terms', TermController::class)
        ->names('admin.terms');

    Route::patch('terms/{id}/activate', [TermController::class, 'activate'])
        ->name('admin.terms.activate')
        ->middleware(RoutePermissions::can('terms.update'));

    Route::patch('terms/{id}/deactivate', [TermController::class, 'deactivate'])
        ->name('admin.terms.deactivate')
        ->middleware(RoutePermissions::can('terms.update'));

    // Students
    Route::resource('students', StudentController::class)
        ->names('admin.students');

    Route::patch('students/{id}/activate', [StudentController::class, 'activate'])
        ->name('admin.students.activate')
        ->middleware(RoutePermissions::can('students.update'));

    Route::patch('students/{id}/deactivate', [StudentController::class, 'deactivate'])
        ->name('admin.students.deactivate')
        ->middleware(RoutePermissions::can('students.update'));

    // Guardians
    Route::resource('guardians', GuardianController::class)
        ->names('admin.guardians');

    Route::patch('guardians/{id}/activate', [GuardianController::class, 'activate'])
        ->name('admin.guardians.activate')
        ->middleware(RoutePermissions::can('guardians.update'));

    Route::patch('guardians/{id}/deactivate', [GuardianController::class, 'deactivate'])
        ->name('admin.guardians.deactivate')
        ->middleware(RoutePermissions::can('guardians.update'));

    // Enrollments
    Route::resource('enrollments', EnrollmentController::class)
        ->names('admin.enrollments');

    Route::patch('enrollments/{id}/activate', [EnrollmentController::class, 'activate'])
        ->name('admin.enrollments.activate')
        ->middleware(RoutePermissions::can('enrollments.update'));

    Route::patch('enrollments/{id}/deactivate', [EnrollmentController::class, 'deactivate'])
        ->name('admin.enrollments.deactivate')
        ->middleware(RoutePermissions::can('enrollments.update'));

    // Circles
    Route::resource('circles', CircleController::class)
        ->names('admin.circles');

    Route::post('circles/{circle}/students', [CircleController::class, 'joinStudent'])
        ->name('admin.circles.students.join')
        ->middleware(RoutePermissions::can('circles.update'));

    Route::delete('circles/{circle}/students/{student}', [CircleController::class, 'leaveStudent'])
        ->name('admin.circles.students.leave')
        ->middleware(RoutePermissions::can('circles.update'));

    Route::patch('circles/{id}/activate', [CircleController::class, 'activate'])
        ->name('admin.circles.activate')
        ->middleware(RoutePermissions::can('circles.update'));

    Route::patch('circles/{id}/deactivate', [CircleController::class, 'deactivate'])
        ->name('admin.circles.deactivate')
        ->middleware(RoutePermissions::can('circles.update'));

    // Circle Classifications
    Route::resource('circle_classifications', CircleClassificationController::class)
        ->names('admin.circle_classifications');

    Route::patch('circle_classifications/{id}/activate', [CircleClassificationController::class, 'activate'])
        ->name('admin.circle_classifications.activate')
        ->middleware(RoutePermissions::can('circle_classifications.update'));

    Route::patch('circle_classifications/{id}/deactivate', [CircleClassificationController::class, 'deactivate'])
        ->name('admin.circle_classifications.deactivate')
        ->middleware(RoutePermissions::can('circle_classifications.update'));

    // Staff Assignments
    Route::resource('staff_assignments', StaffAssignmentController::class)
        ->names('admin.staff_assignments');

    Route::patch('staff_assignments/{id}/activate', [StaffAssignmentController::class, 'activate'])
        ->name('admin.staff_assignments.activate')
        ->middleware(RoutePermissions::can('staff_assignments.update'));

    Route::patch('staff_assignments/{id}/deactivate', [StaffAssignmentController::class, 'deactivate'])
        ->name('admin.staff_assignments.deactivate')
        ->middleware(RoutePermissions::can('staff_assignments.update'));

    // Unassign staff (end active assignment for a circle+role)
    Route::post('staff_assignments/unassign', [StaffAssignmentController::class, 'unassign'])
        ->name('admin.staff_assignments.unassign')
        ->middleware(RoutePermissions::can('staff_assignments.update'));

    // Daily Study Sessions
    Route::resource('daily_study_sessions', DailyStudySessionController::class)
        ->names('admin.daily_study_sessions');

    Route::patch('daily_study_sessions/{id}/activate', [DailyStudySessionController::class, 'activate'])
        ->name('admin.daily_study_sessions.activate')
        ->middleware(RoutePermissions::can('daily_study_sessions.update'));

    Route::patch('daily_study_sessions/{id}/deactivate', [DailyStudySessionController::class, 'deactivate'])
        ->name('admin.daily_study_sessions.deactivate')
        ->middleware(RoutePermissions::can('daily_study_sessions.update'));

    // Daily Studies
    Route::resource('daily_studies', DailyStudyController::class)
        ->names('admin.daily_studies');

    Route::patch('daily_studies/{id}/activate', [DailyStudyController::class, 'activate'])
        ->name('admin.daily_studies.activate')
        ->middleware(RoutePermissions::can('daily_studies.update'));

    Route::patch('daily_studies/{id}/deactivate', [DailyStudyController::class, 'deactivate'])
        ->name('admin.daily_studies.deactivate')
        ->middleware(RoutePermissions::can('daily_studies.update'));

    // Quran Suras
    Route::resource('quran_suras', QuranSuraController::class)
        ->names('admin.quran_suras');

    Route::patch('quran_suras/{id}/activate', [QuranSuraController::class, 'activate'])
        ->name('admin.quran_suras.activate')
        ->middleware(RoutePermissions::can('quran_suras.update'));

    Route::patch('quran_suras/{id}/deactivate', [QuranSuraController::class, 'deactivate'])
        ->name('admin.quran_suras.deactivate')
        ->middleware(RoutePermissions::can('quran_suras.update'));

    // Student Attendances
    Route::resource('student_attendances', StudentAttendanceController::class)
        ->names('admin.student_attendances');

    Route::patch('student_attendances/{id}/activate', [StudentAttendanceController::class, 'activate'])
        ->name('admin.student_attendances.activate')
        ->middleware(RoutePermissions::can('student_attendances.update'));

    Route::patch('student_attendances/{id}/deactivate', [StudentAttendanceController::class, 'deactivate'])
        ->name('admin.student_attendances.deactivate')
        ->middleware(RoutePermissions::can('student_attendances.update'));

    // Teacher Attendances
    Route::resource('teacher_attendances', TeacherAttendanceController::class)
        ->names('admin.teacher_attendances');

    Route::patch('teacher_attendances/{id}/activate', [TeacherAttendanceController::class, 'activate'])
        ->name('admin.teacher_attendances.activate')
        ->middleware(RoutePermissions::can('teacher_attendances.update'));

    Route::patch('teacher_attendances/{id}/deactivate', [TeacherAttendanceController::class, 'deactivate'])
        ->name('admin.teacher_attendances.deactivate')
        ->middleware(RoutePermissions::can('teacher_attendances.update'));

    // Exams
    Route::resource('exams', ExamController::class)
        ->names('admin.exams');

    Route::patch('exams/{id}/activate', [ExamController::class, 'activate'])
        ->name('admin.exams.activate')
        ->middleware(RoutePermissions::can('exams.update'));

    Route::patch('exams/{id}/deactivate', [ExamController::class, 'deactivate'])
        ->name('admin.exams.deactivate')
        ->middleware(RoutePermissions::can('exams.update'));

    // Exam Items
    Route::resource('exam_items', ExamItemController::class)
        ->names('admin.exam_items');

    Route::patch('exam_items/{id}/activate', [ExamItemController::class, 'activate'])
        ->name('admin.exam_items.activate')
        ->middleware(RoutePermissions::can('exam_items.update'));

    Route::patch('exam_items/{id}/deactivate', [ExamItemController::class, 'deactivate'])
        ->name('admin.exam_items.deactivate')
        ->middleware(RoutePermissions::can('exam_items.update'));

    // Exam Types
    Route::resource('exam_types', ExamTypeController::class)
        ->names('admin.exam_types');

    Route::patch('exam_types/{id}/activate', [ExamTypeController::class, 'activate'])
        ->name('admin.exam_types.activate')
        ->middleware(RoutePermissions::can('exam_types.update'));

    Route::patch('exam_types/{id}/deactivate', [ExamTypeController::class, 'deactivate'])
        ->name('admin.exam_types.deactivate')
        ->middleware(RoutePermissions::can('exam_types.update'));

    // Nominations
    Route::resource('nominations', NominationController::class)
        ->names('admin.nominations');

    Route::patch('nominations/{id}/activate', [NominationController::class, 'activate'])
        ->name('admin.nominations.activate')
        ->middleware(RoutePermissions::can('nominations.update'));

    Route::patch('nominations/{id}/deactivate', [NominationController::class, 'deactivate'])
        ->name('admin.nominations.deactivate')
        ->middleware(RoutePermissions::can('nominations.update'));

    // Activities
    Route::resource('activities', ActivityController::class)
        ->names('admin.activities');

    Route::patch('activities/{id}/activate', [ActivityController::class, 'activate'])
        ->name('admin.activities.activate')
        ->middleware(RoutePermissions::can('activities.update'));

    Route::patch('activities/{id}/deactivate', [ActivityController::class, 'deactivate'])
        ->name('admin.activities.deactivate')
        ->middleware(RoutePermissions::can('activities.update'));

    // Activity Media
    Route::resource('activity_media', ActivityMediaController::class)
        ->names('admin.activity_media');

    Route::patch('activity_media/{id}/activate', [ActivityMediaController::class, 'activate'])
        ->name('admin.activity_media.activate')
        ->middleware(RoutePermissions::can('activity_media.update'));

    Route::patch('activity_media/{id}/deactivate', [ActivityMediaController::class, 'deactivate'])
        ->name('admin.activity_media.deactivate')
        ->middleware(RoutePermissions::can('activity_media.update'));

    // Certificate Templates
    Route::resource('certificate_templates', CertificateTemplateController::class)
        ->names('admin.certificate_templates');

    Route::patch('certificate_templates/{id}/activate', [CertificateTemplateController::class, 'activate'])
        ->name('admin.certificate_templates.activate')
        ->middleware(RoutePermissions::can('certificate_templates.update'));

    Route::patch('certificate_templates/{id}/deactivate', [CertificateTemplateController::class, 'deactivate'])
        ->name('admin.certificate_templates.deactivate')
        ->middleware(RoutePermissions::can('certificate_templates.update'));

    // Certificate Issued (minimal resource)
    Route::resource('certificate_issued', CertificateIssuedController::class)
        ->names('admin.certificate_issued');

    Route::patch('certificate_issued/{id}/activate', [CertificateIssuedController::class, 'activate'])
        ->name('admin.certificate_issued.activate')
        ->middleware(RoutePermissions::can('certificate_issued.update'));

    Route::patch('certificate_issued/{id}/deactivate', [CertificateIssuedController::class, 'deactivate'])
        ->name('admin.certificate_issued.deactivate')
        ->middleware(RoutePermissions::can('certificate_issued.update'));

    
});

// روابط مصادقة لوحة التحكم (بدون حماية)
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('login');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/locale', LocaleController::class)->name('locale.set')->middleware('throttle:10,1');

// User inbox routes (JSON)
Route::middleware(['auth'])->prefix('notifications')->name('notifications.')->group(function () {
    Route::get('/', [InboxController::class, 'index'])->name('index');
    Route::get('{notification}', [InboxController::class, 'show'])->name('show');
    Route::post('{notification}/read', [InboxController::class, 'markRead'])->name('read');
    Route::post('{notification}/unread', [InboxController::class, 'markUnread'])->name('unread');
    Route::post('mark-all-read', [InboxController::class, 'markAllRead'])->name('markAllRead');
    Route::post('mark-all-unread', [InboxController::class, 'markAllUnread'])->name('markAllUnread');
});
