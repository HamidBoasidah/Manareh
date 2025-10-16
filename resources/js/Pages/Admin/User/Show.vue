<template>
  <admin-layout>
    <PageBreadcrumb :pageTitle="currentPageTitle" />
    
    <AddUserForm :user="user"/>
  </admin-layout>
</template>

<script setup>
import AdminLayout from '@/components/layout/AdminLayout.vue'
import PageBreadcrumb from '@/components/common/PageBreadcrumb.vue'
import AddUserForm from '@/components/admin/user/ShowUser.vue'
import { computed } from 'vue'
import { useI18n } from 'vue-i18n'
import { usePage } from '@inertiajs/vue3'


const { t } = useI18n()
const currentPageTitle = computed(() => t('users.showUser'))

// استلام البيانات من Inertia

const user = computed(() => usePage().props.user)

</script>
