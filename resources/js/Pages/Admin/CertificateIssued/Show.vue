<template>
  <AdminLayout>
    <PageBreadcrumb :pageTitle="currentPageTitle" />
    <ShowCertificateIssuedItem :certificate="certificate" />
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/components/layout/AdminLayout.vue'
import PageBreadcrumb from '@/components/common/PageBreadcrumb.vue'
import ShowCertificateIssuedItem from '@/components/admin/certificateIssued/ShowCertificateIssuedItem.vue'
import { computed } from 'vue'
import { useI18n } from 'vue-i18n'
import { usePage } from '@inertiajs/vue3'

const { t } = useI18n()
const currentPageTitle = computed(() => t('certificate_issued.showCertificateIssued'))

const certificate = computed(() => usePage().props.certificate)
</script>

<style scoped>
</style>
