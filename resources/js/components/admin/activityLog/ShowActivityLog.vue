<template>
  <div class="space-y-6">
    <ComponentCard>
      <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
        <div>
          <h3 class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">{{ t('activitylogs.id') }}</h3>
          <p class="text-sm text-gray-700 dark:text-gray-300">{{ activity.id }}</p>
        </div>

        <div>
          <h3 class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">{{ t('activitylogs.description') }}</h3>
          <p class="text-sm text-gray-700 dark:text-gray-300">{{ activity.description }}</p>
        </div>

        <div>
          <h3 class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">{{ t('activitylogs.event') }}</h3>
          <p class="text-sm text-gray-700 dark:text-gray-300">{{ activity.event }}</p>
        </div>

        <div>
          <h3 class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">{{ t('activitylogs.causer') }}</h3>
          <p class="text-sm text-gray-700 dark:text-gray-300">{{ activity.causer_name || ('ID: ' + activity.causer_id) }}</p>
        </div>

        <div>
          <h3 class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">{{ t('activitylogs.subjectType') }}</h3>
          <p class="text-sm text-gray-700 dark:text-gray-300">{{ activity.subject_type }}</p>
        </div>

        <div>
          <h3 class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">{{ t('activitylogs.subjectId') }}</h3>
          <p class="text-sm text-gray-700 dark:text-gray-300">{{ activity.subject_id }}</p>
        </div>

        <div class="sm:col-span-2">
          <h3 class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">{{ t('activitylogs.createdAt') }}</h3>
          <p class="text-sm text-gray-700 dark:text-gray-300">{{ activity.created_at }}</p>
        </div>

        <div class="sm:col-span-2">
          <h3 class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">{{ t('activitylogs.properties') }}</h3>
          <pre class="text-xs text-gray-700 dark:text-gray-300 bg-gray-50 dark:bg-gray-800 p-3 rounded overflow-x-auto">
{{ JSON.stringify(activity.properties, null, 2) }}
          </pre>
        </div>
      </div>
    </ComponentCard>

    <div class="flex items-center gap-2">
      <Link :href="route('admin.activitylogs.index')" class="btn-outline">{{ t('buttons.backToList') }}</Link>
      <Link :href="route('admin.activitylogs.destroy', { id: activity.id })" method="delete" class="btn-danger">
        {{ t('buttons.delete') }}
      </Link>
    </div>
  </div>
</template>

<script setup>
import ComponentCard from '@/components/common/ComponentCard.vue'
import { Link } from '@inertiajs/vue3'
import { useI18n } from 'vue-i18n'

const { t } = useI18n()

const props = defineProps({
  activity: { type: Object, required: true },
})
</script>
