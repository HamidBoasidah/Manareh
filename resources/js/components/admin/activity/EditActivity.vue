<template>
  <form class="space-y-6" @submit.prevent="update">
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
      <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800">
        <h2 class="text-lg font-medium text-gray-800 dark:text-white">
          {{ t('activities.activityInformation') }}
        </h2>
      </div>

      <div class="p-4 sm:p-6 dark:border-gray-800">
        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">{{ t('activities.title') }}</label>
            <input v-model="form.title" type="text" autocomplete="off" class="h-11 w-full rounded-lg border border-gray-300 px-4" />
            <p v-if="form.errors.title" class="mt-1 text-sm text-error-500">{{ form.errors.title }}</p>
          </div>

          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">{{ t('activities.place') }}</label>
            <input v-model="form.place" type="text" autocomplete="off" class="h-11 w-full rounded-lg border border-gray-300 px-4" />
            <p v-if="form.errors.place" class="mt-1 text-sm text-error-500">{{ form.errors.place }}</p>
          </div>

          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">{{ t('activities.activityDate') }}</label>
            <input v-model="form.activity_date_g" type="date" class="h-11 w-full rounded-lg border border-gray-300 px-4" />
            <p v-if="form.errors.activity_date_g" class="mt-1 text-sm text-error-500">{{ form.errors.activity_date_g }}</p>
          </div>

          <div class="md:col-span-2">
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">{{ t('activities.description') }}</label>
            <textarea v-model="form.description" rows="4" class="w-full rounded-lg border border-gray-300 px-4 py-2"></textarea>
            <p v-if="form.errors.description" class="mt-1 text-sm text-error-500">{{ form.errors.description }}</p>
          </div>
        </div>
      </div>
    </div>

    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
      <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800">
        <h2 class="text-lg font-medium text-gray-800 dark:text-white">{{ t('common.status') }}</h2>
      </div>
      <div class="p-4 sm:p-6">
        <label class="flex cursor-pointer select-none items-center gap-3 text-sm font-medium text-gray-700 dark:text-gray-400">
          <div class="relative">
            <input type="checkbox" class="sr-only" v-model="form.is_active" />
            <div class="block h-6 w-11 rounded-full" :class="form.is_active ? 'bg-brand-500' : 'bg-gray-200'"></div>
            <div :class="form.is_active ? 'translate-x-full' : 'translate-x-0'" class="absolute left-0.5 top-0.5 h-5 w-5 rounded-full bg-white"></div>
          </div>
          <span class="inline-flex items-center justify-center gap-1 rounded-full px-2.5 py-0.5 text-xs font-medium" :class="form.is_active ? 'bg-green-50 text-green-600' : 'bg-error-50 text-error-600'">{{ form.is_active ? t('common.active') : t('common.inactive') }}</span>
        </label>
      </div>
    </div>

    <div class="flex flex-col gap-3 sm:flex-row sm:justify-end">
      <Link :href="route('admin.activities.index')" class="shadow-theme-xs inline-flex items-center justify-center gap-2 rounded-lg bg-white px-4 py-3 text-sm font-medium text-gray-700 ring-1 ring-gray-300">{{ t('buttons.backToList') }}</Link>
      <button type="submit" class="bg-brand-500 shadow-theme-xs hover:bg-brand-600 inline-flex items-center justify-center gap-2 rounded-lg px-4 py-3 text-sm font-medium text-white" :disabled="form.processing">{{ form.processing ? t('common.loading') : t('buttons.update') }}</button>
    </div>
  </form>
</template>

<script setup>
import { Link, useForm } from '@inertiajs/vue3'
import { useI18n } from 'vue-i18n'
import { useNotifications } from '@/composables/useNotifications'

const { t } = useI18n()
const { success, error } = useNotifications()

const props = defineProps({ activity: Object, mosques: { type: Array, required: false } })

const form = useForm({ title: props.activity?.title ?? '', description: props.activity?.description ?? '', activity_date_g: props.activity?.activity_date_g ?? '', place: props.activity?.place ?? '', mosque_id: props.activity?.mosque_id ?? '', is_active: props.activity?.is_active ?? true })

function update() {
  form.put(route('admin.activities.update', props.activity.id), {
    onSuccess: () => success(t('activities.activityUpdatedSuccessfully')),
    onError: () => error(t('activities.activityUpdateFailed')),
  })
}
</script>
