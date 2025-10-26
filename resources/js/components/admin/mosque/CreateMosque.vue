<template>
  <form class="space-y-6" @submit.prevent="create">
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
      <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800">
        <h2 class="text-lg font-medium text-gray-800 dark:text-white">{{ t('mosques.mosqueInformation') }}</h2>
      </div>

      <div class="p-4 sm:p-6 dark:border-gray-800">
        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
          <div>
            <label for="mosque-name" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">{{ t('mosques.name') }}</label>
            <input v-model="form.name" type="text" id="mosque-name" autocomplete="off" :placeholder="t('mosques.name')" class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
            <p v-if="form.errors.name" class="mt-1 text-sm text-error-500">{{ form.errors.name }}</p>
          </div>

          <div>
            <label for="mosque-city" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">{{ t('common.city') }}</label>
            <input v-model="form.city" type="text" id="mosque-city" autocomplete="off" :placeholder="t('common.city')" class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
            <p v-if="form.errors.city" class="mt-1 text-sm text-error-500">{{ form.errors.city }}</p>
          </div>

          <div class="md:col-span-2">
            <label for="mosque-address" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">{{ t('common.address') }}</label>
            <input v-model="form.address" type="text" id="mosque-address" autocomplete="off" :placeholder="t('common.address')" class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
            <p v-if="form.errors.address" class="mt-1 text-sm text-error-500">{{ form.errors.address }}</p>
          </div>

          <div>
            <label for="mosque-phone" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">{{ t('common.phoneNumber') }}</label>
            <input v-model="form.phone" type="text" id="mosque-phone" autocomplete="off" :placeholder="t('common.phoneNumber')" class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
            <p v-if="form.errors.phone" class="mt-1 text-sm text-error-500">{{ form.errors.phone }}</p>
          </div>

          <div class="md:col-span-2">
            <label for="mosque-notes" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">{{ t('common.notes') }}</label>
            <textarea v-model="form.notes" id="mosque-notes" rows="3" class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"></textarea>
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
          <span class="inline-flex items-center justify-center gap-1 rounded-full px-2.5 py-0.5 text-xs font-medium" :class="{ 'bg-green-50 text-green-600 dark:bg-green-500/15 dark:text-green-500': form.is_active, 'bg-error-50 text-error-600 dark:bg-error-500/15 dark:text-error-500': !form.is_active }">{{ form.is_active ? t('common.active') : t('common.inactive') }}</span>
        </label>
      </div>
    </div>

    <div class="flex flex-col gap-3 sm:flex-row sm:justify-end">
      <Link :href="route('admin.mosques.index')" class="shadow-theme-xs inline-flex items-center justify-center gap-2 rounded-lg bg-white px-4 py-3 text-sm font-medium text-gray-700 ring-1 ring-gray-300 transition hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-400 dark:ring-gray-700 dark:hover:bg-white/[0.03]">{{ t('buttons.backToList') }}</Link>
      <button type="submit" class="bg-brand-500 shadow-theme-xs hover:bg-brand-600 inline-flex items-center justify-center gap-2 rounded-lg px-4 py-3 text-sm font-medium text-white transition" :class="{ 'cursor-not-allowed opacity-70': form.processing }" :disabled="form.processing">{{ form.processing ? t('common.loading') : t('buttons.create') }}</button>
    </div>
  </form>
</template>

<script setup>
import { Link, useForm } from '@inertiajs/vue3'
import { useI18n } from 'vue-i18n'
import { useNotifications } from '@/composables/useNotifications'

const { t } = useI18n()
const { success, error } = useNotifications()

const form = useForm({
  name: '',
  city: '',
  address: '',
  phone: '',
  notes: '',
  is_active: true,
})

function create() {
  form.post(route('admin.mosques.store'), {
    onSuccess: () => { success(t('mosques.mosqueCreatedSuccessfully')); form.reset() },
    onError: () => { error(t('mosques.mosqueCreationFailed')) },
    preserveScroll: true,
  })
}
</script>
