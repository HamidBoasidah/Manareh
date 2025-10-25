<template>
  <AdminLayout>
    <PageBreadcrumb :pageTitle="currentPageTitle" />
    <ShowTeacherAttendance :teacherAttendance="teacherAttendance" />
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/components/layout/AdminLayout.vue'
import PageBreadcrumb from '@/components/common/PageBreadcrumb.vue'
import ShowTeacherAttendance from '@/components/admin/teacherAttendance/ShowTeacherAttendance.vue'
import { computed } from 'vue'
import { useI18n } from 'vue-i18n'
import { usePage } from '@inertiajs/vue3'

const { t } = useI18n()
const currentPageTitle = computed(() => t('teacher_attendances.showTeacherAttendance'))

const teacherAttendance = computed(() => usePage().props.teacher_attendance)
</script>

<style scoped>
</style>
