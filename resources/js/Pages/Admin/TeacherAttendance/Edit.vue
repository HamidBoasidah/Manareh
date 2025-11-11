<template>
  <AdminLayout>
    <PageBreadcrumb :pageTitle="currentPageTitle" />
    <EditTeacherAttendance
      :teacher-attendance="teacherAttendance"
      :circles="circles"
      :teachers="teachers"
      :recorders="recorders"
    />
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/components/layout/AdminLayout.vue'
import PageBreadcrumb from '@/components/common/PageBreadcrumb.vue'
import EditTeacherAttendance from '@/components/admin/teacherAttendance/EditTeacherAttendance.vue'
import { computed } from 'vue'
import { useI18n } from 'vue-i18n'
import { usePage } from '@inertiajs/vue3'

const { t } = useI18n()
const currentPageTitle = computed(() => t('teacher_attendances.editTeacherAttendance'))

const teacherAttendance = computed(() => usePage().props.teacher_attendance)
const circles = computed(() => usePage().props.circles ?? [])
const teachers = computed(() => usePage().props.teachers ?? [])
const recorders = computed(() => usePage().props.recorders ?? [])
</script>

<style scoped>
</style>
