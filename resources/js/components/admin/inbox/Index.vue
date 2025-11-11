<template>
  <div class="flex flex-col gap-4 h-[calc(100vh-120px)]">
    <div class="flex flex-col xl:flex-row gap-4 h-full">
      <!-- Sidebar -->
      <notification-sidebar
        :notifications="notifications.data || notifications"
        :selected-id="selectedId"
        @select="handleSelect"
      />

      <!-- Detail box -->
      <notification-box :notification="selectedNotification" />
    </div>
  </div>
</template>

<script setup>
import { computed, ref, watch } from 'vue'
import NotificationSidebar from '@/Components/Inbox/NotificationSidebar.vue'
import NotificationBox from '@/Components/Inbox/NotificationBox.vue'

const props = defineProps({
  notifications: {
    type: Object,
    required: true,
  },
})

const list = computed(() => props.notifications.data || props.notifications || [])

const selectedId = ref(list.value.length ? list.value[0].id : null)

const selectedNotification = computed(() =>
  list.value.find((n) => n.id === selectedId.value) || null
)

watch(
  () => props.notifications,
  (val) => {
    const arr = val.data || val || []
    if (!arr.length) {
      selectedId.value = null
    } else if (!arr.find((n) => n.id === selectedId.value)) {
      selectedId.value = arr[0].id
    }
  }
)

const handleSelect = (id) => {
  selectedId.value = id
}
</script>
