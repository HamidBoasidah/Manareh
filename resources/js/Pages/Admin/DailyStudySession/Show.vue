<template>
  <AdminLayout>
    <PageBreadcrumb :pageTitle="currentPageTitle" />
    <ShowDailyStudySession :dailyStudySession="dailyStudySession" />
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/components/layout/AdminLayout.vue'
import PageBreadcrumb from '@/components/common/PageBreadcrumb.vue'
import ShowDailyStudySession from '@/components/admin/dailyStudySession/ShowDailyStudySession.vue'
import { computed } from 'vue'
import { useI18n } from 'vue-i18n'
import { usePage } from '@inertiajs/vue3'

const { t } = useI18n()
const currentPageTitle = computed(() => t('daily_study_sessions.showDailyStudySession'))

const dailyStudySession = computed(() => usePage().props.daily_study_session)
</script>

<style scoped>
</style>
