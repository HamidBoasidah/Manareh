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

    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
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
              v-model.number="tables.joined.perPage"
              class="h-9 rounded-lg border border-gray-300 bg-transparent px-3 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:focus:border-brand-800"
            >
              <option v-for="option in perPageOptions" :key="`joined-per-${option}`" class="dark:bg-gray-900 dark:text-gray-400" :value="option">
                {{ option }}
              </option>
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
              v-model="tables.joined.search"
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
                <th class="w-20 border border-gray-100 px-4 py-3 text-start dark:border-gray-800">
                  <p class="text-theme-xs font-medium text-gray-700 dark:text-gray-400">ID</p>
                </th>
                <th class="border border-gray-100 px-4 py-3 text-start dark:border-gray-800">
                  <p class="text-theme-xs font-medium text-gray-700 dark:text-gray-400">{{ t('common.name') }}</p>
                </th>
                <th v-if="canManage" class="w-24 border border-gray-100 px-4 py-3 text-end dark:border-gray-800">
                  <p class="text-theme-xs font-medium text-gray-700 dark:text-gray-400">{{ t('common.action') }}</p>
                </th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="student in tables.joined.paginated" :key="`joined-${student.id}`">
                <td class="border border-gray-100 px-4 py-3 dark:border-gray-800">
                  <p class="text-theme-sm text-gray-700 dark:text-gray-400">{{ student.id }}</p>
                </td>
                <td class="border border-gray-100 px-4 py-3 dark:border-gray-800">
                  <p class="text-theme-sm text-gray-700 dark:text-gray-400">{{ student.name ?? '—' }}</p>
                </td>
                <td v-if="canManage" class="border border-gray-100 px-4 py-3 text-end dark:border-gray-800">
                  <button
                    type="button"
                    class="inline-flex h-8 w-8 items-center justify-center rounded-full border border-error-200 text-error-500 transition hover:bg-error-100 focus:outline-hidden focus:ring-2 focus:ring-error-300 disabled:cursor-not-allowed disabled:opacity-60 dark:border-error-500/30 dark:text-error-400 dark:hover:bg-error-500/15 dark:focus:ring-error-500/40"
                    :title="t('common.delete')"
                    :disabled="isDetachBusy(student.id)"
                    @click="detachStudent(student)"
                  >
                    <svg class="h-4 w-4" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path
                        fill-rule="evenodd"
                        clip-rule="evenodd"
                        d="M7.04142 4.29199C7.04142 3.04935 8.04878 2.04199 9.29142 2.04199H11.7081C12.9507 2.04199 13.9581 3.04935 13.9581 4.29199V4.54199H16.1252H17.166C17.5802 4.54199 17.916 4.87778 17.916 5.29199C17.916 5.70621 17.5802 6.04199 17.166 6.04199H16.8752V8.74687V13.7469V16.7087C16.8752 17.9513 15.8678 18.9587 14.6252 18.9587H6.37516C5.13252 18.9587 4.12516 17.9513 4.12516 16.7087V13.7469V8.74687V6.04199H3.8335C3.41928 6.04199 3.0835 5.70621 3.0835 5.29199C3.0835 4.87778 3.41928 4.54199 3.8335 4.54199H4.87516H7.04142V4.29199ZM15.3752 13.7469V8.74687V6.04199H13.9581H13.2081H7.79142H7.04142H5.62516V8.74687V13.7469V16.7087C5.62516 17.1229 5.96095 17.4587 6.37516 17.4587H14.6252C15.0394 17.4587 15.3752 17.1229 15.3752 16.7087V13.7469ZM8.8335 4.54199H12.4581V4.29199C12.4581 3.87778 12.1223 3.54199 11.7081 3.54199H9.29142C8.87721 3.54199 8.54142 3.87778 8.54142 4.29199V4.54199ZM8.8335 8.50033C9.24771 8.50033 9.5835 8.83611 9.5835 9.25033V14.2503C9.5835 14.6645 9.24771 15.0003 8.8335 15.0003C8.41928 15.0003 8.0835 14.6645 8.0835 14.2503V9.25033C8.0835 8.83611 8.41928 8.50033 8.8335 8.50033ZM12.9168 9.25033C12.9168 8.83611 12.581 8.50033 12.1668 8.50033C11.7526 8.50033 11.4168 8.83611 11.4168 9.25033V14.2503C11.4168 14.6645 11.7526 15.0003 12.1668 15.0003C12.581 15.0003 12.9168 14.6645 12.9168 14.2503V9.25033Z"
                        fill="currentColor"
                      />
                    </svg>
                  </button>
                </td>
              </tr>
              <tr v-if="tables.joined.paginated.length === 0">
                <td :colspan="canManage ? 3 : 2" class="px-4 py-6 text-center text-sm text-gray-500 dark:text-gray-400">
                  {{ t('circles.noCurrentStudents') }}
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <div class="flex flex-col gap-3 border-t border-gray-100 px-4 py-4 text-sm text-gray-500 dark:border-gray-800 dark:text-gray-400 sm:flex-row sm:items-center sm:justify-between">
          <p>
            {{ t('datatable.showing', { start: tables.joined.startEntry, end: tables.joined.endEntry, total: tables.joined.total }) }}
          </p>
          <div class="flex items-center gap-1">
            <button
              class="flex h-9 items-center justify-center rounded-lg border border-gray-300 px-3 text-sm font-medium text-gray-700 shadow-theme-xs transition hover:bg-gray-50 disabled:opacity-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03]"
              @click="tables.joined.prev()"
              :disabled="tables.joined.page === 1"
            >
              {{ t('datatable.previous') }}
            </button>

            <button
              class="flex h-9 items-center justify-center rounded-lg border border-gray-300 px-3 text-sm font-medium text-gray-700 shadow-theme-xs transition hover:bg-gray-50 disabled:opacity-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03]"
              @click="tables.joined.next()"
              :disabled="tables.joined.page === tables.joined.totalPages"
            >
              {{ t('datatable.next') }}
            </button>
          </div>
        </div>
      </div>

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
              v-model.number="tables.free.perPage"
              class="h-9 rounded-lg border border-gray-300 bg-transparent px-3 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:focus:border-brand-800"
            >
              <option v-for="option in perPageOptions" :key="`free-per-${option}`" class="dark:bg-gray-900 dark:text-gray-400" :value="option">
                {{ option }}
              </option>
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
              v-model="tables.free.search"
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
                <th class="w-20 border border-gray-100 px-4 py-3 text-start dark:border-gray-800">
                  <p class="text-theme-xs font-medium text-gray-700 dark:text-gray-400">ID</p>
                </th>
                <th class="border border-gray-100 px-4 py-3 text-start dark:border-gray-800">
                  <p class="text-theme-xs font-medium text-gray-700 dark:text-gray-400">{{ t('common.name') }}</p>
                </th>
                <th v-if="canManage" class="w-24 border border-gray-100 px-4 py-3 text-end dark:border-gray-800">
                  <p class="text-theme-xs font-medium text-gray-700 dark:text-gray-400">{{ t('common.action') }}</p>
                </th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="student in tables.free.paginated" :key="`free-${student.id}`">
                <td class="border border-gray-100 px-4 py-3 dark:border-gray-800">
                  <p class="text-theme-sm text-gray-700 dark:text-gray-400">{{ student.id }}</p>
                </td>
                <td class="border border-gray-100 px-4 py-3 dark:border-gray-800">
                  <p class="text-theme-sm text-gray-700 dark:text-gray-400">{{ student.name ?? '—' }}</p>
                </td>
                <td v-if="canManage" class="border border-gray-100 px-4 py-3 text-end dark:border-gray-800">
                  <button
                    type="button"
                    class="inline-flex h-8 w-8 items-center justify-center rounded-full border border-brand-200 text-brand-500 transition hover:bg-brand-100 focus:outline-hidden focus:ring-2 focus:ring-brand-300 disabled:cursor-not-allowed disabled:opacity-60 dark:border-brand-500/40 dark:text-brand-400 dark:hover:bg-brand-500/15 dark:focus:ring-brand-500/40"
                    :title="t('common.create')"
                    :disabled="isAttachBusy(student.id)"
                    @click="attachStudent(student)"
                  >
                    <svg class="h-4 w-4" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path
                        d="M5 10.0002H15.0006M10.0002 5V15.0006"
                        stroke="currentColor"
                        stroke-width="1.5"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                      />
                    </svg>
                  </button>
                </td>
              </tr>
              <tr v-if="tables.free.paginated.length === 0">
                <td :colspan="canManage ? 3 : 2" class="px-4 py-6 text-center text-sm text-gray-500 dark:text-gray-400">
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
