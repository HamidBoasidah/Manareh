<template>
  <div class="space-y-6">
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
      <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800">
        <h2 class="text-lg font-medium text-gray-800 dark:text-white">
          {{ t('circles.circleInformation') }}
        </h2>
      </div>

      <div class="p-4 sm:p-6">
        <div class="grid grid-cols-1 gap-x-5 gap-y-6 md:grid-cols-2">
          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-500 dark:text-gray-400">
              {{ t('circles.name') }}
            </label>
            <p class="text-base text-gray-800 dark:text-white/90">{{ circle.name }}</p>
          </div>

          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-500 dark:text-gray-400">
              {{ t('circles.mosque') }}
            </label>
            <p class="text-base text-gray-800 dark:text-white/90">{{ circle.mosque_name ?? '—' }}</p>
          </div>

          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-500 dark:text-gray-400">
              {{ t('circles.classification') }}
            </label>
            <p class="text-base text-gray-800 dark:text-white/90">{{ circle.classification_name ?? '—' }}</p>
          </div>

          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-500 dark:text-gray-400">
              {{ t('circles.capacity') }}
            </label>
            <p class="text-base text-gray-800 dark:text-white/90">{{ circle.capacity ?? '—' }}</p>
          </div>

          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-500 dark:text-gray-400">
              {{ t('common.status') }}
            </label>
            <span
              class="inline-flex items-center justify-center gap-1 rounded-full px-2.5 py-0.5 text-xs font-medium"
              :class="{
                'bg-green-50 text-green-600 dark:bg-green-500/15 dark:text-green-500': circle.is_active,
                'bg-error-50 text-error-600 dark:bg-error-500/15 dark:text-error-500': !circle.is_active,
              }"
            >
              {{ circle.is_active ? t('common.active') : t('common.inactive') }}
            </span>
          </div>

          <div class="md:col-span-2">
            <label class="mb-1.5 block text-sm font-medium text-gray-500 dark:text-gray-400">
              {{ t('circles.notes') }}
            </label>
            <p class="text-base text-gray-800 whitespace-pre-wrap dark:text-white/90">{{ circle.notes ?? '—' }}</p>
          </div>
        </div>
      </div>
    </div>

    <!-- جداول الطلاب -->
    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
      <!-- جدول: طلاب الحلقة الحاليين -->
      <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800">
          <h3 class="text-base font-medium text-gray-800 dark:text-white">
            {{ t('circles.currentStudents') }}
          </h3>
        </div>
    
        <div class="max-w-full overflow-x-auto">
          <table class="w-full min-w-full">
            <thead>
              <tr>
                <th class="px-4 py-3 text-start border border-gray-100 dark:border-gray-800 w-20">
                  <p class="font-medium text-gray-700 text-theme-xs dark:text-gray-400">ID</p>
                </th>
                <th class="px-4 py-3 text-start border border-gray-100 dark:border-gray-800">
                  <p class="font-medium text-gray-700 text-theme-xs dark:text-gray-400">{{ t('common.name') }}</p>
                </th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="s in joinedStudents" :key="`joined-${s.id}`">
                <td class="px-4 py-3 border border-gray-100 dark:border-gray-800">
                  <p class="text-gray-700 text-theme-sm dark:text-gray-400">{{ s.id }}</p>
                </td>
                <td class="px-4 py-3 border border-gray-100 dark:border-gray-800">
                  <p class="text-gray-700 text-theme-sm dark:text-gray-400">{{ s.name ?? '—' }}</p>
                </td>
              </tr>
    
              <tr v-if="!joinedStudents || joinedStudents.length === 0">
                <td colspan="2" class="px-4 py-6 text-center text-sm text-gray-500 dark:text-gray-400">
                  {{ t('circles.noCurrentStudents') }}
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    
      <!-- جدول: الطلاب غير المرتبطين بأي حلقة -->
      <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800">
          <h3 class="text-base font-medium text-gray-800 dark:text-white">
            {{ t('circles.freeStudents') }}
          </h3>
        </div>
    
        <div class="max-w-full overflow-x-auto">
          <table class="w-full min-w-full">
            <thead>
              <tr>
                <th class="px-4 py-3 text-start border border-gray-100 dark:border-gray-800 w-20">
                  <p class="font-medium text-gray-700 text-theme-xs dark:text-gray-400">ID</p>
                </th>
                <th class="px-4 py-3 text-start border border-gray-100 dark:border-gray-800">
                  <p class="font-medium text-gray-700 text-theme-xs dark:text-gray-400">{{ t('common.name') }}</p>
                </th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="s in freeStudents" :key="`free-${s.id}`">
                <td class="px-4 py-3 border border-gray-100 dark:border-gray-800">
                  <p class="text-gray-700 text-theme-sm dark:text-gray-400">{{ s.id }}</p>
                </td>
                <td class="px-4 py-3 border border-gray-100 dark:border-gray-800">
                  <p class="text-gray-700 text-theme-sm dark:text-gray-400">{{ s.name ?? '—' }}</p>
                </td>
              </tr>
    
              <tr v-if="!freeStudents || freeStudents.length === 0">
                <td colspan="2" class="px-4 py-6 text-center text-sm text-gray-500 dark:text-gray-400">
                  {{ t('circles.noFreeStudents') }}
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  

    <div class="flex flex-col gap-3 sm:flex-row sm:justify-end">
      <Link
        :href="route('admin.circles.index')"
        class="shadow-theme-xs inline-flex items-center justify-center gap-2 rounded-lg bg-white px-4 py-3 text-sm font-medium text-gray-700 ring-1 ring-gray-300 transition hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-400 dark:ring-gray-700 dark:hover:bg-white/[0.03]"
      >
        {{ t('buttons.backToList') }}
      </Link>

      <Link
        :href="route('admin.circles.edit', circle.id)"
        class="bg-brand-500 shadow-theme-xs hover:bg-brand-600 inline-flex items-center justify-center gap-2 rounded-lg px-4 py-3 text-sm font-medium text-white transition"
      >
        {{ t('buttons.edit') }}
      </Link>
    </div>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import { useI18n } from 'vue-i18n'

const { t } = useI18n()

defineProps({
  circle: { type: Object, required: true },
  joinedStudents: { type: Array, required: true }, // [{id, name}]
  freeStudents:   { type: Array, required: true }, // [{id, name}]
})

</script>
