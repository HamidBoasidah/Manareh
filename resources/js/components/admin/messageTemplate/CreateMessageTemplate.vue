<template>
  <MessageTemplateForm :form="form" :options="options" mode="create" @submit="handleSubmit" />
</template>

<script setup>
import { computed } from 'vue'
import { useForm } from '@inertiajs/vue3'
import { route } from '@/route'
import MessageTemplateForm from './MessageTemplateForm.vue'
import { useNotifications } from '@/composables/useNotifications'
import { useI18n } from 'vue-i18n'

const props = defineProps({
  options: { type: Object, default: () => ({}) },
})

const { success, error } = useNotifications()
const { t } = useI18n()

const defaults = computed(() => ({
  channel: props.options.channels?.[0] || 'in_app',
  locale: props.options.locales?.[0] || 'ar',
}))

const form = useForm({
  name: '',
  code: '',
  channel: defaults.value.channel,
  locale: defaults.value.locale,
  mosque_id: '',
  subject: '',
  description: '',
  body: '',
  variables: [],
  sample_payload: {},
  extras: null,
  is_active: true,
})

const options = computed(() => props.options || {})

function handleSubmit() {
  form.post(route('admin.message_templates.store'), {
    onSuccess: () => {
      success(t('message_templates.notifications.created'))
      form.reset({
        name: '',
        code: '',
        channel: defaults.value.channel,
        locale: defaults.value.locale,
        mosque_id: '',
        subject: '',
        description: '',
        body: '',
        variables: [],
        sample_payload: {},
        extras: null,
        is_active: true,
      })
    },
    onError: () => {
      error(t('message_templates.notifications.genericError'))
    },
    preserveScroll: true,
  })
}
</script>
