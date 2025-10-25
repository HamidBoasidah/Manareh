<template>
  <AdminLayout>
    <PageBreadcrumb :pageTitle="currentPageTitle" />
    <EditMessageTemplate :messageTemplate="messageTemplate" />
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/components/layout/AdminLayout.vue'
import PageBreadcrumb from '@/components/common/PageBreadcrumb.vue'
import EditMessageTemplate from '@/components/admin/messageTemplate/EditMessageTemplate.vue'
import { computed } from 'vue'
import { useI18n } from 'vue-i18n'
import { usePage } from '@inertiajs/vue3'

const { t } = useI18n()
const currentPageTitle = computed(() => t('message_templates.editMessageTemplate'))

const messageTemplate = computed(() => usePage().props.message_template)
</script>

<style scoped>
</style>
