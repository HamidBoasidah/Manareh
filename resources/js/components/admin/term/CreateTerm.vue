<template>
  <form class="space-y-6" @submit.prevent="submit">
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
      <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800">
        <h2 class="text-lg font-medium text-gray-800 dark:text-white">{{ t('terms.termInformation') }}</h2>
      </div>

      <div class="p-4 sm:p-6">
        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
          <div class="md:col-span-2">
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">{{ t('academicYears.academicYear') }}</label>
            <div class="relative z-10">
              <select
                v-model="form.academic_year_id"
                class="h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent px-4 pr-11 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:focus:border-brand-800"
              >
                <option value="" disabled class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">{{ t('terms.selectAcademicYear') }}</option>
                <option v-for="year in academicYears" :key="year.id" :value="year.id" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">
                  {{ year.name }}
                </option>
              </select>
              <span class="pointer-events-none absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 dark:text-gray-400">
                <svg class="stroke-current" width="20" height="20" viewBox="0 0 20 20" fill="none">
                  <path d="M4.792 7.396 10 12.604l5.208-5.208" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
              </span>
            </div>
            <p v-if="form.errors.academic_year_id" class="mt-1 text-sm text-error-500">{{ form.errors.academic_year_id }}</p>
          </div>

          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">{{ t('terms.name') }}</label>
            <input
              v-model="form.name"
              type="text"
              class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800"
              :placeholder="t('terms.namePlaceholder')"
            />
            <p v-if="form.errors.name" class="mt-1 text-sm text-error-500">{{ form.errors.name }}</p>
          </div>

          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">{{ t('terms.startDateG') }}</label>
            <input
              v-model="form.start_date_g"
              type="date"
              class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:focus:border-brand-800"
            />
            <p v-if="form.errors.start_date_g" class="mt-1 text-sm text-error-500">{{ form.errors.start_date_g }}</p>
          </div>

          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">{{ t('terms.endDateG') }}</label>
            <input
              v-model="form.end_date_g"
              type="date"
              class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:focus:border-brand-800"
            />
            <p v-if="form.errors.end_date_g" class="mt-1 text-sm text-error-500">{{ form.errors.end_date_g }}</p>
          </div>

          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">{{ t('terms.startDateH') }}</label>
            <input
              v-model="form.start_date_h"
              type="text"
              class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800"
              :placeholder="t('terms.startDateHPlaceholder')"
            />
            <p v-if="form.errors.start_date_h" class="mt-1 text-sm text-error-500">{{ form.errors.start_date_h }}</p>
          </div>

          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">{{ t('terms.endDateH') }}</label>
            <input
              v-model="form.end_date_h"
              type="text"
              class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800"
              :placeholder="t('terms.endDateHPlaceholder')"
            />
            <p v-if="form.errors.end_date_h" class="mt-1 text-sm text-error-500">{{ form.errors.end_date_h }}</p>
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
            <div class="block h-6 w-11 rounded-full" :class="form.is_active ? 'bg-brand-500 dark:bg-brand-500' : 'bg-gray-200 dark:bg-white/10'"></div>
            <div :class="form.is_active ? 'translate-x-full' : 'translate-x-0'" class="absolute left-0.5 top-0.5 h-5 w-5 rounded-full bg-white shadow-theme-sm duration-300 ease-linear"></div>
          </div>
          <span
            class="inline-flex items-center justify-center gap-1 rounded-full px-2.5 py-0.5 text-xs font-medium"
            :class="form.is_active ? 'bg-green-50 text-green-600 dark:bg-green-500/15 dark:text-green-500' : 'bg-error-50 text-error-600 dark:bg-error-500/15 dark:text-error-500'"
          >
            {{ form.is_active ? t('common.active') : t('common.inactive') }}
          </span>
        </label>
      </div>
    </div>

    <div class="flex flex-col gap-3 sm:flex-row sm:justify-end">
      <Link
        :href="route('admin.terms.index')"
        class="inline-flex items-center justify-center gap-2 rounded-lg bg-white px-4 py-3 text-sm font-medium text-gray-700 ring-1 ring-gray-300 transition hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-400 dark:ring-gray-700 dark:hover:bg-white/[0.03]"
      >
        {{ t('buttons.backToList') }}
      </Link>
      <button
        type="submit"
        class="inline-flex items-center justify-center gap-2 rounded-lg bg-brand-500 px-4 py-3 text-sm font-medium text-white shadow-theme-xs transition hover:bg-brand-600 disabled:cursor-not-allowed disabled:opacity-70"
        :disabled="form.processing"
      >
        {{ form.processing ? t('common.loading') : t('buttons.save') }}
      </button>
    </div>
  </form>
</template>

<script setup>
import { Link, useForm } from '@inertiajs/vue3'
import { useI18n } from 'vue-i18n'
import { useNotifications } from '@/composables/useNotifications'

const { t } = useI18n()
const { success, error } = useNotifications()

const props = defineProps({ academicYears: { type: Array, required: true } })

const form = useForm({
  academic_year_id: '',
  name: '',
  start_date_g: '',
  end_date_g: '',
  start_date_h: '',
  end_date_h: '',
  is_active: true,
})

function submit() {
  form.post(route('admin.terms.store'), {
    preserveScroll: true,
    onSuccess: () => success(t('terms.termCreatedSuccessfully')),
    onError: () => error(t('terms.termCreationFailed')),
  })
}

const academicYears = props.academicYears
</script>
