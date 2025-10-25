<template>
  <AdminLayout>
    <PageBreadcrumb :pageTitle="currentPageTitle" />
    <EditStudentAttendance :studentAttendance="studentAttendance" />
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/components/layout/AdminLayout.vue'
import PageBreadcrumb from '@/components/common/PageBreadcrumb.vue'
import EditStudentAttendance from '@/components/admin/studentAttendance/EditStudentAttendance.vue'
import { computed } from 'vue'
import { useI18n } from 'vue-i18n'
import { usePage } from '@inertiajs/vue3'

const { t } = useI18n()
const currentPageTitle = computed(() => t('student_attendances.editStudentAttendance'))

const studentAttendance = computed(() => usePage().props.student_attendance)
</script>

<style scoped>
</style>
