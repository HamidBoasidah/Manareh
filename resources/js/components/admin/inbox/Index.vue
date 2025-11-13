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
      <notification-box
        :notification="selectedNotification"
        :loading="isLoadingDetails"
      />
    </div>
  </div>
</template>

<script setup>
import { computed, ref, watch } from 'vue'
import axios from 'axios'
import { router } from '@inertiajs/vue3'
import NotificationSidebar from './NotificationSidebar.vue'
import NotificationBox from './NotificationBox.vue'

const defaultRoutes = Object.freeze({
  show: 'notifications.show',
  markRead: 'notifications.read',
})

const props = defineProps({
  // لو انت مرجع PaginatedResponse من لارافل
  notifications: {
    type: [Object, Array],
    required: true,
  },
  routes: {
    type: Object,
    default: () => ({}),
  },
  autoMarkRead: {
    type: Boolean,
    default: true,
  },
})

const list = computed(() =>
  Array.isArray(props.notifications)
    ? props.notifications
    : (props.notifications.data || [])
)

// أول إشعار افتراضيًا
const selectedId = ref(null)
const loadingDetailsId = ref(null)

// الإشعار المحدد حاليًا
const selectedNotification = computed(() =>
  list.value.find((n) => n.id === selectedId.value) || null
)

const isLoadingDetails = computed(() => loadingDetailsId.value === selectedId.value)

const mergedRoutes = computed(() => ({
  ...defaultRoutes,
  ...props.routes,
}))

const buildNotificationUrl = (key, id) => {
  const config = mergedRoutes.value[key]
  if (!config) return null

  if (typeof config === 'function') {
    return config(id)
  }

  if (typeof route === 'function') {
    return route(config, id)
  }

  if (config === 'notifications.read') {
    return `/notifications/${id}/read`
  }

  if (config === 'notifications.show') {
    return `/notifications/${id}`
  }

  if (config === 'admin.notifications.mark-read') {
    return `/admin/notifications/${id}/mark-read`
  }

  if (config === 'admin.notifications.show') {
    return `/admin/notifications/${id}`
  }

  return null
}

// لو القائمة تغيرت (pagination / reload)
watch(
  () => list.value,
  (items) => {
    if (!items.length) {
      selectedId.value = null
      return
    }
    if (!items.find((n) => n.id === selectedId.value)) {
      const unread = items.find((n) => !n.is_read)
      selectedId.value = unread?.id ?? items[0].id
    }
  },
  { immediate: true }
)

const handleSelect = (id) => {
  selectedId.value = id
}

const markNotificationAsRead = (id, notification) => {
  if (!props.autoMarkRead) {
    return
  }

  const url = buildNotificationUrl('markRead', id)
  if (!url) {
    return
  }

  router.post(url, {}, {
    preserveScroll: true,
    preserveState: true,
    onError: () => {
      if (notification) {
        notification.is_read = false
      }
    },
  })
}

const fetchNotificationBody = async (id) => {
  if (!id) return

  const current = list.value.find((x) => x.id === id)
  if (!current || current.body) return

  loadingDetailsId.value = id

  try {
    const url = buildNotificationUrl('show', id)
    if (!url) {
      return
    }
    const { data } = await axios.get(url)
    Object.assign(current, data)
  } catch (error) {
    console.error('Failed to load notification details', error)
  } finally {
    if (loadingDetailsId.value === id) {
      loadingDetailsId.value = null
    }
  }
}

watch(selectedId, (id) => {
  if (!id) return

  const notification = list.value.find((x) => x.id === id)
  if (!notification) return

  if (props.autoMarkRead && !notification.is_read) {
    notification.is_read = true
    markNotificationAsRead(id, notification)
  }

  fetchNotificationBody(id)
})
</script>
