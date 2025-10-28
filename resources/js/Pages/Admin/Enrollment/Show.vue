<template>
  <AdminLayout>
    <PageBreadcrumb :pageTitle="currentPageTitle" />
    <ShowEnrollment :enrollment="enrollment" />
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/components/layout/AdminLayout.vue'
import PageBreadcrumb from '@/components/common/PageBreadcrumb.vue'
import ShowEnrollment from '@/components/admin/enrollment/ShowEnrollment.vue'
import { computed } from 'vue'
import { useI18n } from 'vue-i18n'
import { usePage } from '@inertiajs/vue3'

const { t } = useI18n()
const currentPageTitle = computed(() => t('enrollments.showEnrollment'))

const enrollment = computed(() => usePage().props.enrollment)
</script>

<style scoped>
</style>
