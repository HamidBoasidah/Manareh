<template>
  <AdminLayout>
    <PageBreadcrumb :pageTitle="currentPageTitle" />
    <EditStaffAssignment :staffAssignment="staffAssignment" />
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/components/layout/AdminLayout.vue'
import PageBreadcrumb from '@/components/common/PageBreadcrumb.vue'
import EditStaffAssignment from '@/components/admin/staffAssignment/EditStaffAssignment.vue'
import { computed } from 'vue'
import { useI18n } from 'vue-i18n'
import { usePage } from '@inertiajs/vue3'

const { t } = useI18n()
const currentPageTitle = computed(() => t('staff_assignments.editStaffAssignment'))

const staffAssignment = computed(() => usePage().props.staff_assignment)
</script>

<style scoped>
</style>
