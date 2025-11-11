<template>
  <div class="flex flex-col gap-4 h-[calc(100vh-120px)]">
    <div class="flex flex-col xl:flex-row gap-4 h-full">
      <!-- قائمة الإشعارات المختصرة -->
      <notification-sidebar
        :notifications="list"
        :selected-id="selectedId"
        @select="handleSelect"
      />

      <!-- عرض الإشعار الكامل -->
      <!-- <notification-box :notification="selectedNotification" />-->
    </div>
  </div>
</template>

<script setup>
import { computed, ref, watch } from 'vue'
import { router } from '@inertiajs/vue3'
import { route } from 'ziggy-js'
import NotificationSidebar from '@/components/admin/inbox/NotificationSidebar.vue'
import NotificationBox from '@/components/admin/inbox/NotificationBox.vue'

const props = defineProps({
  notifications: {
    type: [Object, Array],
    required: true,
  },
})

const selectedId = ref(null)
const list = ref([])

const normalizeNotifications = (value) => {
  if (Array.isArray(value)) return value
  if (value && Array.isArray(value.data)) return value.data
  return []
}

const syncNotifications = (value) => {
  const items = normalizeNotifications(value).map((item) => ({ ...item }))
  list.value = items

  if (!items.length) {
    selectedId.value = null
    return
  }

  if (
    selectedId.value === null ||
    !items.some((item) => item.id === selectedId.value)
  ) {
    selectedId.value = items[0].id
  }
}

watch(
  () => props.notifications,
  (value) => {
    syncNotifications(value)
  },
  { immediate: true, deep: true }
)

const selectedNotification = computed(() =>
  list.value.find((n) => n.id === selectedId.value) || null
)

const markAsRead = async (notification) => {
  if (!notification || notification.is_read) return

  // optimistic update
  notification.is_read = true

  try {
    // Use axios to send a straightforward POST; pass param as object to Ziggy
    await window.axios.post(route('user.inbox.read', { id: notification.id }))
  } catch (err) {
    // revert optimistic change on error
    notification.is_read = false

    // if forbidden, show console hint (user may not own this notification)
    if (err.response && err.response.status === 403) {
      console.warn('Mark as read forbidden for notification', notification.id)
    } else {
      console.error('Failed to mark as read', err)
    }
  }
}

const handleSelect = (id) => {
  selectedId.value = id

  const target = list.value.find((n) => n.id === id)
  markAsRead(target)
}
</script>
