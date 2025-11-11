<template>
  <div
    class="xl:w-1/4 w-full flex flex-col rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] h-full"
  >
    <!-- Header -->
    <div class="px-4 pt-4 pb-3 sm:px-5 sm:pt-5 border-b border-gray-200 dark:border-gray-800">
      <div class="flex items-center justify-between">
        <h3 class="font-semibold text-gray-800 text-lg dark:text-white/90">
          الإشعارات
        </h3>
      </div>
      <div class="relative w-full mt-4">
        <input
          v-model="search"
          type="text"
          placeholder="بحث في الإشعارات..."
          class="dark:bg-gray-900 h-10 w-full rounded-lg border border-gray-200 bg-transparent py-2 pl-9 pr-3 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:text-white/90 dark:placeholder:text-white/30"
        />
        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
          <svg
            class="w-4 h-4"
            viewBox="0 0 20 20"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              fill-rule="evenodd"
              clip-rule="evenodd"
              d="M3.04199 9.37381C3.04199 5.87712 5.87735 3.04218 9.37533 3.04218C12.8733 3.04218 15.7087 5.87712 15.7087 9.37381C15.7087 12.8705 12.8733 15.7055 9.37533 15.7055C5.87735 15.7055 3.04199 12.8705 3.04199 9.37381ZM9.37533 1.54218C5.04926 1.54218 1.54199 5.04835 1.54199 9.37381C1.54199 13.6993 5.04926 17.2055 9.37533 17.2055C11.2676 17.2055 13.0032 16.5346 14.3572 15.4178L17.1773 18.2381C17.4702 18.531 17.945 18.5311 18.2379 18.2382C18.5308 17.9453 18.5309 17.4704 18.238 17.1775L15.4182 14.3575C16.5367 13.0035 17.2087 11.2671 17.2087 9.37381C17.2087 5.04835 13.7014 1.54218 9.37533 1.54218Z"
              fill="currentColor"
            />
          </svg>
        </span>
      </div>
    </div>

    <!-- List -->
    <div class="flex-1 overflow-auto px-2.5 py-3 space-y-1 custom-scrollbar">
      <notification-list-item
        v-for="n in filtered"
        :key="n.id"
        :notification="n"
        :active="n.id === selectedId"
        @click="$emit('select', n.id)"
      />
      <div
        v-if="!filtered.length"
        class="flex items-center justify-center h-full text-sm text-gray-400"
      >
        لا توجد إشعارات.
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed, ref } from 'vue'
import NotificationListItem from './NotificationListItem.vue'

const props = defineProps({
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

const search = ref('')

const filtered = computed(() => {
  if (!search.value) return props.notifications
  const q = search.value.toLowerCase()
  return props.notifications.filter((n) => {
    return (
      (n.subject && n.subject.toLowerCase().includes(q)) ||
      (n.short_body && n.short_body.toLowerCase().includes(q)) ||
      (n.body && n.body.toLowerCase().includes(q))
    )
  })
})
</script>
