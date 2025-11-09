<template>
  <form class="space-y-6" @submit.prevent="update">
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
      <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800">
        <h2 class="text-lg font-medium text-gray-800 dark:text-white">{{ t('activities.activityInformation') }}</h2>
      </div>

      <div class="p-4 sm:p-6 dark:border-gray-800">
        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
          <div>
            <label for="activity-title" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">{{ t('activities.title') }}</label>
            <input
              v-model="form.title"
              id="activity-title"
              type="text"
              autocomplete="off"
              :placeholder="t('activities.title')"
              class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
            />
            <p v-if="form.errors.title" class="mt-1 text-sm text-error-500">{{ form.errors.title }}</p>
          </div>

          <div>
            <label for="activity-mosque" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">{{ t('activities.mosqueName') }}</label>
            <div class="relative z-20 bg-transparent">
              <select
                v-model="form.mosque_id"
                id="activity-mosque"
                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                :class="{ 'text-gray-800 dark:text-white/90': form.mosque_id }"
              >
                <option value="" disabled class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">{{ t('activities.selectMosque') || t('activities.mosqueName') }}</option>
                <option v-for="m in mosques || []" :key="m.id" :value="m.id" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">{{ locale === 'ar' && m.name_ar ? m.name_ar : (m.name_en || m.name) }}</option>
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
            <label for="activity-place" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">{{ t('activities.place') }}</label>
            <input
              v-model="form.place"
              id="activity-place"
              type="text"
              autocomplete="off"
              :placeholder="t('activities.place')"
              class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
            />
            <p v-if="form.errors.place" class="mt-1 text-sm text-error-500">{{ form.errors.place }}</p>
          </div>

          <div>
            <label for="activity-date" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">{{ t('activities.activityDate') }}</label>
            <input
              v-model="form.activity_date_g"
              id="activity-date"
              type="date"
              class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700"
            />
            <p v-if="form.errors.activity_date_g" class="mt-1 text-sm text-error-500">{{ form.errors.activity_date_g }}</p>
          </div>

          <div class="md:col-span-2">
            <label for="activity-description" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">{{ t('activities.description') }}</label>
            <textarea
              v-model="form.description"
              id="activity-description"
              rows="4"
              class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
            ></textarea>
            <p v-if="form.errors.description" class="mt-1 text-sm text-error-500">{{ form.errors.description }}</p>
          </div>
        </div>
      </div>
    </div>

      <!-- الوسائط (الصور) -->
      <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800">
          <h2 class="text-lg font-medium text-gray-800 dark:text-white">{{ t('activities.media') || 'الصور' }}</h2>
        </div>

        <div class="p-4 sm:p-6">
          <div>
            <div
              class="relative rounded-lg border border-dashed p-4 text-center transition-colors"
              :class="dragging ? 'border-brand-500 bg-brand-50/40 dark:bg-white/[0.02]' : 'border-gray-200 bg-transparent dark:border-gray-800'"
              @dragover.prevent="dragging = true"
              @dragleave.prevent="dragging = false"
              @drop.prevent="onDrop"
            >
              <input ref="fileInput" type="file" class="hidden" multiple accept="image/*" @change="onInputChange" />

              <div class="flex flex-col items-center justify-center gap-3 py-8">
                <svg width="36" height="36" viewBox="0 0 24 24" fill="none" class="text-gray-400 dark:text-gray-500">
                  <path d="M12 16V8M8 12L12 8l4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                  <path d="M21 15v2a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-2" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <div class="text-sm text-gray-600 dark:text-gray-400">{{ t('activities.dragDrop') || 'اسحب الصور هنا أو' }}
                  <button type="button" @click="openFilePicker" class="ml-2 inline-flex items-center rounded px-2 py-1 text-sm font-medium text-brand-600 hover:underline">
                    {{ t('activities.browseFiles') || 'اختر ملفات' }}
                  </button>
                </div>
                <div class="text-xs text-gray-400">{{ t('activities.maxFiles', { count: maxFiles }) || `الحد الأقصى ${maxFiles} صور، 5MB لكل صورة` }}</div>
              </div>
            </div>

            <p v-if="fileWarning" class="mt-2 text-sm text-error-500">{{ fileWarning }}</p>

            <!-- New file previews -->
            <div v-if="previews.length" class="mt-4 grid grid-cols-2 gap-3 sm:grid-cols-4">
              <div v-for="(p, i) in previews" :key="i" class="relative overflow-hidden rounded-md border bg-white dark:bg-gray-900">
                <img :src="p" class="h-28 w-full object-cover" />
                <button type="button" @click="removeNewFile(i)" class="absolute right-1 top-1 inline-flex h-7 w-7 items-center justify-center rounded-full bg-black/40 text-white">
                  &times;
                </button>
                <div class="absolute left-1 top-1 rounded bg-white/60 px-1 text-xs">{{ formatSize(selectedFiles[i].size) }}</div>
              </div>
            </div>

            <!-- Existing media thumbnails -->
            <div v-if="existingMedia.length" class="mt-4 grid grid-cols-2 gap-3 sm:grid-cols-4">
              <div v-for="m in existingMedia" :key="m.id" class="relative overflow-hidden rounded-md border bg-white dark:bg-gray-900">
                <a :href="`/storage/${m.file_url}`" target="_blank" rel="noopener" class="block h-28 w-full">
                  <img :src="`/storage/${m.file_url}`" class="h-28 w-full object-cover" />
                </a>
                <button type="button" @click="toggleRemoveExisting(m)" :class="m._marked ? 'absolute right-1 top-1 inline-flex h-7 w-7 items-center justify-center rounded-full bg-error-600 text-white' : 'absolute right-1 top-1 inline-flex h-7 w-7 items-center justify-center rounded-full bg-black/40 text-white'">
                  <span v-if="m._marked">✓</span>
                  <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                  </svg>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>

    <!-- الحالة -->
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

    <!-- الأزرار -->
    <div class="flex flex-col gap-3 sm:flex-row sm:justify-end">
      <Link :href="route('admin.activities.index')" class="shadow-theme-xs inline-flex items-center justify-center gap-2 rounded-lg bg-white px-4 py-3 text-sm font-medium text-gray-700 ring-1 ring-gray-300 transition hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-400 dark:ring-gray-700 dark:hover:bg-white/[0.03]">{{ t('buttons.backToList') }}</Link>

      <button
        type="submit"
        class="bg-brand-500 shadow-theme-xs hover:bg-brand-600 inline-flex items-center justify-center gap-2 rounded-lg px-4 py-3 text-sm font-medium text-white transition"
        :class="{ 'cursor-not-allowed opacity-70': form.processing }"
        :disabled="form.processing"
      >
        {{ form.processing ? t('common.loading') : t('buttons.update') }}
      </button>
    </div>
  </form>
</template>

<script setup>
import { ref, reactive, computed } from 'vue'
import { Link, useForm } from '@inertiajs/vue3'
import { useI18n } from 'vue-i18n'
import { useNotifications } from '@/composables/useNotifications'

const { t, locale } = useI18n()
const { success, error } = useNotifications()

const props = defineProps({ activity: { type: Object, required: true }, mosques: { type: Array, required: false } })

// Form includes placeholders for files and removed ids
const form = useForm({
  title: props.activity.title ?? '',
  description: props.activity.description ?? '',
  activity_date_g: props.activity.activity_date_g ?? '',
  place: props.activity.place ?? '',
  mosque_id: props.activity.mosque_id ?? '',
  is_active: props.activity.is_active ?? true,
  // files will be attached before submit
  media: [],
  removed_media_ids: [],
})

// File upload state
const fileInput = ref(null)
const selectedFiles = ref([]) // new File objects
const previews = ref([]) // data URLs for previews
const dragging = ref(false)
const fileWarning = ref('')
const maxFiles = 8
const maxSize = 5 * 1024 * 1024 // 5MB

// existing media from the server
const existingMedia = reactive((props.activity.media || []).map(m => ({ ...m, _marked: false })))

const keptExistingCount = computed(() => existingMedia.filter(m => !m._marked).length)

function openFilePicker() {
  if (fileInput.value) fileInput.value.click()
}

function onInputChange(e) {
  const files = Array.from(e.target.files || [])
  addFiles(files)
  // reset input so same file can be picked again if needed
  e.target.value = ''
}

function onDrop(e) {
  dragging.value = false
  const dt = e.dataTransfer
  if (!dt) return
  const files = Array.from(dt.files || [])
  addFiles(files)
}

function addFiles(files) {
  fileWarning.value = ''
  for (const file of files) {
    // enforce type
    if (!file.type.startsWith('image/')) {
      fileWarning.value = t('activities.invalidFileType') || 'نوع الملف غير مدعوم'
      continue
    }
    // size
    if (file.size > maxSize) {
      fileWarning.value = t('activities.fileTooLarge') || 'حجم الملف أكبر من المسموح'
      continue
    }
    // total count
    if (keptExistingCount.value + selectedFiles.value.length + 1 > maxFiles) {
      fileWarning.value = t('activities.maxFilesReached', { count: maxFiles }) || `الحد الأقصى ${maxFiles} صور` 
      break
    }

    selectedFiles.value.push(file)
    const reader = new FileReader()
    reader.onload = ev => previews.value.push(ev.target.result)
    reader.readAsDataURL(file)
  }
}

function removeNewFile(index) {
  selectedFiles.value.splice(index, 1)
  previews.value.splice(index, 1)
}

function toggleRemoveExisting(m) {
  m._marked = !m._marked
  const id = m.id
  const idx = form.removed_media_ids.indexOf(id)
  if (m._marked && idx === -1) form.removed_media_ids.push(id)
  if (!m._marked && idx !== -1) form.removed_media_ids.splice(idx, 1)
}

function formatSize(bytes) {
  if (bytes < 1024) return bytes + ' B'
  if (bytes < 1024 * 1024) return (bytes / 1024).toFixed(1) + ' KB'
  return (bytes / (1024 * 1024)).toFixed(1) + ' MB'
}

function update() {
  // attach new files and removed ids to the form
  form.media = selectedFiles.value
  // removed_media_ids is already updated by toggleRemoveExisting

  form.put(route('admin.activities.update', { activity: props.activity.id }), {
    onSuccess: () => {
      success(t('activities.activityUpdatedSuccessfully'))
    },
    onError: () => {
      error(t('activities.activityUpdateFailed'))
    },
    preserveScroll: true,
  })
}
</script>
