<template>
  <AdminLayout>
    <PageBreadcrumb :pageTitle="currentPageTitle" />
  <EditDailyStudy :dailyStudy="dailyStudy" :suras="suras" />
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/components/layout/AdminLayout.vue'
import PageBreadcrumb from '@/components/common/PageBreadcrumb.vue'
import EditDailyStudy from '@/components/admin/dailyStudy/EditDailyStudy.vue'
import { computed } from 'vue'
import { useI18n } from 'vue-i18n'
import { usePage } from '@inertiajs/vue3'

const { t } = useI18n()
const currentPageTitle = computed(() => t('daily_studies.editDailyStudy'))

const dailyStudy = computed(() => usePage().props.dailyStudy)
const suras = computed(() => usePage().props.suras ?? [])
</script>

<style scoped>
</style>
