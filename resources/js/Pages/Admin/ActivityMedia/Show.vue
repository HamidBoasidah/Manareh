<template>
  <AdminLayout>
    <PageBreadcrumb :pageTitle="currentPageTitle" />
    <ShowActivityMediaItem :activityMediaItem="activityMediaItem" />
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/components/layout/AdminLayout.vue'
import PageBreadcrumb from '@/components/common/PageBreadcrumb.vue'
import ShowActivityMediaItem from '@/components/admin/activityMedia/ShowActivityMediaItem.vue'
import { computed } from 'vue'
import { useI18n } from 'vue-i18n'
import { usePage } from '@inertiajs/vue3'

const { t } = useI18n()
const currentPageTitle = computed(() => t('activity_media.showActivityMedia'))

const activityMediaItem = computed(() => usePage().props.activity_media_item)
</script>

<style scoped>
</style>
