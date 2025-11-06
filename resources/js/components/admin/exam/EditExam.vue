<template>
  <div class="space-y-5 sm:space-y-6">
    <ComponentCard :title="t('exams.editExam')">
      <form @submit.prevent="submit">
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
          <div>
            <label class="text-sm text-gray-500">{{ t('exams.type') }}</label>
            <select v-model="form.exam_type" class="mt-2 w-full rounded-lg border border-gray-300 bg-transparent py-2.5 px-3 text-sm text-gray-800 focus:outline-none">
              <option value="stage">{{ t('exams.types.stage') || 'Stage' }}</option>
              <option value="juzz">{{ t('exams.types.juzz') || 'Juzz' }}</option>
            </select>
            <p v-if="errors.exam_type" class="mt-1 text-sm text-error-600">{{ errors.exam_type }}</p>
          </div>

          <div>
            <label class="text-sm text-gray-500">{{ t('exams.part') }}</label>
            <input v-model="computedPart" type="text" class="mt-2 w-full rounded-lg border border-gray-300 bg-transparent py-2.5 px-3 text-sm text-gray-800 focus:outline-none" />
            <p v-if="errors.part" class="mt-1 text-sm text-error-600">{{ errors.part }}</p>
          </div>

          <div>
            <label class="text-sm text-gray-500">{{ t('exams.date') }}</label>
            <input v-model="form.exam_date_g" type="date" class="mt-2 w-full rounded-lg border border-gray-300 bg-transparent py-2.5 px-3 text-sm text-gray-800 focus:outline-none" />
            <p v-if="errors.exam_date_g" class="mt-1 text-sm text-error-600">{{ errors.exam_date_g }}</p>
          </div>

          <div>
            <label class="text-sm text-gray-500">{{ t('exams.grade') }}</label>
            <input v-model="form.total_grade" type="text" class="mt-2 w-full rounded-lg border border-gray-300 bg-transparent py-2.5 px-3 text-sm text-gray-800 focus:outline-none" />
            <p v-if="errors.total_grade" class="mt-1 text-sm text-error-600">{{ errors.total_grade }}</p>
          </div>

          <div class="md:col-span-2">
            <label class="text-sm text-gray-500">{{ t('common.remarks') }}</label>
            <textarea v-model="form.remarks" rows="3" class="mt-2 w-full rounded-lg border border-gray-300 bg-transparent py-2.5 px-3 text-sm text-gray-800 focus:outline-none"></textarea>
            <p v-if="errors.remarks" class="mt-1 text-sm text-error-600">{{ errors.remarks }}</p>
          </div>

          <div class="md:col-span-2 flex items-center justify-end">
            <button type="submit" class="bg-brand-500 text-white rounded-lg px-4 py-2">{{ t('common.save') }}</button>
          </div>
        </div>
      </form>
    </ComponentCard>
  </div>
</template>

<script setup>
import { useI18n } from 'vue-i18n'
import ComponentCard from '@/components/common/ComponentCard.vue'
import { useForm, router } from '@inertiajs/vue3'
import { usePage } from '@inertiajs/vue3'
import { computed } from 'vue'
import { route } from '@/route'

const { t } = useI18n()
const page = usePage()
const exam = computed(() => page.props.exam)

const form = useForm({
  exam_type: exam.value?.exam_type ?? 'stage',
  stage: exam.value?.stage ?? null,
  juzz: exam.value?.juzz ?? null,
  exam_date_g: exam.value?.exam_date_g ?? null,
  total_grade: exam.value?.total_grade ?? null,
  remarks: exam.value?.remarks ?? null,
})

const errors = computed(() => form.errors.value || {})

const computedPart = computed({
  get() {
    return form.exam_type === 'stage' ? (form.stage ?? '') : (form.juzz ?? '')
  },
  set(val) {
    if (form.exam_type === 'stage') form.stage = val
    else form.juzz = val
  }
})

function submit() {
  form.put(route('admin.exams.update', exam.value.id), {
    preserveState: true,
    onSuccess: () => { router.visit(route('admin.exams.show', exam.value.id)) }
  })
}
</script>
