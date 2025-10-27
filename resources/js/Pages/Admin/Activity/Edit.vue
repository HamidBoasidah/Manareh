<template>
  <AdminLayout>
    <PageBreadcrumb :pageTitle="currentPageTitle" />
    <EditActivity :activity="activity"
    :mosques="mosques" />
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/components/layout/AdminLayout.vue'
import PageBreadcrumb from '@/components/common/PageBreadcrumb.vue'
import EditActivity from '@/components/admin/activity/EditActivity.vue'
import { computed } from 'vue'
import { useI18n } from 'vue-i18n'
import { usePage } from '@inertiajs/vue3'

const { t } = useI18n()
const currentPageTitle = computed(() => t('activities.editActivity'))

const activity = computed(() => usePage().props.activity)
const mosques = computed(() => usePage().props.mosques)
</script>

<style scoped>
</style>
