<template>
  <form class="space-y-6" @submit.prevent="update">
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
      <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800">
        <h2 class="text-lg font-medium text-gray-800 dark:text-white">
          {{ t('daily_studies.dailyStudyInformation') }}
        </h2>
      </div>

      <div class="p-4 sm:p-6">
        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
              {{ t('daily_studies.session') }}
            </label>
            <input
              :value="dailyStudy.session_id ?? '—'"
              type="text"
              class="h-11 w-full cursor-not-allowed rounded-lg border border-gray-200 bg-gray-50 px-4 text-sm text-gray-600 shadow-theme-xs dark:border-gray-700 dark:bg-white/5 dark:text-gray-400"
              disabled
            />
          </div>

          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
              {{ t('daily_studies.student') }}
            </label>
            <input
              :value="dailyStudy.student_name ?? '—'"
              type="text"
              class="h-11 w-full cursor-not-allowed rounded-lg border border-gray-200 bg-gray-50 px-4 text-sm text-gray-600 shadow-theme-xs dark:border-gray-700 dark:bg-white/5 dark:text-gray-400"
              disabled
            />
          </div>

          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
              {{ t('daily_studies.attendanceStatus') }}
            </label>
            <div class="relative z-20 bg-transparent">
              <select
                v-model="form.attendance_status"
                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
              >
                <option
                  v-for="option in attendanceOptions"
                  :key="option.value"
                  :value="option.value"
                  class="text-gray-700 dark:bg-gray-900 dark:text-gray-300"
                >
                  {{ option.label }}
                </option>
              </select>
              <span class="pointer-events-none absolute top-1/2 right-4 -translate-y-1/2 text-gray-700 dark:text-gray-400">
                <svg class="stroke-current" width="20" height="20" viewBox="0 0 20 20" fill="none">
                  <path d="M4.79175 7.396L10.0001 12.6043L15.2084 7.396" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
              </span>
            </div>
            <p v-if="form.errors.attendance_status" class="mt-1 text-sm text-error-500">{{ form.errors.attendance_status }}</p>
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

          <div class="md:col-span-2">
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
              {{ t('daily_studies.notes') }}
            </label>
            <textarea
              v-model="form.notes"
              rows="4"
              class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-3 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
              :placeholder="t('daily_studies.notes')"
            ></textarea>
            <p v-if="form.errors.notes" class="mt-1 text-sm text-error-500">{{ form.errors.notes }}</p>
          </div>
        </div>
      </div>
    </div>

    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
      <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800">
        <h2 class="text-lg font-medium text-gray-800 dark:text-white">
          {{ t('daily_studies.hifzSection') }}
        </h2>
      </div>

      <div class="p-4 sm:p-6">
        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
              {{ t('daily_studies.hifzFromSura') }}
            </label>
            <div class="relative z-20 bg-transparent">
              <select
                v-model="form.hifz_from_sura_id"
                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
              >
                <option value="">{{ t('daily_studies.selectSura') }}</option>
                <option
                  v-for="option in suraOptions"
                  :key="option.value"
                  :value="option.value"
                  class="text-gray-700 dark:bg-gray-900 dark:text-gray-300"
                >
                  {{ option.label }}
                </option>
              </select>
              <span class="pointer-events-none absolute top-1/2 right-4 -translate-y-1/2 text-gray-700 dark:text-gray-400">
                <svg class="stroke-current" width="20" height="20" viewBox="0 0 20 20" fill="none">
                  <path d="M4.79175 7.396L10.0001 12.6043L15.2084 7.396" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
              </span>
            </div>
            <p v-if="form.errors.hifz_from_sura_id" class="mt-1 text-sm text-error-500">{{ form.errors.hifz_from_sura_id }}</p>
          </div>

          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
              {{ t('daily_studies.hifzFromAyah') }}
            </label>
            <input
              v-model.number="form.hifz_from_ayah"
              type="number"
              min="1"
              class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
              :placeholder="t('daily_studies.hifzFromAyah')"
            />
            <p v-if="form.errors.hifz_from_ayah" class="mt-1 text-sm text-error-500">{{ form.errors.hifz_from_ayah }}</p>
          </div>

          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
              {{ t('daily_studies.hifzToSura') }}
            </label>
            <div class="relative z-20 bg-transparent">
              <select
                v-model="form.hifz_to_sura_id"
                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
              >
                <option value="">{{ t('daily_studies.selectSura') }}</option>
                <option
                  v-for="option in suraOptions"
                  :key="option.value"
                  :value="option.value"
                  class="text-gray-700 dark:bg-gray-900 dark:text-gray-300"
                >
                  {{ option.label }}
                </option>
              </select>
              <span class="pointer-events-none absolute top-1/2 right-4 -translate-y-1/2 text-gray-700 dark:text-gray-400">
                <svg class="stroke-current" width="20" height="20" viewBox="0 0 20 20" fill="none">
                  <path d="M4.79175 7.396L10.0001 12.6043L15.2084 7.396" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
              </span>
            </div>
            <p v-if="form.errors.hifz_to_sura_id" class="mt-1 text-sm text-error-500">{{ form.errors.hifz_to_sura_id }}</p>
          </div>

          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
              {{ t('daily_studies.hifzToAyah') }}
            </label>
            <input
              v-model.number="form.hifz_to_ayah"
              type="number"
              min="1"
              class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
              :placeholder="t('daily_studies.hifzToAyah')"
            />
            <p v-if="form.errors.hifz_to_ayah" class="mt-1 text-sm text-error-500">{{ form.errors.hifz_to_ayah }}</p>
          </div>

          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
              {{ t('daily_studies.hifzPages') }}
            </label>
            <input
              v-model.number="form.hifz_pages"
              type="number"
              min="0"
              class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
              :placeholder="t('daily_studies.hifzPages')"
            />
            <p v-if="form.errors.hifz_pages" class="mt-1 text-sm text-error-500">{{ form.errors.hifz_pages }}</p>
          </div>

        </div>
      </div>
    </div>

    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
      <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800">
        <h2 class="text-lg font-medium text-gray-800 dark:text-white">
          {{ t('daily_studies.murajaahSection') }}
        </h2>
      </div>

      <div class="p-4 sm:p-6">
        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
              {{ t('daily_studies.murajaahFromSura') }}
            </label>
            <div class="relative z-20 bg-transparent">
              <select
                v-model="form.murajaah_from_sura_id"
                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
              >
                <option value="">{{ t('daily_studies.selectSura') }}</option>
                <option
                  v-for="option in suraOptions"
                  :key="option.value"
                  :value="option.value"
                  class="text-gray-700 dark:bg-gray-900 dark:text-gray-300"
                >
                  {{ option.label }}
                </option>
              </select>
              <span class="pointer-events-none absolute top-1/2 right-4 -translate-y-1/2 text-gray-700 dark:text-gray-400">
                <svg class="stroke-current" width="20" height="20" viewBox="0 0 20 20" fill="none">
                  <path d="M4.79175 7.396L10.0001 12.6043L15.2084 7.396" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
              </span>
            </div>
            <p v-if="form.errors.murajaah_from_sura_id" class="mt-1 text-sm text-error-500">{{ form.errors.murajaah_from_sura_id }}</p>
          </div>

          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
              {{ t('daily_studies.murajaahFromAyah') }}
            </label>
            <input
              v-model.number="form.murajaah_from_ayah"
              type="number"
              min="1"
              class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
              :placeholder="t('daily_studies.murajaahFromAyah')"
            />
            <p v-if="form.errors.murajaah_from_ayah" class="mt-1 text-sm text-error-500">{{ form.errors.murajaah_from_ayah }}</p>
          </div>

          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
              {{ t('daily_studies.murajaahToSura') }}
            </label>
            <div class="relative z-20 bg-transparent">
              <select
                v-model="form.murajaah_to_sura_id"
                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
              >
                <option value="">{{ t('daily_studies.selectSura') }}</option>
                <option
                  v-for="option in suraOptions"
                  :key="option.value"
                  :value="option.value"
                  class="text-gray-700 dark:bg-gray-900 dark:text-gray-300"
                >
                  {{ option.label }}
                </option>
              </select>
              <span class="pointer-events-none absolute top-1/2 right-4 -translate-y-1/2 text-gray-700 dark:text-gray-400">
                <svg class="stroke-current" width="20" height="20" viewBox="0 0 20 20" fill="none">
                  <path d="M4.79175 7.396L10.0001 12.6043L15.2084 7.396" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
              </span>
            </div>
            <p v-if="form.errors.murajaah_to_sura_id" class="mt-1 text-sm text-error-500">{{ form.errors.murajaah_to_sura_id }}</p>
          </div>

          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
              {{ t('daily_studies.murajaahToAyah') }}
            </label>
            <input
              v-model.number="form.murajaah_to_ayah"
              type="number"
              min="1"
              class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
              :placeholder="t('daily_studies.murajaahToAyah')"
            />
            <p v-if="form.errors.murajaah_to_ayah" class="mt-1 text-sm text-error-500">{{ form.errors.murajaah_to_ayah }}</p>
          </div>

          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
              {{ t('daily_studies.murajaahPages') }}
            </label>
            <input
              v-model.number="form.murajaah_pages"
              type="number"
              min="0"
              class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
              :placeholder="t('daily_studies.murajaahPages')"
            />
            <p v-if="form.errors.murajaah_pages" class="mt-1 text-sm text-error-500">{{ form.errors.murajaah_pages }}</p>
          </div>
        </div>
      </div>
    </div>

    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
      <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800">
        <h2 class="text-lg font-medium text-gray-800 dark:text-white">
          {{ t('daily_studies.pointsSection') }}
        </h2>
      </div>

      <div class="p-4 sm:p-6">
        <div class="grid grid-cols-1 gap-5">
          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
              {{ t('daily_studies.points') }}
            </label>
            <input
              v-model.number="form.points"
              type="number"
              min="0"
              class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
              :placeholder="t('daily_studies.points')"
            />
            <p v-if="form.errors.points" class="mt-1 text-sm text-error-500">{{ form.errors.points }}</p>
          </div>
        </div>
      </div>
    </div>

    <div class="flex flex-col gap-3 sm:flex-row sm:justify-end">
      <Link
        :href="dailyStudy.session_id ? route('admin.daily_study_sessions.show', dailyStudy.session_id) : route('admin.daily_study_sessions.index')"
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

const { t, locale } = useI18n()
const { success, error } = useNotifications()

const props = defineProps({
  dailyStudy: { type: Object, required: true },
  suras: { type: Array, default: () => [] },
})

const form = useForm({
  _method: 'PUT',
  attendance_status: props.dailyStudy?.attendance_status ?? 'present',
  notes: props.dailyStudy?.notes ?? '',
  is_active: !!props.dailyStudy?.is_active,
  hifz_from_sura_id: props.dailyStudy?.hifz_from_sura_id ? String(props.dailyStudy.hifz_from_sura_id) : '',
  hifz_from_ayah: props.dailyStudy?.hifz_from_ayah ?? null,
  hifz_to_sura_id: props.dailyStudy?.hifz_to_sura_id ? String(props.dailyStudy.hifz_to_sura_id) : '',
  hifz_to_ayah: props.dailyStudy?.hifz_to_ayah ?? null,
  hifz_pages: props.dailyStudy?.hifz_pages ?? null,
  murajaah_from_sura_id: props.dailyStudy?.murajaah_from_sura_id ? String(props.dailyStudy.murajaah_from_sura_id) : '',
  murajaah_from_ayah: props.dailyStudy?.murajaah_from_ayah ?? null,
  murajaah_to_sura_id: props.dailyStudy?.murajaah_to_sura_id ? String(props.dailyStudy.murajaah_to_sura_id) : '',
  murajaah_to_ayah: props.dailyStudy?.murajaah_to_ayah ?? null,
  murajaah_pages: props.dailyStudy?.murajaah_pages ?? null,
  points: props.dailyStudy?.points ?? null,
})

const attendanceStatuses = ['present', 'absent', 'late', 'excused', 'late_in', 'early_out']

const attendanceOptions = computed(() =>
  attendanceStatuses.map((value) => {
    const key = `daily_studies.attendance.${value}`
    const translated = t(key)
    return {
      value,
      label: translated === key ? value : translated,
    }
  })
)

const suraOptions = computed(() =>
  (Array.isArray(props.suras) ? props.suras : [])
    .map((sura) => {
      if (sura?.id == null) {
        return null
      }

      const labelAr = (sura.name_ar ?? '').trim()
      const labelEn = (sura.name_en ?? '').trim()
      const fallbackAr = `سورة ${sura.id}`
      const fallbackEn = `Sura ${sura.id}`
      const label = locale.value === 'ar' ? labelAr || labelEn || fallbackAr : labelEn || labelAr || fallbackEn

      return {
        value: String(sura.id),
        label,
      }
    })
    .filter(Boolean)
)

function normalizeNullableNumber(value) {
  if (value === '' || value === null || value === undefined) {
    return null
  }

  const parsed = Number(value)
  return Number.isNaN(parsed) ? null : parsed
}

function resetTransform() {
  form.transform((data) => data)
}

function update() {
  form.transform((data) => {
    const payload = { ...data }

    payload.hifz_from_sura_id = normalizeNullableNumber(payload.hifz_from_sura_id)
    payload.hifz_from_ayah = normalizeNullableNumber(payload.hifz_from_ayah)
    payload.hifz_to_sura_id = normalizeNullableNumber(payload.hifz_to_sura_id)
    payload.hifz_to_ayah = normalizeNullableNumber(payload.hifz_to_ayah)
    payload.hifz_pages = normalizeNullableNumber(payload.hifz_pages)

    payload.murajaah_from_sura_id = normalizeNullableNumber(payload.murajaah_from_sura_id)
    payload.murajaah_from_ayah = normalizeNullableNumber(payload.murajaah_from_ayah)
    payload.murajaah_to_sura_id = normalizeNullableNumber(payload.murajaah_to_sura_id)
    payload.murajaah_to_ayah = normalizeNullableNumber(payload.murajaah_to_ayah)
    payload.murajaah_pages = normalizeNullableNumber(payload.murajaah_pages)

    payload.points = normalizeNullableNumber(payload.points)

    return payload
  })

  form.post(route('admin.daily_studies.update', props.dailyStudy.id), {
    onSuccess: () => {
      success(t('daily_studies.dailyStudyUpdatedSuccessfully'))
    },
    onError: () => {
      error(t('daily_studies.dailyStudyUpdateFailed'))
    },
    preserveScroll: true,
    onFinish: () => {
      resetTransform()
    },
  })
}
</script>
