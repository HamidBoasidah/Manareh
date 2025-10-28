<template>
  <form class="space-y-6" @submit.prevent="create">
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
      <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800">
        <h2 class="text-lg font-medium text-gray-800 dark:text-white">
          {{ t('students.studentInformation') }}
        </h2>
      </div>

      <div class="p-4 sm:p-6 dark:border-gray-800">
        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
              {{ t('students.selectUser') }}
            </label>
            <div class="relative z-20 bg-transparent">
              <select
                v-model="form.user_id"
                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                :class="{ 'text-gray-800 dark:text-white/90': form.user_id }"
              >
                <option value="" disabled class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">
                  {{ t('students.selectUserPlaceholder') }}
                </option>
                <option
                  v-for="user in users"
                  :key="user.id"
                  :value="user.id"
                  class="text-gray-700 dark:bg-gray-900 dark:text-gray-400"
                >
                  {{ user.name }} ({{ user.email }})
                </option>
              </select>
              <span class="pointer-events-none absolute top-1/2 right-4 z-30 -translate-y-1/2 text-gray-700 dark:text-gray-400">
                <svg class="stroke-current" width="20" height="20" viewBox="0 0 20 20" fill="none">
                  <path d="M4.79175 7.396L10.0001 12.6043L15.2084 7.396" stroke="" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
              </span>
            </div>
            <p v-if="form.errors.user_id" class="mt-1 text-sm text-error-500">{{ form.errors.user_id }}</p>
          </div>

          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
              {{ t('students.selectGuardian') }}
            </label>
            <div class="relative z-20 bg-transparent">
              <select
                v-model="form.guardian_id"
                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                :class="{ 'text-gray-800 dark:text-white/90': form.guardian_id }"
              >
                <option value="" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">
                  {{ t('students.selectGuardianPlaceholder') }}
                </option>
                <option
                  v-for="guardian in guardians"
                  :key="guardian.id"
                  :value="guardian.id"
                  class="text-gray-700 dark:bg-gray-900 dark:text-gray-400"
                >
                  {{ guardian.name }}
                </option>
              </select>
              <span class="pointer-events-none absolute top-1/2 right-4 z-30 -translate-y-1/2 text-gray-700 dark:text-gray-400">
                <svg class="stroke-current" width="20" height="20" viewBox="0 0 20 20" fill="none">
                  <path d="M4.79175 7.396L10.0001 12.6043L15.2084 7.396" stroke="" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
              </span>
            </div>
            <p v-if="form.errors.guardian_id" class="mt-1 text-sm text-error-500">{{ form.errors.guardian_id }}</p>
          </div>

          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
              {{ t('students.selectMosque') }}
            </label>
            <div class="relative z-20 bg-transparent">
              <select
                v-model="form.mosque_id"
                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                :class="{ 'text-gray-800 dark:text-white/90': form.mosque_id }"
              >
                <option value="" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">
                  {{ t('students.selectMosquePlaceholder') }}
                </option>
                <option
                  v-for="mosque in mosques"
                  :key="mosque.id"
                  :value="mosque.id"
                  class="text-gray-700 dark:bg-gray-900 dark:text-gray-400"
                >
                  {{ mosque.name }}
                </option>
              </select>
              <span class="pointer-events-none absolute top-1/2 right-4 z-30 -translate-y-1/2 text-gray-700 dark:text-gray-400">
                <svg class="stroke-current" width="20" height="20" viewBox="0 0 20 20" fill="none">
                  <path d="M4.79175 7.396L10.0001 12.6043L15.2084 7.396" stroke="" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
              </span>
            </div>
            <p v-if="form.errors.mosque_id" class="mt-1 text-sm text-error-500">{{ form.errors.mosque_id }}</p>
          </div>

          <div>
            <label for="student-birth-date" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
              {{ t('students.birthDate') }}
            </label>
            <input
              v-model="form.birth_date"
              type="date"
              id="student-birth-date"
              class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
            />
            <p v-if="form.errors.birth_date" class="mt-1 text-sm text-error-500">{{ form.errors.birth_date }}</p>
          </div>

          <div>
            <label for="student-phone" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
              {{ t('students.phoneNumber') }}
            </label>
            <input
              v-model="form.phone_number"
              type="tel"
              id="student-phone"
              autocomplete="off"
              :placeholder="t('students.phoneNumber')"
              class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
            />
            <p v-if="form.errors.phone_number" class="mt-1 text-sm text-error-500">{{ form.errors.phone_number }}</p>
          </div>

          <div>
            <label for="student-whatsapp" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
              {{ t('students.whatsappNumber') }}
            </label>
            <input
              v-model="form.whatsapp_number"
              type="tel"
              id="student-whatsapp"
              autocomplete="off"
              :placeholder="t('students.whatsappNumber')"
              class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
            />
            <p v-if="form.errors.whatsapp_number" class="mt-1 text-sm text-error-500">{{ form.errors.whatsapp_number }}</p>
          </div>

          <div class="md:col-span-2">
            <label for="student-address" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
              {{ t('students.address') }}
            </label>
            <input
              v-model="form.address"
              type="text"
              id="student-address"
              autocomplete="off"
              :placeholder="t('students.address')"
              class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
            />
            <p v-if="form.errors.address" class="mt-1 text-sm text-error-500">{{ form.errors.address }}</p>
          </div>

          <div>
            <label for="student-nationality" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
              {{ t('students.nationality') }}
            </label>
            <input
              v-model="form.nationality"
              type="text"
              id="student-nationality"
              autocomplete="off"
              :placeholder="t('students.nationality')"
              class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
            />
            <p v-if="form.errors.nationality" class="mt-1 text-sm text-error-500">{{ form.errors.nationality }}</p>
          </div>

          <div class="md:col-span-2">
            <label for="student-notes" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
              {{ t('students.notes') }}
            </label>
            <textarea
              v-model="form.notes"
              id="student-notes"
              rows="4"
              :placeholder="t('students.notes')"
              class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
            ></textarea>
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
        :href="route('admin.students.index')"
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
import { useI18n } from 'vue-i18n'
import { useNotifications } from '@/composables/useNotifications'

const { t } = useI18n()
const { success, error } = useNotifications()

const props = defineProps({
  users: { type: Array, default: () => [] },
  guardians: { type: Array, default: () => [] },
  mosques: { type: Array, default: () => [] },
})

const form = useForm({
  user_id: '',
  mosque_id: '',
  guardian_id: '',
  birth_date: '',
  address: '',
  phone_number: '',
  whatsapp_number: '',
  nationality: '',
  notes: '',
  is_active: true,
})

const { users, guardians, mosques } = props

function create() {
  form.post(route('admin.students.store'), {
    onSuccess: () => {
      success(t('students.studentCreatedSuccessfully'))
      form.reset()
    },
    onError: () => {
      error(t('students.studentCreationFailed'))
    },
    preserveScroll: true,
  })
}
</script>
