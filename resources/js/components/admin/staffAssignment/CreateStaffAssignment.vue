<template>
  <form class="space-y-6" @submit.prevent="create">
    <!-- معلومات التعيين -->
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
      <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800">
        <h2 class="text-lg font-medium text-gray-800 dark:text-white">
          {{ t('staff_assignments.assignmentInformation') }}
        </h2>
      </div>

      <div class="p-4 sm:p-6 dark:border-gray-800">
        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
          <!-- اختيار الحلقة -->
          <div class="md:col-span-2">
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
              {{ t('staff_assignments.selectCircle') }}
            </label>
            <div class="relative z-20 bg-transparent">
              <select
                v-model="form.circle_id"
                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                :class="{ 'text-gray-800 dark:text-white/90': form.circle_id }"
              >
                <option value="" disabled class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">
                  {{ t('staff_assignments.selectCircle') }}
                </option>
                <option
                  v-for="c in circles"
                  :key="c.id"
                  :value="c.id"
                  class="text-gray-700 dark:bg-gray-900 dark:text-gray-400"
                >
                  {{ c.name }}
                </option>
              </select>
              <span class="pointer-events-none absolute top-1/2 right-4 z-30 -translate-y-1/2 text-gray-700 dark:text-gray-400">
                <svg class="stroke-current" width="20" height="20" viewBox="0 0 20 20" fill="none">
                  <path d="M4.79175 7.396L10.0001 12.6043L15.2084 7.396" stroke="" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
              </span>
            </div>
            <p v-if="form.errors.circle_id" class="mt-1 text-sm text-error-500">{{ form.errors.circle_id }}</p>
          </div>

          <!-- اختيار المستخدم -->
          <div>
            <label for="user-id" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
              {{ t('staff_assignments.selectUser') }}
            </label>
            <div class="relative z-20 bg-transparent">
              <select
                v-model="form.user_id"
                id="user-id"
                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                :class="{ 'text-gray-800 dark:text-white/90': form.user_id }"
              >
                <option value="" disabled class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">
                  {{ t('staff_assignments.selectUser') }}
                </option>
                <option v-for="u in users" :key="u.id" :value="u.id" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">
                  {{ u.name }}
                </option>
              </select>
              <span class="pointer-events-none absolute top-1/2 right-4 z-30 -translate-y-1/2 text-gray-700 dark:text-gray-400">
                <svg class="stroke-current" width="20" height="20" viewBox="0 0 20 20" fill="none">
                  <path d="M4.79175 7.396L10.0001 12.6043L15.2084 7.396" stroke="" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
              </span>
            </div>
            <p v-if="form.errors.user_id" class="mt-1 text-sm text-error-500">{{ form.errors.user_id }}</p>
          </div>

          <!-- اختيار الدور -->
          <div>
            <label for="role-in-circle" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
              {{ t('staff_assignments.selectRole') }}
            </label>
            <div class="relative z-20 bg-transparent">
              <select
                v-model="form.role_in_circle"
                id="role-in-circle"
                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                :class="{ 'text-gray-800 dark:text-white/90': form.role_in_circle }"
              >
                <option value="" disabled class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">
                  {{ t('staff_assignments.selectRole') }}
                </option>
                <option v-for="r in roles" :key="r.value" :value="r.value" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">
                  {{ r.label }}
                </option>
              </select>
              <span class="pointer-events-none absolute top-1/2 right-4 z-30 -translate-y-1/2 text-gray-700 dark:text-gray-400">
                <svg class="stroke-current" width="20" height="20" viewBox="0 0 20 20" fill="none">
                  <path d="M4.79175 7.396L10.0001 12.6043L15.2084 7.396" stroke="" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
              </span>
            </div>
            <p v-if="form.errors.role_in_circle" class="mt-1 text-sm text-error-500">{{ form.errors.role_in_circle }}</p>
          </div>

          <!-- تاريخ البدء -->
          <div>
            <label for="start-at" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
              {{ t('staff_assignments.startAt') }}
            </label>
            <input
              v-model="form.start_at"
              type="date"
              id="start-at"
              autocomplete="off"
              class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
            />
            <p v-if="form.errors.start_at" class="mt-1 text-sm text-error-500">{{ form.errors.start_at }}</p>
          </div>

          <!-- تاريخ الانتهاء -->
          <div>
            <label for="end-at" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
              {{ t('staff_assignments.endAt') }}
            </label>
            <input
              v-model="form.end_at"
              type="date"
              id="end-at"
              autocomplete="off"
              class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
            />
            <p v-if="form.errors.end_at" class="mt-1 text-sm text-error-500">{{ form.errors.end_at }}</p>
          </div>

          <!-- ملاحظات -->
          <div class="md:col-span-2">
            <label for="notes" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
              {{ t('staff_assignments.notes') }}
            </label>
            <textarea
              v-model="form.notes"
              id="notes"
              rows="3"
              class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
            />
            <p v-if="form.errors.notes" class="mt-1 text-sm text-error-500">{{ form.errors.notes }}</p>
          </div>
        </div>
      </div>
    </div>

    <!-- معلومات الحلقة الحالية (حسب الاختيار) -->
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]" v-if="form.circle_id">
      <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800">
        <h2 class="text-lg font-medium text-gray-800 dark:text-white">
          {{ t('staff_assignments.currentCircleStatus') }}
        </h2>
      </div>

        <div class="p-4 sm:p-6">
          <div class="grid grid-cols-1 gap-x-5 gap-y-6 md:grid-cols-2">
            <!-- صف المعلم -->
            <div>
              <label class="mb-1.5 block text-sm font-medium text-gray-500 dark:text-gray-400">
                {{ t('staff_assignments.currentAssignee') }} — {{ getRoleLabel('teacher') }}
              </label>
              <p class="text-base text-gray-800 dark:text-white/90">
                {{ teacherName || t('staff_assignments.notAssignedYet') }}
              </p>
            </div>

            <!-- صف المشرف -->
            <div>
              <label class="mb-1.5 block text-sm font-medium text-gray-500 dark:text-gray-400">
                {{ t('staff_assignments.currentAssignee') }} — {{ getRoleLabel(supervisorRole) }}
              </label>
              <p class="text-base text-gray-800 dark:text-white/90">{{ supervisorName || t('staff_assignments.notAssignedYet') }}</p>
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
      <Link
        :href="route('admin.staff_assignments.index')"
        class="shadow-theme-xs inline-flex items-center justify-center gap-2 rounded-lg bg-white px-4 py-3 text-sm font-medium text-gray-700 ring-1 ring-gray-300 transition hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-400 dark:ring-gray-700 dark:hover:bg-white/[0.03]"
      >
        {{ t('buttons.backToList') }}
      </Link>

      <button
        type="submit"
        class="bg-brand-500 shadow-theme-xs hover:bg-brand-600 inline-flex items-center justify-center gap-2 rounded-lg px-4 py-3 text-sm font-medium text-white transition"
        :class="{ 'cursor-not-allowed opacity-70': form.processing }"
        :disabled="form.processing"
      >
        {{ form.processing ? t('common.loading') : t('buttons.create') }}
      </button>
    </div>
  </form>
</template>

<script setup>
import { Link, useForm } from '@inertiajs/vue3'
import { useI18n } from 'vue-i18n'
import { computed } from 'vue'
import { useNotifications } from '@/composables/useNotifications'

const { t } = useI18n()
const { success, error } = useNotifications()

const props = defineProps({
  circles: { type: Array, required: true }, // [{id, name}]
  users:   { type: Array, required: true }, // [{id, name}]
  roles:   { type: Array, required: true }, // [{value, label}] => مثال: value: 'supervisor_edu' | 'supervisor_teach' | 'teacher'
  // قائمة التعيينات الحالية لاستخدامها في إظهار حالة الحلقة فور اختيارها
  // مثال كل عنصر: { circle_id, role_in_circle, user_name, is_active }
  existingAssignments: { type: Array, default: () => [] },
})

const form = useForm({
  circle_id: '',
  user_id: '',
  role_in_circle: '',
  start_at: '',
  end_at: '',
  notes: '',
  is_active: true,
})

// حالـة الحلقة الحالية حسب الاختيار
const currentAssignment = computed(() => {
  if (!form.circle_id) return null
  // إن تم اختيار الدور، اعرض المعيّن لهذا الدور؛ وإلا ابحث أي تعيين نشط للحلقة
  const list = props.existingAssignments.filter(a => String(a.circle_id) === String(form.circle_id))
  if (form.role_in_circle) {
    return list.find(a => a.role_in_circle === form.role_in_circle) || null
  }
  return list.find(a => a.is_active) || list[0] || null
})

const currentAssigneeName = computed(() => currentAssignment.value?.user_name || '')
const currentAssigneeRole = computed(() => currentAssignment.value?.role_in_circle || '')

// assignments for selected circle (all rows we passed from backend)
const assignmentsForSelectedCircle = computed(() => {
  if (!form.circle_id) return []
  return props.existingAssignments.filter(a => String(a.circle_id) === String(form.circle_id))
})

// teacher-specific and supervisor-specific entries
const teacherAssignmentEntry = computed(() => assignmentsForSelectedCircle.value.find(a => a.role_in_circle === 'teacher') || null)
const supervisorAssignmentEntry = computed(() => assignmentsForSelectedCircle.value.find(a => ['supervisor_edu', 'supervisor_tarbawi'].includes(a.role_in_circle)) || null)

const teacherName = computed(() => teacherAssignmentEntry.value?.user_name || '')
const supervisorName = computed(() => supervisorAssignmentEntry.value?.user_name || '')
const supervisorRole = computed(() => supervisorAssignmentEntry.value?.role_in_circle || 'supervisor_edu')

// lookup role label from roles prop (roles: [{value,label}])
const getRoleLabel = (val) => {
  const r = props.roles.find(x => x.value === val)
  return r ? r.label : val
}

function create() {
  form.post(route('admin.staff_assignments.store'), {
    onSuccess: () => {
      success(t('staff_assignments.assignmentCreatedSuccessfully'))
    },
    onError: () => {
      error(t('staff_assignments.assignmentCreationFailed'))
    },
    preserveScroll: true,
  })
}
</script>
