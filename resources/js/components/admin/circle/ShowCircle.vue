<template>
  <div class="space-y-6">
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
      <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800">
        <h2 class="text-lg font-medium text-gray-800 dark:text-white">
          {{ t('circles.circleInformation') }}
        </h2>
      </div>

      <div class="p-4 sm:p-6">
        <div class="grid grid-cols-1 gap-x-5 gap-y-6 md:grid-cols-2">
          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-500 dark:text-gray-400">
              {{ t('circles.name') }}
            </label>
            <p class="text-base text-gray-800 dark:text-white/90">{{ circle.name }}</p>
          </div>

          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-500 dark:text-gray-400">
              {{ t('circles.mosque') }}
            </label>
            <p class="text-base text-gray-800 dark:text-white/90">{{ circle.mosque_name ?? '—' }}</p>
          </div>

          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-500 dark:text-gray-400">
              {{ t('circles.classification') }}
            </label>
            <p class="text-base text-gray-800 dark:text-white/90">{{ circle.classification_name ?? '—' }}</p>
          </div>

          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-500 dark:text-gray-400">
              {{ t('circles.capacity') }}
            </label>
            <p class="text-base text-gray-800 dark:text-white/90">{{ circle.capacity ?? '—' }}</p>
          </div>

          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-500 dark:text-gray-400">
              {{ t('common.status') }}
            </label>
            <span
              class="inline-flex items-center justify-center gap-1 rounded-full px-2.5 py-0.5 text-xs font-medium"
              :class="{
                'bg-green-50 text-green-600 dark:bg-green-500/15 dark:text-green-500': circle.is_active,
                'bg-error-50 text-error-600 dark:bg-error-500/15 dark:text-error-500': !circle.is_active,
              }"
            >
              {{ circle.is_active ? t('common.active') : t('common.inactive') }}
            </span>
          </div>

          <div class="md:col-span-2">
            <label class="mb-1.5 block text-sm font-medium text-gray-500 dark:text-gray-400">
              {{ t('circles.notes') }}
            </label>
            <p class="text-base text-gray-800 whitespace-pre-wrap dark:text-white/90">{{ circle.notes ?? '—' }}</p>
          </div>
        </div>
      </div>
    </div>

    <!-- جداول الطلاب -->
    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
      <!-- جدول: طلاب الحلقة الحاليين -->
      <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800">
          <h3 class="text-base font-medium text-gray-800 dark:text-white">
            {{ t('circles.currentStudents') }}
          </h3>
        </div>
    
        <div class="max-w-full overflow-x-auto">
          <table class="w-full min-w-full">
            <thead>
              <tr>
                <th class="px-4 py-3 text-start border border-gray-100 dark:border-gray-800 w-20">
                  <p class="font-medium text-gray-700 text-theme-xs dark:text-gray-400">ID</p>
                </th>
                <th class="px-4 py-3 text-start border border-gray-100 dark:border-gray-800">
                  <p class="font-medium text-gray-700 text-theme-xs dark:text-gray-400">{{ t('common.name') }}</p>
                </th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="s in joinedStudents" :key="`joined-${s.id}`">
                <td class="px-4 py-3 border border-gray-100 dark:border-gray-800">
                  <p class="text-gray-700 text-theme-sm dark:text-gray-400">{{ s.id }}</p>
                </td>
                <td class="px-4 py-3 border border-gray-100 dark:border-gray-800">
                  <p class="text-gray-700 text-theme-sm dark:text-gray-400">{{ s.name ?? '—' }}</p>
                </td>
              </tr>
    
              <tr v-if="!joinedStudents || joinedStudents.length === 0">
                <td colspan="2" class="px-4 py-6 text-center text-sm text-gray-500 dark:text-gray-400">
                  {{ t('circles.noCurrentStudents') }}
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    
      <!-- جدول: الطلاب غير المرتبطين بأي حلقة -->
      <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800">
          <h3 class="text-base font-medium text-gray-800 dark:text-white">
            {{ t('circles.freeStudents') }}
          </h3>
        </div>
    
        <div class="max-w-full overflow-x-auto">
          <table class="w-full min-w-full">
            <thead>
              <tr>
                <th class="px-4 py-3 text-start border border-gray-100 dark:border-gray-800 w-20">
                  <p class="font-medium text-gray-700 text-theme-xs dark:text-gray-400">ID</p>
                </th>
                <th class="px-4 py-3 text-start border border-gray-100 dark:border-gray-800">
                  <p class="font-medium text-gray-700 text-theme-xs dark:text-gray-400">{{ t('common.name') }}</p>
                </th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="s in freeStudents" :key="`free-${s.id}`">
                <td class="px-4 py-3 border border-gray-100 dark:border-gray-800">
                  <p class="text-gray-700 text-theme-sm dark:text-gray-400">{{ s.id }}</p>
                </td>
                <td class="px-4 py-3 border border-gray-100 dark:border-gray-800">
                  <p class="text-gray-700 text-theme-sm dark:text-gray-400">{{ s.name ?? '—' }}</p>
                </td>
              </tr>
    
              <tr v-if="!freeStudents || freeStudents.length === 0">
                <td colspan="2" class="px-4 py-6 text-center text-sm text-gray-500 dark:text-gray-400">
                  {{ t('circles.noFreeStudents') }}
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <div class="flex flex-col gap-3 border-t border-gray-100 px-4 py-4 text-sm text-gray-500 dark:border-gray-800 dark:text-gray-400 sm:flex-row sm:items-center sm:justify-between">
          <p>
            {{ t('datatable.showing', { start: tables.free.startEntry, end: tables.free.endEntry, total: tables.free.total }) }}
          </p>
          <div class="flex items-center gap-1">
            <button
              class="flex h-9 items-center justify-center rounded-lg border border-gray-300 px-3 text-sm font-medium text-gray-700 shadow-theme-xs transition hover:bg-gray-50 disabled:opacity-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03]"
              @click="tables.free.prev()"
              :disabled="tables.free.page === 1"
            >
              {{ t('datatable.previous') }}
            </button>

            <button
              class="flex h-9 items-center justify-center rounded-lg border border-gray-300 px-3 text-sm font-medium text-gray-700 shadow-theme-xs transition hover:bg-gray-50 disabled:opacity-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03]"
              @click="tables.free.next()"
              :disabled="tables.free.page === tables.free.totalPages"
            >
              {{ t('datatable.next') }}
            </button>
          </div>
        </div>
      </div>
    </div>
  

    <div class="flex flex-col gap-3 sm:flex-row sm:justify-end">
      <Link
        :href="route('admin.circles.index')"
        class="shadow-theme-xs inline-flex items-center justify-center gap-2 rounded-lg bg-white px-4 py-3 text-sm font-medium text-gray-700 ring-1 ring-gray-300 transition hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-400 dark:ring-gray-700 dark:hover:bg-white/[0.03]"
      >
        {{ t('buttons.backToList') }}
      </Link>

      <Link
        :href="route('admin.circles.edit', circle.id)"
        class="bg-brand-500 shadow-theme-xs hover:bg-brand-600 inline-flex items-center justify-center gap-2 rounded-lg px-4 py-3 text-sm font-medium text-white transition"
      >
        {{ t('buttons.edit') }}
      </Link>
    </div>
  </div>
</template>

<script setup>
import { computed, reactive, ref, watch } from 'vue'
import { Link, router } from '@inertiajs/vue3'
import { useI18n } from 'vue-i18n'
import { useNotifications } from '@/composables/useNotifications'
import { route } from 'ziggy-js'

const { t } = useI18n()
const { success, error } = useNotifications()

const props = defineProps({
  circle: { type: Object, required: true },
  joinedStudents: { type: Array, required: true },
  freeStudents: { type: Array, required: true },
  canManageStudents: { type: Boolean, default: false },
})

const perPageOptions = [10, 25, 50]

const canManage = computed(() => props.canManageStudents)

const busyStates = reactive({
  attach: Object.create(null),
  detach: Object.create(null),
})

function setBusy(type, studentId, value) {
  if (!busyStates[type]) return
  if (value) {
    busyStates[type][studentId] = true
  } else {
    delete busyStates[type][studentId]
  }
}

const isAttachBusy = (studentId) => Boolean(busyStates.attach[studentId])
const isDetachBusy = (studentId) => Boolean(busyStates.detach[studentId])

const extractErrorMessage = (errors) => {
  if (!errors) return null
  if (typeof errors === 'string') return errors
  const values = Object.values(errors)
  if (values.length === 0) return null
  const first = values[0]
  return Array.isArray(first) ? first[0] : first
}

function attachStudent(student) {
  if (!canManage.value || !student || isAttachBusy(student.id)) return
  setBusy('attach', student.id, true)

  router.post(
    route('admin.circles.students.join', { circle: props.circle.id }),
    { student_id: student.id },
    {
      preserveScroll: true,
      onSuccess: () => {
        success(t('circles.studentAssignedSuccessfully'))
      },
      onError: (errors) => {
        const message = extractErrorMessage(errors) ?? t('circles.studentAlreadyAssigned')
        error(message)
      },
      onFinish: () => {
        setBusy('attach', student.id, false)
      },
    }
  )
}

function detachStudent(student) {
  if (!canManage.value || !student || isDetachBusy(student.id)) return
  setBusy('detach', student.id, true)

  router.delete(
    route('admin.circles.students.leave', { circle: props.circle.id, student: student.id }),
    {
      preserveScroll: true,
      onSuccess: () => {
        success(t('circles.studentRemovedSuccessfully'))
      },
      onError: (errors) => {
        const message = extractErrorMessage(errors) ?? t('circles.studentNotEnrolled')
        error(message)
      },
      onFinish: () => {
        setBusy('detach', student.id, false)
      },
    }
  )
}

const normalize = (value) => (value ?? '').toString().toLowerCase()

function useSimpleTable(itemsRef, { defaultPerPage = perPageOptions[0] } = {}) {
  const search = ref('')
  const perPage = ref(defaultPerPage)
  const page = ref(1)

  const filtered = computed(() => {
    const term = search.value.trim().toLowerCase()
    const source = itemsRef.value ?? []
    if (!term) return source.slice()

    return source.filter((item) => {
      const name = normalize(item?.name)
      const id = (item?.id ?? '').toString()
      return name.includes(term) || id.includes(term)
    })
  })

  const total = computed(() => filtered.value.length)
  const totalPages = computed(() => (total.value === 0 ? 1 : Math.ceil(total.value / perPage.value)))

  const startIndex = computed(() => (page.value - 1) * perPage.value)
  const endIndex = computed(() => Math.min(startIndex.value + perPage.value, total.value))
  const paginated = computed(() => filtered.value.slice(startIndex.value, endIndex.value))

  const startEntry = computed(() => (total.value === 0 ? 0 : startIndex.value + 1))
  const endEntry = computed(() => (total.value === 0 ? 0 : endIndex.value))
  function next() {
    if (page.value < totalPages.value) page.value += 1
  }

  function prev() {
    if (page.value > 1) page.value -= 1
  }

  watch([search, perPage], () => {
    page.value = 1
  })

  watch(itemsRef, () => {
    page.value = 1
  }, { deep: true })

  watch(totalPages, (value) => {
    if (page.value > value) page.value = value
  })

  return reactive({
    search,
    perPage,
    page,
    paginated,
    total,
    totalPages,
    startEntry,
    endEntry,
    next,
    prev,
  })
}

const tables = {
  joined: useSimpleTable(computed(() => props.joinedStudents ?? [])),
  free: useSimpleTable(computed(() => props.freeStudents ?? [])),
}
</script>
