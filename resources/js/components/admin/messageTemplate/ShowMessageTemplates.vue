<template>
  <div class="overflow-hidden">
    <div class="flex flex-col gap-4 border border-b-0 border-gray-200 px-4 py-4 dark:border-gray-800 sm:flex-row sm:items-center sm:justify-between">
      <div class="flex flex-1 flex-wrap items-center gap-3">
        <div class="relative">
          <span class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-gray-500 dark:text-gray-400">
            <svg class="fill-current" width="18" height="18" viewBox="0 0 20 20" fill="none">
              <path fill-rule="evenodd" clip-rule="evenodd" d="M3.04199 9.37363C3.04199 5.87693 5.87735 3.04199 9.37533 3.04199C12.8733 3.04199 15.7087 5.87693 15.7087 9.37363C15.7087 12.8703 12.8733 15.7053 9.37533 15.7053C5.87735 15.7053 3.04199 12.8703 3.04199 9.37363ZM9.37533 1.54199C5.04926 1.54199 1.54199 5.04817 1.54199 9.37363C1.54199 13.6991 5.04926 17.2053 9.37533 17.2053C11.2676 17.2053 13.0032 16.5344 14.3572 15.4176L17.1773 18.238C17.4702 18.5309 17.945 18.5309 18.2379 18.238C18.5308 17.9451 18.5309 17.4703 18.238 17.1773L15.4182 14.3573C16.5367 13.0033 17.2087 11.2669 17.2087 9.37363C17.2087 5.04817 13.7014 1.54199 9.37533 1.54199Z" />
            </svg>
          </span>
          <input
            v-model.trim="localFilters.search"
            type="text"
            :placeholder="t('datatable.searchPlaceholder')"
            class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent py-2.5 pl-10 pr-4 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:text-white/90 dark:placeholder:text-white/30"
          />
        </div>

        <div class="flex items-center gap-3">
          <select
            v-model="localFilters.channel"
            class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-10 rounded-lg border border-gray-300 bg-transparent px-3 text-sm text-gray-800 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:text-white/90"
          >
            <option value="" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">{{ t('message_templates.filters.allChannels') }}</option>
            <option v-for="channel in (options.channels || [])" :key="channel" :value="channel" class="text-gray-700 dark:bg-gray-900 dark:text-gray-300">
              {{ formatChannel(channel) }}
            </option>
          </select>

          <select
            v-model="localFilters.locale"
            class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-10 rounded-lg border border-gray-300 bg-transparent px-3 text-sm text-gray-800 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:text-white/90"
          >
            <option value="" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">{{ t('message_templates.filters.allLocales') }}</option>
            <option v-for="locale in (options.locales || [])" :key="locale" :value="locale" class="text-gray-700 dark:bg-gray-900 dark:text-gray-300">
              {{ locale.toUpperCase() }}
            </option>
          </select>

          <select
            v-model="localFilters.is_active"
            class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-10 rounded-lg border border-gray-300 bg-transparent px-3 text-sm text-gray-800 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:text-white/90"
          >
            <option value="" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">{{ t('message_templates.filters.allStatuses') }}</option>
            <option value="1" class="text-gray-700 dark:bg-gray-900 dark:text-gray-300">{{ t('common.active') }}</option>
            <option value="0" class="text-gray-700 dark:bg-gray-900 dark:text-gray-300">{{ t('common.inactive') }}</option>
          </select>
        </div>
      </div>

      <div class="flex items-center gap-3">
        <div class="relative">
          <select
            v-model.number="localFilters.per_page"
            class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-10 rounded-lg border border-gray-300 bg-transparent pl-3 pr-8 text-sm text-gray-800 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:text-white/90"
          >
            <option v-for="size in [10, 25, 50]" :key="size" :value="size" class="text-gray-700 dark:bg-gray-900 dark:text-gray-300">{{ size }}</option>
          </select>
          <span class="pointer-events-none absolute right-2 top-1/2 -translate-y-1/2 text-gray-500 dark:text-gray-400">
            <svg class="stroke-current" width="16" height="16" viewBox="0 0 20 20" fill="none">
              <path d="M4.79175 7.396L10.0001 12.6043L15.2084 7.396" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
          </span>
        </div>

        <Tooltip :text="t('messages.notAuthorized')" :show="!canCreate">
          <button
            :disabled="!canCreate"
            class="bg-brand-500 shadow-theme-xs hover:bg-brand-600 inline-flex items-center justify-center gap-2 rounded-lg px-4 py-2.5 text-sm font-medium text-white transition disabled:bg-brand-300 disabled:hover:bg-brand-300"
            @click="goToCreate"
          >
            <svg width="18" height="18" viewBox="0 0 20 20" fill="none"><path d="M10 4.1665V15.8332" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" /><path d="M4.16663 10H15.8333" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" /></svg>
            {{ t('message_templates.actions.createTemplate') }}
          </button>
        </Tooltip>
      </div>
    </div>

    <div class="max-w-full overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-800">
        <thead class="bg-gray-50 dark:bg-white/5">
          <tr>
            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wide text-gray-500 dark:text-gray-300">{{ t('message_templates.fields.name') }}</th>
            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wide text-gray-500 dark:text-gray-300">{{ t('message_templates.fields.code') }}</th>
            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wide text-gray-500 dark:text-gray-300">{{ t('message_templates.fields.channel') }}</th>
            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wide text-gray-500 dark:text-gray-300">{{ t('message_templates.fields.locale') }}</th>
            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wide text-gray-500 dark:text-gray-300">{{ t('message_templates.fields.variablesCount') }}</th>
            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wide text-gray-500 dark:text-gray-300">{{ t('message_templates.fields.updatedAt') }}</th>
            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wide text-gray-500 dark:text-gray-300">{{ t('common.status') }}</th>
            <th class="px-4 py-3 text-center text-xs font-medium uppercase tracking-wide text-gray-500 dark:text-gray-300">{{ t('common.action') }}</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 bg-white dark:divide-gray-800 dark:bg-transparent">
          <tr v-for="template in (messageTemplates.data || [])" :key="template.id">
            <td class="px-4 py-3 text-sm font-medium text-gray-800 dark:text-gray-100">{{ template.name }}</td>
            <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-300"><code class="rounded bg-gray-100 px-2 py-1 text-xs dark:bg-white/10">{{ template.code }}</code></td>
            <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-300">{{ formatChannel(template.channel) }}</td>
            <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-300">{{ template.locale?.toUpperCase() }}</td>
            <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-300">{{ template.variables_count }}</td>
            <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-300">{{ formatDate(template.updated_at) }}</td>
            <td class="px-4 py-3 text-sm">
              <span :class="template.is_active ? 'bg-green-50 text-green-600 dark:bg-green-500/15 dark:text-green-400' : 'bg-error-50 text-error-600 dark:bg-error-500/15 dark:text-error-400'" class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium">
                {{ template.is_active ? t('common.active') : t('common.inactive') }}
              </span>
            </td>
            <td class="px-4 py-3 text-sm">
              <div class="flex items-center justify-center gap-2">
                <Tooltip :text="t('messages.notAuthorized')" :show="!canView">
                  <button :disabled="!canView" class="text-gray-500 transition hover:text-gray-800 dark:text-gray-400 dark:hover:text-white/90 disabled:text-gray-400" @click="goToShow(template.id)">
                    <svg class="fill-current" width="18" height="18" viewBox="0 0 20 20" fill="none"><path fill-rule="evenodd" clip-rule="evenodd" d="M10.8749 13.8619C8.10837 13.8619 5.74279 12.1372 4.79804 9.70241C5.74279 7.26761 8.10837 5.54297 10.8749 5.54297C13.6415 5.54297 16.0071 7.26762 16.9518 9.70243C16.0071 12.1372 13.6415 13.8619 10.8749 13.8619ZM10.8749 4.04297C7.35666 4.04297 4.36964 6.30917 3.29025 9.4593C3.23626 9.61687 3.23626 9.78794 3.29025 9.94552C4.36964 13.0957 7.35666 15.3619 10.8749 15.3619C14.3932 15.3619 17.3802 13.0957 18.4596 9.94555C18.5136 9.78797 18.5136 9.6169 18.4596 9.45932C17.3802 6.30919 14.3932 4.04297 10.8749 4.04297ZM10.8663 7.84413C9.84002 7.84413 9.00808 8.67606 9.00808 9.70231C9.00808 10.7286 9.84002 11.5605 10.8663 11.5605H10.8811C11.9074 11.5605 12.7393 10.7286 12.7393 9.70231C12.7393 8.67606 11.9074 7.84413 10.8811 7.84413H10.8663Z" /></svg>
                  </button>
                </Tooltip>

                <Tooltip :text="t('messages.notAuthorized')" :show="!canEdit">
                  <button :disabled="!canEdit" class="text-gray-500 transition hover:text-brand-500 dark:text-gray-400 dark:hover:text-brand-300 disabled:text-gray-400" @click="goToEdit(template.id)">
                    <svg class="fill-current" width="18" height="18" viewBox="0 0 20 20" fill="none"><path fill-rule="evenodd" clip-rule="evenodd" d="M17.0911 3.53206C16.2124 2.65338 14.7878 2.65338 13.9091 3.53206L5.6074 11.8337C5.29899 12.1421 5.08687 12.5335 4.99684 12.9603L4.26177 16.445C4.20943 16.6931 4.286 16.9508 4.46529 17.1301C4.64458 17.3094 4.90232 17.3859 5.15042 17.3336L8.63507 16.5985C9.06184 16.5085 9.45324 16.2964 9.76165 15.988L18.0633 7.68631C18.942 6.80763 18.942 5.38301 18.0633 4.50433L17.0911 3.53206ZM14.9697 4.59272C15.2626 4.29982 15.7375 4.29982 16.0304 4.59272L17.0027 5.56499C17.2956 5.85788 17.2956 6.33276 17.0027 6.62565L16.1043 7.52402L14.0714 5.49109L14.9697 4.59272ZM13.0107 6.55175L6.66806 12.8944C6.56526 12.9972 6.49455 13.1277 6.46454 13.2699L5.96704 15.6283L8.32547 15.1308C8.46772 15.1008 8.59819 15.0301 8.70099 14.9273L15.0436 8.58468L13.0107 6.55175Z" /></svg>
                  </button>
                </Tooltip>

                <Tooltip :text="t('messages.notAuthorized')" :show="!canToggle">
                  <button
                    :disabled="!canToggle"
                    class="text-gray-500 transition hover:text-brand-500 dark:text-gray-400 dark:hover:text-brand-300 disabled:text-gray-400"
                    @click="toggleStatus(template)"
                  >
                    <svg class="fill-current" width="18" height="18" viewBox="0 0 20 20" fill="none"><path d="M10 4.16699C6.77834 4.16699 4.16668 6.77866 4.16668 10.0003C4.16668 13.222 6.77834 15.8337 10 15.8337C13.2217 15.8337 15.8333 13.222 15.8333 10.0003C15.8333 9.53908 16.2061 9.16699 16.6667 9.16699C17.127 9.16699 17.5 9.53908 17.5 10.0003C17.5 14.1374 14.1371 17.5003 10 17.5003C5.86292 17.5003 2.5 14.1374 2.5 10.0003C2.5 5.86324 5.86292 2.50033 10 2.50033C10.4603 2.50033 10.8333 2.87242 10.8333 3.33366C10.8333 3.7949 10.4603 4.16699 10 4.16699Z" /><path d="M13.3334 3.33366C13.3334 2.87342 13.7055 2.50033 14.1667 2.50033H16.6667C17.1269 2.50033 17.5 2.87342 17.5 3.33366V5.83366C17.5 6.2939 17.1269 6.66699 16.6667 6.66699C16.2065 6.66699 15.8334 6.2939 15.8334 5.83366V4.16699H14.1667C13.7055 4.16699 13.3334 3.7949 13.3334 3.33366Z" /></svg>
                  </button>
                </Tooltip>

                <Tooltip :text="t('messages.notAuthorized')" :show="!canDelete">
                  <button :disabled="!canDelete" class="text-error-500 transition hover:text-error-600 disabled:text-gray-400" @click="confirmDelete(template.id)">
                    <svg class="fill-current" width="18" height="18" viewBox="0 0 20 20" fill="none"><path fill-rule="evenodd" clip-rule="evenodd" d="M7.04142 4.29199C7.04142 3.04935 8.04878 2.04199 9.29142 2.04199H11.7081C12.9507 2.04199 13.9581 3.04935 13.9581 4.29199V4.54199H16.1252H17.166C17.5802 4.54199 17.916 4.87778 17.916 5.29199C17.916 5.70621 17.5802 6.04199 17.166 6.04199H16.8752V8.74687V13.7469V16.7087C16.8752 17.9513 15.8678 18.9587 14.6252 18.9587H6.37516C5.13252 18.9587 4.12516 17.9513 4.12516 16.7087V13.7469V8.74687V6.04199H3.8335C3.41928 6.04199 3.0835 5.70621 3.0835 5.29199C3.0835 4.87778 3.41928 4.54199 3.8335 4.54199H4.87516H7.04142V4.29199ZM15.3752 13.7469V8.74687V6.04199H13.9581H13.2081H7.79142H7.04142H5.62516V8.74687V13.7469V16.7087C5.62516 17.1229 5.96095 17.4587 6.37516 17.4587H14.6252C15.0394 17.4587 15.3752 17.1229 15.3752 16.7087V13.7469ZM8.8335 4.54199H12.4581V4.29199C12.4581 3.87778 12.1223 3.54199 11.7081 3.54199H9.29142C8.87721 3.54199 8.54142 3.87778 8.54142 4.29199V4.54199ZM8.8335 8.50033C9.24771 8.50033 9.5835 8.83611 9.5835 9.25033V14.2503C9.5835 14.6645 9.24771 15.0003 8.8335 15.0003C8.41928 15.0003 8.0835 14.6645 8.0835 14.2503V9.25033C8.0835 8.83611 8.41928 8.50033 8.8335 8.50033ZM12.9168 9.25033C12.9168 8.83611 12.581 8.50033 12.1668 8.50033C11.7526 8.50033 11.4168 8.83611 11.4168 9.25033V14.2503C11.4168 14.6645 11.7526 15.0003 12.1668 15.0003C12.581 15.0003 12.9168 14.6645 12.9168 14.2503V9.25033Z" /></svg>
                  </button>
                </Tooltip>
              </div>
            </td>
          </tr>
          <tr v-if="!messageTemplates.data || messageTemplates.data.length === 0">
            <td colspan="8" class="px-4 py-6 text-center text-sm text-gray-500 dark:text-gray-300">{{ t('message_templates.empty.noTemplates') }}</td>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="border border-t-0 border-gray-200 px-4 py-3 dark:border-gray-800">
      <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <p class="text-sm text-gray-500 dark:text-gray-400">
          {{ t('datatable.showing', { start: messageTemplates.from || 0, end: messageTemplates.to || 0, total: messageTemplates.total || 0 }) }}
        </p>
        <div class="flex items-center gap-2">
          <button class="rounded-lg border border-gray-300 px-3 py-2 text-sm text-gray-700 transition hover:bg-gray-100 disabled:opacity-40 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-white/10" :disabled="!hasPrevious" @click="goToPage(messageTemplates.current_page - 1)">
            {{ t('datatable.previous') }}
          </button>
          <span class="text-sm text-gray-500 dark:text-gray-400">{{ messageTemplates.current_page }} / {{ messageTemplates.last_page }}</span>
          <button class="rounded-lg border border-gray-300 px-3 py-2 text-sm text-gray-700 transition hover:bg-gray-100 disabled:opacity-40 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-white/10" :disabled="!hasNext" @click="goToPage(messageTemplates.current_page + 1)">
            {{ t('datatable.next') }}
          </button>
        </div>
      </div>
    </div>
  </div>

  <DangerAlert :isOpen="deleteState.open" :title="t('messages.areYouSure')" :message="t('message_templates.notifications.deleteConfirmation')" @close="deleteState.open = false" @confirm="performDelete" />
</template>

<script setup>
import { computed, reactive, watch, onBeforeUnmount } from 'vue'
import { router } from '@inertiajs/vue3'
import { route } from '@/route'
import { useI18n } from 'vue-i18n'
import { usePermissions } from '@/composables/usePermissions'
import { useNotifications } from '@/composables/useNotifications'
import Tooltip from '@/components/ui/Tooltip.vue'
import DangerAlert from '@/components/modals/DangerAlert.vue'
import dayjs from 'dayjs'

const props = defineProps({
  messageTemplates: { type: Object, required: true },
  filters: { type: Object, default: () => ({}) },
  options: { type: Object, default: () => ({}) },
})

const { t } = useI18n()
const { hasAnyPermission } = usePermissions()
const { success, error } = useNotifications()

const canCreate = computed(() => hasAnyPermission(['message_templates.create']))
const canEdit = computed(() => hasAnyPermission(['message_templates.update']))
const canDelete = computed(() => hasAnyPermission(['message_templates.delete']))
const canView = computed(() => hasAnyPermission(['message_templates.view']))
const canToggle = computed(() => hasAnyPermission(['message_templates.update']))

const localFilters = reactive({
  search: props.filters.search || '',
  channel: props.filters.channel || '',
  locale: props.filters.locale || '',
  is_active: props.filters.is_active ?? '',
  per_page: props.filters.per_page ? Number(props.filters.per_page) : props.messageTemplates.per_page || 10,
})

const messageTemplates = computed(() => props.messageTemplates || {})
const options = computed(() => props.options || {})

function goToCreate() {
  router.visit(route('admin.message_templates.create'))
}

function goToShow(id) {
  if (!canView.value) return
  router.visit(route('admin.message_templates.show', id))
}

function goToEdit(id) {
  if (!canEdit.value) return
  router.visit(route('admin.message_templates.edit', id))
}

function sanitizedFilters(page = 1) {
  return {
    search: localFilters.search || undefined,
    channel: localFilters.channel || undefined,
    locale: localFilters.locale || undefined,
    is_active: localFilters.is_active === '' ? undefined : localFilters.is_active,
    per_page: localFilters.per_page || undefined,
    page,
  }
}

function goToPage(page) {
  if (page < 1 || page > messageTemplates.value.last_page) return
  router.get(route('admin.message_templates.index'), sanitizedFilters(page), { preserveScroll: true, preserveState: true, replace: true })
}

function fetchFiltered() {
  router.get(route('admin.message_templates.index'), sanitizedFilters(1), { preserveScroll: true, preserveState: true, replace: true })
}

watch(() => [localFilters.channel, localFilters.locale, localFilters.is_active, localFilters.per_page], fetchFiltered)

watch(
  () => localFilters.search,
  (value) => {
    if (searchDelay.timer) clearTimeout(searchDelay.timer)
    searchDelay.timer = setTimeout(() => {
      const payload = sanitizedFilters(1)
      payload.search = value || undefined
  router.get(route('admin.message_templates.index'), payload, { preserveScroll: true, preserveState: true, replace: true })
    }, 400)
  }
)

const searchDelay = reactive({ timer: null })

onBeforeUnmount(() => {
  if (searchDelay.timer) clearTimeout(searchDelay.timer)
})

const deleteState = reactive({ open: false, id: null })

function confirmDelete(id) {
  if (!canDelete.value) return
  deleteState.id = id
  deleteState.open = true
}

function performDelete() {
  if (!deleteState.id) return
  router.delete(route('admin.message_templates.destroy', deleteState.id), {
    preserveScroll: true,
    onSuccess: () => {
      success(t('message_templates.notifications.deleted'))
      deleteState.open = false
    },
    onError: () => {
      error(t('message_templates.notifications.genericError'))
      deleteState.open = false
    },
  })
}

function toggleStatus(template) {
  if (!canToggle.value) return
  const original = template.is_active
  template.is_active = !original
  const patchRoute = template.is_active ? 'admin.message_templates.activate' : 'admin.message_templates.deactivate'
  router.patch(route(patchRoute, { id: template.id }), {}, {
    preserveScroll: true,
    preserveState: true,
    onSuccess: () => {
      success(t(template.is_active ? 'message_templates.notifications.activated' : 'message_templates.notifications.deactivated'))
    },
    onError: () => {
      template.is_active = original
      error(t('message_templates.notifications.genericError'))
    },
  })
}

const hasPrevious = computed(() => (messageTemplates.value.current_page || 1) > 1)
const hasNext = computed(() => (messageTemplates.value.current_page || 1) < (messageTemplates.value.last_page || 1))

function formatDate(value) {
  if (!value) return '—'
  try {
    return dayjs(value).format('YYYY-MM-DD HH:mm')
  } catch (e) {
    return value
  }
}

function formatChannel(channel) {
  if (!channel) return '—'
  const key = `message_templates.channels.${channel}`
  const translated = t(key)
  return translated === key ? channel : translated
}
</script>
