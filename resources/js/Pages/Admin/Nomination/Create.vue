<template>
  <AdminLayout>
    <PageBreadcrumb :pageTitle="currentPageTitle" />
    <CreateNomination
      :students="students"
      :plans="plans"
      :terms="terms"
      :nominators="nominators"
      :nominationTypes="nominationTypes"
      :nominationStatuses="nominationStatuses"
    />
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/components/layout/AdminLayout.vue'
import PageBreadcrumb from '@/components/common/PageBreadcrumb.vue'
import CreateNomination from '@/components/admin/nomination/CreateNomination.vue'
import { usePage } from '@inertiajs/vue3'
import { computed } from 'vue'
import { useI18n } from 'vue-i18n'

const { t } = useI18n()
const currentPageTitle = computed(() => t('nominations.addNomination'))

const students = computed(() => usePage().props.students)
const plans = computed(() => usePage().props.plans)
const terms = computed(() => usePage().props.terms)
const nominators = computed(() => usePage().props.nominators)
const nominationTypes = computed(() => usePage().props.nominationTypes)
const nominationStatuses = computed(() => usePage().props.nominationStatuses)
</script>

<style scoped>
</style>
