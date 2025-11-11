<template>
  <AdminLayout>
    <PageBreadcrumb :pageTitle="currentPageTitle" />
    <div class="space-y-5 sm:space-y-6">
      <ComponentCard :title="currentPageTitle">
        <ShowMessageTemplates :message-templates="messageTemplates" :filters="filters" :options="options" />
      </ComponentCard>
    </div>
  </AdminLayout>
</template>

<script setup>
import PageBreadcrumb from '@/components/common/PageBreadcrumb.vue'
import AdminLayout from '@/components/layout/AdminLayout.vue'
import ComponentCard from '@/components/common/ComponentCard.vue'
import ShowMessageTemplates from '@/components/admin/messageTemplate/ShowMessageTemplates.vue'
import { usePage } from '@inertiajs/vue3'
import { computed } from 'vue'
import { useI18n } from 'vue-i18n'

const { t } = useI18n()
const currentPageTitle = computed(() => t('menu.message_templates'))

const page = usePage()
const messageTemplates = computed(() => page.props.message_templates)
const filters = computed(() => page.props.filters || {})
const options = computed(() => page.props.options || {})
</script>

<style scoped>
</style>
