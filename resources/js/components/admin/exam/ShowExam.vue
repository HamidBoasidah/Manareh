<template>
  <div class="space-y-6">
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
      <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800">
        <h2 class="text-lg font-medium text-gray-800 dark:text-white">{{ t('exams.showExam') }}</h2>
      </div>

  <div class="p-4 sm:p-6">
  <div class="grid grid-cols-1 gap-x-5 gap-y-6 md:grid-cols-3">
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
            <label class="mb-1.5 block text-sm font-medium text-gray-500 dark:text-gray-400">{{ t('nominations.type') || 'نوع الترشيح' }}</label>
            <p class="text-base text-gray-800 dark:text-white/90">{{ t('nominations.types.' + (exam.nomination_type || '') ) || exam.nomination_type || '—' }}</p>
          </div>

          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-500 dark:text-gray-400">{{ t('nominations.nominatedBy') || 'المرشح' }}</label>
            <p class="text-base text-gray-800 dark:text-white/90">{{ exam.nominated_by ?? (exam.nominated_by_name ?? '—') }}</p>
          </div>

          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-500 dark:text-gray-400">{{ t('exams.total_points') || 'مجموع النقاط' }}</label>
            <p class="text-base text-gray-800 dark:text-white/90">{{ computedTotal }}</p>
          </div>

          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-500 dark:text-gray-400">{{ t('exams.total_grade') || 'التقدير العام' }}</label>
            <p class="text-base text-gray-800 dark:text-white/90">{{ computedGrade ?? (exam.total_grade ?? '—') }}</p>
          </div>

          
        </div>
      </div>
    </div>

    <!-- Exam items: two rows of four columns each -->
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
      <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800">
        <h3 class="text-md font-medium text-gray-800 dark:text-white">{{ t('menu.exam_items') }}</h3>
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

      <div class="w-full">
        <button
          @click="saveChanges"
          :disabled="form.processing"
          class="w-full bg-brand-500 shadow-theme-xs hover:bg-brand-600 inline-flex items-center justify-center gap-2 rounded-lg px-4 py-3 text-sm font-medium text-white transition"
        >
          {{ form.processing ? t('common.loading') : t('common.save') }}
        </button>
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
import { Link, usePage, router, useForm } from '@inertiajs/vue3'
import { route } from 'ziggy-js'
import { reactive, computed, onMounted } from 'vue'
import { useNotifications } from '@/composables/useNotifications'

const { t } = useI18n()

const props = defineProps({
  exam: { type: Object, required: false },
})

// prefer explicit prop if provided; fallback to Inertia page props
const page = usePage()
const exam = props.exam ?? page.props.exam

// items computed and map by item_key
const items = computed(() => (exam && exam.items) ? exam.items : [])

const itemMap = computed(() => {
  const map = {}
  items.value.forEach(i => { if (i && i.item_key) map[i.item_key] = i })
  return map
})

// dynamic ordering: prefer default order but include any unexpected keys
const defaultOrder = ['q1','q2','q3','q4','q5','q6','t1','t2']
const availableKeys = computed(() => items.value.map(i => i.item_key))
const sortedKeys = computed(() => [
  ...defaultOrder.filter(k => availableKeys.value.includes(k)),
  ...availableKeys.value.filter(k => !defaultOrder.includes(k))
])
const row1Keys = computed(() => sortedKeys.value.slice(0,4))
const row2Keys = computed(() => sortedKeys.value.slice(4,8))

// reactive scores keyed by exam_item id (initialize on mount)
const scores = reactive({})

// form (use Inertia useForm to match CreateNomination.vue pattern)
const form = useForm({ items: [], total_points: 0, total_grade: '' })

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

const computedTotal = computed(() => {
  let sum = 0
  // sum over items, prefer the live selected score in `scores`, otherwise use stored score_points
  items.value.forEach(i => {
    const sid = i.id
    const live = scores[sid]
    if (live !== undefined && live !== null && live !== '') {
      const n = Number(live)
      if (!Number.isNaN(n)) sum += n
    } else {
      const n = Number(i.score_points)
      if (!Number.isNaN(n)) sum += n
    }
  })
  return Number.isInteger(sum) ? sum : Math.round(sum * 10) / 10
})

// compute overall grade label based on computedTotal and fixed max (0..80)
const MAX_POINTS = 80
const computedGrade = computed(() => {
  const total = Number(computedTotal.value)
  if (Number.isNaN(total)) return null
  const pct = (total / MAX_POINTS) * 100
  // thresholds (percent): >=90 excellent, >=80 very good, >=65 good, >=50 acceptable, else fail
  if (pct >= 90) return t('grades.excellent') || 'ممتاز'
  if (pct >= 80) return t('grades.very_good') || 'جيد جدا'
  if (pct >= 65) return t('grades.good') || 'جيد'
  if (pct >= 50) return t('grades.acceptable') || 'مقبول'
  return t('grades.fail') || 'راسب'
})

onMounted(() => {
  // quick debug info — remove after verifying in browser console
  try {
    // initialize scores from items if empty
    if (items.value.length) {
      items.value.forEach(i => { scores[i.id] = i.score_points ?? '' })
    }
    // eslint-disable-next-line no-console
    console.log('ShowExam: items', items.value)
    // eslint-disable-next-line no-console
    console.log('ShowExam: sortedKeys', sortedKeys.value)
    // eslint-disable-next-line no-console
    console.log('ShowExam: options sample for q1', optionsFor(itemMap.value['q1']?.max_points))
  } catch (e) {
    // eslint-disable-next-line no-console
    console.warn('ShowExam debug error', e)
  }
})

const { success, error } = useNotifications()

async function saveChanges() {
  if (!exam || !exam.id) return

  // collect changed items
  const changed = items.value
    .filter(i => String(scores[i.id]) !== String(i.score_points ?? ''))
    .map(i => ({ id: i.id, score_points: scores[i.id] ?? 0 }))

  // fill form payload
  form.items = changed
  form.total_points = computedTotal.value ?? 0
  form.total_grade = computedGrade.value ?? (exam.total_grade ?? '')

  form.put(route('admin.exams.update', exam.id), {
    preserveState: true,
    preserveScroll: true,
    onSuccess: () => {
      success(t('messages.savedSuccessfully') || 'Saved')
    },
    onError: () => {
      error(t('messages.saveFailed') || 'Save failed')
    }
  })
}

function labelForKey(k){
  const labels = { q1: t('exam_items.q1') || 'سؤال 1', q2: t('exam_items.q2') || 'سؤال 2', q3: t('exam_items.q3') || 'سؤال 3', q4: t('exam_items.q4') || 'سؤال 4', q5: t('exam_items.q5') || 'سؤال 5', q6: t('exam_items.q6') || 'سؤال 6', t1: t('exam_items.t1') || 'تجويد 1', t2: t('exam_items.t2') || 'تجويد 2' }
  return labels[k] ?? k
}
</script>
