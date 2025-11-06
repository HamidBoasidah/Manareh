<template>
  <div class="space-y-6">
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
      <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800">
        <h2 class="text-lg font-medium text-gray-800 dark:text-white">{{ t('nominations.nominationInformation') || t('nominations.showNomination') }}</h2>
      </div>

      <div class="p-4 sm:p-6">
        <div class="grid grid-cols-1 gap-x-5 gap-y-6 md:grid-cols-2">
          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-500 dark:text-gray-400">{{ t('nominations.fields.student') || t('daily_studies.student') }}</label>
            <p class="text-base text-gray-800 dark:text-white/90">{{ nomination.student_name || '—' }}</p>
          </div>

          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-500 dark:text-gray-400">{{ t('nominations.fields.circle') || t('daily_study_sessions.circle') }}</label>
            <p class="text-base text-gray-800 dark:text-white/90">{{ nomination.circle_name || '—' }}</p>
          </div>

          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-500 dark:text-gray-400">{{ t('nominations.type') }}</label>
            <p class="text-base text-gray-800 dark:text-white/90">{{ t('nominations.types.' + nomination.nomination_type) || nomination.nomination_type }}</p>
          </div>

          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-500 dark:text-gray-400">{{ t('nominations.fields.status') || t('common.status') }}</label>
            <p class="text-base text-gray-800 dark:text-white/90">{{ t('nominations.statuses.' + nomination.status) || nomination.status }}</p>
          </div>

          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-500 dark:text-gray-400">{{ t('nominations.fields.academic_year') || t('academicYears.academicYear') }}</label>
            <p class="text-base text-gray-800 dark:text-white/90">{{ nomination.academic_year_name || '—' }}</p>
          </div>

          <div class="md:col-span-2">
            <label class="mb-1.5 block text-sm font-medium text-gray-500 dark:text-gray-400">{{ t('common.notes') || t('common.notes') }}</label>
            <p class="text-base text-gray-800 dark:text-white/90">{{ nomination.notes || '—' }}</p>
          </div>
        </div>
      </div>
    </div>

    <div class="flex flex-col gap-3 sm:flex-row sm:justify-end">
      <Link :href="route('admin.nominations.index')" class="shadow-theme-xs inline-flex items-center justify-center gap-2 rounded-lg bg-white px-4 py-3 text-sm font-medium text-gray-700 ring-1 ring-gray-300 transition hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-400 dark:ring-gray-700 dark:hover:bg-white/[0.03]">{{ t('buttons.backToList') }}</Link>
      <Link :href="route('admin.nominations.edit', nomination.id)" class="bg-brand-500 shadow-theme-xs hover:bg-brand-600 inline-flex items-center justify-center gap-2 rounded-lg px-4 py-3 text-sm font-medium text-white transition">{{ t('buttons.edit') }}</Link>
    </div>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import { useI18n } from 'vue-i18n'
import { route } from '@/route'

const { t } = useI18n()

const props = defineProps({ nomination: { type: Object, required: true } })

function displayUser(user) {
  if (!user) return 'N/A'
  if (typeof user === 'object') return user.name || user.username || user.email || 'N/A'
  return user
}
</script>

<!-- Use Tailwind utility classes inline; avoid @apply in scoped styles -->
