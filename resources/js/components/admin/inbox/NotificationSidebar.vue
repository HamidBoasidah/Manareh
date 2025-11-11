<template>
  <div
    class="xl:w-1/4 w-full flex flex-col rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] h-full"
  >
    <!-- Header بسيط -->
    <div class="px-4 pt-4 pb-3 sm:px-5 sm:pt-5 border-b border-gray-200 dark:border-gray-800">
      <h3 class="font-semibold text-gray-800 text-lg dark:text-white/90">
        الإشعارات
      </h3>
    </div>

    <!-- قائمة الإشعارات -->
    <div class="flex-1 overflow-auto px-2.5 py-3 space-y-1 custom-scrollbar">
      <notification-list-item
        v-for="n in notifications"
        :key="n.id"
        :notification="n"
        :active="n.id === selectedId"
        @click="$emit('select', n.id)"
      />

      <div
        v-if="!notifications.length"
        class="flex items-center justify-center h-full text-sm text-gray-400"
      >
        لا توجد إشعارات.
      </div>
    </div>
  </div>
</template>

<script setup>
import NotificationListItem from './NotificationListItem.vue'

defineProps({
  notifications: {
    type: Array,
    required: true,
  },
  selectedId: {
    type: Number,
    default: null,
  },
})

defineEmits(['select'])
</script>
