<template>
  <AdminLayout>
    <PageBreadcrumb :pageTitle="currentPageTitle" />
    <ShowStaffAssignment :staffAssignment="staffAssignment" />
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/components/layout/AdminLayout.vue'
import PageBreadcrumb from '@/components/common/PageBreadcrumb.vue'
import ShowStaffAssignment from '@/components/admin/staffAssignment/ShowStaffAssignment.vue'
import { computed } from 'vue'
import { useI18n } from 'vue-i18n'
import { usePage } from '@inertiajs/vue3'

const { t } = useI18n()
const currentPageTitle = computed(() => t('staff_assignments.showStaffAssignment'))

const staffAssignment = computed(() => usePage().props.staff_assignment)
</script>

<style scoped>
</style>
