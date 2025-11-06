<template>
  <div class="space-y-6">
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
      <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800">
        <h2 class="text-lg font-medium text-gray-800 dark:text-white">{{ t('exams.showExam') }}</h2>
      </div>

      <div class="p-4 sm:p-6">
        <div class="grid grid-cols-1 gap-x-5 gap-y-6 md:grid-cols-2">
          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-500 dark:text-gray-400">{{ t('students.studentName') }}</label>
            <p class="text-base text-gray-800 dark:text-white/90">{{ exam.student?.user?.name ?? exam.student_name ?? '—' }}</p>
          </div>

          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-500 dark:text-gray-400">{{ t('circles.name') }}</label>
            <p class="text-base text-gray-800 dark:text-white/90">{{ exam.circle?.name ?? exam.circle_name ?? '—' }}</p>
          </div>

          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-500 dark:text-gray-400">{{ t('exams.type') }}</label>
            <p class="text-base text-gray-800 dark:text-white/90">{{ t('exams.types.' + exam.exam_type) }}</p>
          </div>

          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-500 dark:text-gray-400">{{ t('exams.part') }}</label>
            <p class="text-base text-gray-800 dark:text-white/90">{{ exam.exam_type === 'stage' ? (exam.stage ?? '—') : (exam.juzz ?? '—') }}</p>
          </div>

          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-500 dark:text-gray-400">{{ t('exams.date') }}</label>
            <p class="text-base text-gray-800 dark:text-white/90">{{ exam.exam_date_g ?? exam.exam_date_h ?? '—' }}</p>
          </div>

          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-500 dark:text-gray-400">{{ t('common.status') }}</label>
            <span
              class="inline-flex items-center justify-center gap-1 rounded-full px-2.5 py-0.5 text-xs font-medium"
              :class="{
                'bg-green-50 text-green-600 dark:bg-green-500/15 dark:text-green-500': exam.is_active,
                'bg-error-50 text-error-600 dark:bg-error-500/15 dark:text-error-500': !exam.is_active,
              }"
            >
              {{ exam.is_active ? t('common.active') : t('common.inactive') }}
            </span>
          </div>

          <div class="md:col-span-2">
            <label class="mb-1.5 block text-sm font-medium text-gray-500 dark:text-gray-400">{{ t('common.remarks') }}</label>
            <p class="text-base text-gray-800 whitespace-pre-wrap dark:text-white/90">{{ exam.remarks ?? '—' }}</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Exam items: two rows of four columns each -->
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
      <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800">
        <h3 class="text-md font-medium text-gray-800 dark:text-white">{{ t('exam_items') }}</h3>
      </div>

      <div class="p-4 sm:p-6">
        <div class="space-y-4">
          <!-- two rows: first 4 keys, then next 4 -->
          <div class="grid grid-cols-1 gap-4 md:grid-cols-4">
            <div v-for="key in row1Keys" :key="key" class="">
              <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">{{ labelForKey(key) }}</label>
              <div class="relative z-20 bg-transparent">
                <select
                  v-model="scores[itemMap[key]?.id]"
                  :disabled="!itemMap[key]"
                  class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                >
                  <option value="">-</option>
                  <option v-for="opt in optionsFor(itemMap[key]?.max_points)" :key="opt" :value="Number(opt)">{{ opt }}</option>
                </select>
                <span class="pointer-events-none absolute top-1/2 right-4 z-30 -translate-y-1/2 text-gray-700 dark:text-gray-400">
                  <svg class="stroke-current" width="20" height="20" viewBox="0 0 20 20" fill="none">
                    <path d="M4.79175 7.396L10.0001 12.6043L15.2084 7.396" stroke="" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
                </span>
              </div>
              
            </div>
          </div>

          <div class="grid grid-cols-1 gap-4 md:grid-cols-4">
            <div v-for="key in row2Keys" :key="key" class="">
              <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">{{ labelForKey(key) }}</label>
              <div class="relative z-20 bg-transparent">
                <select
                  v-model="scores[itemMap[key]?.id]"
                  :disabled="!itemMap[key]"
                  class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                >
                  <option value="">-</option>
                  <option v-for="opt in optionsFor(itemMap[key]?.max_points)" :key="opt" :value="Number(opt)">{{ opt }}</option>
                </select>
                <span class="pointer-events-none absolute top-1/2 right-4 z-30 -translate-y-1/2 text-gray-700 dark:text-gray-400">
                  <svg class="stroke-current" width="20" height="20" viewBox="0 0 20 20" fill="none">
                    <path d="M4.79175 7.396L10.0001 12.6043L15.2084 7.396" stroke="" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
                </span>
              </div>
              
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="flex flex-col gap-3 sm:flex-row sm:justify-end">
      <Link
        :href="route('admin.exams.index')"
        class="shadow-theme-xs inline-flex items-center justify-center gap-2 rounded-lg bg-white px-4 py-3 text-sm font-medium text-gray-700 ring-1 ring-gray-300 transition hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-400 dark:ring-gray-700 dark:hover:bg-white/[0.03]"
      >
        {{ t('buttons.backToList') }}
      </Link>

      <Link
        :href="route('admin.exams.edit', exam.id)"
        class="bg-brand-500 shadow-theme-xs hover:bg-brand-600 inline-flex items-center justify-center gap-2 rounded-lg px-4 py-3 text-sm font-medium text-white transition"
      >
        {{ t('buttons.edit') }}
      </Link>
    </div>
  </div>
</template>

<script setup>
import { useI18n } from 'vue-i18n'
import { Link, usePage } from '@inertiajs/vue3'
import { route } from 'ziggy-js'
import { reactive, computed, onMounted } from 'vue'

const { t } = useI18n()

const props = defineProps({
  exam: { type: Object, required: false },
})

// prefer explicit prop if provided; fallback to Inertia page props
const page = usePage()
const exam = props.exam ?? page.props.exam

// prepare items map keyed by item_key for easy lookup
const itemMap = computed(() => {
  const map = {};
  if (exam && exam.items) {
    exam.items.forEach(i => map[i.item_key] = i)
  }
  return map;
})

// ordering: first row q1..q4, second row q5,q6,t1,t2
const row1Keys = ['q1','q2','q3','q4']
const row2Keys = ['q5','q6','t1','t2']

// reactive scores keyed by exam_item id (initialize from exam.items)
const scores = reactive({})
if (exam && exam.items) {
  exam.items.forEach(i => scores[i.id] = i.score_points)
}

const DEFAULT_MAX = 10
function optionsFor(max) {
  // default to DEFAULT_MAX when missing
  if (max == null) max = DEFAULT_MAX
  const out = []
  for (let v = 0; v <= Number(max); v = Math.round((v + 0.5) * 10) / 10) {
    // format so .0 shows without trailing .0 when integer
    out.push(Number.isInteger(v) ? v.toString() : v.toFixed(1))
  }
  return out
}

onMounted(() => {
  // quick debug info — remove after verifying in browser console
  try {
    // eslint-disable-next-line no-console
    console.log('ShowExam: exam items', exam?.items)
    // eslint-disable-next-line no-console
    console.log('ShowExam: itemMap', itemMap.value)
    // eslint-disable-next-line no-console
    console.log('ShowExam: options sample for q1', optionsFor(itemMap.value['q1']?.max_points))
  } catch (e) {
    // eslint-disable-next-line no-console
    console.warn('ShowExam debug error', e)
  }
})

function labelForKey(k){
  const labels = { q1: t('exam_items.q1') || 'سؤال 1', q2: t('exam_items.q2') || 'سؤال 2', q3: t('exam_items.q3') || 'سؤال 3', q4: t('exam_items.q4') || 'سؤال 4', q5: t('exam_items.q5') || 'سؤال 5', q6: t('exam_items.q6') || 'سؤال 6', t1: t('exam_items.t1') || 'تجويد 1', t2: t('exam_items.t2') || 'تجويد 2' }
  return labels[k] ?? k
}
</script>
