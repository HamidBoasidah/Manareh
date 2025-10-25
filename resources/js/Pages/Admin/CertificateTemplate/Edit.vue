<template>
  <AdminLayout>
    <PageBreadcrumb :pageTitle="currentPageTitle" />
    <EditCertificateTemplate :certificateTemplate="certificateTemplate" />
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/components/layout/AdminLayout.vue'
import PageBreadcrumb from '@/components/common/PageBreadcrumb.vue'
import EditCertificateTemplate from '@/components/admin/certificateTemplate/EditCertificateTemplate.vue'
import { computed } from 'vue'
import { useI18n } from 'vue-i18n'
import { usePage } from '@inertiajs/vue3'

const { t } = useI18n()
const currentPageTitle = computed(() => t('certificate_templates.editCertificateTemplate'))

const certificateTemplate = computed(() => usePage().props.certificate_template)
</script>

<style scoped>
</style>
