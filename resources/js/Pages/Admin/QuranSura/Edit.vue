<template>
  <AdminLayout>
    <PageBreadcrumb :pageTitle="currentPageTitle" />
    <EditQuranSura :quranSura="quranSura" />
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/components/layout/AdminLayout.vue'
import PageBreadcrumb from '@/components/common/PageBreadcrumb.vue'
import EditQuranSura from '@/components/admin/quranSura/EditQuranSura.vue'
import { computed } from 'vue'
import { useI18n } from 'vue-i18n'
import { usePage } from '@inertiajs/vue3'

const { t } = useI18n()
const currentPageTitle = computed(() => t('quran_suras.editQuranSura'))

const quranSura = computed(() => usePage().props.quran_sura)
</script>

<style scoped>
</style>
