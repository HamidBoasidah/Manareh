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

          <!-- Activity media gallery -->
          <div class="md:col-span-2">
            <label class="mb-1.5 block text-sm font-medium text-gray-500 dark:text-gray-400">{{ t('activities.media') }}</label>
            <div v-if="activity.media && activity.media.length" class="mt-2 grid grid-cols-2 gap-3 sm:grid-cols-3 md:grid-cols-4">
              <div v-for="m in activity.media" :key="m.id" class="group relative overflow-hidden rounded-lg border border-gray-200 bg-gray-50 dark:border-gray-700 dark:bg-gray-800">
                <a :href="`/storage/${m.file_url}`" target="_blank" rel="noopener" class="block h-28 w-full">
                  <img :src="`/storage/${m.file_url}`" :alt="m.caption || 'media'" class="h-28 w-full object-cover" />
                </a>
                <div class="p-2 text-xs text-gray-700 dark:text-gray-200">
                  <div class="truncate">{{ m.caption || '' }}</div>
                </div>
              </div>
            </div>
            <p v-else class="text-sm text-gray-500 dark:text-gray-400">{{ t('activity_media.noActivityMedia') || '—' }}</p>
          </div>

          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-500 dark:text-gray-400">{{ t('common.status') }}</label>
            <span
              class="inline-flex items-center justify-center gap-1 rounded-full px-2.5 py-0.5 text-xs font-medium"
              :class="{
                'bg-green-50 text-green-600 dark:bg-green-500/15 dark:text-green-500': activity.is_active,
                'bg-error-50 text-error-600 dark:bg-error-500/15 dark:text-error-500': !activity.is_active,
              }"
            >
              {{ activity.is_active ? t('common.active') : t('common.inactive') }}
            </span>
          </div>
        </div>
      </div>
    </div>

    <div class="flex flex-col gap-3 sm:flex-row sm:justify-end">
      <Link
        :href="route('admin.activities.index')"
        class="shadow-theme-xs inline-flex items-center justify-center gap-2 rounded-lg bg-white px-4 py-3 text-sm font-medium text-gray-700 ring-1 ring-gray-300 transition hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-400 dark:ring-gray-700 dark:hover:bg-white/[0.03]"
      >
        {{ t('buttons.backToList') }}
      </Link>      
      <Link :href="route('admin.activities.edit', activity.id)" class="bg-brand-500 shadow-theme-xs hover:bg-brand-600 inline-flex items-center justify-center gap-2 rounded-lg px-4 py-3 text-sm font-medium text-white">{{ t('buttons.edit') }}</Link>
    </div>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import { useI18n } from 'vue-i18n'
import dayjs from 'dayjs'

const { t, locale } = useI18n()

const props = defineProps({ activity: Object })
const activity = props.activity

function formatDate(d) {
  if (!d) return '—'
  try {
    return dayjs(d).format('YYYY-MM-DD')
  } catch (e) {
    return d
  }
}
</script>
