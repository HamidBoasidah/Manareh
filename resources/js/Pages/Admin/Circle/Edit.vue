<template>
  <AdminLayout>
    <PageBreadcrumb :pageTitle="currentPageTitle" />
    <EditCircle :circle="circle"
      :mosques="mosques"
      :classifications="classifications"
    />
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/components/layout/AdminLayout.vue'
import PageBreadcrumb from '@/components/common/PageBreadcrumb.vue'
import EditCircle from '@/components/admin/circle/EditCircle.vue'
import { computed } from 'vue'
import { useI18n } from 'vue-i18n'
import { usePage } from '@inertiajs/vue3'

const { t } = useI18n()
const currentPageTitle = computed(() => t('circles.editCircle'))

const circle = computed(() => usePage().props.circle)

const mosques = computed(() => usePage().props.mosques)
const classifications = computed(() => usePage().props.classifications)
</script>

<style scoped>
</style>
