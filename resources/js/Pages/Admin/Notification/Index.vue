<template>
  <AdminLayout>
    <PageBreadcrumb :pageTitle="currentPageTitle" />
    <div class="space-y-5 sm:space-y-6">
      <ComponentCard :title="currentPageTitle">
        <ShowNotifications
          :notifications="notifications"
          :routes="routeConfig"
          :auto-mark-read="false"
        />
      </ComponentCard>
    </div>
  </AdminLayout>
</template>

<script setup>
import PageBreadcrumb from '@/components/common/PageBreadcrumb.vue'
import AdminLayout from '@/components/layout/AdminLayout.vue'
import ComponentCard from '@/components/common/ComponentCard.vue'
import ShowNotifications from '@/components/admin/inbox/Index.vue'
import { usePage } from '@inertiajs/vue3'
import { computed } from 'vue'
import { useI18n } from 'vue-i18n'

const { t } = useI18n()
const page = usePage()
const currentPageTitle = computed(() => t('menu.notifications'))

const notifications = computed(() => page.props.notifications)

const routeConfig = computed(() => page.props.routeConfig ?? {
  show: 'admin.notifications.show',
  markRead: 'admin.notifications.mark-read',
})
</script>

<style scoped>
</style>
