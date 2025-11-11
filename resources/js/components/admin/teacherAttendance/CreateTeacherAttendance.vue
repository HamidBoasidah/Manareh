<template>
  <form class="space-y-6" @submit.prevent="create">
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
      <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800">
        <h2 class="text-lg font-medium text-gray-800 dark:text-white">
          {{ t('teacher_attendances.teacherAttendanceInformation') }}
        </h2>
      </div>

      <div class="p-4 sm:p-6">
        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
              {{ t('teacher_attendances.circle') }}
            </label>
            <div class="relative z-20 bg-transparent">
              <select
                v-model="form.circle_id"
                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                :class="{ 'text-gray-800 dark:text-white/90': form.circle_id }"
              >
                <option value="" disabled class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">
                  {{ t('teacher_attendances.selectCircle') }}
                </option>
                <option
                  v-for="circle in circles"
                  :key="circle.id"
                  :value="circle.id"
                  class="text-gray-700 dark:bg-gray-900 dark:text-gray-400"
                >
                  {{ circle.name }}
                </option>
              </select>
              <span class="pointer-events-none absolute top-1/2 right-4 z-30 -translate-y-1/2 text-gray-700 dark:text-gray-400">
                <svg class="stroke-current" width="20" height="20" viewBox="0 0 20 20" fill="none">
                  <path d="M4.79175 7.396L10.0001 12.6043L15.2084 7.396" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
              </span>
            </div>
            <p v-if="form.errors.circle_id" class="mt-1 text-sm text-error-500">{{ form.errors.circle_id }}</p>
          </div>

          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
              {{ t('teacher_attendances.teacher') }}
            </label>
            <div class="relative z-20 bg-transparent">
              <select
                v-model="form.user_id"
                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                :class="{ 'text-gray-800 dark:text-white/90': form.user_id }"
              >
                <option value="" disabled class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">
                  {{ t('teacher_attendances.selectTeacher') }}
                </option>
                <option
                  v-for="teacher in teachers"
                  :key="teacher.id"
                  :value="teacher.id"
                  class="text-gray-700 dark:bg-gray-900 dark:text-gray-400"
                >
                  {{ teacher.name }}
                </option>
              </select>
              <span class="pointer-events-none absolute top-1/2 right-4 z-30 -translate-y-1/2 text-gray-700 dark:text-gray-400">
                <svg class="stroke-current" width="20" height="20" viewBox="0 0 20 20" fill="none">
                  <path d="M4.79175 7.396L10.0001 12.6043L15.2084 7.396" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
              </span>
            </div>
            <p v-if="form.errors.user_id" class="mt-1 text-sm text-error-500">{{ form.errors.user_id }}</p>
          </div>

          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
              {{ t('teacher_attendances.dateG') }}
            </label>
            <input
              v-model="form.date_g"
              type="date"
              class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
            />
            <p v-if="form.errors.date_g" class="mt-1 text-sm text-error-500">{{ form.errors.date_g }}</p>
          </div>

          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
              {{ t('teacher_attendances.dateH') }}
            </label>
            <input
              v-model="form.date_h"
              type="text"
              class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
              :placeholder="t('teacher_attendances.dateH')"
            />
            <p v-if="form.errors.date_h" class="mt-1 text-sm text-error-500">{{ form.errors.date_h }}</p>
          </div>

          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
              {{ t('teacher_attendances.status') }}
            </label>
            <div class="relative z-20 bg-transparent">
              <select
                v-model="form.status"
                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                :class="{ 'text-gray-800 dark:text-white/90': form.status }"
              >
                <option value="" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">
                  {{ t('teacher_attendances.selectStatus') }}
                </option>
                <option
                  v-for="option in statusOptions"
                  :key="option.value"
                  :value="option.value"
                  class="text-gray-700 dark:bg-gray-900 dark:text-gray-400"
                >
                  {{ option.label }}
                </option>
              </select>
              <span class="pointer-events-none absolute top-1/2 right-4 z-30 -translate-y-1/2 text-gray-700 dark:text-gray-400">
                <svg class="stroke-current" width="20" height="20" viewBox="0 0 20 20" fill="none">
                  <path d="M4.79175 7.396L10.0001 12.6043L15.2084 7.396" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
              </span>
            </div>
            <p v-if="form.errors.status" class="mt-1 text-sm text-error-500">{{ form.errors.status }}</p>
          </div>

          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
              {{ t('teacher_attendances.recordedBy') }}
            </label>
            <div class="relative z-20 bg-transparent">
              <select
                v-model="form.recorded_by"
                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                :class="{ 'text-gray-800 dark:text-white/90': form.recorded_by }"
              >
                <option value="" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">
                  {{ t('teacher_attendances.selectRecorder') }}
                </option>
                <option
                  v-for="recorder in recorders"
                  :key="recorder.id"
                  :value="recorder.id"
                  class="text-gray-700 dark:bg-gray-900 dark:text-gray-400"
                >
                  {{ recorder.name }}
                </option>
              </select>
              <span class="pointer-events-none absolute top-1/2 right-4 z-30 -translate-y-1/2 text-gray-700 dark:text-gray-400">
                <svg class="stroke-current" width="20" height="20" viewBox="0 0 20 20" fill="none">
                  <path d="M4.79175 7.396L10.0001 12.6043L15.2084 7.396" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
              </span>
            </div>
            <p v-if="form.errors.recorded_by" class="mt-1 text-sm text-error-500">{{ form.errors.recorded_by }}</p>
          </div>

          <div class="md:col-span-2">
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
              {{ t('teacher_attendances.notes') }}
            </label>
            <textarea
              v-model="form.notes"
              rows="3"
              class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
            />
            <p v-if="form.errors.notes" class="mt-1 text-sm text-error-500">{{ form.errors.notes }}</p>
          </div>
        </div>
      </div>
    </div>

    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
      <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800">
        <h2 class="text-lg font-medium text-gray-800 dark:text-white">{{ t('common.status') }}</h2>
      </div>
      <div class="p-4 sm:p-6">
        <label for="toggle-active" class="flex cursor-pointer select-none items-center gap-3 text-sm font-medium text-gray-700 dark:text-gray-400">
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

    <div class="flex flex-col gap-3 sm:flex-row sm:justify-end">
      <Link
        :href="route('admin.teacher_attendances.index')"
        class="shadow-theme-xs inline-flex items-center justify-center gap-2 rounded-lg bg-white px-4 py-3 text-sm font-medium text-gray-700 ring-1 ring-gray-300 transition hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-400 dark:ring-gray-700 dark:hover:bg-white/[0.03]"
      >
        {{ t('buttons.backToList') }}
      </Link>

      <button
        type="submit"
        class="bg-brand-500 shadow-theme-xs hover:bg-brand-600 inline-flex items-center justify-center gap-2 rounded-lg px-4 py-3 text-sm font-medium text-white transition"
        :class="{ 'cursor-not-allowed opacity-70': form.processing }"
        :disabled="form.processing"
      >
        {{ form.processing ? t('common.loading') : t('buttons.create') }}
      </button>
    </div>
  </form>
</template>

<script setup>
import { Link, useForm } from '@inertiajs/vue3'
import { computed, watch } from 'vue'
import { useI18n } from 'vue-i18n'
import { useNotifications } from '@/composables/useNotifications'

const { t } = useI18n()
const { success, error } = useNotifications()

const props = defineProps({
  circles: { type: Array, default: () => [] },
  teachers: { type: Array, default: () => [] },
  recorders: { type: Array, default: () => [] },
  defaultStatus: { type: String, default: 'present' },
  currentUserId: { type: [Number, String, null], default: null },
  defaultIsActive: { type: Boolean, default: true },
})

const statusKeys = ['present', 'absent', 'excused', 'late_in', 'early_out', 'half_day', 'on_leave', 'sick']
const statusOptions = computed(() =>
  statusKeys.map((value) => ({
    value,
    label: t(`teacher_attendances.statusLabels.${value}`),
  }))
)

const defaultCircleId = computed(() => props.circles?.[0]?.id ?? '')
const defaultTeacherId = computed(() => props.teachers?.[0]?.id ?? '')

const form = useForm({
  circle_id: '',
  user_id: '',
  date_g: '',
  date_h: '',
  status: props.defaultStatus || '',
  notes: '',
  recorded_by: props.currentUserId ?? '',
  is_active: props.defaultIsActive,
})

watch(defaultCircleId, (newVal) => {
  if (!form.circle_id && newVal) {
    form.circle_id = newVal
  }
}, { immediate: true })

watch(defaultTeacherId, (newVal) => {
  if (!form.user_id && newVal) {
    form.user_id = newVal
  }
}, { immediate: true })

watch(() => props.currentUserId, (newVal) => {
  if (newVal !== null && newVal !== undefined) {
    form.recorded_by = newVal
  } else {
    form.recorded_by = ''
  }
}, { immediate: true })

function create() {
  form.post(route('admin.teacher_attendances.store'), {
    onSuccess: () => {
      success(t('teacher_attendances.teacherAttendanceCreatedSuccessfully'))
      const keepStatus = form.status
      form.reset()
      form.is_active = props.defaultIsActive
      form.status = keepStatus
  form.recorded_by = props.currentUserId ?? ''
      form.circle_id = defaultCircleId.value || ''
      form.user_id = defaultTeacherId.value || ''
    },
    onError: () => {
      error(t('teacher_attendances.teacherAttendanceCreationFailed'))
    },
    preserveScroll: true,
  })
}
</script>
