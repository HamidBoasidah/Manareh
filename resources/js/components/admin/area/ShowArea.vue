<template>
  <div class="space-y-6">
    <ComponentCard>
      <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
        <div>
          <h3 class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">{{ t('areas.nameAr') }}</h3>
          <p class="text-sm text-gray-700 dark:text-gray-300">{{ area.name_ar }}</p>
        </div>
        <div>
          <h3 class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">{{ t('areas.nameEn') }}</h3>
          <p class="text-sm text-gray-700 dark:text-gray-300">{{ area.name_en }}</p>
        </div>
        <div>
          <h3 class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">{{ t('areas.district') }}</h3>
          <p class="text-sm text-gray-700 dark:text-gray-300">{{ area.district_name_ar || area.district_name_en }}</p>
        </div>
        <div>
          <h3 class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">{{ t('common.status') }}</h3>
          <p class="text-sm text-gray-700 dark:text-gray-300">{{ area.is_active ? t('common.active') : t('common.inactive') }}</p>
        </div>
      </div>
    </ComponentCard>

    <div class="flex items-center gap-2">
      <Link :href="route('admin.areas.index')" class="btn-outline">{{ t('buttons.backToList') }}</Link>
      <Link :href="route('admin.areas.edit', { area: area.id })" class="btn-primary">{{ t('buttons.edit') }}</Link>
    </div>
  </div>
</template>

<script setup>
import ComponentCard from '@/components/common/ComponentCard.vue'
import { Link } from '@inertiajs/vue3'
import { useI18n } from 'vue-i18n'

const { t } = useI18n()

const props = defineProps({
  area: { type: Object, required: true },
})
</script>
