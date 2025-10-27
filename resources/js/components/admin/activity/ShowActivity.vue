<template>
  <div class="space-y-6">
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
      <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800">
        <h2 class="text-lg font-medium text-gray-800 dark:text-white">{{ t('activities.activityInformation') }}</h2>
      </div>

      <div class="p-4 sm:p-6">
        <div class="grid grid-cols-1 gap-x-5 gap-y-6 md:grid-cols-2">
          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-500 dark:text-gray-400">{{ t('activities.title') }}</label>
            <p class="text-base text-gray-800 dark:text-white/90">{{ activity.title }}</p>
          </div>

          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-500 dark:text-gray-400">{{ t('activities.mosqueName') }}</label>
            <p class="text-base text-gray-800 dark:text-white/90">{{ activity.mosque_name || '—' }}</p>
          </div>

          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-500 dark:text-gray-400">{{ t('activities.place') }}</label>
            <p class="text-base text-gray-800 dark:text-white/90">{{ activity.place || '—' }}</p>
          </div>

          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-500 dark:text-gray-400">{{ t('activities.activityDate') }}</label>
            <p class="text-base text-gray-800 dark:text-white/90">{{ formatDate(activity.activity_date_g) }}</p>
          </div>

          <div class="md:col-span-2">
            <label class="mb-1.5 block text-sm font-medium text-gray-500 dark:text-gray-400">{{ t('activities.description') }}</label>
            <p class="text-base text-gray-800 dark:text-white/90">{{ activity.description || '—' }}</p>
          </div>

          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-500 dark:text-gray-400">{{ t('common.status') }}</label>
            <span class="inline-flex items-center justify-center gap-1 rounded-full px-2.5 py-0.5 text-xs font-medium" :class="activity.is_active ? 'bg-green-50 text-green-600' : 'bg-error-50 text-error-600'">{{ activity.is_active ? t('common.active') : t('common.inactive') }}</span>
          </div>
        </div>
      </div>
    </div>

    <div class="flex flex-col gap-3 sm:flex-row sm:justify-end">
      <Link :href="route('admin.activities.index')" class="shadow-theme-xs inline-flex items-center justify-center gap-2 rounded-lg bg-white px-4 py-3 text-sm font-medium text-gray-700 ring-1 ring-gray-300">{{ t('buttons.backToList') }}</Link>
      <Link :href="route('admin.activities.edit', activity.id)" class="bg-brand-500 shadow-theme-xs hover:bg-brand-600 inline-flex items-center justify-center gap-2 rounded-lg px-4 py-3 text-sm font-medium text-white">{{ t('buttons.edit') }}</Link>
    </div>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import { useI18n } from 'vue-i18n'
import dayjs from 'dayjs'

const { t } = useI18n()

const props = defineProps({ activity: Object })
const activity = props.activity

function formatDate(d) { if (!d) return '-'; try { return dayjs(d).format('YYYY-MM-DD') } catch (e) { return d } }
</script>
