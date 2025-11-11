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
      <notification-box :notification="selectedNotification" />
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

const handleSelect = (id) => {
  selectedId.value = id

  // Fetch full notification details (AJAX). The controller will return JSON
  // when Accept: application/json, and will mark the notification as read.
  // Merge the returned payload into the local list so the detail box shows full body.
  try {
    window.axios
      .get(route('user.inbox.show', id), { headers: { Accept: 'application/json' } })
      .then((resp) => {
        const payload = resp.data
        if (!payload) return

        // Merge into the list (replace or augment the existing summary item)
        const idx = list.value.findIndex((i) => i.id === payload.id)
        if (idx !== -1) {
          list.value.splice(idx, 1, { ...list.value[idx], ...payload })
        } else {
          // if not present (edge-case), push it
          list.value.unshift(payload)
        }
      })
      .catch(() => {
        // ignore silently; the UX still selects the item
      })
  } catch (e) {
    // ignore
  }
}
</script>
