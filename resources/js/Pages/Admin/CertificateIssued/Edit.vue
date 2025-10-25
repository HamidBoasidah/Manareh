<template>
  <AdminLayout>
    <PageBreadcrumb :pageTitle="currentPageTitle" />
    <EditCertificateIssued :certificate="certificate" />
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/components/layout/AdminLayout.vue'
import PageBreadcrumb from '@/components/common/PageBreadcrumb.vue'
import EditCertificateIssued from '@/components/admin/certificateIssued/EditCertificateIssued.vue'
import { computed } from 'vue'
import { useI18n } from 'vue-i18n'
import { usePage } from '@inertiajs/vue3'

const { t } = useI18n()
const currentPageTitle = computed(() => t('certificate_issued.editCertificateIssued'))

const certificate = computed(() => usePage().props.certificate)
</script>

<style scoped>
</style>
