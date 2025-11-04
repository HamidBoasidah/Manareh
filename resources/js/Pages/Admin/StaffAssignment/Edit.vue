<template>
	<AdminLayout>
		<PageBreadcrumb :pageTitle="currentPageTitle" />
		<EditStaffAssignment
			:circles="circles"
			:users="users"
			:roles="roles"
			:existingAssignments="existingAssignments"
			:assignment="assignment"
		/>
	</AdminLayout>
</template>

<script setup>
import AdminLayout from '@/components/layout/AdminLayout.vue'
import PageBreadcrumb from '@/components/common/PageBreadcrumb.vue'
import EditStaffAssignment from '@/components/admin/staffAssignment/EditStaffAssignment.vue'
import { computed } from 'vue'
import { useI18n } from 'vue-i18n'
import { usePage } from '@inertiajs/vue3'

const { t } = useI18n()
const currentPageTitle = computed(() => t('staff_assignments.editStaffAssignment'))

const page = usePage()
const circles = computed(() => page.props.circles ?? [])
const users = computed(() => page.props.users ?? [])
const roles = computed(() => page.props.roles ?? [])
const existingAssignments = computed(() => page.props.existingAssignments ?? [])
// Controller sends the DTO under `assignment`
const assignment = computed(() => page.props.assignment ?? page.props.staffAssignment ?? null)
</script>

<style scoped>
</style>
