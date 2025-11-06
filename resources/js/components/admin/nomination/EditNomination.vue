<template>
  <form class="space-y-6" @submit.prevent="update">
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
      <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800">
        <h2 class="text-lg font-medium text-gray-800 dark:text-white">{{ t('nominations.nominationInformation') }}</h2>
      </div>

      <div class="p-4 sm:p-6 dark:border-gray-800">
        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
          <!-- Student -->
          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">{{ t('nominations.fields.student') }}</label>
            <div class="relative z-20 bg-transparent">
              <select
                v-model="form.student_id"
                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                :class="{ 'text-gray-800 dark:text-white/90': form.student_id }"
              >
                <option value="" disabled class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">{{ t('nominations.selectStudent') }}</option>
                <option v-for="s in students" :key="s.id" :value="s.id" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">{{ s.name }}</option>
              </select>
              <span class="pointer-events-none absolute top-1/2 right-4 z-30 -translate-y-1/2 text-gray-700 dark:text-gray-400">
                <svg class="stroke-current" width="20" height="20" viewBox="0 0 20 20" fill="none">
                  <path d="M4.79175 7.396L10.0001 12.6043L15.2084 7.396" stroke="" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
              </span>
            </div>
            <p v-if="form.errors.student_id" class="mt-1 text-sm text-error-500">{{ form.errors.student_id }}</p>
          </div>

          <!-- Circle (display only, derived from selected student) -->
          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">{{ t('nominations.fields.circle') }}</label>
            <p class="text-base text-gray-800 dark:text-white/90">{{ selectedStudentCircleName || props.nomination.circle_name || '—' }}</p>
            <p v-if="form.errors.circle_id" class="mt-1 text-sm text-error-500">{{ form.errors.circle_id }}</p>
          </div>

          <!-- Nomination type -->
          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">{{ t('nominations.type') }}</label>
            <div class="relative z-20 bg-transparent">
              <select
                v-model="form.nomination_type"
                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                :class="{ 'text-gray-800 dark:text-white/90': form.nomination_type }"
              >
                <option value="" disabled class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">{{ t('nominations.selectType') }}</option>
                <option v-for="opt in nominationTypes" :key="opt.value" :value="opt.value" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">{{ t('nominations.types.' + opt.value) || opt.label || opt.value }}</option>
              </select>
              <span class="pointer-events-none absolute top-1/2 right-4 z-30 -translate-y-1/2 text-gray-700 dark:text-gray-400">
                <svg class="stroke-current" width="20" height="20" viewBox="0 0 20 20" fill="none">
                  <path d="M4.79175 7.396L10.0001 12.6043L15.2084 7.396" stroke="" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
              </span>
            </div>
            <p v-if="form.errors.nomination_type" class="mt-1 text-sm text-error-500">{{ form.errors.nomination_type }}</p>
          </div>

          <!-- Supervisor-specific exam fields -->
          <div v-if="form.nomination_type === 'supervisor_nomination'">
            <!-- Exam type -->
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">{{ t('nominations.examType') || 'Exam type' }}</label>
            <div class="relative z-20 bg-transparent">
              <select
                v-model="form.exam_type"
                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                :class="{ 'text-gray-800 dark:text-white/90': form.exam_type }"
              >
                <option value="" disabled class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">{{ t('nominations.selectExamType') || '--' }}</option>
                <option value="stage">{{ t('exams.types.stage') || 'Stage' }}</option>
                <option value="juzz">{{ t('exams.types.juzz') || 'Juzz' }}</option>
              </select>
              <span class="pointer-events-none absolute top-1/2 right-4 z-30 -translate-y-1/2 text-gray-700 dark:text-gray-400">
                <svg class="stroke-current" width="20" height="20" viewBox="0 0 20 20" fill="none">
                  <path d="M4.79175 7.396L10.0001 12.6043L15.2084 7.396" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
              </span>
            </div>
            <p v-if="form.errors.exam_type" class="mt-1 text-sm text-error-500">{{ form.errors.exam_type }}</p>

            <!-- Exam part -->
            <div class="mt-4">
              <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">{{ t('nominations.examPart') || 'Exam part' }}</label>
              <div class="relative z-20 bg-transparent">
                <select
                  v-model="form.exam_part"
                  class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                  :class="{ 'text-gray-800 dark:text-white/90': form.exam_part }"
                >
                  <option value="" disabled class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">{{ t('nominations.selectExamPart') || '--' }}</option>
                  <option v-for="n in examParts" :key="n" :value="n" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">{{ examTypeLabel(form.exam_type) + ' ' + n }}</option>
                </select>
                <span class="pointer-events-none absolute top-1/2 right-4 z-30 -translate-y-1/2 text-gray-700 dark:text-gray-400">
                  <svg class="stroke-current" width="20" height="20" viewBox="0 0 20 20" fill="none">
                    <path d="M4.79175 7.396L10.0001 12.6043L15.2084 7.396" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                  </svg>
                </span>
              </div>
              <p v-if="form.errors.exam_part" class="mt-1 text-sm text-error-500">{{ form.errors.exam_part }}</p>
            </div>
          </div>

          <!-- Academic year -->
          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">{{ t('nominations.fields.academic_year') }}</label>
            <div class="relative z-20 bg-transparent">
              <select
                v-model="form.academic_year_id"
                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                :class="{ 'text-gray-800 dark:text-white/90': form.academic_year_id }"
              >
                <option value="" disabled class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">{{ t('nominations.selectAcademicYear') }}</option>
                <option v-for="p in plans" :key="p.id" :value="p.id" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">{{ p.name }}</option>
              </select>
              <span class="pointer-events-none absolute top-1/2 right-4 z-30 -translate-y-1/2 text-gray-700 dark:text-gray-400">
                <svg class="stroke-current" width="20" height="20" viewBox="0 0 20 20" fill="none">
                  <path d="M4.79175 7.396L10.0001 12.6043L15.2084 7.396" stroke="" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
              </span>
            </div>
            <p v-if="form.errors.academic_year_id" class="mt-1 text-sm text-error-500">{{ form.errors.academic_year_id }}</p>
          </div>

          <!-- Term -->
          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">{{ t('nominations.term') }}</label>
            <div class="relative z-20 bg-transparent">
              <select
                v-model="form.term_id"
                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                :class="{ 'text-gray-800 dark:text-white/90': form.term_id }"
              >
                <option value="" disabled class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">{{ t('nominations.selectTerm') }}</option>
                <option v-for="t in terms" :key="t.id" :value="t.id" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">{{ t.name }}</option>
              </select>
              <span class="pointer-events-none absolute top-1/2 right-4 z-30 -translate-y-1/2 text-gray-700 dark:text-gray-400">
                <svg class="stroke-current" width="20" height="20" viewBox="0 0 20 20" fill="none">
                  <path d="M4.79175 7.396L10.0001 12.6043L15.2084 7.396" stroke="" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
              </span>
            </div>
            <p v-if="form.errors.term_id" class="mt-1 text-sm text-error-500">{{ form.errors.term_id }}</p>
          </div>

          <!-- Nominated by -->
          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">{{ t('nominations.fields.nominatedBy') }}</label>
            <div class="relative z-20 bg-transparent">
              <select
                v-model="form.nominated_by"
                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                :class="{ 'text-gray-800 dark:text-white/90': form.nominated_by }"
              >
                <option value="" disabled class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">{{ t('nominations.selectNominator') }}</option>
                <option v-for="n in nominators" :key="n.id" :value="n.id" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">{{ n.name }}</option>
              </select>
              <span class="pointer-events-none absolute top-1/2 right-4 z-30 -translate-y-1/2 text-gray-700 dark:text-gray-400">
                <svg class="stroke-current" width="20" height="20" viewBox="0 0 20 20" fill="none">
                  <path d="M4.79175 7.396L10.0001 12.6043L15.2084 7.396" stroke="" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
              </span>
            </div>
            <p v-if="form.errors.nominated_by" class="mt-1 text-sm text-error-500">{{ form.errors.nominated_by }}</p>
          </div>

          <!-- Notes -->
          <div class="md:col-span-2">
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">{{ t('common.notes') }}</label>
            <textarea
              v-model="form.notes"
              rows="4"
              class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
            ></textarea>
            <p v-if="form.errors.notes" class="mt-1 text-sm text-error-500">{{ form.errors.notes }}</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Status -->
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
      <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800">
        <h2 class="text-lg font-medium text-gray-800 dark:text-white">{{ t('common.status') }}</h2>
      </div>
      <div class="p-4 sm:p-6">
        <div class="flex flex-col justify-end">
          <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">{{ t('common.status') }}</label>
          <label for="toggle-active" class="flex cursor-pointer select-none items-center gap-3 rounded-lg border border-transparent px-3 py-2 text-sm font-medium text-gray-700 transition hover:border-gray-200 dark:text-gray-400 dark:hover:border-gray-700">
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
          <p v-if="form.errors.is_active" class="mt-1 text-sm text-error-500">{{ form.errors.is_active }}</p>
        </div>
      </div>
    </div>

    <!-- Actions -->
    <div class="flex flex-col gap-3 sm:flex-row sm:justify-end">
      <Link :href="route('admin.nominations.index')" class="shadow-theme-xs inline-flex items-center justify-center gap-2 rounded-lg bg-white px-4 py-3 text-sm font-medium text-gray-700 ring-1 ring-gray-300 transition hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-400 dark:ring-gray-700">{{ t('buttons.backToList') }}</Link>
      <button type="submit" class="bg-brand-500 shadow-theme-xs hover:bg-brand-600 inline-flex items-center justify-center gap-2 rounded-lg px-4 py-3 text-sm font-medium text-white transition" :class="{ 'cursor-not-allowed opacity-70': form.processing }" :disabled="form.processing">{{ form.processing ? t('common.loading') : t('buttons.update') }}</button>
    </div>
  </form>
</template>

<script setup>
import { Link, useForm } from '@inertiajs/vue3'
import { watch, computed } from 'vue'
import { useI18n } from 'vue-i18n'
import { useNotifications } from '@/composables/useNotifications'

const { t, locale } = useI18n()
const { success, error } = useNotifications()

const props = defineProps({
  nomination: { type: Object, required: true },
  students: { type: Array, default: () => [] },
  plans: { type: Array, default: () => [] },
  terms: { type: Array, default: () => [] },
  nominators: { type: Array, default: () => [] },
  nominationTypes: { type: Array, default: () => [] },
  nominationStatuses: { type: Array, default: () => [] },
})

const form = useForm({
  _method: 'PUT',
  student_id: props.nomination.student_id ?? '',
  circle_id: props.nomination.circle_id ?? '',
  nomination_type: props.nomination.nomination_type ?? '',
  // exam info for supervisor nominations
  exam_type: props.nomination.exam_type ?? '',
  exam_part: props.nomination.exam_part ?? '',
  academic_year_id: props.nomination.academic_year_id ?? '',
  status: props.nomination.status ?? 'submitted',
  term_id: props.nomination.term_id ?? '',
  nominated_by: props.nomination.nominated_by ?? '',
  notes: props.nomination.notes ?? '',
  is_active: !!props.nomination.is_active,
})

function update() {
  form.post(route('admin.nominations.update', props.nomination.id), {
    onSuccess: () => success(t('nominations.updatedSuccessfully')),
    onError: () => error(t('nominations.updateFailed')),
    preserveScroll: true,
  })
}

/* delete functionality removed intentionally */

// Auto-fill circle when student selection changes (respect existing mapping from server)
watch(() => form.student_id, (val) => {
  const student = props.students.find((s) => String(s.id) === String(val))
  if (student && student.circle_id) {
    form.circle_id = student.circle_id
  }
})

// computed helper for selected student's circle name (used in template)
const selectedStudentCircleName = computed(() => {
  const sid = form.student_id
  const s = props.students.find((x) => String(x.id) === String(sid))
  return s ? (s.circle_name || '') : ''
})

// list of parts depending on exam_type
const examParts = computed(() => {
  if (!form.exam_type) return []
  if (form.exam_type === 'stage') return Array.from({ length: 10 }, (_, i) => i + 1)
  if (form.exam_type === 'juzz') return Array.from({ length: 30 }, (_, i) => i + 1)
  return []
})

// helper to get exam type label with Arabic fallback when translation missing
function examTypeLabel(key) {
  if (!key) return ''
  const label = t('exams.types.' + key)
  if (label && label !== 'exams.types.' + key) return label
  return key === 'stage' ? 'اختبار مرحلة' : 'اختبار جزء'
}

// if nomination type changes away from supervisor_nomination, clear exam fields
watch(() => form.nomination_type, (val) => {
  if (val !== 'supervisor_nomination') {
    form.exam_type = ''
    form.exam_part = ''
  }
})

// when exam_type changes, clear exam_part
watch(() => form.exam_type, () => {
  form.exam_part = ''
})
</script>
