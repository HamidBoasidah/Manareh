<template>
  <AdminLayout>
    <PageBreadcrumb :pageTitle="currentPageTitle" />
    <CreateCircle 
      :mosques="mosques"
      :classifications="classifications"
    />
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/components/layout/AdminLayout.vue'
import PageBreadcrumb from '@/components/common/PageBreadcrumb.vue'
import CreateCircle from '@/components/admin/circle/CreateCircle.vue'
import { computed } from 'vue'
import { useI18n } from 'vue-i18n'

const { t } = useI18n()
const currentPageTitle = computed(() => t('circles.addCircle'))

const mosques = computed(() => usePage().props.mosques)
const classifications = computed(() => usePage().props.classifications)

</script>

<style scoped>
</style>
