<template>
  <div class="space-y-6">
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
      <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800">
        <h2 class="text-lg font-medium text-gray-800 dark:text-white">{{ t('message_templates.basicInformation') }}</h2>
      </div>
      <dl class="grid grid-cols-1 gap-x-8 gap-y-4 p-6 sm:grid-cols-2">
        <div v-for="row in informationRows" :key="row.label" class="flex flex-col gap-1">
          <dt class="text-xs font-medium uppercase tracking-wide text-gray-500 dark:text-gray-400">{{ row.label }}</dt>
          <dd class="text-sm text-gray-800 dark:text-gray-200">{{ row.value }}</dd>
        </div>
      </dl>
    </div>

    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
      <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800">
        <h2 class="text-lg font-medium text-gray-800 dark:text-white">{{ t('message_templates.sections.bodyPreview') }}</h2>
      </div>
      <pre class="whitespace-pre-wrap break-words p-6 text-sm text-gray-800 dark:text-gray-200">{{ template.body }}</pre>
    </div>

    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
      <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800">
        <h2 class="text-lg font-medium text-gray-800 dark:text-white">{{ t('message_templates.sections.variables') }}</h2>
      </div>
      <div class="p-6">
        <div v-if="!(template.variables && template.variables.length)" class="rounded-lg border border-dashed border-gray-300 bg-gray-50 px-4 py-6 text-center text-sm text-gray-500 dark:border-gray-700 dark:bg-white/5 dark:text-gray-300">
          {{ t('message_templates.empty.noVariables') }}
        </div>
        <div v-else class="overflow-hidden rounded-xl border border-gray-200 dark:border-gray-800">
          <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-white/5">
              <tr>
                <th scope="col" class="px-4 py-2 text-left text-xs font-medium uppercase tracking-wide text-gray-500 dark:text-gray-300">{{ t('message_templates.fields.variableKey') }}</th>
                <th scope="col" class="px-4 py-2 text-left text-xs font-medium uppercase tracking-wide text-gray-500 dark:text-gray-300">{{ t('message_templates.fields.variableLabel') }}</th>
                <th scope="col" class="px-4 py-2 text-left text-xs font-medium uppercase tracking-wide text-gray-500 dark:text-gray-300">{{ t('message_templates.fields.variableType') }}</th>
                <th scope="col" class="px-4 py-2 text-left text-xs font-medium uppercase tracking-wide text-gray-500 dark:text-gray-300">{{ t('message_templates.fields.variableRequired') }}</th>
                <th scope="col" class="px-4 py-2 text-left text-xs font-medium uppercase tracking-wide text-gray-500 dark:text-gray-300">{{ t('message_templates.fields.variableDescription') }}</th>
                <th scope="col" class="px-4 py-2 text-left text-xs font-medium uppercase tracking-wide text-gray-500 dark:text-gray-300">{{ t('message_templates.fields.sampleValue') }}</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 bg-white dark:divide-gray-800 dark:bg-transparent">
              <tr v-for="variable in template.variables" :key="variable.key">
                <td class="px-4 py-3 text-sm text-gray-800 dark:text-gray-200"><code class="rounded bg-gray-100 px-2 py-1 text-xs dark:bg-white/10">{{ variable.key }}</code></td>
                <td class="px-4 py-3 text-sm text-gray-800 dark:text-gray-200">{{ variable.label || '—' }}</td>
                <td class="px-4 py-3 text-sm text-gray-800 dark:text-gray-200">{{ formatVariableType(variable.type) }}</td>
                <td class="px-4 py-3 text-sm text-gray-800 dark:text-gray-200">
                  <span :class="variable.required ? 'text-green-600 dark:text-green-400' : 'text-gray-500 dark:text-gray-400'">
                    {{ variable.required ? t('common.active') : t('common.inactive') }}
                  </span>
                </td>
                <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-300">{{ variable.description || '—' }}</td>
                <td class="px-4 py-3 text-sm text-gray-800 dark:text-gray-200">{{ template.sample_payload?.[variable.key] ?? '—' }}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]" v-if="template.extras && template.extras.cta">
      <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800">
        <h2 class="text-lg font-medium text-gray-800 dark:text-white">{{ t('message_templates.sections.extras') }}</h2>
      </div>
      <dl class="grid grid-cols-1 gap-x-8 gap-y-4 p-6 sm:grid-cols-2">
        <div class="flex flex-col gap-1">
          <dt class="text-xs font-medium uppercase tracking-wide text-gray-500 dark:text-gray-400">{{ t('message_templates.fields.ctaLabel') }}</dt>
          <dd class="text-sm text-gray-800 dark:text-gray-200">{{ template.extras.cta.label || '—' }}</dd>
        </div>
        <div class="flex flex-col gap-1">
          <dt class="text-xs font-medium uppercase tracking-wide text-gray-500 dark:text-gray-400">{{ t('message_templates.fields.ctaUrl') }}</dt>
          <dd class="text-sm text-gray-800 dark:text-gray-200">{{ template.extras.cta.url || '—' }}</dd>
        </div>
      </dl>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'
import { useI18n } from 'vue-i18n'

const props = defineProps({
  messageTemplate: { type: Object, required: true },
  options: { type: Object, default: () => ({}) },
})

const { t } = useI18n()

const template = computed(() => props.messageTemplate || {})

const informationRows = computed(() => [
  {
    label: t('message_templates.fields.name'),
    value: template.value.name || '—',
  },
  {
    label: t('message_templates.fields.code'),
    value: template.value.code || '—',
  },
  {
    label: t('message_templates.fields.channel'),
    value: formatChannel(template.value.channel),
  },
  {
    label: t('message_templates.fields.locale'),
    value: (template.value.locale || '—').toUpperCase(),
  },
  {
    label: t('message_templates.fields.mosque'),
    value: template.value.mosque_name || t('message_templates.fields.globalTemplate'),
  },
  {
    label: t('message_templates.fields.status'),
    value: template.value.is_active ? t('common.active') : t('common.inactive'),
  },
  {
    label: t('message_templates.fields.subject'),
    value: template.value.subject || '—',
  },
  {
    label: t('message_templates.fields.description'),
    value: template.value.description || '—',
  },
  {
    label: t('message_templates.fields.updatedAt'),
    value: formatDate(template.value.updated_at),
  },
])

function formatChannel(channel) {
  if (!channel) return '—'
  const key = `message_templates.channels.${channel}`
  const translated = t(key)
  return translated === key ? channel : translated
}

function formatVariableType(type) {
  if (!type) return '—'
  const key = `message_templates.variableTypes.${type}`
  const translated = t(key)
  return translated === key ? type : translated
}

function formatDate(value) {
  if (!value) return '—'
  try {
    return new Date(value).toLocaleString()
  } catch (e) {
    return value
  }
}
</script>

<script>
export default {
  components: {
    DetailRow: {
      props: {
        label: { type: String, required: true },
        value: { type: [String, Number], default: '—' },
      },
      template: `
        <div class="flex flex-col gap-1">
          <dt class="text-xs font-medium uppercase tracking-wide text-gray-500 dark:text-gray-400">{{ label }}</dt>
          <dd class="text-sm text-gray-800 dark:text-gray-200">{{ value ?? '—' }}</dd>
        </div>
      `,
    },
  },
}
</script>
