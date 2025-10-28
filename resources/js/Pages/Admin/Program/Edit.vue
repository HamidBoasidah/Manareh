<template>
  <AdminLayout>
    <PageBreadcrumb :pageTitle="currentPageTitle" />
    <EditProgram :program="program" :mosques="mosques" />
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/components/layout/AdminLayout.vue'
import PageBreadcrumb from '@/components/common/PageBreadcrumb.vue'
import EditProgram from '@/components/admin/program/EditProgram.vue'
import { computed } from 'vue'
import { useI18n } from 'vue-i18n'
import { usePage } from '@inertiajs/vue3'

const { t } = useI18n()
const currentPageTitle = computed(() => t('programs.editProgram'))

const program = computed(() => usePage().props.program)
const mosques = computed(() => usePage().props.mosques)
</script>

<style scoped>
</style>
