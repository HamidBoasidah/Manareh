<template>
  <div class="space-y-6">
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
      <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800">
        <h2 class="text-lg font-medium text-gray-800 dark:text-white">
          {{ t('daily_studies.dailyStudyInformation') }}
        </h2>
      </div>

      <div class="p-4 sm:p-6">
        <div class="grid grid-cols-1 gap-x-5 gap-y-6 md:grid-cols-2">
          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-500 dark:text-gray-400">
              {{ t('daily_studies.session') }}
            </label>
            <p class="text-base text-gray-800 dark:text-white/90">{{ displayValue(dailyStudy.session_id) }}</p>
          </div>

          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-500 dark:text-gray-400">
              {{ t('daily_studies.studentId') }}
            </label>
            <p class="text-base text-gray-800 dark:text-white/90">{{ displayValue(dailyStudy.student_id) }}</p>
          </div>

          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-500 dark:text-gray-400">
              {{ t('daily_studies.student') }}
            </label>
            <p class="text-base text-gray-800 dark:text-white/90">{{ displayValue(dailyStudy.student_name) }}</p>
          </div>

          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-500 dark:text-gray-400">
              {{ t('daily_studies.attendanceStatus') }}
            </label>
            <span
              class="inline-flex items-center justify-center gap-1 rounded-full px-2.5 py-0.5 text-xs font-medium"
              :class="attendanceBadgeClass(dailyStudy.attendance_status)"
            >
              {{ attendanceLabel }}
            </span>
          </div>

          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-500 dark:text-gray-400">
              {{ t('common.status') }}
            </label>
            <span
              class="inline-flex items-center justify-center gap-1 rounded-full px-2.5 py-0.5 text-xs font-medium"
              :class="statusBadgeClass(dailyStudy.is_active)"
            >
              {{ dailyStudy.is_active ? t('common.active') : t('common.inactive') }}
            </span>
          </div>

          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-500 dark:text-gray-400">
              {{ t('daily_studies.points') }}
            </label>
            <p class="text-base text-gray-800 dark:text-white/90">{{ displayValue(dailyStudy.points) }}</p>
          </div>

          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-500 dark:text-gray-400">
              {{ t('datatable.createdAt') }}
            </label>
            <p class="text-base text-gray-800 dark:text-white/90">{{ displayValue(dailyStudy.created_at) }}</p>
          </div>

          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-500 dark:text-gray-400">
              {{ t('datatable.updatedAt') }}
            </label>
            <p class="text-base text-gray-800 dark:text-white/90">{{ displayValue(dailyStudy.updated_at) }}</p>
          </div>

          <div class="md:col-span-2">
            <label class="mb-1.5 block text-sm font-medium text-gray-500 dark:text-gray-400">
              {{ t('daily_studies.notes') }}
            </label>
            <p class="whitespace-pre-wrap text-base text-gray-800 dark:text-white/90">
              {{ displayText(dailyStudy.notes) }}
            </p>
          </div>
        </div>
      </div>
    </div>

    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
      <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800">
        <h2 class="text-lg font-medium text-gray-800 dark:text-white">
          {{ t('daily_studies.hifzSection') }}
        </h2>
      </div>

      <div class="p-4 sm:p-6">
        <div class="grid grid-cols-1 gap-x-5 gap-y-6 md:grid-cols-2">
          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-500 dark:text-gray-400">
              {{ t('daily_studies.hifzFromSura') }}
            </label>
            <p class="text-base text-gray-800 dark:text-white/90">{{ displayValue(dailyStudy.hifz_from_sura_id) }}</p>
          </div>

          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-500 dark:text-gray-400">
              {{ t('daily_studies.hifzFromAyah') }}
            </label>
            <p class="text-base text-gray-800 dark:text-white/90">{{ displayValue(dailyStudy.hifz_from_ayah) }}</p>
          </div>

          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-500 dark:text-gray-400">
              {{ t('daily_studies.hifzToSura') }}
            </label>
            <p class="text-base text-gray-800 dark:text-white/90">{{ displayValue(dailyStudy.hifz_to_sura_id) }}</p>
          </div>

          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-500 dark:text-gray-400">
              {{ t('daily_studies.hifzToAyah') }}
            </label>
            <p class="text-base text-gray-800 dark:text-white/90">{{ displayValue(dailyStudy.hifz_to_ayah) }}</p>
          </div>

          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-500 dark:text-gray-400">
              {{ t('daily_studies.hifzPages') }}
            </label>
            <p class="text-base text-gray-800 dark:text-white/90">{{ displayValue(dailyStudy.hifz_pages) }}</p>
          </div>
        </div>
      </div>
    </div>

    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
      <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800">
        <h2 class="text-lg font-medium text-gray-800 dark:text-white">
          {{ t('daily_studies.murajaahSection') }}
        </h2>
      </div>

      <div class="p-4 sm:p-6">
        <div class="grid grid-cols-1 gap-x-5 gap-y-6 md:grid-cols-2">
          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-500 dark:text-gray-400">
              {{ t('daily_studies.murajaahFromSura') }}
            </label>
            <p class="text-base text-gray-800 dark:text-white/90">{{ displayValue(dailyStudy.murajaah_from_sura_id) }}</p>
          </div>

          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-500 dark:text-gray-400">
              {{ t('daily_studies.murajaahFromAyah') }}
            </label>
            <p class="text-base text-gray-800 dark:text-white/90">{{ displayValue(dailyStudy.murajaah_from_ayah) }}</p>
          </div>

          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-500 dark:text-gray-400">
              {{ t('daily_studies.murajaahToSura') }}
            </label>
            <p class="text-base text-gray-800 dark:text-white/90">{{ displayValue(dailyStudy.murajaah_to_sura_id) }}</p>
          </div>

          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-500 dark:text-gray-400">
              {{ t('daily_studies.murajaahToAyah') }}
            </label>
            <p class="text-base text-gray-800 dark:text-white/90">{{ displayValue(dailyStudy.murajaah_to_ayah) }}</p>
          </div>

          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-500 dark:text-gray-400">
              {{ t('daily_studies.murajaahPages') }}
            </label>
            <p class="text-base text-gray-800 dark:text-white/90">{{ displayValue(dailyStudy.murajaah_pages) }}</p>
          </div>
        </div>
      </div>
    </div>

    <div class="flex flex-col gap-3 sm:flex-row sm:justify-end">
      <Link
        :href="dailyStudy.session_id ? route('admin.daily_study_sessions.show', dailyStudy.session_id) : route('admin.daily_study_sessions.index')"
        class="shadow-theme-xs inline-flex items-center justify-center gap-2 rounded-lg bg-white px-4 py-3 text-sm font-medium text-gray-700 ring-1 ring-gray-300 transition hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-400 dark:ring-gray-700 dark:hover:bg-white/[0.03]"
      >
        {{ t('buttons.backToList') }}
      </Link>

      <Link
        :href="route('admin.daily_studies.edit', dailyStudy.id)"
        class="bg-brand-500 shadow-theme-xs hover:bg-brand-600 inline-flex items-center justify-center gap-2 rounded-lg px-4 py-3 text-sm font-medium text-white transition"
      >
        {{ t('buttons.edit') }}
      </Link>
    </div>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import { computed } from 'vue'
import { useI18n } from 'vue-i18n'
import { route } from '@/route'

const { t } = useI18n()

const props = defineProps({
  dailyStudy: { type: Object, required: true },
})

const attendanceLabel = computed(() => mapAttendance(props.dailyStudy?.attendance_status))

function displayValue(value) {
  if (value === 0) return 0
  if (value === null || value === undefined || value === '') return '—'
  return value
}

function displayText(value) {
  if (typeof value !== 'string') return displayValue(value)
  return value.trim().length ? value : '—'
}

function mapAttendance(value) {
  if (!value) return '—'
  const key = `daily_studies.attendance.${value}`
  const translated = t(key)
  return translated === key ? value : translated
}

function attendanceBadgeClass(value) {
  switch (value) {
    case 'present':
      return 'bg-green-50 text-green-600 dark:bg-green-500/15 dark:text-green-500'
    case 'absent':
      return 'bg-error-50 text-error-600 dark:bg-error-500/15 dark:text-error-500'
    case 'late':
    case 'late_in':
      return 'bg-amber-50 text-amber-600 dark:bg-amber-500/20 dark:text-amber-500'
    case 'excused':
      return 'bg-blue-50 text-blue-600 dark:bg-blue-500/15 dark:text-blue-400'
    case 'early_out':
      return 'bg-purple-50 text-purple-600 dark:bg-purple-500/15 dark:text-purple-400'
    default:
      return 'bg-gray-100 text-gray-600 dark:bg-white/10 dark:text-gray-400'
  }
}

function statusBadgeClass(isActive) {
  return isActive
    ? 'bg-green-50 text-green-600 dark:bg-green-500/15 dark:text-green-500'
    : 'bg-error-50 text-error-600 dark:bg-error-500/15 dark:text-error-500'
}
</script>
