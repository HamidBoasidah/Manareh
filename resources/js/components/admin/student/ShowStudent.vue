<template>
  <div class="space-y-6">
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
      <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800">
        <h2 class="text-lg font-medium text-gray-800 dark:text-white">
          {{ t('students.studentInformation') }}
        </h2>
      </div>

      <div class="p-4 sm:p-6">
        <div class="grid grid-cols-1 gap-x-5 gap-y-6 md:grid-cols-2">
          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-500 dark:text-gray-400">
              {{ t('students.studentName') }}
            </label>
            <p class="text-base text-gray-800 dark:text-white/90">{{ student.user_name ?? '—' }}</p>
          </div>

          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-500 dark:text-gray-400">
              {{ t('students.email') }}
            </label>
            <p class="text-base text-gray-800 dark:text-white/90">{{ student.email ?? '—' }}</p>
          </div>

          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-500 dark:text-gray-400">
              {{ t('students.guardian') }}
            </label>
            <p class="text-base text-gray-800 dark:text-white/90">{{ student.guardian_name ?? '—' }}</p>
          </div>

          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-500 dark:text-gray-400">
              {{ t('students.guardianPhone') }}
            </label>
            <p class="text-base text-gray-800 dark:text-white/90">{{ student.guardian_phone ?? '—' }}</p>
          </div>

          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-500 dark:text-gray-400">
              {{ t('students.mosque') }}
            </label>
            <p class="text-base text-gray-800 dark:text-white/90">{{ student.mosque_name ?? '—' }}</p>
          </div>

          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-500 dark:text-gray-400">
              {{ t('students.birthDate') }}
            </label>
            <p class="text-base text-gray-800 dark:text-white/90">{{ student.birth_date ?? '—' }}</p>
          </div>

          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-500 dark:text-gray-400">
              {{ t('students.phoneNumber') }}
            </label>
            <p class="text-base text-gray-800 dark:text-white/90">{{ student.phone_number ?? '—' }}</p>
          </div>

          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-500 dark:text-gray-400">
              {{ t('students.whatsappNumber') }}
            </label>
            <p class="text-base text-gray-800 dark:text-white/90">{{ student.whatsapp_number ?? '—' }}</p>
          </div>

          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-500 dark:text-gray-400">
              {{ t('students.address') }}
            </label>
            <p class="text-base text-gray-800 dark:text-white/90">{{ student.address ?? '—' }}</p>
          </div>

          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-500 dark:text-gray-400">
              {{ t('students.nationality') }}
            </label>
            <p class="text-base text-gray-800 dark:text-white/90">{{ student.nationality ?? '—' }}</p>
          </div>

          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-500 dark:text-gray-400">
              {{ t('common.status') }}
            </label>
            <span
              class="inline-flex items-center justify-center gap-1 rounded-full px-2.5 py-0.5 text-xs font-medium"
              :class="{
                'bg-green-50 text-green-600 dark:bg-green-500/15 dark:text-green-500': student.is_active,
                'bg-error-50 text-error-600 dark:bg-error-500/15 dark:text-error-500': !student.is_active,
              }"
            >
              {{ student.is_active ? t('common.active') : t('common.inactive') }}
            </span>
          </div>

          <div class="md:col-span-2">
            <label class="mb-1.5 block text-sm font-medium text-gray-500 dark:text-gray-400">
              {{ t('students.notes') }}
            </label>
            <p class="text-base text-gray-800 whitespace-pre-wrap dark:text-white/90">{{ student.notes ?? '—' }}</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Student Image Section -->
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
      <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800">
        <h2 class="text-lg font-medium text-gray-800 dark:text-white">{{ t('users.userImage') }}</h2>
      </div>
      <div class="p-4 sm:p-6">
        <div v-if="student.user_attachment" class="relative flex justify-center p-4">
          <img :src="`/storage/${student.user_attachment}`" alt="Student Image" class="max-h-64 rounded-lg border border-gray-200 object-contain dark:border-gray-800" />
        </div>
        <div v-else class="flex justify-center p-10">
          <p class="text-center text-sm text-gray-500 dark:text-gray-400">
            {{ t('users.noImage') }}
          </p>
        </div>
      </div>
    </div>

    <div class="flex flex-col gap-3 sm:flex-row sm:justify-end">
      <Link
        :href="route('admin.students.index')"
        class="shadow-theme-xs inline-flex items-center justify-center gap-2 rounded-lg bg-white px-4 py-3 text-sm font-medium text-gray-700 ring-1 ring-gray-300 transition hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-400 dark:ring-gray-700 dark:hover:bg-white/[0.03]"
      >
        {{ t('buttons.backToList') }}
      </Link>

      <Link
        :href="route('admin.students.edit', student.id)"
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
  student: { type: Object, required: true },
})
</script>
