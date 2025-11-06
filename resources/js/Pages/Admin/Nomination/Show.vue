<template>
  <AdminLayout>
    <PageBreadcrumb :pageTitle="currentPageTitle" />
    <ShowNomination :nomination="nomination" />
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/components/layout/AdminLayout.vue'
import PageBreadcrumb from '@/components/common/PageBreadcrumb.vue'
import ShowNomination from '@/components/admin/nomination/ShowNomination.vue'
import { computed } from 'vue'
import { useI18n } from 'vue-i18n'
import { usePage } from '@inertiajs/vue3'

const { t } = useI18n()
const currentPageTitle = computed(() => t('nominations.showNomination'))

const nomination = computed(() => usePage().props.nomination)
</script>

<style scoped>
</style>
