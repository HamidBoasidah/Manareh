<template>
  <div class="space-y-6">
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
      <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800">
        <h2 class="text-lg font-medium text-gray-800 dark:text-white">
          {{ t('staff_assignments.assignmentInformation') }}
        </h2>
      </div>

      <div class="p-4 sm:p-6">
        <div class="grid grid-cols-1 gap-x-5 gap-y-6 md:grid-cols-2">
          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-500 dark:text-gray-400">
              {{ t('staff_assignments.userName') }}
            </label>
            <p class="text-base text-gray-800 dark:text-white/90">{{ assignment.user_name }}</p>
          </div>

          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-500 dark:text-gray-400">
              {{ t('staff_assignments.circleName') }}
            </label>
            <p class="text-base text-gray-800 dark:text-white/90">{{ assignment.circle_name }}</p>
          </div>

          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-500 dark:text-gray-400">
              {{ t('staff_assignments.roleInCircle') }}
            </label>
            <p class="text-base text-gray-800 dark:text-white/90">{{ assignment.role_in_circle }}</p>
          </div>

          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-500 dark:text-gray-400">
              {{ t('staff_assignments.startAt') }}
            </label>
            <p class="text-base text-gray-800 dark:text-white/90">{{ assignment.start_at }}</p>
          </div>

          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-500 dark:text-gray-400">
              {{ t('staff_assignments.endAt') }}
            </label>
            <p class="text-base text-gray-800 dark:text-white/90">
              {{ assignment.end_at ? assignment.end_at : t('staff_assignments.ongoing') }}
            </p>
          </div>

          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-500 dark:text-gray-400">
              {{ t('common.status') }}
            </label>
            <span
              class="inline-flex items-center justify-center gap-1 rounded-full px-2.5 py-0.5 text-xs font-medium"
              :class="{
                'bg-green-50 text-green-600 dark:bg-green-500/15 dark:text-green-500': assignment.is_active,
                'bg-error-50 text-error-600 dark:bg-error-500/15 dark:text-error-500': !assignment.is_active,
              }"
            >
              {{ assignment.is_active ? t('common.active') : t('common.inactive') }}
            </span>
          </div>

          <div class="md:col-span-2">
            <label class="mb-1.5 block text-sm font-medium text-gray-500 dark:text-gray-400">
              {{ t('common.notes') }}
            </label>
            <p class="text-base text-gray-800 dark:text-white/90">{{ assignment.notes }}</p>
          </div>
        </div>
      </div>
    </div>

    <div class="flex flex-col gap-3 sm:flex-row sm:justify-end">
      <Link
        :href="route('admin.staff_assignments.index')"
        class="shadow-theme-xs inline-flex items-center justify-center gap-2 rounded-lg bg-white px-4 py-3 text-sm font-medium text-gray-700 ring-1 ring-gray-300 transition hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-400 dark:ring-gray-700 dark:hover:bg-white/[0.03]"
      >
        {{ t('buttons.backToList') }}
      </Link>

      <Link
        :href="route('admin.staff_assignments.edit', assignment.id)"
        class="bg-brand-500 shadow-theme-xs hover:bg-brand-600 inline-flex items-center justify-center gap-2 rounded-lg px-4 py-3 text-sm font-medium text-white transition"
      >
        {{ t('buttons.edit') }}
      </Link>

      <button
        type="button"
        v-if="!assignment.end_at"
        @click="openDeleteModal"
        :disabled="form.processing"
        class="bg-error-500 shadow-theme-xs hover:bg-error-600 inline-flex items-center justify-center gap-2 rounded-lg px-4 py-3 text-sm font-medium text-white transition"
      >
        {{ form.processing ? t('common.loading') : t('staff_assignments.removeAssignment') }}
      </button>
    </div>
  </div>

  <DangerAlert
    :isOpen="isDeleteModalOpen"
    :title="t('messages.areYouSure')"
    :message="t('messages.deleteAssignmentConfirmation')"
    @close="closeDeleteModal"
    @confirm="confirmUnassign"
  />
</template>

<script setup>
import { Link, useForm } from '@inertiajs/vue3'
import { useI18n } from 'vue-i18n'
import { useNotifications } from '@/composables/useNotifications'
import { ref } from 'vue'
import DangerAlert from '@/components/modals/DangerAlert.vue'

const { t } = useI18n()
const { success, error } = useNotifications()

defineProps({
  assignment: { type: Object, required: true },
})

// form for unassign action
const form = useForm({
  circle_id: null,
  role: null,
})

const isDeleteModalOpen = ref(false)

function openDeleteModal() {
  isDeleteModalOpen.value = true
}

function closeDeleteModal() {
  isDeleteModalOpen.value = false
}

function confirmUnassign() {
  // set payload
  form.circle_id = assignment.circle_id
  form.role = assignment.role_in_circle

  form.post(route('admin.staff_assignments.unassign'), {
    onSuccess: () => {
      success(t('staff_assignments.assignmentDeletedSuccessfully'))
      closeDeleteModal()
    },
    onError: () => {
      error(t('staff_assignments.assignmentDeletionFailed'))
      closeDeleteModal()
    }
  })
}
</script>
