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

        <div
          class="flex flex-col gap-3 border-b border-gray-200 px-4 py-4 dark:border-gray-800 sm:flex-row sm:items-center sm:justify-between"
        >
          <div class="flex items-center gap-3 text-sm text-gray-500 dark:text-gray-400">
            <span>{{ t('datatable.show') }}</span>
            <select
              v-model.number="joinedPerPage"
              class="h-9 rounded-lg border border-gray-300 bg-transparent px-3 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:focus:border-brand-800"
            >
              <option class="dark:bg-gray-900 dark:text-gray-400" :value="10">10</option>
              <option class="dark:bg-gray-900 dark:text-gray-400" :value="25">25</option>
              <option class="dark:bg-gray-900 dark:text-gray-400" :value="50">50</option>
            </select>
            <span>{{ t('datatable.entries') }}</span>
          </div>

          <div class="relative">
            <span class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 dark:text-gray-500">
              <svg class="h-4 w-4" viewBox="0 0 20 20" fill="none">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M3.04199 9.37363C3.04199 5.87693 5.87735 3.04199 9.37533 3.04199C12.8733 3.04199 15.7087 5.87693 15.7087 9.37363C15.7087 12.8703 12.8733 15.7053 9.37533 15.7053C5.87735 15.7053 3.04199 12.8703 3.04199 9.37363ZM9.37533 1.54199C5.04926 1.54199 1.54199 5.04817 1.54199 9.37363C1.54199 13.6991 5.04926 17.2053 9.37533 17.2053C11.2676 17.2053 13.0032 16.5344 14.3572 15.4176L17.1773 18.238C17.4702 18.5309 17.945 18.5309 18.2379 18.238C18.5308 17.9451 18.5309 17.4703 18.238 17.1773L15.4182 14.3573C16.5367 13.0033 17.2087 11.2669 17.2087 9.37363C17.2087 5.04817 13.7014 1.54199 9.37533 1.54199Z" fill="currentColor" />
              </svg>
            </span>
            <input
              v-model="joinedSearch"
              type="text"
              :placeholder="t('datatable.searchPlaceholder')"
              class="h-11 w-full rounded-lg border border-gray-300 bg-transparent py-2.5 pl-10 pr-4 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800"
            />
          </div>
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
              <tr v-for="s in joinedPaginated" :key="`joined-${s.id}`">
                <td class="px-4 py-3 border border-gray-100 dark:border-gray-800">
                  <p class="text-gray-700 text-theme-sm dark:text-gray-400">{{ s.id }}</p>
                </td>
                <td class="px-4 py-3 border border-gray-100 dark:border-gray-800">
                  <p class="text-gray-700 text-theme-sm dark:text-gray-400">{{ s.name ?? '—' }}</p>
                </td>
              </tr>
    
              <tr v-if="joinedPaginated.length === 0">
                <td colspan="2" class="px-4 py-6 text-center text-sm text-gray-500 dark:text-gray-400">
                  {{ t('circles.noCurrentStudents') }}
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <div class="flex flex-col gap-3 border-t border-gray-100 px-4 py-4 text-sm text-gray-500 dark:border-gray-800 dark:text-gray-400 sm:flex-row sm:items-center sm:justify-between">
          <p>
            {{ t('datatable.showing', { start: joinedStartEntry, end: joinedEndEntry, total: joinedTotal }) }}
          </p>
          <div class="flex items-center gap-1">
            <button
              class="flex h-9 items-center justify-center rounded-lg border border-gray-300 px-3 text-sm font-medium text-gray-700 shadow-theme-xs transition hover:bg-gray-50 disabled:opacity-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03]"
              @click="joinedPrevPage"
              :disabled="joinedPage === 1"
            >
              {{ t('datatable.previous') }}
            </button>

            <button
              v-for="page in joinedPages"
              :key="`joined-page-${page}`"
              @click="joinedGoToPage(page)"
              class="flex h-9 w-9 items-center justify-center rounded-lg text-sm font-medium transition"
              :class="joinedPage === page
                ? 'bg-brand-500/10 text-brand-500'
                : 'text-gray-700 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-white/10'"
            >
              {{ page }}
            </button>

            <button
              class="flex h-9 items-center justify-center rounded-lg border border-gray-300 px-3 text-sm font-medium text-gray-700 shadow-theme-xs transition hover:bg-gray-50 disabled:opacity-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03]"
              @click="joinedNextPage"
              :disabled="joinedPage === joinedTotalPages"
            >
              {{ t('datatable.next') }}
            </button>
          </div>
        </div>
      </div>
    
      <!-- جدول: الطلاب غير المرتبطين بأي حلقة -->
      <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800">
          <h3 class="text-base font-medium text-gray-800 dark:text-white">
            {{ t('circles.freeStudents') }}
          </h3>
        </div>

        <div
          class="flex flex-col gap-3 border-b border-gray-200 px-4 py-4 dark:border-gray-800 sm:flex-row sm:items-center sm:justify-between"
        >
          <div class="flex items-center gap-3 text-sm text-gray-500 dark:text-gray-400">
            <span>{{ t('datatable.show') }}</span>
            <select
              v-model.number="freePerPage"
              class="h-9 rounded-lg border border-gray-300 bg-transparent px-3 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:focus:border-brand-800"
            >
              <option class="dark:bg-gray-900 dark:text-gray-400" :value="10">10</option>
              <option class="dark:bg-gray-900 dark:text-gray-400" :value="25">25</option>
              <option class="dark:bg-gray-900 dark:text-gray-400" :value="50">50</option>
            </select>
            <span>{{ t('datatable.entries') }}</span>
          </div>

          <div class="relative">
            <span class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 dark:text-gray-500">
              <svg class="h-4 w-4" viewBox="0 0 20 20" fill="none">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M3.04199 9.37363C3.04199 5.87693 5.87735 3.04199 9.37533 3.04199C12.8733 3.04199 15.7087 5.87693 15.7087 9.37363C15.7087 12.8703 12.8733 15.7053 9.37533 15.7053C5.87735 15.7053 3.04199 12.8703 3.04199 9.37363ZM9.37533 1.54199C5.04926 1.54199 1.54199 5.04817 1.54199 9.37363C1.54199 13.6991 5.04926 17.2053 9.37533 17.2053C11.2676 17.2053 13.0032 16.5344 14.3572 15.4176L17.1773 18.238C17.4702 18.5309 17.945 18.5309 18.2379 18.238C18.5308 17.9451 18.5309 17.4703 18.238 17.1773L15.4182 14.3573C16.5367 13.0033 17.2087 11.2669 17.2087 9.37363C17.2087 5.04817 13.7014 1.54199 9.37533 1.54199Z" fill="currentColor" />
              </svg>
            </span>
            <input
              v-model="freeSearch"
              type="text"
              :placeholder="t('datatable.searchPlaceholder')"
              class="h-11 w-full rounded-lg border border-gray-300 bg-transparent py-2.5 pl-10 pr-4 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800"
            />
          </div>
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
              <tr v-for="s in freePaginated" :key="`free-${s.id}`">
                <td class="px-4 py-3 border border-gray-100 dark:border-gray-800">
                  <p class="text-gray-700 text-theme-sm dark:text-gray-400">{{ s.id }}</p>
                </td>
                <td class="px-4 py-3 border border-gray-100 dark:border-gray-800">
                  <p class="text-gray-700 text-theme-sm dark:text-gray-400">{{ s.name ?? '—' }}</p>
                </td>
              </tr>
    
              <tr v-if="freePaginated.length === 0">
                <td colspan="2" class="px-4 py-6 text-center text-sm text-gray-500 dark:text-gray-400">
                  {{ t('circles.noFreeStudents') }}
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <div class="flex flex-col gap-3 border-t border-gray-100 px-4 py-4 text-sm text-gray-500 dark:border-gray-800 dark:text-gray-400 sm:flex-row sm:items-center sm:justify-between">
          <p>
            {{ t('datatable.showing', { start: freeStartEntry, end: freeEndEntry, total: freeTotal }) }}
          </p>
          <div class="flex items-center gap-1">
            <button
              class="flex h-9 items-center justify-center rounded-lg border border-gray-300 px-3 text-sm font-medium text-gray-700 shadow-theme-xs transition hover:bg-gray-50 disabled:opacity-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03]"
              @click="freePrevPage"
              :disabled="freePage === 1"
            >
              {{ t('datatable.previous') }}
            </button>

            <button
              v-for="page in freePages"
              :key="`free-page-${page}`"
              @click="freeGoToPage(page)"
              class="flex h-9 w-9 items-center justify-center rounded-lg text-sm font-medium transition"
              :class="freePage === page
                ? 'bg-brand-500/10 text-brand-500'
                : 'text-gray-700 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-white/10'"
            >
              {{ page }}
            </button>

            <button
              class="flex h-9 items-center justify-center rounded-lg border border-gray-300 px-3 text-sm font-medium text-gray-700 shadow-theme-xs transition hover:bg-gray-50 disabled:opacity-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03]"
              @click="freeNextPage"
              :disabled="freePage === freeTotalPages"
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
import { computed, ref, toRefs, watch } from 'vue'
import { Link } from '@inertiajs/vue3'
import { useI18n } from 'vue-i18n'

const { t } = useI18n()

const props = defineProps({
  circle: { type: Object, required: true },
  joinedStudents: { type: Array, required: true },
  freeStudents: { type: Array, required: true },
})

const { circle, joinedStudents, freeStudents } = toRefs(props)

const joinedSearch = ref('')
const joinedPerPage = ref(10)
const joinedPage = ref(1)

const freeSearch = ref('')
const freePerPage = ref(10)
const freePage = ref(1)

const normalize = (value) => (value ?? '').toString().toLowerCase()

const joinedFiltered = computed(() => {
  const term = joinedSearch.value.trim().toLowerCase()
  const source = joinedStudents.value ?? []
  if (!term) return source
  return source.filter((student) => {
    const name = normalize(student.name)
    const id = (student.id ?? '').toString()
    return name.includes(term) || id.includes(term)
  })
})

const joinedTotal = computed(() => joinedFiltered.value.length)
const joinedTotalPages = computed(() => (joinedTotal.value === 0 ? 1 : Math.ceil(joinedTotal.value / joinedPerPage.value)))
const joinedPaginated = computed(() => {
  const start = (joinedPage.value - 1) * joinedPerPage.value
  return joinedFiltered.value.slice(start, start + joinedPerPage.value)
})
const joinedStartEntry = computed(() => (joinedTotal.value === 0 ? 0 : (joinedPage.value - 1) * joinedPerPage.value + 1))
const joinedEndEntry = computed(() => Math.min(joinedPage.value * joinedPerPage.value, joinedTotal.value))
const joinedPages = computed(() => Array.from({ length: joinedTotalPages.value }, (_, i) => i + 1))

const freeFiltered = computed(() => {
  const term = freeSearch.value.trim().toLowerCase()
  const source = freeStudents.value ?? []
  if (!term) return source
  return source.filter((student) => {
    const name = normalize(student.name)
    const id = (student.id ?? '').toString()
    return name.includes(term) || id.includes(term)
  })
})

const freeTotal = computed(() => freeFiltered.value.length)
const freeTotalPages = computed(() => (freeTotal.value === 0 ? 1 : Math.ceil(freeTotal.value / freePerPage.value)))
const freePaginated = computed(() => {
  const start = (freePage.value - 1) * freePerPage.value
  return freeFiltered.value.slice(start, start + freePerPage.value)
})
const freeStartEntry = computed(() => (freeTotal.value === 0 ? 0 : (freePage.value - 1) * freePerPage.value + 1))
const freeEndEntry = computed(() => Math.min(freePage.value * freePerPage.value, freeTotal.value))
const freePages = computed(() => Array.from({ length: freeTotalPages.value }, (_, i) => i + 1))

const joinedGoToPage = (page) => {
  if (page >= 1 && page <= joinedTotalPages.value) joinedPage.value = page
}
const joinedNextPage = () => { if (joinedPage.value < joinedTotalPages.value) joinedPage.value += 1 }
const joinedPrevPage = () => { if (joinedPage.value > 1) joinedPage.value -= 1 }

const freeGoToPage = (page) => {
  if (page >= 1 && page <= freeTotalPages.value) freePage.value = page
}
const freeNextPage = () => { if (freePage.value < freeTotalPages.value) freePage.value += 1 }
const freePrevPage = () => { if (freePage.value > 1) freePage.value -= 1 }

watch([joinedSearch, joinedPerPage], () => { joinedPage.value = 1 })
watch([freeSearch, freePerPage], () => { freePage.value = 1 })

watch(joinedStudents, () => {
  joinedPage.value = 1
}, { deep: true })

watch(freeStudents, () => {
  freePage.value = 1
}, { deep: true })

watch(joinedTotalPages, (newTotal) => {
  if (joinedPage.value > newTotal) joinedPage.value = newTotal
})

watch(freeTotalPages, (newTotal) => {
  if (freePage.value > newTotal) freePage.value = newTotal
})

</script>
