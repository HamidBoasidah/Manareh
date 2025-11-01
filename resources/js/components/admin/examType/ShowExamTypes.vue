<template>
  <div class="overflow-hidden">
    <div
      class="flex flex-col gap-2 px-4 py-4 border border-b-0 border-gray-200 rounded-b-none rounded-xl dark:border-gray-800 sm:flex-row sm:items-center sm:justify-between"
    >
      <div class="flex items-center gap-3">
        <span class="text-gray-500 dark:text-gray-400">{{ t('datatable.show') }}</span>
        <div class="relative z-20 bg-transparent">
          <select
            v-model="perPage"
            class="w-full py-2 pl-3 pr-8 text-sm text-gray-800 bg-transparent border border-gray-300 rounded-lg appearance-none dark:bg-dark-900 h-9 bg-none shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800"
            :class="{ 'text-gray-500 dark:text-gray-400': perPage !== '' }"
          >
            <option value="10" class="text-gray-500 dark:bg-gray-900 dark:text-gray-400">10</option>
            <option value="25" class="text-gray-500 dark:bg-gray-900 dark:text-gray-400">25</option>
            <option value="50" class="text-gray-500 dark:bg-gray-900 dark:text-gray-400">50</option>
          </select>
          <span
            class="absolute z-30 text-gray-500 -translate-y-1/2 pointer-events-none right-2 top-1/2 dark:text-gray-400"
          >
            <svg class="stroke-current" width="16" height="16" viewBox="0 0 16 16" fill="none">
              <path d="M3.8335 5.9165L8.00016 10.0832L12.1668 5.9165" stroke="" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </span>
        </div>
        <span class="text-gray-500 dark:text-gray-400">{{ t('datatable.entries') }}</span>
      </div>

      <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
        <div class="relative">
          <button class="absolute text-gray-500 -translate-y-1/2 left-4 top-1/2 dark:text-gray-400">
            <svg class="fill-current" width="20" height="20" viewBox="0 0 20 20" fill="none">
              <path fill-rule="evenodd" clip-rule="evenodd" d="M3.04199 9.37363C3.04199 5.87693 5.87735 3.04199 9.37533 3.04199C12.8733 3.04199 15.7087 5.87693 15.7087 9.37363C15.7087 12.8703 12.8733 15.7053 9.37533 15.7053C5.87735 15.7053 3.04199 12.8703 3.04199 9.37363ZM9.37533 1.54199C5.04926 1.54199 1.54199 5.04817 1.54199 9.37363C1.54199 13.6991 5.04926 17.2053 9.37533 17.2053C11.2676 17.2053 13.0032 16.5344 14.3572 15.4176L17.1773 18.238C17.4702 18.5309 17.945 18.5309 18.2379 18.238C18.5308 17.9451 18.5309 17.4703 18.238 17.1773L15.4182 14.3573C16.5367 13.0033 17.2087 11.2669 17.2087 9.37363C17.2087 5.04817 13.7014 1.54199 9.37533 1.54199Z" fill=""/>
            </svg>
          </button>
          <input
            v-model="search"
            type="text"
            :placeholder="t('datatable.searchPlaceholder')"
            class="dark:bg-dark-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent py-2.5 pl-11 pr-4 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800 xl:w-[300px]"
          />
        </div>

        <Tooltip :text="t('messages.notAuthorized')" :show="!canCreate">
          <button
            :disabled="!canCreate"
            @click="handleCreateClick"
            class="bg-brand-500 shadow-theme-xs hover:bg-brand-600 inline-flex items-center justify-center gap-2 rounded-lg px-4 py-[11px] text-sm font-medium text-white transition sm:w-auto disabled:bg-brand-300 disabled:hover:bg-brand-300 disabled:text-white/70"
          >
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none">
              <path d="M5 10.0002H15.0006M10.0002 5V15.0006" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            {{ t('exam_types.addExamType') }}
          </button>
        </Tooltip>
      </div>
    </div>

    <div class="max-w-full overflow-x-auto">
      <table class="w-full min-w-full">
        <thead>
          <tr>
            <th class="px-4 py-3 text-start border border-gray-100 dark:border-gray-800 w-12">
              <label class="flex items-center text-sm font-medium text-gray-700 cursor-pointer select-none dark:text-gray-400">
                <span class="relative">
                  <input type="checkbox" class="sr-only" v-model="selectAll" @change="toggleSelectAll" />
                  <span
                    :class="selectAll ? 'border-brand-500 bg-brand-500' : 'bg-transparent border-gray-300 dark:border-gray-700'"
                    class="flex h-4 w-4 items-center justify-center rounded-sm border-[1.25px]"
                  >
                    <span :class="selectAll ? '' : 'opacity-0'">
                      <svg width="12" height="12" viewBox="0 0 12 12" fill="none">
                        <path d="M10 3L4.5 8.5L2 6" stroke="white" stroke-width="1.6666" stroke-linecap="round" stroke-linejoin="round"/>
                      </svg>
                    </span>
                  </span>
                </span>
              </label>
            </th>

            <th class="px-4 py-3 text-start border border-gray-100 dark:border-gray-800">
              <div class="flex items-center justify-between w-full cursor-pointer" @click="sortBy('name')">
                <p class="font-medium text-gray-700 text-theme-xs dark:text-gray-400">{{ t('exam_types.name') }}</p>
                <span class="flex flex-col gap-0.5">
                  <svg class="fill-gray-300 dark:fill-gray-700" width="8" height="5" viewBox="0 0 8 5" fill="none"><path d="M4.40962 0.585167C4.21057 0.300808 3.78943 0.300807 3.59038 0.585166L1.05071 4.21327C0.81874 4.54466 1.05582 5 1.46033 5H6.53967C6.94418 5 7.18126 4.54466 6.94929 4.21327L4.40962 0.585167Z"/></svg>
                  <svg class="fill-gray-300 dark:fill-gray-700" width="8" height="5" viewBox="0 0 8 5" fill="none"><path d="M4.40962 4.41483C4.21057 4.69919 3.78943 4.69919 3.59038 4.41483L1.05071 0.786732C0.81874 0.455343 1.05582 0 1.46033 0H6.53967C6.94418 0 7.18126 0.455342 6.94929 0.786731L4.40962 4.41483Z"/></svg>
                </span>
              </div>
            </th>

            <th class="px-4 py-3 text-start border border-gray-100 dark:border-gray-800">
              <div class="flex items-center justify-between w-full cursor-pointer" @click="sortBy('mosque_name_ar')">
                <p class="font-medium text-gray-700 text-theme-xs dark:text-gray-400">{{ t('mosques.mosque') }}</p>
                <span class="flex flex-col gap-0.5">
                  <svg class="fill-gray-300 dark:fill-gray-700" width="8" height="5" viewBox="0 0 8 5" fill="none"><path d="M4.40962 0.585167C4.21057 0.300808 3.78943 0.300807 3.59038 0.585166L1.05071 4.21327C0.81874 4.54466 1.05582 5 1.46033 5H6.53967C6.94418 5 7.18126 4.54466 6.94929 4.21327L4.40962 0.585167Z"/></svg>
                  <svg class="fill-gray-300 dark:fill-gray-700" width="8" height="5" viewBox="0 0 8 5" fill="none"><path d="M4.40962 4.41483C4.21057 4.69919 3.78943 4.69919 3.59038 4.41483L1.05071 0.786732C0.81874 0.455343 1.05582 0 1.46033 0H6.53967C6.94418 0 7.18126 0.455342 6.94929 0.786731L4.40962 4.41483Z"/></svg>
                </span>
              </div>
            </th>

            <th class="px-4 py-3 text-start border border-gray-100 dark:border-gray-800">
              <div class="flex items-center justify-between w-full cursor-pointer" @click="sortBy('is_active')">
                <p class="font-medium text-gray-700 text-theme-xs dark:text-gray-400">{{ t('common.status') }}</p>
                <span class="flex flex-col gap-0.5">
                  <svg class="fill-gray-300 dark:fill-gray-700" width="8" height="5" viewBox="0 0 8 5" fill="none"><path d="M4.40962 0.585167C4.21057 0.300808 3.78943 0.300807 3.59038 0.585166L1.05071 4.21327C0.81874 4.54466 1.05582 5 1.46033 5H6.53967C6.94418 5 7.18126 4.54466 6.94929 4.21327L4.40962 0.585167Z"/></svg>
                  <svg class="fill-gray-300 dark:fill-gray-700" width="8" height="5" viewBox="0 0 8 5" fill="none"><path d="M4.40962 4.41483C4.21057 4.69919 3.78943 4.69919 3.59038 4.41483L1.05071 0.786732C0.81874 0.455343 1.05582 0 1.46033 0H6.53967C6.94418 0 7.18126 0.455342 6.94929 0.786731L4.40962 4.41483Z"/></svg>
                </span>
              </div>
            </th>

            <th class="px-4 py-3 text-start border border-gray-100 dark:border-gray-800">
              <p class="font-medium text-gray-700 text-theme-xs dark:text-gray-400">{{ t('common.toggle') }}</p>
            </th>

            <th class="px-4 py-3 text-start border border-gray-100 dark:border-gray-800">
              <p class="font-medium text-gray-700 text-theme-xs dark:text-gray-400">{{ t('common.action') }}</p>
            </th>
          </tr>
        </thead>

        <tbody>
          <tr
            v-for="type in paginatedData"
            :key="type.id"
            :class="{ 'bg-gray-50 dark:bg-gray-900': type.selected }"
          >
            <td class="px-4 py-3 border border-gray-100 dark:border-gray-800">
              <label class="flex items-center text-sm font-medium text-gray-700 cursor-pointer select-none dark:text-gray-400">
                <span class="relative">
                  <input type="checkbox" class="sr-only" v-model="type.selected" @change="updateSelectAll" />
                  <span
                    :class="type.selected ? 'border-brand-500 bg-brand-500' : 'bg-transparent border-gray-300 dark:border-gray-700'"
                    class="flex h-4 w-4 items-center justify-center rounded-sm border-[1.25px]"
                  >
                    <span :class="type.selected ? '' : 'opacity-0'">
                      <svg width="12" height="12" viewBox="0 0 12 12" fill="none">
                        <path d="M10 3L4.5 8.5L2 6" stroke="white" stroke-width="1.6666" stroke-linecap="round" stroke-linejoin="round"/>
                      </svg>
                    </span>
                  </span>
                </span>
              </label>
            </td>

            <td class="px-4 py-3 border border-gray-100 dark:border-gray-800">
              <p class="text-gray-700 text-theme-sm dark:text-gray-400">{{ type.name }}</p>
            </td>

            <td class="px-4 py-3 border border-gray-100 dark:border-gray-800">
              <p class="text-gray-700 text-theme-sm dark:text-gray-400">
                {{
                  locale === 'ar'
                    ? type.mosque?.name_ar ?? type.mosque_name_ar ?? '—'
                    : type.mosque?.name_en ?? type.mosque_name_en ?? '—'
                }}
              </p>
            </td>

            <td class="px-4 py-3 border border-gray-100 dark:border-gray-800">
              <span
                class="inline-flex items-center justify-center gap-1 rounded-full px-2.5 py-0.5 text-xs font-medium"
                :class="{
                  'bg-green-50 text-green-600 dark:bg-green-500/15 dark:text-green-500': type.is_active,
                  'bg-error-50 text-error-600 dark:bg-error-500/15 dark:text-error-500': !type.is_active,
                }"
              >
                {{ type.is_active ? t('common.active') : t('common.inactive') }}
              </span>
            </td>

            <td class="px-4 py-3 border border-gray-100 dark:border-gray-800">
              <label :for="'toggle-' + type.id" class="cursor-pointer">
                <div class="relative">
                  <input
                    type="checkbox"
                    :id="'toggle-' + type.id"
                    class="sr-only"
                    :checked="type.is_active"
                    @change="toggleExamTypeStatus(type)"
                  />
                  <div class="block h-5 w-9 rounded-full" :class="type.is_active ? 'bg-brand-500 dark:bg-brand-500' : 'bg-gray-200 dark:bg-white/10'"></div>
                  <div :class="[type.is_active ? 'rtl:translate-x-[-100%] ltr:translate-x-full' : 'translate-x-0']" class="shadow-theme-sm absolute top-0.5 h-4 w-4 rounded-full bg-white duration-200 ease-linear rtl:right-0.5 ltr:left-0.5"></div>
                </div>
              </label>
            </td>

            <td class="px-4 py-3 border border-gray-100 dark:border-gray-800">
              <div class="flex items-center w-full gap-2">
                <Tooltip :text="t('messages.notAuthorized')" :show="!canView">
                  <button
                    :disabled="!canView"
                    @click="handleViewClick(type.id)"
                    class="text-gray-500 hover:text-gray-800 dark:text-gray-400 dark:hover:text-white/90 disabled:text-gray-400 disabled:dark:text-gray-500"
                  >
                    <svg class="fill-current" width="21" height="20" viewBox="0 0 21 20" fill="none">
                      <path fill-rule="evenodd" clip-rule="evenodd" d="M10.5 13.8619C7.73348 13.8619 5.3679 12.1372 4.42315 9.70241C5.3679 7.26761 7.73348 5.54297 10.5 5.54297C13.2665 5.54297 15.6321 7.26762 16.5769 9.70243C15.6321 12.1372 13.2665 13.8619 10.5 13.8619ZM10.5 4.04297C6.98174 4.04297 3.99472 6.30917 2.91533 9.4593C2.86134 9.61687 2.86134 9.78794 2.91533 9.94552C3.99472 13.0957 6.98174 15.3619 10.5 15.3619C14.0183 15.3619 17.0053 13.0957 18.0846 9.94555C18.1387 9.78797 18.1387 9.6169 18.0846 9.45932C17.0053 6.30919 14.0183 4.04297 10.5 4.04297ZM10.4913 7.84413C9.46496 7.84413 8.63303 8.67606 8.63303 9.70231C8.63303 10.7286 9.46496 11.5605 10.4913 11.5605H10.5061C11.5323 11.5605 12.3643 10.7286 12.3643 9.70231C12.3643 8.67606 11.5323 7.84413 10.5061 7.84413H10.4913Z" />
                    </svg>
                  </button>
                </Tooltip>

                <Tooltip :text="t('messages.notAuthorized')" :show="!canEdit">
                  <button
                    :disabled="!canEdit"
                    @click="handleEditClick(type.id)"
                    class="text-gray-500 hover:text-blue-500 dark:text-gray-400 dark:hover:text-blue-300 disabled:text-gray-400 disabled:dark:text-gray-500"
                  >
                    <svg class="fill-current" width="21" height="21" viewBox="0 0 21 21" fill="none">
                      <path fill-rule="evenodd" clip-rule="evenodd" d="M16.7161 3.53206C15.8374 2.65338 14.4128 2.65338 13.5341 3.53206L5.23244 11.8337C4.92402 12.1421 4.71191 12.5335 4.62188 12.9603L3.88681 16.445C3.83447 16.6931 3.91104 16.9508 4.09033 17.1301C4.26962 17.3094 4.52736 17.3859 4.77546 17.3336L8.26011 16.5985C8.68688 16.5085 9.07828 16.2964 9.38669 15.988L17.6884 7.68631C18.567 6.80763 18.567 5.38301 17.6884 4.50433L16.7161 3.53206ZM14.5947 4.59272C14.8876 4.29982 15.3625 4.29982 15.6554 4.59272L16.6277 5.56499C16.9206 5.85788 16.9206 6.33276 16.6277 6.62565L15.7293 7.52402L13.6964 5.49109L14.5947 4.59272ZM12.6357 6.55175L6.29304 12.8944C6.19024 12.9972 6.11953 13.1277 6.08952 13.2699L5.59202 15.6283L7.95045 15.1308C8.0927 15.1008 8.22317 15.0301 8.32597 14.9273L14.6686 8.58468L12.6357 6.55175Z" />
                    </svg>
                  </button>
                </Tooltip>

                <Tooltip :text="t('messages.notAuthorized')" :show="!canDelete">
                  <button
                    :disabled="!canDelete"
                    @click="handleDeleteClick(type.id)"
                    class="text-gray-500 hover:text-error-500 dark:text-gray-400 dark:hover:text-error-500 disabled:text-gray-400 disabled:dark:text-gray-500"
                  >
                    <svg class="fill-current" width="21" height="21" viewBox="0 0 21 21" fill="none">
                      <path fill-rule="evenodd" clip-rule="evenodd" d="M6.66636 4.29199C6.66636 3.04935 7.67372 2.04199 8.91636 2.04199H11.333C12.5757 2.04199 13.583 3.04935 13.583 4.29199V4.54199H15.7502H16.7909C17.2052 4.54199 17.5409 4.87778 17.5409 5.29199C17.5409 5.70621 17.2052 6.04199 16.7909 6.04199H16.5002V8.74687V13.7469V16.7087C16.5002 17.9513 15.4928 18.9587 14.2502 18.9587H6.00019C4.75755 18.9587 3.75019 17.9513 3.75019 16.7087V13.7469V8.74687V6.04199H3.45853C3.04431 6.04199 2.70853 5.70621 2.70853 5.29199C2.70853 4.87778 3.04431 4.54199 3.45853 4.54199H4.50019H6.66636V4.29199ZM15.0002 13.7469V8.74687V6.04199H13.583H12.833H7.41636H6.66636H5.25019V8.74687V13.7469V16.7087C5.25019 17.1229 5.58598 17.4587 6.00019 17.4587H14.2502C14.6644 17.4587 15.0002 17.1229 15.0002 16.7087V13.7469ZM8.45853 4.54199H12.083V4.29199C12.083 3.87778 11.7472 3.54199 11.333 3.54199H8.91636C8.50215 3.54199 8.16636 3.87778 8.16636 4.29199V4.54199ZM8.45853 8.50033C8.87274 8.50033 9.20853 8.83611 9.20853 9.25033V14.2503C9.20853 14.6645 8.87274 15.0003 8.45853 15.0003C8.04431 15.0003 7.70853 14.6645 7.70853 14.2503V9.25033C7.70853 8.83611 8.04431 8.50033 8.45853 8.50033ZM12.5417 9.25033C12.5417 8.83611 12.206 8.50033 11.7917 8.50033C11.3775 8.50033 11.0417 8.83611 11.0417 9.25033V14.2503C11.0417 14.6645 11.3775 15.0003 11.7917 15.0003C12.206 15.0003 12.5417 14.6645 12.5417 14.2503V9.25033Z" />
                    </svg>
                  </button>
                </Tooltip>
              </div>
            </td>
          </tr>

          <tr v-if="paginatedData.length === 0">
            <td colspan="7" class="px-4 py-6 text-center text-sm text-gray-500 dark:text-gray-400">
              {{ t('exam_types.noExamType') }}
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="border border-t-0 rounded-b-xl border-gray-100 py-4 pl-[18px] pr-4 dark:border-gray-800">
      <div class="flex flex-col xl:flex-row xl:items-center xl:justify-between">
        <p class="pb-3 text-sm font-medium text-center text-gray-500 border-b border-gray-100 dark:border-gray-800 dark:text-gray-400 xl:border-b-0 xl:pb-0 xl:text-left">
          {{ t('datatable.showing', { start: startEntry, end: endEntry, total: totalEntries }) }}
        </p>
        <div class="flex items-center justify-center gap-0.5 pt-3 xl:justify-end xl:pt-0">
          <button @click="prevPage" :disabled="currentPage === 1" class="mr-2.5 flex items-center h-10 justify-center rounded-lg border border-gray-300 bg-white px-3.5 py-2.5 text-gray-700 shadow-theme-xs hover:bg-gray-50 disabled:opacity-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03]">
            {{ t('datatable.previous') }}
          </button>
          <button @click="goToPage(1)" :class="currentPage === 1 ? 'bg-blue-500/[0.08] text-brand-500' : 'text-gray-700 dark:text-gray-400'" class="flex h-10 w-10 items-center justify-center rounded-lg text-sm font-medium hover:bg-blue-500/[0.08] hover:text-brand-500 dark:hover:text-brand-500">1</button>
          <span v-if="currentPage > 3" class="flex h-10 w-10 items-center justify-center rounded-lg hover:bg-blue-500/[0.08] hover:text-brand-500 dark:hover:text-brand-500">...</span>
          <button v-for="page in pagesAroundCurrent" :key="page" @click="goToPage(page)" :class="currentPage === page ? 'bg-blue-500/[0.08] text-brand-500' : 'text-gray-700 dark:text-gray-400'" class="flex h-10 w-10 items-center justify-center rounded-lg text-sm font-medium hover:bg-blue-500/[0.08] hover:text-brand-500 dark:hover:text-brand-500">
            {{ page }}
          </button>
          <span v-if="currentPage < totalPages - 2" class="flex h-10 w-10 items-center justify-center rounded-lg text-sm font-medium text-gray-700 hover:bg-blue-500/[0.08] hover:text-brand-500 dark:text-gray-400 dark:hover:text-brand-500">...</span>
          <button v-if="totalPages > 1" @click="goToPage(totalPages)" :class="currentPage === totalPages ? 'bg-blue-500/[0.08] text-brand-500' : 'text-gray-700 dark:text-gray-400'" class="flex h-10 w-10 items-center justify-center rounded-lg text-sm font-medium hover:bg-blue-500/[0.08] hover:text-brand-500 dark:hover:text-brand-500">
            {{ totalPages }}
          </button>
          <button @click="nextPage" :disabled="currentPage === totalPages" class="ml-2.5 flex items-center h-10 justify-center rounded-lg border border-gray-300 bg-white px-3.5 py-2.5 text-gray-700 shadow-theme-xs hover:bg-gray-50 disabled:opacity-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03]">
            {{ t('datatable.next') }}
          </button>
        </div>
      </div>
    </div>
  </div>

  <DangerAlert
    :isOpen="isDeleteModalOpen"
    :title="t('messages.areYouSure')"
    :message="t('exam_types.deleteExamTypeConfirmation')"
    @close="closeDeleteModal"
    @confirm="confirmDelete"
  />
</template>

<script setup>
import { computed, ref, watch } from 'vue'
import { router } from '@inertiajs/vue3'
import { route } from '@/route'
import { useI18n } from 'vue-i18n'
import Tooltip from '@/components/ui/Tooltip.vue'
import DangerAlert from '@/components/modals/DangerAlert.vue'
import { usePermissions } from '@/composables/usePermissions'
import { useNotifications } from '@/composables/useNotifications'

const { hasAnyPermission } = usePermissions()
const { t, locale } = useI18n()
const { success, error } = useNotifications()

const canCreate = computed(() => hasAnyPermission(['exam_types.create', 'exam_types.store', 'exam_types.add']))
const canView = computed(() => hasAnyPermission(['exam_types.view', 'exam_types.show', 'exam_types.read']))
const canEdit = computed(() => hasAnyPermission(['exam_types.update', 'exam_types.edit']))
const canDelete = computed(() => hasAnyPermission(['exam_types.delete', 'exam_types.destroy']))

const props = defineProps({
  examTypes: {
    type: Object,
    required: true,
  },
})

const search = ref('')
const sortColumn = ref('name')
const sortDirection = ref('asc')
const currentPage = ref(props.examTypes?.current_page ?? 1)
const perPage = ref(props.examTypes?.per_page ?? 10)
const selectAll = ref(false)

const isDeleteModalOpen = ref(false)
const examTypeToDeleteId = ref(null)

function handleCreateClick() {
  if (!canCreate.value) return
  router.visit(route('admin.exam_types.create'))
}

function handleViewClick(id) {
  if (!canView.value) return
  router.visit(route('admin.exam_types.show', id))
}

function handleEditClick(id) {
  if (!canEdit.value) return
  router.visit(route('admin.exam_types.edit', id))
}

function handleDeleteClick(id) {
  if (!canDelete.value) return
  examTypeToDeleteId.value = id
  isDeleteModalOpen.value = true
}

function closeDeleteModal() {
  isDeleteModalOpen.value = false
  examTypeToDeleteId.value = null
}

function confirmDelete() {
  if (!examTypeToDeleteId.value) return

  router.delete(route('admin.exam_types.destroy', examTypeToDeleteId.value), {
    onSuccess: () => {
      success(t('exam_types.examTypeDeletedSuccessfully'))
      closeDeleteModal()
    },
    onError: () => {
      error(t('exam_types.examTypeDeletionFailed'))
      closeDeleteModal()
    },
    preserveScroll: true,
  })
}

function toggleExamTypeStatus(type) {
  const wasActive = type.is_active
  type.is_active = !wasActive

  const url = wasActive
    ? route('admin.exam_types.deactivate', { id: type.id })
    : route('admin.exam_types.activate', { id: type.id })

  router.patch(url, {}, {
    preserveState: true,
    preserveScroll: true,
    onError: () => {
      type.is_active = wasActive
    },
  })
}

const filteredData = computed(() => {
  const searchLower = (search.value || '').toLowerCase()

  return (props.examTypes?.data || [])
    .filter((item) => {
      const name = item.name?.toLowerCase() || ''
      const mosqueAr = (item.mosque?.name_ar || item.mosque_name_ar || '').toLowerCase()
      const mosqueEn = (item.mosque?.name_en || item.mosque_name_en || '').toLowerCase()
      return (
        name.includes(searchLower) ||
        mosqueAr.includes(searchLower) ||
        mosqueEn.includes(searchLower)
      )
    })
    .sort((a, b) => {
      const modifier = sortDirection.value === 'asc' ? 1 : -1
      const valueA = (a?.[sortColumn.value] ?? '').toString().toLowerCase()
      const valueB = (b?.[sortColumn.value] ?? '').toString().toLowerCase()
      if (valueA < valueB) return -1 * modifier
      if (valueA > valueB) return 1 * modifier
      return 0
    })
})

const paginatedData = computed(() => filteredData.value)

const totalEntries = computed(() => props.examTypes?.total || filteredData.value.length)
const startEntry = computed(() => props.examTypes?.from || 1)
const endEntry = computed(() => props.examTypes?.to || filteredData.value.length)
const totalPages = computed(() => props.examTypes?.last_page || 1)

const pagesAroundCurrent = computed(() => {
  const pages = []
  const start = Math.max(2, currentPage.value - 2)
  const end = Math.min(totalPages.value - 1, currentPage.value + 2)
  for (let i = start; i <= end; i += 1) pages.push(i)
  return pages
})

watch(() => props.examTypes?.current_page, (val) => {
  currentPage.value = typeof val === 'number' ? val : 1
})

watch(() => props.examTypes?.per_page, (val) => {
  if (typeof val === 'number') perPage.value = val
})

const fetchPage = (page) => {
  const targetPage = page ?? currentPage.value
  router.get(
    window.location.pathname,
    {
      page: targetPage,
      per_page: perPage.value,
      search: search.value || undefined,
      sort: sortColumn.value,
      direction: sortDirection.value,
    },
    { preserveState: true, preserveScroll: true, replace: true },
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

const sortBy = (column) => {
  if (sortColumn.value === column) {
    sortDirection.value = sortDirection.value === 'asc' ? 'desc' : 'asc'
  } else {
    sortColumn.value = column
    sortDirection.value = 'asc'
  }
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

</script>
