<template>
  <AdminLayout>
    <PageBreadcrumb :pageTitle="currentPageTitle" />
    <ShowCircleClassification :circleClassification="circleClassification" />
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/components/layout/AdminLayout.vue'
import PageBreadcrumb from '@/components/common/PageBreadcrumb.vue'
import ShowCircleClassification from '@/components/admin/circleClassification/ShowCircleClassification.vue'
import { computed } from 'vue'
import { useI18n } from 'vue-i18n'
import { usePage } from '@inertiajs/vue3'

const { t } = useI18n()
const currentPageTitle = computed(() => t('circle_classifications.showCircleClassification'))

const circleClassification = computed(() => usePage().props.circle_classification)
</script>

<style scoped>
</style>
