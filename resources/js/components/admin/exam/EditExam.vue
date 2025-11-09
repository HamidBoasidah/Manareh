<template>
  <form class="space-y-6" @submit.prevent="update">
    <!-- Exam information -->
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
      <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800">
        <h2 class="text-lg font-medium text-gray-800 dark:text-white">{{ t('exams.editExam') }}</h2>
      </div>

      <div class="p-4 sm:p-6">
        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
          <!-- Exam type -->
          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">{{ t('exams.type') }}</label>
            <div class="relative z-20 bg-transparent">
              <select
                v-model="form.exam_type"
                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
              >
                <option value="stage">{{ t('exams.types.stage') }}</option>
                <option value="juzz">{{ t('exams.types.juzz') }}</option>
              </select>
              <span class="pointer-events-none absolute top-1/2 right-4 z-30 -translate-y-1/2 text-gray-700 dark:text-gray-400">
                <svg class="stroke-current" width="20" height="20" viewBox="0 0 20 20" fill="none">
                  <path d="M4.79175 7.396L10.0001 12.6043L15.2084 7.396" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
              </span>
            </div>
            <p v-if="form.errors.exam_type" class="mt-1 text-sm text-error-500">{{ form.errors.exam_type }}</p>
          </div>

          <!-- Part (stage/juzz) -->
          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">{{ t('exams.part') }}</label>
            <input
              v-model="computedPart"
              type="text"
              class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
            />
            <p v-if="form.errors.juzz || form.errors.stage" class="mt-1 text-sm text-error-500">{{ form.errors.juzz || form.errors.stage }}</p>
          </div>

          <!-- Date -->
          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">{{ t('exams.date') }}</label>
            <input
              v-model="form.exam_date_g"
              type="date"
              :class="{ 'text-gray-800 dark:text-white/90': form.exam_date_g }
                "
              class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700"
            />
            <p v-if="form.errors.exam_date_g" class="mt-1 text-sm text-error-500">{{ form.errors.exam_date_g }}</p>
          </div>

          <!-- Grade -->
          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">{{ t('exams.total_grade') }}</label>
            <input
              v-model="form.total_grade"
              type="text"
              :class="{ 'text-gray-800 dark:text-white/90': form.total_grade }
                "
              class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700"
            />
            <p v-if="form.errors.total_grade" class="mt-1 text-sm text-error-500">{{ form.errors.total_grade }}</p>
          </div>

          <!-- Remarks -->
          <div class="md:col-span-2">
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">{{ t('common.remarks') }}</label>
            <textarea
              v-model="form.remarks"
              rows="3"
              class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
            ></textarea>
            <p v-if="form.errors.remarks" class="mt-1 text-sm text-error-500">{{ form.errors.remarks }}</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Status / actions -->
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
      <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800">
        <h2 class="text-lg font-medium text-gray-800 dark:text-white">{{ t('common.status') }}</h2>
      </div>
      <div class="p-4 sm:p-6">
        <div class="flex flex-col justify-end">
          <label for="toggle-active" class="flex cursor-pointer select-none items-center gap-3 rounded-lg border border-transparent px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-400">
            <div class="relative">
              <input type="checkbox" id="toggle-active" class="sr-only" v-model="form.is_active" />
              <div class="block h-6 w-11 rounded-full" :class="form.is_active ? 'bg-brand-500 dark:bg-brand-500' : 'bg-gray-200 dark:bg-white/10'"></div>
              <div :class="form.is_active ? 'translate-x-full' : 'translate-x-0'" class="absolute left-0.5 top-0.5 h-5 w-5 rounded-full bg-white shadow-theme-sm duration-300 ease-linear"></div>
            </div>
            <span
              class="inline-flex items-center justify-center gap-1 rounded-full px-2.5 py-0.5 text-xs font-medium"
              :class="{
                'bg-green-50 text-green-600 dark:bg-green-500/15 dark:text-green-500': form.is_active,
                'bg-error-50 text-error-600 dark:bg-error-500/15 dark:text-error-500': !form.is_active,
              }"
            >
              {{ form.is_active ? t('common.active') : t('common.inactive') }}
            </span>
          </label>
        </div>
      </div>
    </div>

    <!-- Buttons -->
    <div class="flex flex-col gap-3 sm:flex-row sm:justify-end">
      <Link
        :href="route('admin.exams.index')"
        class="shadow-theme-xs inline-flex items-center justify-center gap-2 rounded-lg bg-white px-4 py-3 text-sm font-medium text-gray-700 ring-1 ring-gray-300 transition hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-400 dark:ring-gray-700 dark:hover:bg-white/[0.03]"
      >
        {{ t('buttons.backToList') }}
      </Link>

      <button
        @click="update"
        :class="{ 'cursor-not-allowed opacity-70': form.processing }"
        :disabled="form.processing"
        class="bg-brand-500 shadow-theme-xs hover:bg-brand-600 inline-flex items-center justify-center gap-2 rounded-lg px-4 py-3 text-sm font-medium text-white transition"
      >
        {{ form.processing ? t('common.loading') : t('buttons.update') }}
      </button>
    </div>
  </form>
</template>

<script setup>
import { Link, useForm } from '@inertiajs/vue3'
import { useI18n } from 'vue-i18n'
import { useNotifications } from '@/composables/useNotifications'
import { computed } from 'vue'
import { route } from '@/route'

const { t } = useI18n()
const { success, error } = useNotifications()

const props = defineProps({
  exam: { type: Object, required: true },
})

const form = useForm({
  _method: 'PUT',
  exam_type: props.exam.exam_type ?? 'stage',
  stage: props.exam.stage ?? null,
  juzz: props.exam.juzz ?? null,
  exam_date_g: props.exam.exam_date_g ?? null,
  total_grade: props.exam.total_grade ?? null,
  remarks: props.exam.remarks ?? null,
  is_active: !!props.exam.is_active,
})

const computedPart = computed({
  get() { return form.exam_type === 'stage' ? (form.stage ?? '') : (form.juzz ?? '') },
  set(val) { if (form.exam_type === 'stage') form.stage = val; else form.juzz = val }
})

function update() {
  form.post(route('admin.exams.update', props.exam.id), {
    preserveScroll: true,
    onSuccess: () => success(t('exams.examUpdatedSuccessfully') || t('messages.savedSuccessfully') || 'تم الحفظ'),
    onError: () => error(t('exams.examUpdateFailed') || t('messages.saveFailed') || 'فشل الحفظ'),
  })
}
</script>
