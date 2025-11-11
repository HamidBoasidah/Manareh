<template>
  <div
    class="flex flex-col gap-1 cursor-pointer rounded-xl px-3 py-2.5 transition-colors"
    :class="[
      active
        ? 'bg-brand-50 border border-brand-100 dark:bg-brand-500/10 dark:border-brand-500/40'
        : 'hover:bg-gray-100 dark:hover:bg-white/[0.04]',
    ]"
  >
    <div class="flex items-center justify-between gap-2">
      <h5
        class="text-sm font-medium truncate"
        :class="notification.is_read
          ? 'text-gray-700 dark:text-gray-300'
          : 'text-gray-900 dark:text-white'"
      >
        {{ notification.subject || 'بدون عنوان' }}
      </h5>

      <!-- نقطة: غير مقروء -->
      <span
        v-if="!notification.is_read"
        class="inline-block w-2 h-2 rounded-full bg-brand-500"
      ></span>
    </div>

    <!-- اختياري: معاينة قصيرة (مخفية افتراضيًا) -->
    <template v-if="showPreview">
      <p class="text-xs text-gray-500 dark:text-gray-400 line-clamp-2">
        {{ notification.short_body || truncate(notification.body, 120) }}
      </p>

      <span class="text-[10px] text-gray-400">
        {{ notification.created_at_human || notification.created_at }}
      </span>
    </template>
  </div>
</template>

<script setup>
const props = defineProps({
  notification: {
    type: Object,
    required: true,
  },
  active: {
    type: Boolean,
    default: false,
  },
  // show a short preview under the title (default false -> only title + dot)
  showPreview: {
    type: Boolean,
    default: false,
  },
})

const { showPreview } = props

const truncate = (text = '', max = 100) => {
  if (!text) return ''
  if (text.length <= max) return text
  return text.slice(0, max).trim() + '...'
}
</script>
