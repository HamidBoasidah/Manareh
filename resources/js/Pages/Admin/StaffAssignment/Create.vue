<template>
  <AdminLayout>
    <PageBreadcrumb :pageTitle="currentPageTitle" />
    <CreateStaffAssignment 
      :circles="circles"
      :users="users"
      :roles="roles"
      :existingAssignments="existingAssignments"
    />
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/components/layout/AdminLayout.vue'
import PageBreadcrumb from '@/components/common/PageBreadcrumb.vue'
import CreateStaffAssignment from '@/components/admin/staffAssignment/CreateStaffAssignment.vue'
import { computed } from 'vue'
import { useI18n } from 'vue-i18n'
import { usePage } from '@inertiajs/vue3'

const { t } = useI18n()
const currentPageTitle = computed(() => t('staff_assignments.addStaffAssignment'))

const circles = computed(() => usePage().props.circles)
const users = computed(() => usePage().props.users)
const roles = computed(() => usePage().props.roles)
const existingAssignments = computed(() => usePage().props.existingAssignments)
</script>

<style scoped>
</style>
