<template>
  <div class="space-y-6">
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
      <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800">
        <h2 class="text-lg font-medium text-gray-800 dark:text-white">
          {{ t('teacher_attendances.teacherAttendanceInformation') }}
        </h2>
      </div>

      <div class="p-4 sm:p-6">
        <div class="grid grid-cols-1 gap-x-5 gap-y-6 md:grid-cols-2">
          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-500 dark:text-gray-400">
              {{ t('teacher_attendances.teacher') }}
            </label>
            <p class="text-base text-gray-800 dark:text-white/90">
              {{ teacherAttendance.user_name || '—' }}
            </p>
            <p v-if="teacherAttendance.user_role" class="mt-1 text-sm text-gray-500 dark:text-gray-400">
              {{ t('teacher_attendances.role') }}: {{ teacherAttendance.user_role }}
            </p>
          </div>

          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-500 dark:text-gray-400">
              {{ t('teacher_attendances.circle') }}
            </label>
            <p class="text-base text-gray-800 dark:text-white/90">
              {{ teacherAttendance.circle_name || '—' }}
            </p>
          </div>

          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-500 dark:text-gray-400">
              {{ t('teacher_attendances.dateG') }}
            </label>
            <p class="text-base text-gray-800 dark:text-white/90">
              {{ teacherAttendance.date_g || '—' }}
            </p>
          </div>

          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-500 dark:text-gray-400">
              {{ t('teacher_attendances.dateH') }}
            </label>
            <p class="text-base text-gray-800 dark:text-white/90">
              {{ teacherAttendance.date_h || '—' }}
            </p>
          </div>

          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-500 dark:text-gray-400">
              {{ t('teacher_attendances.status') }}
            </label>
            <span
              class="inline-flex items-center justify-center gap-1 rounded-full px-2.5 py-0.5 text-xs font-medium"
              :class="statusBadgeClass"
            >
              {{ statusLabel }}
            </span>
          </div>

          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-500 dark:text-gray-400">
              {{ t('common.status') }}
            </label>
            <span
              class="inline-flex items-center justify-center gap-1 rounded-full px-2.5 py-0.5 text-xs font-medium"
              :class="teacherAttendance.is_active ? 'bg-green-50 text-green-600 dark:bg-green-500/15 dark:text-green-500' : 'bg-error-50 text-error-600 dark:bg-error-500/15 dark:text-error-500'"
            >
              {{ teacherAttendance.is_active ? t('common.active') : t('common.inactive') }}
            </span>
          </div>

          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-500 dark:text-gray-400">
              {{ t('teacher_attendances.recordedBy') }}
            </label>
            <p class="text-base text-gray-800 dark:text-white/90">
              {{ teacherAttendance.recorded_by_name || '—' }}
            </p>
          </div>

          <div v-if="teacherAttendance.notes" class="md:col-span-2">
            <label class="mb-1.5 block text-sm font-medium text-gray-500 dark:text-gray-400">
              {{ t('teacher_attendances.notes') }}
            </label>
            <p class="text-base text-gray-800 dark:text-white/90 whitespace-pre-wrap">
              {{ teacherAttendance.notes }}
            </p>
          </div>
        </div>
      </div>
    </div>

    <div class="flex flex-col gap-3 sm:flex-row sm:justify-end">
      <Link
        :href="route('admin.teacher_attendances.index')"
        class="shadow-theme-xs inline-flex items-center justify-center gap-2 rounded-lg bg-white px-4 py-3 text-sm font-medium text-gray-700 ring-1 ring-gray-300 transition hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-400 dark:ring-gray-700 dark:hover:bg-white/[0.03]"
      >
        {{ t('buttons.backToList') }}
      </Link>

      <Link
        :href="route('admin.teacher_attendances.edit', teacherAttendance.id)"
        class="bg-brand-500 shadow-theme-xs hover:bg-brand-600 inline-flex items-center justify-center gap-2 rounded-lg px-4 py-3 text-sm font-medium text-white transition"
      >
        {{ t('buttons.edit') }}
      </Link>
    </div>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import { computed, toRefs } from 'vue'
import { useI18n } from 'vue-i18n'

const { t } = useI18n()

const props = defineProps({
  teacherAttendance: { type: Object, required: true },
})

const { teacherAttendance } = toRefs(props)

const statusLabel = computed(() => {
  const status = teacherAttendance.value?.status || ''
  return status ? t(`teacher_attendances.statusLabels.${status}`) : '—'
})

const statusBadgeClass = computed(() => {
  switch (teacherAttendance.value?.status) {
    case 'present':
      return 'bg-green-50 text-green-600 dark:bg-green-500/15 dark:text-green-500'
    case 'absent':
      return 'bg-error-50 text-error-600 dark:bg-error-500/15 dark:text-error-500'
    case 'excused':
      return 'bg-blue-50 text-blue-600 dark:bg-blue-500/15 dark:text-blue-300'
    case 'late_in':
    case 'early_out':
      return 'bg-yellow-50 text-yellow-600 dark:bg-yellow-500/15 dark:text-yellow-400'
    case 'half_day':
      return 'bg-indigo-50 text-indigo-600 dark:bg-indigo-500/15 dark:text-indigo-400'
    case 'on_leave':
      return 'bg-purple-50 text-purple-600 dark:bg-purple-500/15 dark:text-purple-400'
    case 'sick':
      return 'bg-amber-50 text-amber-600 dark:bg-amber-500/15 dark:text-amber-400'
    default:
      return 'bg-gray-100 text-gray-600 dark:bg-white/10 dark:text-gray-300'
  }
})
</script>
