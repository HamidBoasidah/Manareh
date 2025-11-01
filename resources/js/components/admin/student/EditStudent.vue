<template>
  <form class="space-y-6" @submit.prevent="update">
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
      <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800">
        <h2 class="text-lg font-medium text-gray-800 dark:text-white">
          {{ t('users.userInformation') }}
        </h2>
      </div>

      <div class="p-4 sm:p-6 dark:border-gray-800">
        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
              {{ t('adduser.userName') }}
            </label>
            <input
              v-model="form.user.name"
              type="text"
              autocomplete="name"
              :placeholder="t('adduser.userNamePlaceholder')"
              class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
            />
            <p v-if="form.errors['user.name']" class="mt-1 text-sm text-error-500">{{ form.errors['user.name'] }}</p>
          </div>

          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
              {{ t('common.email') }}
            </label>
            <div class="relative">
              <span class="absolute left-0 top-1/2 -translate-y-1/2 border-r border-gray-200 px-3.5 py-3 text-gray-500 dark:border-gray-800 dark:text-gray-400">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path
                    fill-rule="evenodd"
                    clip-rule="evenodd"
                    d="M3.04175 7.06206V14.375C3.04175 14.6511 3.26561 14.875 3.54175 14.875H16.4584C16.7346 14.875 16.9584 14.6511 16.9584 14.375V7.06245L11.1443 11.1168C10.457 11.5961 9.54373 11.5961 8.85638 11.1168L3.04175 7.06206ZM16.9584 5.19262C16.9584 5.19341 16.9584 5.1942 16.9584 5.19498V5.20026C16.9572 5.22216 16.946 5.24239 16.9279 5.25501L10.2864 9.88638C10.1145 10.0062 9.8862 10.0062 9.71437 9.88638L3.07255 5.25485C3.05342 5.24151 3.04202 5.21967 3.04202 5.19636C3.042 5.15695 3.07394 5.125 3.11335 5.125H16.8871C16.9253 5.125 16.9564 5.15494 16.9584 5.19262ZM18.4584 5.21428V14.375C18.4584 15.4796 17.563 16.375 16.4584 16.375H3.54175C2.43718 16.375 1.54175 15.4796 1.54175 14.375V5.19498C1.54175 5.1852 1.54194 5.17546 1.54231 5.16577C1.55858 4.31209 2.25571 3.625 3.11335 3.625H16.8871C17.7549 3.625 18.4584 4.32843 18.4585 5.19622C18.4585 5.20225 18.4585 5.20826 18.4584 5.21428Z"
                    fill="#667085"
                  />
                </svg>
              </span>
              <input
                v-model="form.user.email"
                type="email"
                autocomplete="email"
                :placeholder="t('users.emailPlaceholder')"
                class="dark:bg-dark-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 pl-[62px] text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800"
              />
            </div>
            <p v-if="form.errors['user.email']" class="mt-1 text-sm text-error-500">{{ form.errors['user.email'] }}</p>
          </div>

          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
              {{ t('common.phoneNumber') }}
            </label>
            <input
              v-model="form.user.phone_number"
              type="tel"
              autocomplete="tel"
              :placeholder="t('users.phonePlaceholder')"
              class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
            />
            <p v-if="form.errors['user.phone_number']" class="mt-1 text-sm text-error-500">{{ form.errors['user.phone_number'] }}</p>
          </div>

          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
              {{ t('common.whatsappNumber') }}
            </label>
            <input
              v-model="form.user.whatsapp_number"
              type="tel"
              autocomplete="off"
              :placeholder="t('users.whatsappPlaceholder')"
              class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
            />
            <p v-if="form.errors['user.whatsapp_number']" class="mt-1 text-sm text-error-500">{{ form.errors['user.whatsapp_number'] }}</p>
          </div>

          <div class="md:col-span-2">
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
              {{ t('common.address') }}
            </label>
            <input
              v-model="form.user.address"
              type="text"
              autocomplete="street-address"
              :placeholder="t('users.addressPlaceholder')"
              class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
            />
            <p v-if="form.errors['user.address']" class="mt-1 text-sm text-error-500">{{ form.errors['user.address'] }}</p>
          </div>

          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
              {{ t('users.password') }}
            </label>
            <div class="relative">
              <input
                :type="showPassword ? 'text' : 'password'"
                v-model="form.user.password"
                autocomplete="new-password"
                :placeholder="t('users.passwordPlaceholder')"
                class="dark:bg-dark-900 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
              />
              <button
                type="button"
                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 transition hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200"
                @click="showPassword = !showPassword"
              >
                <svg v-if="!showPassword" class="h-5 w-5" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path
                    fill-rule="evenodd"
                    clip-rule="evenodd"
                    d="M10.0002 13.8619C7.23361 13.8619 4.86803 12.1372 3.92328 9.70241C4.86804 7.26761 7.23361 5.54297 10.0002 5.54297C12.7667 5.54297 15.1323 7.26762 16.0771 9.70243C15.1323 12.1372 12.7667 13.8619 10.0002 13.8619ZM10.0002 4.04297C6.48191 4.04297 3.49489 6.30917 2.4155 9.4593C2.3615 9.61687 2.3615 9.78794 2.41549 9.94552C3.49488 13.0957 6.48191 15.3619 10.0002 15.3619C13.5184 15.3619 16.5055 13.0957 17.5849 9.94555C17.6389 9.78797 17.6389 9.6169 17.5849 9.45932C16.5055 6.30919 13.5184 4.04297 10.0002 4.04297ZM9.99151 7.84413C8.96527 7.84413 8.13333 8.67606 8.13333 9.70231C8.13333 10.7286 8.96527 11.5605 9.99151 11.5605H10.0064C11.0326 11.5605 11.8646 10.7286 11.8646 9.70231C11.8646 8.67606 11.0326 7.84413 10.0064 7.84413H9.99151Z"
                    fill="currentColor"
                  />
                </svg>
                <svg v-else class="h-5 w-5" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path
                    fill-rule="evenodd"
                    clip-rule="evenodd"
                    d="M4.63803 3.57709C4.34513 3.2842 3.87026 3.2842 3.57737 3.57709C3.28447 3.86999 3.28447 4.34486 3.57737 4.63775L4.85323 5.91362C3.74609 6.84199 2.89363 8.06395 2.4155 9.45936C2.3615 9.61694 2.3615 9.78801 2.41549 9.94558C3.49488 13.0957 6.48191 15.3619 10.0002 15.3619C11.255 15.3619 12.4422 15.0737 13.4994 14.5598L15.3625 16.4229C15.6554 16.7158 16.1302 16.7158 16.4231 16.4229C16.716 16.13 16.716 15.6551 16.4231 15.3622L4.63803 3.57709ZM12.3608 13.4212L10.4475 11.5079C10.3061 11.5423 10.1584 11.5606 10.0064 11.5606H9.99151C8.96527 11.5606 8.13333 10.7286 8.13333 9.70237C8.13333 9.5461 8.15262 9.39434 8.18895 9.24933L5.91885 6.97923C5.03505 7.69015 4.34057 8.62704 3.92328 9.70247C4.86803 12.1373 7.23361 13.8619 10.0002 13.8619C10.8326 13.8619 11.6287 13.7058 12.3608 13.4212ZM16.0771 9.70249C15.7843 10.4569 15.3552 11.1432 14.8199 11.7311L15.8813 12.7925C16.6329 11.9813 17.2187 11.0143 17.5849 9.94561C17.6389 9.78803 17.6389 9.61696 17.5849 9.45938C16.5055 6.30925 13.5184 4.04303 10.0002 4.04303C9.13525 4.04303 8.30244 4.17999 7.52218 4.43338L8.75139 5.66259C9.1556 5.58413 9.57311 5.54303 10.0002 5.54303C12.7667 5.54303 15.1323 7.26768 16.0771 9.70249Z"
                    fill="currentColor"
                  />
                </svg>
              </button>
            </div>
            <p v-if="form.errors['user.password']" class="mt-1 text-sm text-error-500">{{ form.errors['user.password'] }}</p>
          </div>

          <div class="flex flex-col justify-end">
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
              {{ t('common.status') }}
            </label>
            <label for="toggle-active" class="flex cursor-pointer select-none items-center gap-3 rounded-lg border border-transparent px-3 py-2 text-sm font-medium text-gray-700 transition hover:border-gray-200 dark:text-gray-400 dark:hover:border-gray-700">
              <div class="relative">
                <input type="checkbox" id="toggle-active" class="sr-only" v-model="form.user.is_active" />
                <div class="block h-6 w-11 rounded-full" :class="form.user.is_active ? 'bg-brand-500 dark:bg-brand-500' : 'bg-gray-200 dark:bg-white/10'"></div>
                <div :class="form.user.is_active ? 'translate-x-full' : 'translate-x-0'" class="absolute left-0.5 top-0.5 h-5 w-5 rounded-full bg-white shadow-theme-sm duration-300 ease-linear"></div>
              </div>
              <span
                class="inline-flex items-center justify-center gap-1 rounded-full px-2.5 py-0.5 text-xs font-medium"
                :class="{
                  'bg-green-50 text-green-600 dark:bg-green-500/15 dark:text-green-500': form.user.is_active,
                  'bg-error-50 text-error-600 dark:bg-error-500/15 dark:text-error-500': !form.user.is_active,
                }"
              >
                {{ form.user.is_active ? t('common.active') : t('common.inactive') }}
              </span>
            </label>
            <p v-if="form.errors['user.is_active']" class="mt-1 text-sm text-error-500">{{ form.errors['user.is_active'] }}</p>
          </div>
        </div>
      </div>
    </div>

    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
      <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800">
        <h2 class="text-lg font-medium text-gray-800 dark:text-white">
          {{ t('users.userImage') }}
        </h2>
      </div>

      <div class="p-4 sm:p-6">
        <label
          for="student-image"
          class="shadow-theme-xs group relative block cursor-pointer rounded-lg border-2 border-dashed border-gray-300 transition hover:border-brand-500 dark:border-gray-800 dark:bg-gray-900 dark:hover:border-brand-500"
        >
          <div v-if="!imagePreview" class="flex justify-center p-10">
            <div class="flex max-w-[260px] flex-col items-center gap-4">
              <div
                class="inline-flex h-13 w-13 items-center justify-center rounded-full border border-gray-200 text-gray-700 transition dark:border-gray-800 dark:text-gray-400"
              >
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                  <path
                    d="M20.0004 16V18.5C20.0004 19.3284 19.3288 20 18.5004 20H5.49951C4.67108 20 3.99951 19.3284 3.99951 18.5V16M12.0015 4L12.0015 16M7.37454 8.6246L11.9994 4.00269L16.6245 8.6246"
                    stroke="currentColor"
                    stroke-width="1.5"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                  />
                </svg>
              </div>
              <p class="text-center text-sm text-gray-500 dark:text-gray-400">
                <span class="font-medium text-gray-800 dark:text-white/90">{{ t('common.clickToUpload') }}</span>
                {{ t('common.orDragDrop') }}
              </p>
            </div>
          </div>

          <div v-else class="relative flex justify-center p-4">
            <img
              :src="imagePreview"
              alt="Student preview"
              class="max-h-48 rounded-lg border border-gray-200 object-contain dark:border-gray-800"
            />
            <button
              v-if="form.user.attachment"
              type="button"
              @click.stop="removeImage"
              class="absolute -top-2 -right-2 hidden rounded-full bg-error-500 p-1 text-white shadow group-hover:flex"
            >
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18" />
                <line x1="6" y1="6" x2="18" y2="18" />
              </svg>
            </button>
          </div>

          <input
            ref="fileInput"
            type="file"
            id="student-image"
            class="hidden"
            accept="image/*"
            @change="handleFileUpload"
          />
        </label>
        <p v-if="form.errors['user.attachment']" class="mt-2 text-sm text-error-500">{{ form.errors['user.attachment'] }}</p>
      </div>
    </div>

    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
      <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800">
        <h2 class="text-lg font-medium text-gray-800 dark:text-white">
          {{ t('students.studentInformation') }}
        </h2>
      </div>

      <div class="p-4 sm:p-6 dark:border-gray-800">
        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
              {{ t('students.selectGuardian') }}
            </label>
            <div class="relative z-20 bg-transparent">
              <select
                v-model="form.guardian_id"
                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                :class="{ 'text-gray-800 dark:text-white/90': form.guardian_id }"
              >
                <option value="" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">
                  {{ t('students.selectGuardianPlaceholder') }}
                </option>
                <option
                  v-for="guardian in guardians"
                  :key="guardian.id"
                  :value="guardian.id"
                  class="text-gray-700 dark:bg-gray-900 dark:text-gray-400"
                >
                  {{ guardian.name }}
                </option>
              </select>
              <span class="pointer-events-none absolute top-1/2 right-4 z-30 -translate-y-1/2 text-gray-700 dark:text-gray-400">
                <svg class="stroke-current" width="20" height="20" viewBox="0 0 20 20" fill="none">
                  <path d="M4.79175 7.396L10.0001 12.6043L15.2084 7.396" stroke="" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
              </span>
            </div>
            <p v-if="form.errors.guardian_id" class="mt-1 text-sm text-error-500">{{ form.errors.guardian_id }}</p>
          </div>

          <div>
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
              {{ t('students.selectMosque') }}
            </label>
            <div class="relative z-20 bg-transparent">
              <select
                v-model="form.mosque_id"
                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                :class="{ 'text-gray-800 dark:text-white/90': form.mosque_id }"
              >
                <option value="" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">
                  {{ t('students.selectMosquePlaceholder') }}
                </option>
                <option
                  v-for="mosque in mosques"
                  :key="mosque.id"
                  :value="mosque.id"
                  class="text-gray-700 dark:bg-gray-900 dark:text-gray-400"
                >
                  {{ mosque.name }}
                </option>
              </select>
              <span class="pointer-events-none absolute top-1/2 right-4 z-30 -translate-y-1/2 text-gray-700 dark:text-gray-400">
                <svg class="stroke-current" width="20" height="20" viewBox="0 0 20 20" fill="none">
                  <path d="M4.79175 7.396L10.0001 12.6043L15.2084 7.396" stroke="" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
              </span>
            </div>
            <p v-if="form.errors.mosque_id" class="mt-1 text-sm text-error-500">{{ form.errors.mosque_id }}</p>
          </div>

          <div>
            <label for="student-birth-date" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
              {{ t('students.birthDate') }}
            </label>
            <input
              v-model="form.birth_date"
              type="date"
              id="student-birth-date"
              class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
            />
            <p v-if="form.errors.birth_date" class="mt-1 text-sm text-error-500">{{ form.errors.birth_date }}</p>
          </div>

          <div>
            <label for="student-nationality" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
              {{ t('students.nationality') }}
            </label>
            <input
              v-model="form.nationality"
              type="text"
              id="student-nationality"
              autocomplete="off"
              :placeholder="t('students.nationality')"
              class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
            />
            <p v-if="form.errors.nationality" class="mt-1 text-sm text-error-500">{{ form.errors.nationality }}</p>
          </div>

          <div class="md:col-span-2">
            <label for="student-notes" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
              {{ t('students.notes') }}
            </label>
            <textarea
              v-model="form.notes"
              id="student-notes"
              rows="4"
              :placeholder="t('students.notesPlaceholder') ?? t('students.notes')"
              class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
            ></textarea>
            <p v-if="form.errors.notes" class="mt-1 text-sm text-error-500">{{ form.errors.notes }}</p>
          </div>
        </div>
      </div>
    </div>

    <div class="flex flex-col gap-3 sm:flex-row sm:justify-end">
      <Link
        :href="route('admin.students.index')"
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
        {{ form.processing ? t('common.loading') : t('buttons.update') }}
      </button>
    </div>
  </form>
</template>

<script setup>
import { Link, useForm } from '@inertiajs/vue3'
import { ref, onBeforeUnmount, watch } from 'vue'
import { useI18n } from 'vue-i18n'
import { useNotifications } from '@/composables/useNotifications'

const { t } = useI18n()
const { success, error } = useNotifications()

const props = defineProps({
  student: { type: Object, required: true },
  guardians: { type: Array, default: () => [] },
  mosques: { type: Array, default: () => [] },
})

const existingImageUrl = ref(props.student.user_attachment ?? null)

const form = useForm({
  _method: 'PUT',
  user: {
    name: props.student.user_name ?? '',
    email: props.student.user_email ?? '',
    password: '',
    phone_number: props.student.phone_number ?? '',
    whatsapp_number: props.student.whatsapp_number ?? '',
    address: props.student.address ?? '',
    is_active: !!props.student.is_active,
    attachment: null,
  },
  guardian_id: props.student.guardian_id ?? '',
  mosque_id: props.student.mosque_id ?? '',
  birth_date: props.student.birth_date ?? '',
  nationality: props.student.nationality ?? '',
  notes: props.student.notes ?? '',
})

const showPassword = ref(false)
const imagePreview = ref(existingImageUrl.value)
const fileInput = ref(null)
let currentObjectUrl = null

function revokeObjectUrl() {
  if (currentObjectUrl) {
    URL.revokeObjectURL(currentObjectUrl)
    currentObjectUrl = null
  }
}

function handleFileUpload(event) {
  const file = event.target.files?.[0] || null
  form.user.attachment = file
  revokeObjectUrl()
  if (file) {
    currentObjectUrl = URL.createObjectURL(file)
    imagePreview.value = currentObjectUrl
  } else {
    imagePreview.value = existingImageUrl.value
  }
}

function removeImage() {
  form.user.attachment = null
  revokeObjectUrl()
  imagePreview.value = existingImageUrl.value
  if (fileInput.value) {
    fileInput.value.value = ''
  }
}

function update() {
  form
    .transform((data) => {
      const payload = {
        ...data,
        user: {
          ...data.user,
        },
      }

      if (!payload.user.password) {
        delete payload.user.password
        delete payload.user.password_confirmation
      } else {
        payload.user.password_confirmation = payload.user.password
      }

      if (!payload.user.attachment) {
        delete payload.user.attachment
      }

      return payload
    })
    .post(route('admin.students.update', props.student.id), {
      onSuccess: () => {
        success(t('students.studentUpdatedSuccessfully'))
        form.user.password = ''
      },
      onError: () => {
        error(t('students.studentUpdateFailed'))
      },
      onFinish: () => {
        form.transform((data) => data)
      },
      preserveScroll: true,
    })
}

onBeforeUnmount(() => {
  revokeObjectUrl()
})

watch(
  () => props.student.user_attachment,
  (newUrl) => {
    existingImageUrl.value = newUrl ?? null
    if (!form.user.attachment) {
      imagePreview.value = existingImageUrl.value
    }
  }
)
</script>
