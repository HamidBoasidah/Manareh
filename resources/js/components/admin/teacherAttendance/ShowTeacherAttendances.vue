<template>
  <div class="overflow-hidden">
    <div class="px-4 pt-6">
      <div ref="monthPickerContainer" class="relative flex items-center gap-3">
        <button
          type="button"
          @click="goToPreviousMonth"
          class="flex h-9 w-9 items-center justify-center rounded-full border border-gray-200 text-gray-500 transition hover:border-brand-400 hover:text-brand-500 focus:outline-hidden dark:border-gray-700 dark:text-white/60 dark:hover:border-brand-500/60 dark:hover:text-brand-300"
        >
          <svg class="h-4 w-4" viewBox="0 0 16 16" fill="none">
            <path d="M9.6665 12.0001L5.99984 8.00008L9.6665 4.00008" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round" />
          </svg>
        </button>

        <button
          type="button"
          @click="toggleMonthPicker"
          class="inline-flex items-center gap-2 rounded-xl border border-transparent px-4 py-2 text-lg font-semibold text-gray-800 transition hover:border-brand-300 hover:text-brand-500 focus:outline-hidden dark:text-white/90 dark:hover:border-brand-500/60 dark:hover:text-brand-300"
        >
          <span class="capitalize">{{ monthLabel }}</span>
          <svg class="h-4 w-4" viewBox="0 0 16 16" fill="none">
            <path d="M3.3335 6L8.00016 10.6667L12.6668 6" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round" />
          </svg>
        </button>

        <button
          type="button"
          @click="goToNextMonth"
          class="flex h-9 w-9 items-center justify-center rounded-full border border-gray-200 text-gray-500 transition hover:border-brand-400 hover:text-brand-500 focus:outline-hidden dark:border-gray-700 dark:text-white/60 dark:hover:border-brand-500/60 dark:hover:text-brand-300"
        >
          <svg class="h-4 w-4" viewBox="0 0 16 16" fill="none">
            <path d="M6.3335 4.00008L9.99984 8.00008L6.3335 12.0001" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round" />
          </svg>
        </button>

        <div
          v-if="showMonthPicker"
          class="absolute left-1/2 top-full z-30 mt-3 w-80 -translate-x-1/2 overflow-hidden rounded-2xl border border-gray-200 bg-white/95 backdrop-blur-sm shadow-xl transition-all dark:border-white/10 dark:bg-white/5"
        >
          <div class="flex flex-col gap-3">
            <div class="grid grid-cols-2 gap-3">
              <div class="flex flex-col gap-1">
                <span class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-white/60">{{ monthSelectLabel }}</span>
                <select
                  v-model.number="pickerMonth"
                  class="rounded-xl border border-gray-300 bg-white px-3 py-2 text-sm text-gray-800 shadow-theme-xs transition focus:border-brand-300 focus:outline-hidden focus:ring-2 focus:ring-brand-400/20 dark:border-white/15 dark:bg-white/10 dark:text-white/80 dark:focus:border-brand-400"
                >
                  <option v-for="option in monthOptions" :key="option.value" :value="option.value">
                    {{ option.label }}
                  </option>
                </select>
              </div>
              <div class="flex flex-col gap-1">
                <span class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-white/60">{{ yearSelectLabel }}</span>
                <select
                  v-model.number="pickerYear"
                  class="rounded-xl border border-gray-300 bg-white px-3 py-2 text-sm text-gray-800 shadow-theme-xs transition focus:border-brand-300 focus:outline-hidden focus:ring-2 focus:ring-brand-400/20 dark:border-white/15 dark:bg-white/10 dark:text-white/80 dark:focus:border-brand-400"
                >
                  <option v-for="year in yearOptions" :key="year" :value="year">{{ year }}</option>
                </select>
              </div>
            </div>
            <div class="flex justify-end gap-2 px-1 pb-1">
              <button
                type="button"
                @click="cancelMonthPicker"
                class="rounded-xl border border-gray-200 px-3 py-2 text-sm font-medium text-gray-600 transition hover:border-gray-300 hover:text-gray-800 focus:outline-hidden dark:border-white/15 dark:text-white/70 dark:hover:border-white/25 dark:hover:text-white"
              >
                {{ cancelLabel }}
              </button>
              <button
                type="button"
                @click="applyMonthPicker"
                class="rounded-xl bg-brand-500 px-3.5 py-2 text-sm font-semibold text-white shadow-theme-xs transition hover:bg-brand-600 focus:outline-hidden dark:shadow-brand-500/30"
              >
                {{ applyLabel }}
              </button>
            </div>
          </div>
        </div>
      </div>

      <div class="mt-4">
        <div class="grid grid-cols-3 gap-2 sm:grid-cols-6 md:grid-cols-8 lg:grid-cols-10 xl:grid-cols-11">
          <button
            v-for="day in monthDays"
            :key="day.key"
            type="button"
            @click="selectDay(day)"
            class="flex flex-col items-center justify-center rounded-xl border px-3 py-2 text-sm font-medium transition focus:outline-hidden focus:ring-2 focus:ring-brand-500/40"
            :class="selectedDateKey === day.key
              ? 'border-brand-500 bg-brand-500 text-white shadow-theme-sm dark:border-brand-500/70 dark:bg-brand-500/40'
              : 'border-gray-200 bg-white text-gray-600 hover:bg-gray-50 dark:border-gray-700 dark:bg-white/5 dark:text-white/70 dark:hover:bg-white/10'"
            :aria-pressed="selectedDateKey === day.key"
          >
            <span class="text-[11px] uppercase tracking-wide">{{ day.dayName }}</span>
            <span class="text-base font-semibold">{{ day.dayNumber }}</span>
          </button>
        </div>
      </div>
    </div>

    <div class="flex flex-col gap-2 px-4 py-4 border border-b-0 border-gray-200 rounded-b-none rounded-xl dark:border-gray-800 sm:flex-row sm:items-center sm:justify-between">
      <div class="flex items-center gap-3">
        <span class="text-gray-500 dark:text-gray-400">{{ t('datatable.show') }}</span>
        <div class="relative z-20 bg-transparent">
          <select
            v-model="perPage"
            class="w-full h-9 appearance-none rounded-lg border border-gray-300 bg-transparent py-2 pl-3 pr-8 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-dark-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800"
          >
            <option value="12" class="text-gray-500 dark:bg-gray-900 dark:text-gray-400">12</option>
            <option value="24" class="text-gray-500 dark:bg-gray-900 dark:text-gray-400">24</option>
            <option value="48" class="text-gray-500 dark:bg-gray-900 dark:text-gray-400">48</option>
          </select>
          <span class="pointer-events-none absolute right-2 top-1/2 z-30 -translate-y-1/2 text-gray-500 dark:text-gray-400">
            <svg class="stroke-current" width="16" height="16" viewBox="0 0 16 16" fill="none">
              <path d="M3.8335 5.9165L8.00016 10.0832L12.1668 5.9165" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
          </span>
        </div>

        <div class="hidden ml-2 items-center border-l border-gray-200 pl-4 sm:flex dark:border-gray-700">
          <label class="flex cursor-pointer select-none items-center text-sm font-medium text-gray-700 dark:text-gray-400">
            <span class="relative">
              <input type="checkbox" class="sr-only" v-model="selectAll" @change="toggleSelectAll" />
              <span :class="selectAll ? 'border-brand-500 bg-brand-500' : 'bg-transparent border-gray-300 dark:border-gray-700'" class="flex h-4 w-4 items-center justify-center rounded-sm border-[1.25px]">
                <span :class="selectAll ? '' : 'opacity-0'">
                  <svg width="12" height="12" viewBox="0 0 12 12" fill="none">
                    <path d="M10 3L4.5 8.5L2 6" stroke="white" stroke-width="1.6666" stroke-linecap="round" stroke-linejoin="round" />
                  </svg>
                </span>
              </span>
            </span>
            <span class="sr-only">Select all</span>
          </label>
        </div>

        <span class="text-gray-500 dark:text-gray-400">{{ t('datatable.entries') }}</span>
      </div>

      <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
        <div class="relative">
          <button class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 dark:text-gray-400" type="button" tabindex="-1">
            <svg class="fill-current" width="20" height="20" viewBox="0 0 20 20" fill="none">
              <path fill-rule="evenodd" clip-rule="evenodd" d="M3.04199 9.37363C3.04199 5.87693 5.87735 3.04199 9.37533 3.04199C12.8733 3.04199 15.7087 5.87693 15.7087 9.37363C15.7087 12.8703 12.8733 15.7053 9.37533 15.7053C5.87735 15.7053 3.04199 12.8703 3.04199 9.37363ZM9.37533 1.54199C5.04926 1.54199 1.54199 5.04817 1.54199 9.37363C1.54199 13.6991 5.04926 17.2053 9.37533 17.2053C11.2676 17.2053 13.0032 16.5344 14.3572 15.4176L17.1773 18.238C17.4702 18.5309 17.945 18.5309 18.2379 18.238C18.5308 17.9451 18.5309 17.4703 18.238 17.1773L15.4182 14.3573C16.5367 13.0033 17.2087 11.2669 17.2087 9.37363C17.2087 5.04817 13.7014 1.54199 9.37533 1.54199Z" />
            </svg>
          </button>
          <input
            v-model="search"
            type="text"
            :placeholder="t('datatable.searchPlaceholder')"
            class="h-11 w-full rounded-lg border border-gray-300 bg-transparent py-2.5 pl-11 pr-4 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800 xl:w-[300px]"
          />
        </div>

        <Tooltip :text="t('messages.notAuthorized')" :show="!canCreate">
          <button
            :disabled="!canCreate"
            @click="handleCreateClick"
            class="inline-flex items-center justify-center gap-2 rounded-lg bg-brand-500 px-4 py-[11px] text-sm font-medium text-white shadow-theme-xs transition hover:bg-brand-600 disabled:bg-brand-300 disabled:text-white/70 disabled:hover:bg-brand-300 sm:w-auto"
          >
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none">
              <path d="M5 10.0002H15.0006M10.0002 5V15.0006" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
            {{ t('teacher_attendances.addTeacherAttendance') }}
          </button>
        </Tooltip>
      </div>
    </div>
    <div class="px-4 pb-4">
      <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
        <div
          v-for="attendance in paginatedData"
          :key="attendance.id"
          class="group relative rounded-xl border border-gray-200 bg-white p-5 shadow-theme-sm transition hover:shadow-theme-md dark:border-gray-800 dark:bg-white/5"
          :class="attendance.selected ? 'ring-2 ring-brand-200 dark:ring-brand-500/40' : ''"
        >
          <div class="absolute left-4 top-4">
            <label class="flex cursor-pointer select-none items-center text-sm font-medium text-gray-700 dark:text-gray-400">
              <span class="relative">
                <input type="checkbox" class="sr-only" v-model="attendance.selected" @change="updateSelectAll" />
                <span :class="attendance.selected ? 'border-brand-500 bg-brand-500' : 'bg-transparent border-gray-300 dark:border-gray-700'" class="flex h-4 w-4 items-center justify-center rounded-sm border-[1.25px]">
                  <span :class="attendance.selected ? '' : 'opacity-0'">
                    <svg width="12" height="12" viewBox="0 0 12 12" fill="none">
                      <path d="M10 3L4.5 8.5L2 6" stroke="white" stroke-width="1.6666" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                  </span>
                </span>
              </span>
            </label>
          </div>

          <div class="flex flex-col gap-4 pt-8">
            <div class="flex items-start justify-between gap-3">
              <div class="flex flex-col gap-1">
                <p class="text-base font-semibold text-gray-800 dark:text-white/90">{{ attendance.user_name || '—' }}</p>
                <span v-if="attendance.user_role" class="text-xs text-gray-500 dark:text-gray-400">{{ attendance.user_role }}</span>
              </div>
              <span
                class="inline-flex items-center justify-center gap-1 rounded-full px-2.5 py-0.5 text-xs font-medium"
                :class="statusBadgeClass(attendance.status)"
              >
                {{ statusLabel(attendance.status) }}
              </span>
            </div>

            <div class="flex flex-wrap items-center gap-3 text-sm text-gray-500 dark:text-gray-400">
              <span class="inline-flex items-center gap-1">
                {{ attendance.circle_name || '—' }}
              </span>
              <span class="inline-flex items-center gap-1">
                <Calendar2Line class="h-4 w-4" />
                {{ attendance.date_g || '—' }}
              </span>
            </div>

            <div class="flex items-center justify-end gap-2 pt-2 opacity-0 transition group-hover:opacity-100">
              <Tooltip :text="t('messages.notAuthorized')" :show="!canView">
                <button
                  :disabled="!canView"
                  @click.stop="handleViewClick(attendance.id)"
                  class="flex h-8 w-8 items-center justify-center rounded-full bg-gray-100 text-gray-500 shadow-theme-xs ring-1 ring-transparent transition hover:bg-white hover:text-gray-800 dark:bg-white/10 dark:text-white/70 dark:ring-white/10 dark:hover:bg-white/20 dark:hover:text-white"
                >
                  <svg class="h-4 w-4" viewBox="0 0 21 20" fill="none">
                    <path
                      fill="currentColor"
                      fill-rule="evenodd"
                      clip-rule="evenodd"
                      d="M10.8749 13.8619C8.10837 13.8619 5.74279 12.1372 4.79804 9.70241C5.74279 7.26761 8.10837 5.54297 10.8749 5.54297C13.6415 5.54297 16.0071 7.26762 16.9518 9.70243C16.0071 12.1372 13.6415 13.8619 10.8749 13.8619ZM10.8749 4.04297C7.35666 4.04297 4.36964 6.30917 3.29025 9.4593C3.23626 9.61687 3.23626 9.78794 3.29025 9.94552C4.36964 13.0957 7.35666 15.3619 10.8749 15.3619C14.3932 15.3619 17.3802 13.0957 18.4596 9.94555C18.5136 9.78797 18.5136 9.6169 18.4596 9.45932C17.3802 6.30919 14.3932 4.04297 10.8749 4.04297ZM10.8663 7.84413C9.84002 7.84413 9.00808 8.67606 9.00808 9.70231C9.00808 10.7286 9.84002 11.5605 10.8663 11.5605H10.8811C11.9074 11.5605 12.7393 10.7286 12.7393 9.70231C12.7393 8.67606 11.9074 7.84413 10.8811 7.84413H10.8663Z"
                    />
                  </svg>
                </button>
              </Tooltip>

              <Tooltip :text="t('messages.notAuthorized')" :show="!canEdit">
                <button
                  :disabled="!canEdit"
                  @click.stop="handleEditClick(attendance.id)"
                  class="flex h-8 w-8 items-center justify-center rounded-full bg-gray-100 text-gray-500 shadow-theme-xs ring-1 ring-transparent transition hover:bg-white hover:text-blue-500 dark:bg-white/10 dark:text-white/70 dark:ring-white/10 dark:hover:bg-white/20 dark:hover:text-blue-300"
                >
                  <svg class="h-4 w-4" viewBox="0 0 21 21" fill="none">
                    <path
                      fill="currentColor"
                      fill-rule="evenodd"
                      clip-rule="evenodd"
                      d="M17.0911 3.53206C16.2124 2.65338 14.7878 2.65338 13.9091 3.53206L5.6074 11.8337C5.29899 12.1421 5.08687 12.5335 4.99684 12.9603L4.26177 16.445C4.20943 16.6931 4.286 16.9508 4.46529 17.1301C4.64458 17.3094 4.90232 17.3859 5.15042 17.3336L8.63507 16.5985C9.06184 16.5085 9.45324 16.2964 9.76165 15.988L18.0633 7.68631C18.942 6.80763 18.942 5.38301 18.0633 4.50433L17.0911 3.53206ZM14.9697 4.59272C15.2626 4.29982 15.7375 4.29982 16.0304 4.59272L17.0027 5.56499C17.2956 5.85788 17.2956 6.33276 17.0027 6.62565L16.1043 7.52402L14.0714 5.49109L14.9697 4.59272ZM13.0107 6.55175L6.66806 12.8944C6.56526 12.9972 6.49455 13.1277 6.46454 13.2699L5.96704 15.6283L8.32547 15.1308C8.46772 15.1008 8.59819 15.0301 8.70099 14.9273L15.0436 8.58468L13.0107 6.55175Z"
                    />
                  </svg>
                </button>
              </Tooltip>

              <Tooltip :text="t('messages.notAuthorized')" :show="!canDelete">
                <button
                  :disabled="!canDelete"
                  @click.stop="handleDeleteClick(attendance.id)"
                  class="flex h-8 w-8 items-center justify-center rounded-full bg-gray-100 text-gray-500 shadow-theme-xs ring-1 ring-transparent transition hover:bg-white hover:text-error-500 dark:bg-white/10 dark:text-white/70 dark:ring-white/10 dark:hover:bg-white/20 dark:hover:text-error-400"
                >
                  <svg class="h-4 w-4" viewBox="0 0 21 21" fill="none">
                    <path
                      fill="currentColor"
                      fill-rule="evenodd"
                      clip-rule="evenodd"
                      d="M7.04142 4.29199C7.04142 3.04935 8.04878 2.04199 9.29142 2.04199H11.7081C12.9507 2.04199 13.9581 3.04935 13.9581 4.29199V4.54199H16.1252H17.166C17.5802 4.54199 17.916 4.87778 17.916 5.29199C17.916 5.70621 17.5802 6.04199 17.166 6.04199H16.8752V8.74687V13.7469V16.7087C16.8752 17.9513 15.8678 18.9587 14.6252 18.9587H6.37516C5.13252 18.9587 4.12516 17.9513 4.12516 16.7087V13.7469V8.74687V6.04199H3.8335C3.41928 6.04199 3.0835 5.70621 3.0835 5.29199C3.0835 4.87778 3.41928 4.54199 3.8335 4.54199H4.87516H7.04142V4.29199ZM15.3752 13.7469V8.74687V6.04199H13.9581H13.2081H7.79142H7.04142H5.62516V8.74687V13.7469V16.7087C5.62516 17.1229 5.96095 17.4587 6.37516 17.4587H14.6252C15.0394 17.4587 15.3752 17.1229 15.3752 16.7087V13.7469ZM8.8335 4.54199H12.4581V4.29199C12.4581 3.87778 12.1223 3.54199 11.7081 3.54199H9.29142C8.87721 3.54199 8.54142 3.87778 8.54142 4.29199V4.54199ZM8.8335 8.50033C9.24771 8.50033 9.5835 8.83611 9.5835 9.25033V14.2503C9.5835 14.6645 9.24771 15.0003 8.8335 15.0003C8.41928 15.0003 8.0835 14.6645 8.0835 14.2503V9.25033C8.0835 8.83611 8.41928 8.50033 8.8335 8.50033ZM12.9168 9.25033C12.9168 8.83611 12.581 8.50033 12.1668 8.50033C11.7526 8.50033 11.4168 8.83611 11.4168 9.25033V14.2503C11.4168 14.6645 11.7526 15.0003 12.1668 15.0003C12.581 15.0003 12.9168 14.6645 12.9168 14.2503Z"
                    />
                  </svg>
                </button>
              </Tooltip>
            </div>
          </div>
        </div>
      </div>

      <div v-if="paginatedData.length === 0" class="mt-6 rounded-xl border border-dashed border-gray-200 py-12 text-center text-sm text-gray-500 dark:border-gray-700 dark:text-gray-400">
        {{ t('teacher_attendances.noTeacherAttendance') }}
      </div>
    </div>

    <div class="border border-t-0 border-gray-100 rounded-b-xl py-4 pl-[18px] pr-4 dark:border-gray-800">
      <div class="flex flex-col xl:flex-row xl:items-center xl:justify-between">
        <p class="pb-3 text-center text-sm font-medium text-gray-500 dark:text-gray-400 xl:border-b-0 xl:pb-0 xl:text-left">
          {{ t('datatable.showing', { start: startEntry, end: endEntry, total: totalEntries }) }}
        </p>
        <div class="flex items-center justify-center gap-0.5 pt-3 xl:justify-end xl:pt-0">
          <button @click="prevPage" :disabled="currentPage === 1" class="mr-2.5 flex h-10 items-center justify-center rounded-lg border border-gray-300 bg-white px-3.5 py-2.5 text-gray-700 shadow-theme-xs hover:bg-gray-50 disabled:opacity-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03]">
            {{ t('datatable.previous') }}
          </button>
          <button @click="goToPage(1)" :class="currentPage === 1 ? 'bg-blue-500/[0.08] text-brand-500' : 'text-gray-700 dark:text-gray-400'" class="flex h-10 w-10 items-center justify-center rounded-lg text-sm font-medium hover:bg-blue-500/[0.08] hover:text-brand-500 dark:hover:text-brand-500">1</button>
          <span v-if="currentPage > 3" class="flex h-10 w-10 items-center justify-center rounded-lg text-sm font-medium text-gray-700 hover:bg-blue-500/[0.08] hover:text-brand-500 dark:text-gray-400 dark:hover:text-brand-500">...</span>
          <button v-for="page in pagesAroundCurrent" :key="page" @click="goToPage(page)" :class="currentPage === page ? 'bg-blue-500/[0.08] text-brand-500' : 'text-gray-700 dark:text-gray-400'" class="flex h-10 w-10 items-center justify-center rounded-lg text-sm font-medium hover:bg-blue-500/[0.08] hover:text-brand-500 dark:hover:text-brand-500">
            {{ page }}
          </button>
          <span v-if="currentPage < totalPages - 2" class="flex h-10 w-10 items-center justify-center rounded-lg text-sm font-medium text-gray-700 hover:bg-blue-500/[0.08] hover:text-brand-500 dark:text-gray-400 dark:hover:text-brand-500">...</span>
          <button v-if="totalPages > 1" @click="goToPage(totalPages)" :class="currentPage === totalPages ? 'bg-blue-500/[0.08] text-brand-500' : 'text-gray-700 dark:text-gray-400'" class="flex h-10 w-10 items-center justify-center rounded-lg text-sm font-medium hover:bg-blue-500/[0.08] hover:text-brand-500 dark:hover:text-brand-500">
            {{ totalPages }}
          </button>
          <button @click="nextPage" :disabled="currentPage === totalPages" class="ml-2.5 flex h-10 items-center justify-center rounded-lg border border-gray-300 bg-white px-3.5 py-2.5 text-gray-700 shadow-theme-xs hover:bg-gray-50 disabled:opacity-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03]">
            {{ t('datatable.next') }}
          </button>
        </div>
      </div>
    </div>
  </div>

  <DangerAlert
    :isOpen="isDeleteModalOpen"
    :title="t('messages.areYouSure')"
    :message="t('messages.deleteTeacherAttendanceConfirmation')"
    @close="closeDeleteModal"
    @confirm="confirmDelete"
  />
</template>

<script setup>
import { ref, computed, watch, onMounted, onBeforeUnmount } from 'vue'
import { router } from '@inertiajs/vue3'
import { route } from '@/route'
import { useI18n } from 'vue-i18n'
import Tooltip from '@/components/ui/Tooltip.vue'
import DangerAlert from '@/components/modals/DangerAlert.vue'
import { usePermissions } from '@/composables/usePermissions'
import { useNotifications } from '@/composables/useNotifications'
import { Calendar2Line } from '@/icons'
import dayjs from 'dayjs'

const { hasAnyPermission } = usePermissions()
const { t, locale } = useI18n()
const { success, error } = useNotifications()

const canCreate = computed(() => hasAnyPermission(['teacher_attendances.create', 'teacher_attendances.store']))
const canView = computed(() => hasAnyPermission(['teacher_attendances.view', 'teacher_attendances.show']))
const canEdit = computed(() => hasAnyPermission(['teacher_attendances.update', 'teacher_attendances.edit']))
const canDelete = computed(() => hasAnyPermission(['teacher_attendances.delete', 'teacher_attendances.destroy']))

const props = defineProps({
  teacherAttendances: { type: Object, required: true },
  filters: { type: Object, default: () => ({}) },
})

const search = ref(props.filters?.search || '')
const currentPage = ref(props.teacherAttendances?.current_page ?? 1)
const perPage = ref(props.teacherAttendances?.per_page ?? 10)
const selectAll = ref(false)
const today = dayjs()

const parseDateSafe = (value) => {
  if (!value) return null
  const parsed = dayjs(value)
  return parsed.isValid() ? parsed : null
}

const selectedDateFromFilters = parseDateSafe(props.filters?.selected_date)
const monthFromFilters = parseDateSafe(props.filters?.month ? `${props.filters.month}-01` : null)
const initialSelectedDate = selectedDateFromFilters || today
const initialMonth = monthFromFilters || initialSelectedDate

const calendarMonth = ref(initialMonth.startOf('month'))
const selectedDay = ref(Math.min(initialSelectedDate.date(), calendarMonth.value.daysInMonth()))
const showMonthPicker = ref(false)
const monthPickerContainer = ref(null)
const pickerMonth = ref(calendarMonth.value.month())
const pickerYear = ref(calendarMonth.value.year())
const localeCode = computed(() => (locale.value === 'ar' ? 'ar-SA' : 'en-US'))
const monthLabel = computed(() => new Intl.DateTimeFormat(localeCode.value, { month: 'long', year: 'numeric' }).format(calendarMonth.value.toDate()))
const monthDays = computed(() => {
  const formatter = new Intl.DateTimeFormat(localeCode.value, { weekday: 'short' })
  const daysInMonth = calendarMonth.value.daysInMonth()
  return Array.from({ length: daysInMonth }, (_, index) => {
    const date = calendarMonth.value.date(index + 1)
    return {
      key: date.format('YYYY-MM-DD'),
      dayNumber: index + 1,
      dayName: formatter.format(date.toDate()),
    }
  })
})
const selectedDate = computed(() => {
  const safeDay = Math.min(selectedDay.value, calendarMonth.value.daysInMonth())
  return calendarMonth.value.date(safeDay)
})
const selectedDateKey = computed(() => selectedDate.value.format('YYYY-MM-DD'))
const monthOptions = computed(() => {
  const formatter = new Intl.DateTimeFormat(localeCode.value, { month: 'long' })
  return Array.from({ length: 12 }, (_, idx) => {
    const date = dayjs().month(idx).date(1)
    return { value: idx, label: formatter.format(date.toDate()) }
  })
})
const yearOptions = computed(() => {
  const baseYear = today.year()
  return Array.from({ length: 11 }, (_, idx) => baseYear - 5 + idx)
})
const translateWithFallback = (key, fallbackEn, fallbackAr) => {
  const translated = t(key)
  if (!translated || translated === key) {
    return locale.value === 'ar' ? fallbackAr : fallbackEn
  }
  return translated
}
const monthSelectLabel = computed(() => translateWithFallback('common.month', 'Month', 'الشهر'))
const yearSelectLabel = computed(() => translateWithFallback('common.year', 'Year', 'السنة'))
const cancelLabel = computed(() => translateWithFallback('common.cancel', 'Cancel', 'إلغاء'))
const applyLabel = computed(() => translateWithFallback('common.apply', 'Apply', 'تطبيق'))

const resetSelections = () => {
  selectAll.value = false
  ;(props.teacherAttendances?.data || []).forEach((item) => {
    item.selected = false
  })
}

const updateCalendarMonth = (target) => {
  calendarMonth.value = target.startOf('month')
  selectedDay.value = Math.min(selectedDay.value, calendarMonth.value.daysInMonth())
  resetSelections()
  fetchPage(1)
}
const goToPreviousMonth = () => {
  updateCalendarMonth(calendarMonth.value.subtract(1, 'month'))
}
const goToNextMonth = () => {
  updateCalendarMonth(calendarMonth.value.add(1, 'month'))
}
const toggleMonthPicker = () => {
  if (showMonthPicker.value) {
    showMonthPicker.value = false
    return
  }
  pickerMonth.value = calendarMonth.value.month()
  pickerYear.value = calendarMonth.value.year()
  showMonthPicker.value = true
}
const cancelMonthPicker = () => {
  showMonthPicker.value = false
}
const applyMonthPicker = () => {
  const target = dayjs().year(pickerYear.value).month(pickerMonth.value).date(1)
  updateCalendarMonth(target)
  showMonthPicker.value = false
}
const handleGlobalClick = (event) => {
  if (!showMonthPicker.value) return
  const container = monthPickerContainer.value
  if (!container) return
  if (!container.contains(event.target)) {
    showMonthPicker.value = false
  }
}
const selectDay = (day) => {
  if (selectedDay.value === day.dayNumber) return
  selectedDay.value = day.dayNumber
  resetSelections()
  fetchPage(1)
}

function goToCreate() {
  router.visit(route('admin.teacher_attendances.create'))
}
function goToView(id) {
  router.visit(route('admin.teacher_attendances.show', id))
}
function goToEdit(id) {
  router.visit(route('admin.teacher_attendances.edit', id))
}

function handleCreateClick() {
  if (!canCreate.value) return
  goToCreate()
}
function handleViewClick(id) {
  if (!canView.value) return
  goToView(id)
}
function handleEditClick(id) {
  if (!canEdit.value) return
  goToEdit(id)
}

const isDeleteModalOpen = ref(false)
const attendanceToDeleteId = ref(null)

function handleDeleteClick(id) {
  if (!canDelete.value) return
  attendanceToDeleteId.value = id
  isDeleteModalOpen.value = true
}
function closeDeleteModal() {
  isDeleteModalOpen.value = false
  attendanceToDeleteId.value = null
}
function confirmDelete() {
  if (!attendanceToDeleteId.value) return
  router.delete(route('admin.teacher_attendances.destroy', attendanceToDeleteId.value), {
    onSuccess: () => {
      success(t('teacher_attendances.teacherAttendanceDeletedSuccessfully'))
      closeDeleteModal()
    },
    onError: () => {
      error(t('teacher_attendances.teacherAttendanceDeletionFailed'))
      closeDeleteModal()
    },
    preserveScroll: true,
  })
}

const statusKeys = ['present', 'absent', 'excused', 'late_in', 'early_out', 'half_day', 'on_leave', 'sick']
const statusLabel = (status) => {
  if (!status || !statusKeys.includes(status)) return '—'
  return t(`teacher_attendances.statusLabels.${status}`)
}
const statusBadgeClass = (status) => {
  switch (status) {
    case 'present':
      return 'bg-green-50 text-green-600 dark:bg-green-500/15 dark:text-green-500'
    case 'absent':
      return 'bg-error-50 text-error-600 dark:bg-error-500/15 dark:text-error-500'
    case 'excused':
      return 'bg-blue-50 text-blue-600 dark:bg-blue-500/15 dark:text-blue-300'
    case 'late_in':
    case 'early_out':
      return 'bg-yellow-50 text-yellow-600 dark:bg-yellow-500/15 dark:text-yellow-400'
    case 'half_day':
      return 'bg-indigo-50 text-indigo-600 dark:bg-indigo-500/15 dark:text-indigo-400'
    case 'on_leave':
      return 'bg-purple-50 text-purple-600 dark:bg-purple-500/15 dark:text-purple-400'
    case 'sick':
      return 'bg-amber-50 text-amber-600 dark:bg-amber-500/15 dark:text-amber-400'
    default:
      return 'bg-gray-100 text-gray-600 dark:bg-white/10 dark:text-gray-300'
  }
}

const filteredData = computed(() => {
  const searchLower = (search.value || '').toLowerCase()
  const dateKey = selectedDateKey.value
  return (props.teacherAttendances?.data || [])
    .filter((item) => {
      const teacher = item.user_name?.toLowerCase() || ''
      const circle = item.circle_name?.toLowerCase() || ''
      const status = item.status?.toLowerCase() || ''
      return teacher.includes(searchLower) || circle.includes(searchLower) || status.includes(searchLower)
    })
    .filter((item) => {
      if (!dateKey) return true
      const itemDate = item.date_g ? dayjs(item.date_g).format('YYYY-MM-DD') : ''
      return itemDate === dateKey
    })
})

const paginatedData = computed(() => filteredData.value)

const totalEntries = computed(() => props.teacherAttendances?.total || filteredData.value.length)
const startEntry = computed(() => props.teacherAttendances?.from || 1)
const endEntry = computed(() => props.teacherAttendances?.to || filteredData.value.length)
const totalPages = computed(() => props.teacherAttendances?.last_page || 1)

const pagesAroundCurrent = computed(() => {
  const pages = []
  const start = Math.max(2, currentPage.value - 2)
  const end = Math.min(totalPages.value - 1, currentPage.value + 2)
  for (let i = start; i <= end; i += 1) pages.push(i)
  return pages
})

let searchDebounceId = null

watch(() => props.teacherAttendances?.current_page, (val) => {
  currentPage.value = typeof val === 'number' ? val : 1
})
watch(() => props.teacherAttendances?.per_page, (val) => {
  if (typeof val === 'number') perPage.value = val
})

watch(search, (val, oldVal) => {
  if (val === oldVal) return
  if (searchDebounceId) clearTimeout(searchDebounceId)
  searchDebounceId = setTimeout(() => {
    fetchPage(1)
    searchDebounceId = null
  }, 300)
})

const fetchPage = (page) => {
  const target = page ?? currentPage.value
  router.get(
    window.location.pathname,
    {
      page: target,
      per_page: perPage.value,
      search: search.value || undefined,
      selected_date: selectedDateKey.value,
      month: calendarMonth.value.format('YYYY-MM'),
    },
    { preserveState: true, preserveScroll: true, replace: true }
  )
}

const goToPage = (page) => {
  if (page >= 1 && page <= totalPages.value) fetchPage(page)
}
const nextPage = () => {
  if (currentPage.value < totalPages.value) fetchPage(currentPage.value + 1)
}
const prevPage = () => {
  if (currentPage.value > 1) fetchPage(currentPage.value - 1)
}

const toggleSelectAll = () => {
  filteredData.value.forEach((item) => {
    item.selected = selectAll.value
  })
}
const updateSelectAll = () => {
  const items = filteredData.value
  selectAll.value = items.length > 0 && items.every((item) => item.selected)
}

watch(perPage, (val, oldVal) => {
  if (val !== oldVal) fetchPage(1)
})

onMounted(() => {
  document.addEventListener('click', handleGlobalClick)
})

onBeforeUnmount(() => {
  document.removeEventListener('click', handleGlobalClick)
  if (searchDebounceId) clearTimeout(searchDebounceId)
})
</script>
