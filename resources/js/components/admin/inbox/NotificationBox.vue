<template>
  <div
    class="flex-1 flex flex-col h-full rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]"
  >
    <!-- Header -->
    <div
      class="flex items-center justify-between px-5 py-4 border-b border-gray-200 dark:border-gray-800"
    >
      <div class="flex flex-col">
        <h4 class="text-base font-semibold text-gray-800 dark:text-white/90">
          {{ notification?.subject || 'تفاصيل الإشعار' }}
        </h4>
        <p
          v-if="notification"
          class="mt-1 text-xs text-gray-500 dark:text-gray-400"
        >
          {{ notification.created_at_human || notification.created_at }}
          <span
            class="inline-flex items-center gap-1 ml-3 text-[10px] px-2 py-0.5 rounded-full"
            :class="
              notification.is_read
                ? 'bg-gray-100 text-gray-500 dark:bg-white/5 dark:text-gray-300'
                : 'bg-brand-50 text-brand-700 dark:bg-brand-500/10 dark:text-brand-300'
            "
          >
            <span
              class="w-1.5 h-1.5 rounded-full"
              :class="notification.is_read ? 'bg-gray-400' : 'bg-brand-500'"
            ></span>
            {{ notification.is_read ? 'مقروء' : 'غير مقروء' }}
          </span>
        </p>
      </div>
    </div>

    <!-- Body -->
    <div class="flex-1 p-5 overflow-auto custom-scrollbar">
      <div v-if="notification" class="space-y-3">
        <p class="text-sm leading-relaxed text-gray-800 whitespace-pre-line dark:text-white/90">
          {{ notification.body }}
        </p>

        <!-- عرض بيانات إضافية من payload إن وجدت -->
        <div
          v-if="notification.payload && Object.keys(notification.payload).length"
          class="mt-3 text-[11px] text-gray-500 dark:text-gray-400 border-t border-gray-100 dark:border-white/5 pt-2 space-y-0.5"
        >
          <div
            v-for="(value, key) in notification.payload"
            :key="key"
          >
            <span class="font-semibold">{{ formatKey(key) }}:</span>
            <span class="ml-1">{{ value }}</span>
          </div>
        </div>
      </div>

      <div
        v-else
        class="flex items-center justify-center h-full text-sm text-gray-400"
      >
        اختر إشعارًا من القائمة على اليسار لعرض تفاصيله.
      </div>
    </div>
  </div>
</template>

<script setup>
const props = defineProps({
  notification: {
    type: Object,
    default: null,
  },
})

const formatKey = (key) => {
  // بسيط: تقدر تخصصه لتعريب المفاتيح
  return key.replace(/_/g, ' ')
}
</script>
