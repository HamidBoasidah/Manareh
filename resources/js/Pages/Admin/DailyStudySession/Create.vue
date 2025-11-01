<template>
  <AdminLayout>
    <PageBreadcrumb :pageTitle="currentPageTitle" />
    <CreateDailyStudySession :circles="circles" />
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/components/layout/AdminLayout.vue'
import PageBreadcrumb from '@/components/common/PageBreadcrumb.vue'
import CreateDailyStudySession from '@/components/admin/dailyStudySession/CreateDailyStudySession.vue'
import { computed } from 'vue'
import { useI18n } from 'vue-i18n'

const { t } = useI18n()
const currentPageTitle = computed(() => t('daily_study_sessions.addDailyStudySession'))

const props = defineProps({
  circles: { type: Array, default: () => [] },
})

const circles = computed(() => props.circles ?? [])
</script>

<style scoped>
</style>
