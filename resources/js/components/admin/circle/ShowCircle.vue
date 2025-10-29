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

    <!-- ✅ أضِف هذا القسم أسفل بطاقة معلومات الحلقة وقبل أزرار "رجوع/تعديل" -->

<!-- Students Tables -->
<div class="grid grid-cols-1 gap-6 md:grid-cols-2">
  <!-- جدول طلاب الحلقة الحاليين -->
  <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
    <div class="flex items-center justify-between border-b border-gray-200 px-4 py-3 dark:border-gray-800">
      <h3 class="text-base font-medium text-gray-800 dark:text-white">
        {{ t('circles.currentStudents') || 'Current Students' }}
      </h3>

      <div class="flex items-center gap-3">
        <div class="relative">
          <button class="absolute text-gray-500 -translate-y-1/2 left-3 top-1/2 dark:text-gray-400">
            <svg class="fill-current" width="18" height="18" viewBox="0 0 20 20" fill="none">
              <path fill-rule="evenodd" clip-rule="evenodd" d="M3.042 9.374c0-3.497 2.835-6.332 6.333-6.332 3.497 0 6.333 2.835 6.333 6.332 0 3.497-2.836 6.333-6.333 6.333-3.498 0-6.333-2.836-6.333-6.333Zm6.333-7.832C5.05 1.542 1.542 5.048 1.542 9.374c0 4.325 3.508 7.831 7.833 7.831 1.892 0 3.628-.671 4.982-1.788l2.82 2.82c.293.293.768.293 1.06 0 .293-.293.293-.768 0-1.06l-2.82-2.821c1.118-1.354 1.79-3.09 1.79-4.982 0-4.326-3.508-7.832-7.832-7.832Z" />
            </svg>
          </button>
          <input
            v-model="tables.current.search"
            type="text"
            :placeholder="t('datatable.searchPlaceholder')"
            class="dark:bg-dark-900 h-10 w-40 rounded-lg border border-gray-300 bg-transparent py-2 pl-9 pr-3 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800"
          />
        </div>

        <div class="relative z-10 bg-transparent">
          <select
            v-model="tables.current.perPage"
            class="w-[64px] h-9 rounded-lg border border-gray-300 bg-transparent pl-2 pr-6 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
          >
            <option :value="5"  class="dark:bg-gray-900">5</option>
            <option :value="8"  class="dark:bg-gray-900">8</option>
            <option :value="10" class="dark:bg-gray-900">10</option>
          </select>
          <span class="pointer-events-none absolute right-2 top-1/2 -translate-y-1/2 text-gray-500 dark:text-gray-400">
            <svg width="14" height="14" viewBox="0 0 16 16" fill="none"><path d="M3.833 5.917 8 10.083l4.167-4.166" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </span>
        </div>
      </div>
    </div>

    <div class="max-w-full overflow-x-auto">
      <table class="w-full min-w-full">
        <thead>
          <tr>
            <th class="px-4 py-3 text-start border border-gray-100 dark:border-gray-800 w-16">#</th>
            <th class="px-4 py-3 text-start border border-gray-100 dark:border-gray-800">
              <div class="flex cursor-pointer items-center justify-between" @click="tables.current.sortBy('name')">
                <span class="font-medium text-gray-700 text-theme-xs dark:text-gray-400">{{ t('common.name') }}</span>
                <span class="flex flex-col">
                  <svg class="fill-gray-300 dark:fill-gray-700" width="8" height="5" viewBox="0 0 8 5"><path d="M4.41.585a.5.5 0 0 0-.82 0L1.05 4.213C.819 4.545 1.056 5 1.46 5h5.08c.404 0 .641-.455.41-.787L4.41.585Z"/></svg>
                  <svg class="fill-gray-300 dark:fill-gray-700" width="8" height="5" viewBox="0 0 8 5"><path d="M4.41 4.415a.5.5 0 0 1-.82 0L1.05.787C.819.455 1.056 0 1.46 0h5.08c.404 0 .641.455.41.787L4.41 4.415Z"/></svg>
                </span>
              </div>
            </th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(s, idx) in tables.current.paginated" :key="s.id">
            <td class="px-4 py-3 border border-gray-100 dark:border-gray-800">{{ tables.current.rowNumber(idx) }}</td>
            <td class="px-4 py-3 border border-gray-100 dark:border-gray-800">
              <span class="text-gray-700 text-theme-sm dark:text-gray-400">{{ s.name }}</span>
            </td>
          </tr>
          <tr v-if="tables.current.total === 0">
            <td colspan="2" class="px-4 py-6 text-center text-sm text-gray-500 dark:text-gray-400">
              {{ t('students.noStudents') || 'No students' }}
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- pagination -->
    <div class="border border-t-0 rounded-b-2xl border-gray-100 px-4 py-3 dark:border-gray-800">
      <div class="flex items-center justify-between">
        <p class="text-sm text-gray-500 dark:text-gray-400">
          {{ t('datatable.showing', { start: tables.current.startEntry, end: tables.current.endEntry, total: tables.current.total }) }}
        </p>
        <div class="flex items-center gap-1">
          <button @click="tables.current.prev()" :disabled="tables.current.page === 1" class="rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-700 shadow-theme-xs hover:bg-gray-50 disabled:opacity-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400">
            {{ t('datatable.previous') }}
          </button>
          <button @click="tables.current.next()" :disabled="tables.current.page === tables.current.totalPages" class="rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-700 shadow-theme-xs hover:bg-gray-50 disabled:opacity-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400">
            {{ t('datatable.next') }}
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- جدول الطلاب غير الملتحقين بأي حلقة -->
  <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
    <div class="flex items-center justify-between border-b border-gray-200 px-4 py-3 dark:border-gray-800">
      <h3 class="text-base font-medium text-gray-800 dark:text-white">
        {{ t('circles.freeStudents') || 'Unassigned Students' }}
      </h3>

      <div class="flex items-center gap-3">
        <div class="relative">
          <button class="absolute text-gray-500 -translate-y-1/2 left-3 top-1/2 dark:text-gray-400">
            <svg class="fill-current" width="18" height="18" viewBox="0 0 20 20" fill="none"><path fill-rule="evenodd" clip-rule="evenodd" d="M3.042 9.374c0-3.497 2.835-6.332 6.333-6.332 3.497 0 6.333 2.835 6.333 6.332 0 3.497-2.836 6.333-6.333 6.333-3.498 0-6.333-2.836-6.333-6.333Z"/></svg>
          </button>
          <input
            v-model="tables.free.search"
            type="text"
            :placeholder="t('datatable.searchPlaceholder')"
            class="dark:bg-dark-900 h-10 w-40 rounded-lg border border-gray-300 bg-transparent py-2 pl-9 pr-3 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800"
          />
        </div>

        <div class="relative z-10 bg-transparent">
          <select
            v-model="tables.free.perPage"
            class="w-[64px] h-9 rounded-lg border border-gray-300 bg-transparent pl-2 pr-6 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
          >
            <option :value="5"  class="dark:bg-gray-900">5</option>
            <option :value="8"  class="dark:bg-gray-900">8</option>
            <option :value="10" class="dark:bg-gray-900">10</option>
          </select>
          <span class="pointer-events-none absolute right-2 top-1/2 -translate-y-1/2 text-gray-500 dark:text-gray-400">
            <svg width="14" height="14" viewBox="0 0 16 16" fill="none"><path d="M3.833 5.917 8 10.083l4.167-4.166" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </span>
        </div>
      </div>
    </div>

    <div class="max-w-full overflow-x-auto">
      <table class="w-full min-w-full">
        <thead>
          <tr>
            <th class="px-4 py-3 text-start border border-gray-100 dark:border-gray-800 w-16">#</th>
            <th class="px-4 py-3 text-start border border-gray-100 dark:border-gray-800">
              <div class="flex cursor-pointer items-center justify-between" @click="tables.free.sortBy('name')">
                <span class="font-medium text-gray-700 text-theme-xs dark:text-gray-400">{{ t('common.name') }}</span>
                <span class="flex flex-col">
                  <svg class="fill-gray-300 dark:fill-gray-700" width="8" height="5" viewBox="0 0 8 5"><path d="M4.41.585a.5.5 0 0 0-.82 0L1.05 4.213C.819 4.545 1.056 5 1.46 5h5.08c.404 0 .641-.455.41-.787L4.41.585Z"/></svg>
                  <svg class="fill-gray-300 dark:fill-gray-700" width="8" height="5" viewBox="0 0 8 5"><path d="M4.41 4.415a.5.5 0 0 1-.82 0L1.05.787C.819.455 1.056 0 1.46 0h5.08c.404 0 .641.455.41.787L4.41 4.415Z"/></svg>
                </span>
              </div>
            </th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(s, idx) in tables.free.paginated" :key="s.id">
            <td class="px-4 py-3 border border-gray-100 dark:border-gray-800">{{ tables.free.rowNumber(idx) }}</td>
            <td class="px-4 py-3 border border-gray-100 dark:border-gray-800">
              <span class="text-gray-700 text-theme-sm dark:text-gray-400">{{ s.name }}</span>
            </td>
          </tr>
          <tr v-if="tables.free.total === 0">
            <td colspan="2" class="px-4 py-6 text-center text-sm text-gray-500 dark:text-gray-400">
              {{ t('students.noFreeStudents') || 'No unassigned students' }}
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- pagination -->
    <div class="border border-t-0 rounded-b-2xl border-gray-100 px-4 py-3 dark:border-gray-800">
      <div class="flex items-center justify-between">
        <p class="text-sm text-gray-500 dark:text-gray-400">
          {{ t('datatable.showing', { start: tables.free.startEntry, end: tables.free.endEntry, total: tables.free.total }) }}
        </p>
        <div class="flex items-center gap-1">
          <button @click="tables.free.prev()" :disabled="tables.free.page === 1" class="rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-700 shadow-theme-xs hover:bg-gray-50 disabled:opacity-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400">
            {{ t('datatable.previous') }}
          </button>
          <button @click="tables.free.next()" :disabled="tables.free.page === tables.free.totalPages" class="rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-700 shadow-theme-xs hover:bg-gray-50 disabled:opacity-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400">
            {{ t('datatable.next') }}
          </button>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- /Students Tables -->

  

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
import { ref, reactive, computed, watch } from 'vue'
import { Link } from '@inertiajs/vue3'
import { useI18n } from 'vue-i18n'

const { t } = useI18n()

/** ✅ عدّل الـ props لتستقبل القوائم (id,name) */
const props = defineProps({
  circle: { type: Object, required: true },
  currentStudents: { type: Array, default: () => [] }, // [{id,name}]
  freeStudents:    { type: Array, default: () => [] }, // [{id,name}]
})

/** 🔁 مُنشئ حالة جدول عام لتفادي تكرار الكود */
function useSimpleTable(rawItemsRef) {
  const search   = ref('')
  const page     = ref(1)
  const perPage  = ref(8)
  const sortCol  = ref('name')
  const sortDir  = ref('asc') // asc | desc

  const filtered = computed(() => {
    const term = (search.value || '').toLowerCase().trim()
    let arr = (rawItemsRef.value || []).filter(x =>
      !term ? true : (x.name || '').toLowerCase().includes(term)
    )
    // sort
    const m = sortDir.value === 'asc' ? 1 : -1
    arr = arr.slice().sort((a, b) => (a[sortCol.value] || '').localeCompare(b[sortCol.value] || '') * m)
    return arr
  })

  const total = computed(() => filtered.value.length)
  const totalPages = computed(() => Math.max(1, Math.ceil(total.value / perPage.value)))
  watch([perPage, filtered], () => { if (page.value > totalPages.value) page.value = 1 })

  const startIndex = computed(() => (page.value - 1) * perPage.value)
  const endIndex   = computed(() => Math.min(startIndex.value + perPage.value, total.value))
  const paginated  = computed(() => filtered.value.slice(startIndex.value, endIndex.value))

  function sortBy(col) {
    if (sortCol.value === col) sortDir.value = sortDir.value === 'asc' ? 'desc' : 'asc'
    else { sortCol.value = col; sortDir.value = 'asc' }
  }

  function next() { if (page.value < totalPages.value) page.value++ }
  function prev() { if (page.value > 1) page.value-- }

  function rowNumber(idxInPage) { return startIndex.value + idxInPage + 1 }
  const startEntry = computed(() => (total.value ? startIndex.value + 1 : 0))
  const endEntry   = computed(() => endIndex.value)

  return reactive({
    // state
    search, page, perPage, sortCol, sortDir,
    // data
    filtered, paginated, total, totalPages, startEntry, endEntry,
    // actions
    sortBy, next, prev, rowNumber,
  })
}

/** 🔗 اربط الجدولين */
const tables = {
  current: useSimpleTable(computed(() => props.currentStudents)),
  free:    useSimpleTable(computed(() => props.freeStudents)),
}
</script>
