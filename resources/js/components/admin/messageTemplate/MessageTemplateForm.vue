<template>
  <form class="space-y-6" @submit.prevent="handleSubmit">
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
      <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800">
        <h2 class="text-lg font-medium text-gray-800 dark:text-white">{{ t('message_templates.basicInformation') }}</h2>
      </div>

      <div class="p-4 sm:p-6">
        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">{{ t('message_templates.fields.name') }}</label>
            <input
              v-model="form.name"
              type="text"
              autocomplete="off"
              class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:text-white/90 dark:placeholder:text-white/30"
              :placeholder="t('message_templates.fields.name')"
            />
            <p v-if="form.errors.name" class="mt-1 text-sm text-error-500">{{ form.errors.name }}</p>
          </div>

          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">{{ t('message_templates.fields.code') }}</label>
            <input
              v-model="form.code"
              type="text"
              autocomplete="off"
              class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm uppercase tracking-wide text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:text-white/90 dark:placeholder:text-white/30"
              :placeholder="t('message_templates.fields.codePlaceholder')"
            />
            <p v-if="form.errors.code" class="mt-1 text-sm text-error-500">{{ form.errors.code }}</p>
          </div>

          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">{{ t('message_templates.fields.channel') }}</label>
            <div class="relative z-10 bg-transparent">
              <select
                v-model="form.channel"
                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 pr-11 text-sm text-gray-800 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:text-white/90"
              >
                <option v-for="channel in (options.channels || [])" :key="channel" :value="channel" class="text-gray-700 dark:bg-gray-900 dark:text-gray-300">
                  {{ formatChannel(channel) }}
                </option>
              </select>
              <span class="pointer-events-none absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 dark:text-gray-400">
                <svg class="stroke-current" width="18" height="18" viewBox="0 0 20 20" fill="none">
                  <path d="M4.79175 7.396L10.0001 12.6043L15.2084 7.396" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
              </span>
            </div>
            <p v-if="form.errors.channel" class="mt-1 text-sm text-error-500">{{ form.errors.channel }}</p>
          </div>

          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">{{ t('message_templates.fields.locale') }}</label>
            <div class="relative z-10 bg-transparent">
              <select
                v-model="form.locale"
                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 pr-11 text-sm text-gray-800 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:text-white/90"
              >
                <option v-for="locale in (options.locales || [])" :key="locale" :value="locale" class="text-gray-700 dark:bg-gray-900 dark:text-gray-300">
                  {{ locale.toUpperCase() }}
                </option>
              </select>
              <span class="pointer-events-none absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 dark:text-gray-400">
                <svg class="stroke-current" width="18" height="18" viewBox="0 0 20 20" fill="none">
                  <path d="M4.79175 7.396L10.0001 12.6043L15.2084 7.396" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
              </span>
            </div>
            <p v-if="form.errors.locale" class="mt-1 text-sm text-error-500">{{ form.errors.locale }}</p>
          </div>

          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">{{ t('message_templates.fields.mosque') }}</label>
            <div class="relative z-10 bg-transparent">
              <select
                v-model="form.mosque_id"
                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 pr-11 text-sm text-gray-800 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:text-white/90"
              >
                <option :value="''" class="text-gray-700 dark:bg-gray-900 dark:text-gray-300">{{ t('message_templates.fields.globalTemplate') }}</option>
                <option v-for="mosque in (options.mosques || [])" :key="mosque.id" :value="mosque.id" class="text-gray-700 dark:bg-gray-900 dark:text-gray-300">
                  {{ mosque.name }}
                </option>
              </select>
              <span class="pointer-events-none absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 dark:text-gray-400">
                <svg class="stroke-current" width="18" height="18" viewBox="0 0 20 20" fill="none">
                  <path d="M4.79175 7.396L10.0001 12.6043L15.2084 7.396" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
              </span>
            </div>
            <p v-if="form.errors.mosque_id" class="mt-1 text-sm text-error-500">{{ form.errors.mosque_id }}</p>
          </div>

          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">{{ t('message_templates.fields.subject') }}</label>
            <input
              v-model="form.subject"
              type="text"
              autocomplete="off"
              class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:text-white/90 dark:placeholder:text-white/30"
              :placeholder="t('message_templates.fields.subjectPlaceholder')"
            />
            <p v-if="form.errors.subject" class="mt-1 text-sm text-error-500">{{ form.errors.subject }}</p>
          </div>

          <div class="flex items-center gap-3">
            <label for="toggle-template-active" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">{{ t('message_templates.fields.isActive') }}</label>
            <label :for="`toggle-template-active-${mode}`" class="flex cursor-pointer select-none items-center gap-3">
              <div class="relative">
                <input :id="`toggle-template-active-${mode}`" v-model="form.is_active" type="checkbox" class="sr-only" />
                <div class="block h-6 w-11 rounded-full" :class="form.is_active ? 'bg-brand-500 dark:bg-brand-500' : 'bg-gray-200 dark:bg-white/10'"></div>
                <div :class="form.is_active ? 'translate-x-full' : 'translate-x-0'" class="absolute left-0.5 top-0.5 h-5 w-5 rounded-full bg-white shadow-theme-sm duration-300 ease-linear"></div>
              </div>
              <span
                class="inline-flex items-center justify-center gap-1 rounded-full px-2.5 py-0.5 text-xs font-medium"
                :class="form.is_active ? 'bg-green-50 text-green-600 dark:bg-green-500/15 dark:text-green-500' : 'bg-error-50 text-error-600 dark:bg-error-500/15 dark:text-error-500'"
              >
                {{ form.is_active ? t('common.active') : t('common.inactive') }}
              </span>
            </label>
          </div>
        </div>

        <div class="mt-5">
          <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">{{ t('message_templates.fields.description') }}</label>
          <textarea
            v-model="form.description"
            rows="3"
            class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:text-white/90 dark:placeholder:text-white/30"
            :placeholder="t('message_templates.fields.descriptionPlaceholder')"
          ></textarea>
          <p v-if="form.errors.description" class="mt-1 text-sm text-error-500">{{ form.errors.description }}</p>
        </div>

        <div class="mt-5">
          <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">{{ t('message_templates.fields.body') }}</label>
          <textarea
            v-model="form.body"
            rows="8"
            class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:text-white/90 dark:placeholder:text-white/30"
            :placeholder="t('message_templates.fields.bodyPlaceholder')"
          ></textarea>
          <p v-if="form.errors.body" class="mt-1 text-sm text-error-500">{{ form.errors.body }}</p>
          <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
            {{ t('message_templates.help.bodyVariables') }}
          </p>
          <button type="button" class="mt-3 inline-flex items-center gap-2 rounded-lg border border-brand-500 px-3 py-2 text-sm text-brand-500 transition hover:bg-brand-500 hover:text-white" @click="extractVariablesFromBody">
            <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M9 3.75V14.25" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
              <path d="M4.5 9H13.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
            {{ t('message_templates.actions.detectPlaceholders') }}
          </button>
        </div>
      </div>
    </div>

    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
      <div class="flex items-center justify-between border-b border-gray-200 px-6 py-4 dark:border-gray-800">
        <h2 class="text-lg font-medium text-gray-800 dark:text-white">{{ t('message_templates.sections.variables') }}</h2>
        <button type="button" class="inline-flex items-center gap-2 rounded-lg border border-dashed border-gray-300 px-3 py-2 text-sm text-gray-700 transition hover:border-brand-500 hover:text-brand-500 dark:border-gray-700 dark:text-gray-300" @click="addVariable">
          <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M9 3.75V14.25" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            <path d="M4.5 9H13.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
          </svg>
          {{ t('message_templates.actions.addVariable') }}
        </button>
      </div>

      <div class="p-4 sm:p-6">
        <div v-if="(form.variables || []).length === 0" class="rounded-lg border border-dashed border-gray-300 bg-gray-50 px-4 py-6 text-center text-sm text-gray-500 dark:border-gray-700 dark:bg-white/5 dark:text-gray-300">
          {{ t('message_templates.empty.noVariables') }}
        </div>

        <div v-else class="space-y-4">
          <div
            v-for="(variable, index) in form.variables"
            :key="index"
            class="rounded-xl border border-gray-200 p-4 dark:border-gray-700 dark:bg-white/5"
          >
            <div class="flex flex-col gap-4 md:flex-row md:items-start">
              <div class="md:w-1/5">
                <label class="mb-1 block text-xs font-medium uppercase tracking-wide text-gray-500 dark:text-gray-400">{{ t('message_templates.fields.variableKey') }}</label>
                <input
                  v-model="variable.key"
                  type="text"
                  class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-10 w-full rounded-lg border border-gray-300 bg-transparent px-3 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:text-white/90"
                  placeholder="student_name"
                />
              </div>

              <div class="md:w-1/5">
                <label class="mb-1 block text-xs font-medium uppercase tracking-wide text-gray-500 dark:text-gray-400">{{ t('message_templates.fields.variableLabel') }}</label>
                <input
                  v-model="variable.label"
                  type="text"
                  class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-10 w-full rounded-lg border border-gray-300 bg-transparent px-3 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:text-white/90"
                  :placeholder="t('message_templates.fields.variableLabelPlaceholder')"
                />
              </div>

              <div class="md:w-1/5">
                <label class="mb-1 block text-xs font-medium uppercase tracking-wide text-gray-500 dark:text-gray-400">{{ t('message_templates.fields.variableType') }}</label>
                <div class="relative">
                  <select
                    v-model="variable.type"
                    class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-10 w-full appearance-none rounded-lg border border-gray-300 bg-transparent px-3 pr-9 text-sm text-gray-800 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:text-white/90"
                  >
                    <option v-for="type in (options.variable_types || [])" :key="type" :value="type" class="text-gray-700 dark:bg-gray-900 dark:text-gray-300">
                      {{ formatVariableType(type) }}
                    </option>
                  </select>
                  <span class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 dark:text-gray-400">
                    <svg class="stroke-current" width="16" height="16" viewBox="0 0 20 20" fill="none">
                      <path d="M4.79175 7.396L10.0001 12.6043L15.2084 7.396" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                  </span>
                </div>
              </div>

              <div class="md:w-1/5">
                <label class="mb-1 block text-xs font-medium uppercase tracking-wide text-gray-500 dark:text-gray-400">{{ t('message_templates.fields.variableRequired') }}</label>
                <label class="inline-flex items-center gap-2 text-sm text-gray-700 dark:text-gray-300">
                  <input v-model="variable.required" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-brand-500 focus:ring-brand-500 dark:border-gray-600" />
                  {{ t('message_templates.fields.requiredCheckbox') }}
                </label>
              </div>

              <div class="flex flex-1 flex-col">
                <label class="mb-1 block text-xs font-medium uppercase tracking-wide text-gray-500 dark:text-gray-400">{{ t('message_templates.fields.variableDescription') }}</label>
                <textarea v-model="variable.description" rows="2" class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 w-full rounded-lg border border-gray-300 bg-transparent px-3 py-2 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:text-white/90 dark:placeholder:text-white/30"></textarea>
              </div>
            </div>

            <div class="mt-3 flex items-center justify-between gap-3">
              <div class="flex flex-1 flex-col">
                <label class="mb-1 block text-xs font-medium uppercase tracking-wide text-gray-500 dark:text-gray-400">{{ t('message_templates.fields.sampleValue') }}</label>
                <input
                  v-model="form.sample_payload[variable.key]"
                  type="text"
                  class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-10 w-full rounded-lg border border-gray-300 bg-transparent px-3 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:text-white/90"
                  :placeholder="t('message_templates.fields.sampleValuePlaceholder')"
                />
              </div>

              <button type="button" class="mt-7 inline-flex items-center gap-1 rounded-full bg-error-500/10 px-3 py-1 text-xs font-medium text-error-600 transition hover:bg-error-500 hover:text-white dark:text-error-400" @click="removeVariable(index)">
                <svg width="14" height="14" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M5 5L15 15" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" />
                  <path d="M15 5L5 15" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" />
                </svg>
                {{ t('common.delete') }}
              </button>
            </div>
          </div>
        </div>

        <p v-if="form.errors.variables" class="mt-2 text-sm text-error-500">{{ form.errors.variables }}</p>
      </div>
    </div>

    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
      <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800">
        <h2 class="text-lg font-medium text-gray-800 dark:text-white">{{ t('message_templates.sections.extras') }}</h2>
      </div>
      <div class="p-4 sm:p-6 space-y-4">
        <div>
          <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">{{ t('message_templates.fields.ctaLabel') }}</label>
          <input
            v-model="cta.label"
            type="text"
            class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:text-white/90"
            :placeholder="t('message_templates.fields.ctaLabelPlaceholder')"
          />
        </div>
        <div>
          <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">{{ t('message_templates.fields.ctaUrl') }}</label>
          <input
            v-model="cta.url"
            type="url"
            class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:text-white/90"
            placeholder="https://example.com"
          />
        </div>
      </div>
    </div>

    <div class="flex flex-col gap-3 sm:flex-row sm:justify-end">
      <Link :href="route('admin.message_templates.index')" class="shadow-theme-xs inline-flex items-center justify-center gap-2 rounded-lg bg-white px-4 py-3 text-sm font-medium text-gray-700 ring-1 ring-gray-300 transition hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-400 dark:ring-gray-700 dark:hover:bg-white/[0.03]">
        {{ t('buttons.backToList') }}
      </Link>
      <button
        type="submit"
        class="bg-brand-500 shadow-theme-xs hover:bg-brand-600 inline-flex items-center justify-center gap-2 rounded-lg px-4 py-3 text-sm font-medium text-white disabled:cursor-not-allowed disabled:opacity-70"
        :disabled="form.processing"
      >
        {{ form.processing ? t('common.loading') : submitLabel }}
      </button>
    </div>
  </form>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import { computed, reactive, watch } from 'vue'
import { useI18n } from 'vue-i18n'

const props = defineProps({
  mode: { type: String, default: 'create' },
  form: { type: Object, required: true },
  options: { type: Object, default: () => ({}) },
})

const emit = defineEmits(['submit'])

const { t } = useI18n()

const submitLabel = computed(() => (props.mode === 'edit' ? t('buttons.update') : t('buttons.create')))

const cta = reactive({
  get label() {
    return props.form.extras?.cta?.label ?? ''
  },
  set label(value) {
    updateExtras('label', value)
  },
  get url() {
    return props.form.extras?.cta?.url ?? ''
  },
  set url(value) {
    updateExtras('url', value)
  },
})

function updateExtras(key, value) {
  const extras = { ...(props.form.extras || {}) }
  extras.cta = { ...(extras.cta || {}), [key]: value }

  if (!extras.cta.label && !extras.cta.url) {
    delete extras.cta
  }

  props.form.extras = Object.keys(extras).length ? extras : null
}

function addVariable() {
  const variables = props.form.variables || []
  variables.push({ key: '', label: '', type: 'string', required: false, description: '' })
  props.form.variables = variables
}

function removeVariable(index) {
  const variables = props.form.variables || []
  variables.splice(index, 1)
  props.form.variables = variables
  syncSamplePayload()
}

function formatChannel(channel) {
  return t(`message_templates.channels.${channel}`, channel)
}

function formatVariableType(type) {
  return t(`message_templates.variableTypes.${type}`, type)
}

function extractVariablesFromBody() {
  const body = props.form.body || ''
  const matches = body.matchAll(/{{\s*([A-Za-z0-9_.\-]+)\s*}}/g)
  const variables = props.form.variables || []
  const existingKeys = new Set(variables.map((item) => item.key))

  for (const match of matches) {
    const rawKey = match[1]
    const key = rawKey.toLowerCase().replace(/[^a-z0-9_.\-]/g, '_')
    if (!existingKeys.has(key)) {
      variables.push({
        key,
        label: key
          .split(/[-_.]/)
          .map((part) => part.charAt(0).toUpperCase() + part.slice(1))
          .join(' '),
        type: 'string',
        required: false,
        description: '',
      })
      existingKeys.add(key)
    }
  }

  props.form.variables = variables
  syncSamplePayload()
}

function syncSamplePayload() {
  const payload = { ...(props.form.sample_payload || {}) }
  const keys = new Set((props.form.variables || []).map((v) => v.key).filter(Boolean))

  Object.keys(payload).forEach((key) => {
    if (!keys.has(key)) {
      delete payload[key]
    }
  })

  keys.forEach((key) => {
    if (payload[key] === undefined) {
      payload[key] = ''
    }
  })

  props.form.sample_payload = payload
}

watch(
  () => props.form.variables,
  () => {
    syncSamplePayload()
  },
  { deep: true }
)

function handleSubmit() {
  emit('submit')
}
</script>
