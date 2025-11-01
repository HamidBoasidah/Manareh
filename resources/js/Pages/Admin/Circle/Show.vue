<template>
  <AdminLayout>
    <PageBreadcrumb :pageTitle="currentPageTitle" />
    <ShowCircle
      :circle="circle"
      :joinedStudents="joinedStudents"
      :freeStudents="freeStudents"
      :can-manage-students="canManageStudents"
    />
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/components/layout/AdminLayout.vue'
import PageBreadcrumb from '@/components/common/PageBreadcrumb.vue'
import ShowCircle from '@/components/admin/circle/ShowCircle.vue'
import { computed } from 'vue'
import { useI18n } from 'vue-i18n'
import { usePage } from '@inertiajs/vue3'

const { t } = useI18n()
const currentPageTitle = computed(() => t('circles.showCircle'))

const circle = computed(() => usePage().props.circle)
const joinedStudents = computed(() => usePage().props.joinedStudents)
const freeStudents = computed(() => usePage().props.freeStudents)
const canManageStudents = computed(() => usePage().props.canManageStudents ?? false)
</script>

<style scoped>
</style>
