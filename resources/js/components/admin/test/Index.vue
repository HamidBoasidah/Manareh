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
import axios from 'axios'
import NotificationSidebar from '@/Components/admin/inbox/NotificationSidebar.vue'
import NotificationBox from '@/Components/admin/inbox/NotificationBox.vue'

const props = defineProps({
  // لو انت مرجع PaginatedResponse من لارافل
  notifications: {
    type: [Object, Array],
    required: true,
  },
})

const list = computed(() =>
  Array.isArray(props.notifications)
    ? props.notifications
    : (props.notifications.data || [])
)

// أول إشعار افتراضيًا
const selectedId = ref(list.value[0]?.id ?? null)

// الإشعار المحدد حاليًا
const selectedNotification = computed(() =>
  list.value.find((n) => n.id === selectedId.value) || null
)

// لو القائمة تغيرت (pagination / reload)
watch(
  () => list.value,
  (items) => {
    if (!items.length) {
      selectedId.value = null
      return
    }
    if (!items.find((n) => n.id === selectedId.value)) {
      selectedId.value = items[0].id
    }
  },
  { immediate: true }
)

const handleSelect = (id) => {
  selectedId.value = id

  const n = list.value.find((x) => x.id === id)
  if (n && !n.is_read) {
    // تحديث فوري في الواجهة (optimistic UI)
    n.is_read = true

    // طلب لتعليم الإشعار كمقروء في الباك
    router.post(route('notifications.read', id), {}, {
      preserveScroll: true,
      preserveState: true,
    })
  }
}

// عند اختيار عنصر، تأكد أن لدينا body؛ إذا لم يكن، اطلب التفاصيل من السيرفر
watch(selectedId, async (id) => {
  if (!id) return
  const current = list.value.find((x) => x.id === id)
  if (current && !current.body) {
    try {
      const url = route('user.inbox.show', id)
      const { data } = await axios.get(url)
      // دمج الحقول المستلمة في العنصر المحفوظ
      Object.assign(current, data)
    } catch (e) {
      // فشل الشبكة: اترك الواجهة كما هي
      console.error('Failed to fetch notification details', e)
    }
  }
})
</script>
