<template>
  <MessageTemplateForm :form="form" :options="options" mode="edit" @submit="handleSubmit" />
</template>

<script setup>
import { computed } from 'vue'
import { useForm } from '@inertiajs/vue3'
import { route } from '@/route'
import MessageTemplateForm from './MessageTemplateForm.vue'
import { useNotifications } from '@/composables/useNotifications'
import { useI18n } from 'vue-i18n'

const props = defineProps({
  messageTemplate: { type: Object, required: true },
  options: { type: Object, default: () => ({}) },
})

const { success, error } = useNotifications()
const { t } = useI18n()

const form = useForm({
  name: props.messageTemplate.name ?? '',
  code: props.messageTemplate.code ?? '',
  channel: props.messageTemplate.channel ?? 'in_app',
  locale: props.messageTemplate.locale ?? 'ar',
  mosque_id: props.messageTemplate.mosque_id ?? '',
  subject: props.messageTemplate.subject ?? '',
  description: props.messageTemplate.description ?? '',
  body: props.messageTemplate.body ?? '',
  variables: Array.isArray(props.messageTemplate.variables) ? [...props.messageTemplate.variables] : [],
  sample_payload: props.messageTemplate.sample_payload ? { ...props.messageTemplate.sample_payload } : {},
  extras: props.messageTemplate.extras ? { ...props.messageTemplate.extras } : null,
  is_active: props.messageTemplate.is_active ?? true,
})

const options = computed(() => props.options || {})

function handleSubmit() {
  form.put(route('admin.message_templates.update', props.messageTemplate.id), {
    onSuccess: () => {
      success(t('message_templates.notifications.updated'))
    },
    onError: () => {
      error(t('message_templates.notifications.genericError'))
    },
    preserveScroll: true,
  })
}
</script>
