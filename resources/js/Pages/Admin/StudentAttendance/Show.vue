<template>
  <AdminLayout>
    <PageBreadcrumb :pageTitle="currentPageTitle" />
    <ShowStudentAttendance :studentAttendance="studentAttendance" />
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/components/layout/AdminLayout.vue'
import PageBreadcrumb from '@/components/common/PageBreadcrumb.vue'
import ShowStudentAttendance from '@/components/admin/studentAttendance/ShowStudentAttendance.vue'
import { computed } from 'vue'
import { useI18n } from 'vue-i18n'
import { usePage } from '@inertiajs/vue3'

const { t } = useI18n()
const currentPageTitle = computed(() => t('student_attendances.showStudentAttendance'))

const studentAttendance = computed(() => usePage().props.student_attendance)
</script>

<style scoped>
</style>
