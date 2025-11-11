<template>
  <AdminLayout>
    <PageBreadcrumb :pageTitle="currentPageTitle" />
    <CreateTeacherAttendance
      :circles="circles"
      :teachers="teachers"
      :recorders="recorders"
      :current-user-id="currentUserId"
    />
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/components/layout/AdminLayout.vue'
import PageBreadcrumb from '@/components/common/PageBreadcrumb.vue'
import CreateTeacherAttendance from '@/components/admin/teacherAttendance/CreateTeacherAttendance.vue'
import { computed } from 'vue'
import { useI18n } from 'vue-i18n'
import { usePage } from '@inertiajs/vue3'

const { t } = useI18n()
const currentPageTitle = computed(() => t('teacher_attendances.addTeacherAttendance'))

const page = usePage()
const circles = computed(() => page.props.circles ?? [])
const teachers = computed(() => page.props.teachers ?? [])
const recorders = computed(() => page.props.recorders ?? [])
const currentUserId = computed(() => page.props.auth?.user?.id ?? null)
</script>

<style scoped>
</style>
