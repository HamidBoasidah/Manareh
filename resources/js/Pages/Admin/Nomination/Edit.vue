<template>
  <AdminLayout>
    <PageBreadcrumb :pageTitle="currentPageTitle" />
    <EditNomination
      :nomination="nomination"
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
import EditNomination from '@/components/admin/nomination/EditNomination.vue'
import { computed } from 'vue'
import { useI18n } from 'vue-i18n'
import { usePage } from '@inertiajs/vue3'

const { t } = useI18n()
const currentPageTitle = computed(() => t('nominations.editNomination'))

const page = usePage()
const nomination = computed(() => page.props.nomination)
const students = computed(() => page.props.students)
const plans = computed(() => page.props.plans)
const terms = computed(() => page.props.terms)
const nominators = computed(() => page.props.nominators)
const nominationTypes = computed(() => page.props.nominationTypes)
const nominationStatuses = computed(() => page.props.nominationStatuses)
</script>

<style scoped>
</style>
