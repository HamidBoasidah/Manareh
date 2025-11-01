<template>
  <form class="space-y-6" @submit.prevent="update">
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
      <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800">
        <h2 class="text-lg font-medium text-gray-800 dark:text-white">{{ t('daily_study_sessions.sessionInformation') }}</h2>
      </div>

      <div class="p-4 sm:p-6">
        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">{{ t('daily_study_sessions.circle') }}</label>
            <div class="relative z-20 bg-transparent">
              <select
                v-model="form.circle_id"
                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                :class="{ 'text-gray-800 dark:text-white/90': form.circle_id }"
              >
                <option value="" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">{{ t('daily_study_sessions.selectCircle') }}</option>
                <option v-for="circle in circles" :key="circle.id" :value="circle.id" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">
                  {{ circle.name }}
                </option>
              </select>
              <span class="pointer-events-none absolute top-1/2 right-4 -translate-y-1/2 text-gray-700 dark:text-gray-400">
                <svg class="stroke-current" width="20" height="20" viewBox="0 0 20 20" fill="none">
                  <path d="M4.79175 7.396L10.0001 12.6043L15.2084 7.396" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
              </span>
            </div>
            <p v-if="form.errors.circle_id" class="mt-1 text-sm text-error-500">{{ form.errors.circle_id }}</p>
          </div>

          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">{{ t('daily_study_sessions.sessionDateG') }}</label>
            <input
              v-model="form.session_date_g"
              type="date"
              class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
            />
            <p v-if="form.errors.session_date_g" class="mt-1 text-sm text-error-500">{{ form.errors.session_date_g }}</p>
          </div>

          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">{{ t('daily_study_sessions.sessionDateH') }}</label>
            <input
              v-model="form.session_date_h"
              type="text"
              :placeholder="t('daily_study_sessions.sessionDateHPlaceholder')"
              class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
            />
            <p v-if="form.errors.session_date_h" class="mt-1 text-sm text-error-500">{{ form.errors.session_date_h }}</p>
          </div>

          <div class="flex flex-col justify-end">
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">{{ t('common.status') }}</label>
            <label for="toggle-active" class="flex cursor-pointer select-none items-center gap-3 rounded-lg border border-transparent px-3 py-2 text-sm font-medium text-gray-700 transition hover:border-gray-200 dark:text-gray-400 dark:hover:border-gray-700">
              <div class="relative">
                <input id="toggle-active" type="checkbox" class="sr-only" v-model="form.is_active" />
                <div class="block h-6 w-11 rounded-full" :class="form.is_active ? 'bg-brand-500 dark:bg-brand-500' : 'bg-gray-200 dark:bg-white/10'"></div>
                <div :class="form.is_active ? 'translate-x-full' : 'translate-x-0'" class="absolute left-0.5 top-0.5 h-5 w-5 rounded-full bg-white shadow-theme-sm duration-300 ease-linear"></div>
              </div>
              <span class="inline-flex items-center justify-center gap-1 rounded-full px-2.5 py-0.5 text-xs font-medium" :class="form.is_active ? 'bg-green-50 text-green-600 dark:bg-green-500/15 dark:text-green-500' : 'bg-error-50 text-error-600 dark:bg-error-500/15 dark:text-error-500'">
                {{ form.is_active ? t('common.active') : t('common.inactive') }}
              </span>
            </label>
            <p v-if="form.errors.is_active" class="mt-1 text-sm text-error-500">{{ form.errors.is_active }}</p>
          </div>
        </div>
      </div>
    </div>

    <div class="flex flex-col gap-3 sm:flex-row sm:justify-end">
      <Link :href="route('admin.daily_study_sessions.index')" class="shadow-theme-xs inline-flex items-center justify-center gap-2 rounded-lg bg-white px-4 py-3 text-sm font-medium text-gray-700 ring-1 ring-gray-300 transition hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-400 dark:ring-gray-700 dark:hover:bg-white/[0.03]">
        {{ t('buttons.backToList') }}
      </Link>

      <button type="submit" class="bg-brand-500 shadow-theme-xs hover:bg-brand-600 inline-flex items-center justify-center gap-2 rounded-lg px-4 py-3 text-sm font-medium text-white transition" :class="{ 'cursor-not-allowed opacity-70': form.processing }" :disabled="form.processing">
        {{ form.processing ? t('common.loading') : t('buttons.update') }}
      </button>
    </div>
  </form>
</template>

<script setup>
import { Link, useForm } from '@inertiajs/vue3'
import { computed } from 'vue'
import { useI18n } from 'vue-i18n'
import { useNotifications } from '@/composables/useNotifications'
import { route } from '@/route'

const { t } = useI18n()
const { success, error } = useNotifications()

const props = defineProps({
  dailyStudySession: { type: Object, required: true },
  circles: { type: Array, default: () => [] },
})

const form = useForm({
  _method: 'PUT',
  circle_id: props.dailyStudySession?.circle_id ?? '',
  session_date_g: props.dailyStudySession?.session_date_g ?? '',
  session_date_h: props.dailyStudySession?.session_date_h ?? '',
  is_active: !!props.dailyStudySession?.is_active,
})

function update() {
  form.post(route('admin.daily_study_sessions.update', props.dailyStudySession.id), {
    onSuccess: () => {
      success(t('daily_study_sessions.dailyStudySessionUpdatedSuccessfully'))
    },
    onError: () => {
      error(t('daily_study_sessions.dailyStudySessionUpdateFailed'))
    },
    preserveScroll: true,
  })
}

const circles = computed(() => props.circles ?? [])
</script>
