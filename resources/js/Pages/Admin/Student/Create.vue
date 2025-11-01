<template>
  <AdminLayout>
    <PageBreadcrumb :pageTitle="currentPageTitle" />
    <CreateStudent :guardians="guardians" :mosques="mosques" />
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/components/layout/AdminLayout.vue'
import PageBreadcrumb from '@/components/common/PageBreadcrumb.vue'
import CreateStudent from '@/components/admin/student/CreateStudent.vue'
import { computed } from 'vue'
import { useI18n } from 'vue-i18n'
import { usePage } from '@inertiajs/vue3'

const { t } = useI18n()
const currentPageTitle = computed(() => t('students.addStudent'))

const guardians = computed(() => usePage().props.guardians)
const mosques = computed(() => usePage().props.mosques)
</script>

<style scoped>
</style>
