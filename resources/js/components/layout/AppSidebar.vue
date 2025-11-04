<template>
  <aside
    :class="[
      'fixed mt-16 flex flex-col lg:mt-0 top-0 px-5 h-screen z-99999 bg-white dark:bg-gray-900 text-gray-900 border-gray-200 dark:border-gray-800',
      // desktop side border على جانب inline-start
      'lg:border-r rtl:lg:border-l rtl:lg:border-r-0',
      // عرض الشريط
      'w-[290px]',
      (isExpanded || isHovered) ? 'lg:w-[290px]' : 'lg:w-[90px]',
    ]"
  :style="sidebarInlineStyle"
    @mouseenter="!isExpanded && (isHovered = true)"
    @mouseleave="isHovered = false"
  >
    <div :class="['py-8 flex', (!isExpanded && !isHovered) ? 'lg:justify-center' : 'justify-start']">
      <Link href="/">
        <img
          v-if="isExpanded || isHovered || isMobileOpen"
          class="dark:hidden"
          src="/images/logo/logo.svg"
          alt="Logo"
          width="150"
          height="40"
        />
        <img
          v-if="isExpanded || isHovered || isMobileOpen"
          class="hidden dark:block"
          src="/images/logo/manara_logo.svg"
          alt="Logo"
          width="150"
          height="40"
        />
        <img
          v-else
          src="/images/logo/logo-icon.svg"
          alt="Logo"
          width="32"
          height="32"
        />
      </Link>
    </div>
    <div class="flex flex-col overflow-y-auto duration-300 ease-linear no-scrollbar">
      <nav class="mb-6">
        <div class="flex flex-col gap-4">
          <div v-for="(menuGroup, groupIndex) in menuGroups" :key="groupIndex">
            <h2
              :class="[
                'mb-4 text-xs uppercase flex leading-[20px] text-gray-400',
                !isExpanded && !isHovered
                  ? 'lg:justify-center'
                  : 'justify-start',
              ]"
            >
              <template v-if="isExpanded || isHovered || isMobileOpen">
                {{ menuGroup.title }}
              </template>
              <HorizontalDots v-else />
            </h2>
            <ul class="flex flex-col gap-4">
              <li v-for="(item, index) in menuGroup.items" :key="item.name">
                <button
                  v-if="item.subItems"
                  @click="toggleSubmenu(groupIndex, index)"
                  :class="[
                    'menu-item group w-full',
                    {
                      'menu-item-active': isSubmenuOpen(groupIndex, index),
                      'menu-item-inactive': !isSubmenuOpen(groupIndex, index),
                    },
                    !isExpanded && !isHovered
                      ? 'lg:justify-center'
                      : 'lg:justify-start',
                  ]"
                >
                  <span
                    :class="[
                      isSubmenuOpen(groupIndex, index)
                        ? 'menu-item-icon-active'
                        : 'menu-item-icon-inactive',
                    ]"
                  >
                    <component :is="item.icon" />
                  </span>
                  <span
                    v-if="isExpanded || isHovered || isMobileOpen"
                    class="menu-item-text"
                    >{{ item.name }}</span
                  >
                  <ChevronDownIcon
                    v-if="isExpanded || isHovered || isMobileOpen"
                    :class="[
                      'ml-auto w-5 h-5 transition-transform duration-200',
                      {
                        'rotate-180 text-brand-500': isSubmenuOpen(
                          groupIndex,
                          index
                        ),
                      },
                    ]"
                  />
                </button>
                <Link
                  v-else-if="item.path"
                  :href="item.path"
                  :class="[
                    'menu-item group',
                    {
                      'menu-item-active': isActive(item.path),
                      'menu-item-inactive': !isActive(item.path),
                    },
                  ]"
                >
                  <span
                    :class="[
                      isActive(item.path)
                        ? 'menu-item-icon-active'
                        : 'menu-item-icon-inactive',
                    ]"
                  >
                    <component :is="item.icon" />
                  </span>
                  <span
                    v-if="isExpanded || isHovered || isMobileOpen"
                    class="menu-item-text"
                    >{{ item.name }}</span
                  >
                </Link>
                <transition
                  @enter="startTransition"
                  @after-enter="endTransition"
                  @before-leave="startTransition"
                  @after-leave="endTransition"
                >
                  <div
                    v-show="
                      isSubmenuOpen(groupIndex, index) &&
                      (isExpanded || isHovered || isMobileOpen)
                    "
                  >
                    <ul class="mt-2 space-y-1 ml-9">
                      <li v-for="subItem in item.subItems" :key="subItem.name">
                        <Link
                          :href="subItem.path"
                          :class="[
                            'menu-dropdown-item',
                            {
                              'menu-dropdown-item-active': isActive(
                                subItem.path
                              ),
                              'menu-dropdown-item-inactive': !isActive(
                                subItem.path
                              ),
                            },
                          ]"
                        >
                          {{ subItem.name }}
                          <span class="flex items-center gap-1 ml-auto">
                            <span
                              v-if="subItem.new"
                              :class="[
                                'menu-dropdown-badge',
                                {
                                  'menu-dropdown-badge-active': isActive(
                                    subItem.path
                                  ),
                                  'menu-dropdown-badge-inactive': !isActive(
                                    subItem.path
                                  ),
                                },
                              ]"
                            >
                              {{ t('common.new') }}
                            </span>
                            <span
                              v-if="subItem.pro"
                              :class="[
                                'menu-dropdown-badge',
                                {
                                  'menu-dropdown-badge-active': isActive(
                                    subItem.path
                                  ),
                                  'menu-dropdown-badge-inactive': !isActive(
                                    subItem.path
                                  ),
                                },
                              ]"
                            >
                              {{ t('common.pro') }}
                            </span>
                          </span>
                        </Link>
                      </li>
                    </ul>
                  </div>
                </transition>
              </li>
            </ul>
          </div>
        </div>
      </nav>
    </div>
  </aside>
</template>

<script setup>
import { computed } from "vue";
import { useI18n } from 'vue-i18n'
import { Link, usePage } from '@inertiajs/vue3'
import {
  GridIcon,
  UserCircleIcon,
  ChevronDownIcon,
  HorizontalDots,
  BuildingIcon,
  HistoryIcon
} from "../../icons"
import { useSidebar } from "@/composables/useSidebar"
import { usePermissions } from "@/composables/usePermissions"

const { t } = useI18n()
const page = usePage()
const { isExpanded, isMobileOpen, isHovered, openSubmenu, isMobile } = useSidebar()
const { can } = usePermissions()

const passes = (permission) => !permission || can(permission)

const filterMenuItems = (items = []) =>
  items
    .map((item) => {
      if (item.subItems) {
        const subItems = filterMenuItems(item.subItems)
        return subItems.length
          ? {
              ...item,
              subItems,
            }
          : null
      }

      return passes(item.permission) ? item : null
    })
    .filter(Boolean)

const filterMenuGroups = (groups = []) =>
  groups
    .map((group) => {
      const items = filterMenuItems(group.items)
      return items.length
        ? {
            ...group,
            items,
          }
        : null
    })
    .filter(Boolean)

const sidebarInlineStyle = computed(() => {
  const desktop = !isMobile.value
  return {
    insetInlineStart: desktop ? '0' : (isMobileOpen.value ? '0' : '-100%'),
    transition: 'inset-inline-start 300ms ease-in-out',
  }
})

const menuGroups = computed(() =>
  filterMenuGroups([
    {
      title: t('menu.menu'),
      items: [
        {
          icon: GridIcon,
          name: t('menu.dashboard'),
          subItems: [
            {
              name: t('menu.ecommerce'),
              path: '/',
              permission: 'dashboard.view',
            },
          ],
        },
        {
          icon: BuildingIcon,
          name: t('menu.locations'),
          subItems: [
            {
              name: t('menu.governorates'),
              path: route('admin.governorates.index'),
              permission: 'governorates.view',
            },
            {
              name: t('menu.districts'),
              path: route('admin.districts.index'),
              permission: 'districts.view',
            },
            {
              name: t('menu.areas'),
              path: route('admin.areas.index'),
              permission: 'areas.view',
            }
          ],
        },
        {
          icon: BuildingIcon,
          name: t('menu.foundationalData'),
          subItems: [
            {
              name: t('menu.mosques'),
              path: route('admin.mosques.index'),
              permission: 'mosques.view',
            },
            {
              name: t('menu.circles'),
              path: route('admin.circles.index'),
              permission: 'circles.view',
            },
            {
              name: t('menu.programs'),
              path: route('admin.programs.index'),
              permission: 'programs.view',
            },
            {
              name: t('menu.activities'),
              path: route('admin.activities.index'),
              permission: 'activities.view',
            }
          ],
        },
        // Additional admin sections (scaffolded). Icons are placeholders and can be changed later.
        
        {
          icon: GridIcon,
          name: t('menu.academic_years'),
          path: route('admin.academic_years.index'),
          permission: 'academic_years.view',
        },
        
        {
          icon: GridIcon,
          name: t('menu.plans'),
          path: route('admin.plans.index'),
          permission: 'plans.view',
        },
        {
          icon: GridIcon,
          name: t('menu.terms'),
          path: route('admin.terms.index'),
          permission: 'terms.view',
        },
        {
          icon: GridIcon,
          name: t('menu.students'),
          path: route('admin.students.index'),
          permission: 'students.view',
        },
        {
          icon: GridIcon,
          name: t('menu.guardians'),
          path: route('admin.guardians.index'),
          permission: 'guardians.view',
        },
        
        {
          icon: GridIcon,
          name: t('menu.circle_classifications'),
          path: route('admin.circle_classifications.index'),
          permission: 'circle_classifications.view',
        },
        {
          icon: GridIcon,
          name: t('menu.staff_assignments'),
          path: route('admin.staff_assignments.index'),
          permission: 'staff_assignments.view',
        },
        {
          icon: GridIcon,
          name: t('menu.daily_study_sessions'),
          path: route('admin.daily_study_sessions.index'),
          permission: 'daily_study_sessions.view',
        },
        {
          icon: GridIcon,
          name: t('menu.quran_suras'),
          path: route('admin.quran_suras.index'),
          permission: 'quran_suras.view',
        },
        {
          icon: GridIcon,
          name: t('menu.student_attendances'),
          path: route('admin.student_attendances.index'),
          permission: 'student_attendances.view',
        },
        {
          icon: GridIcon,
          name: t('menu.teacher_attendances'),
          path: route('admin.teacher_attendances.index'),
          permission: 'teacher_attendances.view',
        },
        {
          icon: GridIcon,
          name: t('menu.exams'),
          path: route('admin.exams.index'),
          permission: 'exams.view',
        },
        {
          icon: GridIcon,
          name: t('menu.exam_items'),
          path: route('admin.exam_items.index'),
          permission: 'exam_items.view',
        },
        {
          icon: GridIcon,
          name: t('menu.exam_types'),
          path: route('admin.exam_types.index'),
          permission: 'exam_types.view',
        },
        {
          icon: GridIcon,
          name: t('menu.nominations'),
          path: route('admin.nominations.index'),
          permission: 'nominations.view',
        },
        
        {
          icon: GridIcon,
          name: t('menu.activity_media'),
          path: route('admin.activity_media.index'),
          permission: 'activity_media.view',
        },
        {
          icon: GridIcon,
          name: t('menu.message_templates'),
          path: route('admin.message_templates.index'),
          permission: 'message_templates.view',
        },
        {
          icon: GridIcon,
          name: t('menu.notifications'),
          path: route('admin.notifications.index'),
          permission: 'notifications.view',
        },
        {
          icon: GridIcon,
          name: t('menu.certificate_templates'),
          path: route('admin.certificate_templates.index'),
          permission: 'certificate_templates.view',
        },
        {
          icon: GridIcon,
          name: t('menu.certificate_issued'),
          path: route('admin.certificate_issued.index'),
          permission: 'certificate_issued.view',
        },
        {
          icon: UserCircleIcon,
          name: t('menu.profile'),
          path: '/profile',
          permission: 'profile.view',
        },
        {
          icon: UserCircleIcon,
          name: t('menu.users'),
          subItems: [
            {
              name: 'المستخدمون',
              path: route('admin.users.index'),
              permission: 'users.view',
            },
            {
              name: 'الأدوار',
              path: route('admin.roles.index'),
              permission: 'roles.view',
            },
            {
              name: 'الصلاحيات',
              path: route('admin.permissions.index'),
              permission: 'permissions.view',
            },
          ],
        },
        {
          icon: HistoryIcon,
          name: t('menu.activityLogs'),
          path: '/activitylogs',
          permission: 'activitylogs.view',
        },
      ],
    },
  ]),
)

const isActive = (path) => {
  if (!path) return false;

  // Normalize both values to compare pathname-only and ignore trailing slashes
  const normalize = (p) => {
    try {
      // If `p` is a full URL, extract its pathname
      const url = new URL(p, window.location.origin);
      p = url.pathname;
    } catch (e) {
      // not a full URL, keep as-is
    }

    // Ensure string, remove origin if present, strip trailing slashes (but keep single '/')
    let s = String(p || '');
    s = s.replace(window.location.origin, '');
    s = s.replace(/\/+$|^(?:)$/, ''); // remove trailing slashes
    if (s === '') s = '/';
    return s;
  };

  const current = normalize(page.url);
  const target = normalize(path);

  // Exact match or a parent path (e.g. /admin/terms and /admin/terms/1)
  // Special-case root path: only match exactly '/'
  if (target === '/') return current === '/';
  return current === target || current.startsWith(target + '/');
};

const toggleSubmenu = (groupIndex, itemIndex) => {
  const key = `${groupIndex}-${itemIndex}`;
  openSubmenu.value = openSubmenu.value === key ? null : key;
};

const isAnySubmenuRouteActive = computed(() => {
  return menuGroups.value.some((group) =>
    group.items.some(
      (item) =>
        item.subItems && item.subItems.some((subItem) => isActive(subItem.path))
    )
  )
})

const isSubmenuOpen = (groupIndex, itemIndex) => {
  const key = `${groupIndex}-${itemIndex}`;
  return (
    openSubmenu.value === key ||
    (isAnySubmenuRouteActive.value &&
      menuGroups.value[groupIndex].items[itemIndex].subItems?.some((subItem) =>
        isActive(subItem.path)
      ))
  )
};

const startTransition = (el) => {
  el.style.height = "auto";
  const height = el.scrollHeight;
  el.style.height = "0px";
  el.offsetHeight; // force reflow
  el.style.height = height + "px";
};

const endTransition = (el) => {
  el.style.height = "";
};
</script>
