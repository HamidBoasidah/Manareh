<template>
  <AdminLayout>
    <PageBreadcrumb :pageTitle="currentPageTitle" />
    <CreateMessageTemplate :options="options" />
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/components/layout/AdminLayout.vue'
import PageBreadcrumb from '@/components/common/PageBreadcrumb.vue'
import CreateMessageTemplate from '@/components/admin/messageTemplate/CreateMessageTemplate.vue'
import { computed } from 'vue'
import { useI18n } from 'vue-i18n'
import { usePage } from '@inertiajs/vue3'

const { t } = useI18n()
const currentPageTitle = computed(() => t('message_templates.addMessageTemplate'))
const options = computed(() => usePage().props.options || {})
</script>

<style scoped>
</style>
