<template>
  <form class="space-y-6" @submit.prevent="create">
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
      <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800">
        <h2 class="text-lg font-medium text-gray-800 dark:text-white">
          {{ t('activities.activityInformation') }}
        </h2>
      </div>

      <div class="p-4 sm:p-6 dark:border-gray-800">
        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">{{ t('activities.title') }}</label>
            <input v-model="form.title" type="text" autocomplete="off" :placeholder="t('activities.title')" class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
            <p v-if="form.errors.title" class="mt-1 text-sm text-error-500">{{ form.errors.title }}</p>
          </div>

          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">{{ t('activities.mosqueName') }}</label>
            <div class="relative z-20 bg-transparent">
              <select v-model="form.mosque_id" class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" :class="{ 'text-gray-800 dark:text-white/90': form.mosque_id }">
                <option value="" disabled class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">{{ t('activities.selectMosque') || t('activities.mosqueName') }}</option>
                <option v-for="m in mosques || []" :key="m.id" :value="m.id" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">{{ m.name }}</option>
              </select>
              <span class="pointer-events-none absolute top-1/2 right-4 z-30 -translate-y-1/2 text-gray-700 dark:text-gray-400">
                <svg class="stroke-current" width="20" height="20" viewBox="0 0 20 20" fill="none">
                  <path d="M4.79175 7.396L10.0001 12.6043L15.2084 7.396" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
              </span>
            </div>
            <p v-if="form.errors.mosque_id" class="mt-1 text-sm text-error-500">{{ form.errors.mosque_id }}</p>
          </div>

          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">{{ t('activities.place') }}</label>
            <input v-model="form.place" type="text" autocomplete="off" :placeholder="t('activities.place')" class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
            <p v-if="form.errors.place" class="mt-1 text-sm text-error-500">{{ form.errors.place }}</p>
          </div>

          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">{{ t('activities.activityDate') }}</label>
            <input
              v-model="form.activity_date_g"
              type="date"
              :class="{ 'text-gray-800 dark:text-white/90': form.activity_date_g }"
              class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 dark:text-gray-400 placeholder:text-gray-700 dark:placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700"
            />
            <p v-if="form.errors.activity_date_g" class="mt-1 text-sm text-error-500">{{ form.errors.activity_date_g }}</p>
          </div>

          <div class="md:col-span-2">
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">{{ t('activities.description') }}</label>
            <textarea v-model="form.description" rows="4" class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"></textarea>
            <p v-if="form.errors.description" class="mt-1 text-sm text-error-500">{{ form.errors.description }}</p>
          </div>
        </div>
      </div>
    </div>

    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
      <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800">
        <h2 class="text-lg font-medium text-gray-800 dark:text-white">{{ t('common.status') }}</h2>
      </div>
      <div class="p-4 sm:p-6">
        <label for="toggle-active" class="flex cursor-pointer select-none items-center gap-3 text-sm font-medium text-gray-700 dark:text-gray-400">
          <div class="relative">
            <input type="checkbox" id="toggle-active" class="sr-only" v-model="form.is_active" />
            <div class="block h-6 w-11 rounded-full" :class="form.is_active ? 'bg-brand-500 dark:bg-brand-500' : 'bg-gray-200 dark:bg-white/10'"></div>
            <div :class="form.is_active ? 'translate-x-full' : 'translate-x-0'" class="absolute left-0.5 top-0.5 h-5 w-5 rounded-full bg-white shadow-theme-sm duration-300 ease-linear"></div>
          </div>
          <span
            class="inline-flex items-center justify-center gap-1 rounded-full px-2.5 py-0.5 text-xs font-medium"
            :class="{
              'bg-green-50 text-green-600 dark:bg-green-500/15 dark:text-green-500': form.is_active,
              'bg-error-50 text-error-600 dark:bg-error-500/15 dark:text-error-500': !form.is_active,
            }"
          >
            {{ form.is_active ? t('common.active') : t('common.inactive') }}
          </span>
        </label>
      </div>
    </div>

    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
      <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800">
        <h2 class="text-lg font-medium text-gray-800 dark:text-white">{{ t('activities.media') }}</h2>
      </div>
      <div class="p-4 sm:p-6">
        <label for="activity-media" class="block text-sm font-medium text-gray-700 dark:text-gray-400 mb-2">{{ t('activities.uploadImages') }}</label>
        <div class="flex items-center gap-3">
          <button type="button" @click="fileInput && fileInput.click()" class="inline-flex items-center gap-2 rounded-lg border border-gray-300 dark:border-gray-700 px-3 py-2 text-sm text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800">{{ t('common.chooseFiles') }}</button>
          <span class="text-sm text-gray-500 dark:text-gray-300">{{ t('activities.maxFilesInfo') }}</span>
        </div>

        <input ref="fileInput" id="activity-media" type="file" multiple accept="image/*" class="hidden" @change="handleFilesChange" />

        <div v-if="previews.length" class="mt-3 grid grid-cols-3 gap-3">
          <div v-for="(p, i) in previews" :key="i" class="relative">
            <img :src="p" class="h-28 w-full object-cover rounded-lg border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800" />
            <button type="button" @click="removeFile(i)" class="absolute -top-2 -right-2 rounded-full bg-error-500 p-1 text-white">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
          </div>
        </div>
      </div>
    </div>

    <div class="flex flex-col gap-3 sm:flex-row sm:justify-end">
      <Link :href="route('admin.activities.index')" class="shadow-theme-xs inline-flex items-center justify-center gap-2 rounded-lg bg-white px-4 py-3 text-sm font-medium text-gray-700 ring-1 ring-gray-300 transition hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-400 dark:ring-gray-700 dark:hover:bg-white/[0.03]">{{ t('buttons.backToList') }}</Link>
      <button type="submit" class="bg-brand-500 shadow-theme-xs hover:bg-brand-600 inline-flex items-center justify-center gap-2 rounded-lg px-4 py-3 text-sm font-medium text-white" :class="{ 'cursor-not-allowed opacity-70': form.processing }" :disabled="form.processing">{{ form.processing ? t('common.loading') : t('buttons.create') }}</button>
    </div>
  </form>
</template>

<script setup>
import { Link, useForm } from '@inertiajs/vue3'
import { ref, onBeforeUnmount } from 'vue'
import { useI18n } from 'vue-i18n'
import { useNotifications } from '@/composables/useNotifications'

const { t } = useI18n()
const { success, error } = useNotifications()

const props = defineProps({ mosques: { type: Array, required: false } })

const form = useForm({ title: '', description: '', activity_date_g: '', place: '', mosque_id: '', is_active: true, media: [] })

const fileInput = ref(null)
const selectedFiles = ref([])
const previews = ref([])
const dragging = ref(false)
const fileWarning = ref('')

// client-side limits
const MAX_FILES = 8
const MAX_FILE_SIZE_BYTES = 5 * 1024 * 1024 // 5 MB

function formatSize(bytes) {
  if (bytes < 1024) return bytes + ' B'
  if (bytes < 1024 * 1024) return (bytes / 1024).toFixed(1) + ' KB'
  return (bytes / (1024 * 1024)).toFixed(1) + ' MB'
}

function addFiles(files) {
  fileWarning.value = ''
  const incoming = Array.from(files || [])

  // prevent adding more than MAX_FILES
  if (selectedFiles.value.length + incoming.length > MAX_FILES) {
    fileWarning.value = t('activities.maxFilesInfo')
    return
  }

  for (const f of incoming) {
    if (f.size > MAX_FILE_SIZE_BYTES) {
      fileWarning.value = `${f.name} — ${t('activities.maxFilesInfo')}`
      continue
    }

    selectedFiles.value.push(f)
    previews.value.push(URL.createObjectURL(f))
  }

  if (fileInput.value) fileInput.value.value = ''
}

function handleFilesChange(e) {
  addFiles(e.target.files)
}

function onDragOver(e) {
  dragging.value = true
}

function onDragLeave(e) {
  dragging.value = false
}

function onDrop(e) {
  dragging.value = false
  addFiles(e.dataTransfer.files)
}

function removeFile(idx) {
  const url = previews.value[idx]
  if (url) URL.revokeObjectURL(url)
  previews.value.splice(idx, 1)
  selectedFiles.value.splice(idx, 1)
}

onBeforeUnmount(() => {
  previews.value.forEach((u) => URL.revokeObjectURL(u))
})

function create() {
  // attach selected files to the form
  form.media = []
  selectedFiles.value.forEach((f) => form.media.push(f))

  form.post(route('admin.activities.store'), {
    onSuccess: () => {
      success(t('activities.activityCreatedSuccessfully'))
      previews.value.forEach((u) => URL.revokeObjectURL(u))
      previews.value = []
      selectedFiles.value = []
      form.reset()
    },
    onError: () => error(t('activities.activityCreationFailed')),
  })
}
</script>
