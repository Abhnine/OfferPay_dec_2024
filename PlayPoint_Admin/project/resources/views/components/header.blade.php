<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Meta tags  -->
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta
      name="viewport"
      content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"
    />

    <title>{{ $admin_data->site_name }}</title>
    <link rel="icon" type="image/png" href="images/favicon.png" />

    <!-- CSS Assets -->
    <link rel="stylesheet" href="{{url('css/app.css')}}" />
    <link rel="stylesheet" href="{{url('css/style.css')}}" />

    <!-- Javascript Assets -->
    <script src="{{url('js/app.js')}}" defer></script>
    <script src="{{url('js/csm-add.js')}}" defer></script>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet"
    />
  </head>

  <body x-data class="is-header-blur" x-bind="$store.global.documentBody">
    <!-- App preloader-->
    <div
      class="app-preloader fixed z-50 grid h-full w-full place-content-center bg-slate-50 dark:bg-navy-900"
    >
    <div class="spinner h-7 w-7 animate-spin text-slate-500 dark:text-navy-300">
        <svg
          xmlns="http://www.w3.org/2000/svg"
          class="h-full w-full"
          fill="none"
          viewBox="0 0 28 28"
        >
          <path
            fill="currentColor"
            fill-rule="evenodd"
            d="M28 14c0 7.732-6.268 14-14 14S0 21.732 0 14 6.268 0 14 0s14 6.268 14 14zm-2.764.005c0 6.185-5.014 11.2-11.2 11.2-6.185 0-11.2-5.015-11.2-11.2 0-6.186 5.015-11.2 11.2-11.2 6.186 0 11.2 5.014 11.2 11.2zM8.4 16.8a2.8 2.8 0 100-5.6 2.8 2.8 0 000 5.6z"
            clip-rule="evenodd"
          />
        </svg>
      </div>
    </div>


    <!-- Page Wrapper -->
    <div
      id="root"
      class="min-h-100vh flex grow bg-slate-50 dark:bg-navy-900"
      x-cloak
    >

    <!-- Sidebar -->
    <div class="sidebar print:hidden">
        <!-- Main Sidebar -->

        <!-- Sidebar Panel -->
        <div class="sidebar-panel">
          <div
            class="flex h-full grow flex-col bg-white pl-[var(--main-sidebar-width)] dark:bg-navy-750"
          >
            <!-- Sidebar Panel Header -->
            <div
              class="nav-cut"
            >
             <div></div>
              <button
                @click="$store.global.isSidebarExpanded = false"
                class="btn h-7 w-7 rounded-full p-0 text-primary hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:text-accent-light/80 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25 xl:hidden"
              >
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  class="h-6 w-6"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M15 19l-7-7 7-7"
                  />
                </svg>
              </button>
            </div>
            <style>
            .pl-\[var\(--main-sidebar-width\)\] {
            padding-left: 0rem !important;
            }
            :root {
            --main-sidebar-width: 0rem !important;
            --sidebar-panel-width: 290px;
            }
            </style>
            <!-- Sidebar Panel Body -->
            <div class="flex h-full w-full transform-gpu flex-col bg-white transition-transform duration-200 dark:bg-navy-700" style="overflow-y:scroll;"
            x-transition:enter="ease-out" x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="ease-in" x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full" style="">
                <div class="h-24">
                  <img class="h-full w-full object-cover object-center" src="{{ url('/images/banner/app-back.jpg') }}" alt="image">
                </div>
                <div class="flex space-x-5 px-5">
                  <div class="avatar -mt-5 h-20 w-20">
                    <img class="rounded-full border-2 border-white dark:border-navy-700" src="{{url($admin_data->profile_image)}}" alt="avatar">

                  </div>
                  <div class="mt-2 w-full" style="margin-left:10px;">
                    <div class="flex justify-between space-x-3">
                      <h4 class="text-base font-medium text-slate-700 dark:text-navy-50">
                        {{ mb_strimwidth($admin_data->name, 0,  20,  '..')}}
                      </h4>
                      {{-- add --}}
                    </div>

                    <a class="cursor-pointer text-xs+ text-primary hover:text-primary-focus dark:text-accent-light dark:hover:text-accent">
                    {{ mb_strimwidth($admin_data->email, 0,  23,  '..') }}</a>

                    <a class="tag mt-1 bg-success/10 text-success hover:bg-success/20 focus:bg-success/20 active:bg-success/25">
                    Administration</a>
                    </div>
                </div>
                <div style="margin-top: 8px;" class="my-4 mx-5 h-px bg-slate-200 dark:bg-navy-500"></div>

                <ul class="flex flex-1 flex-col px-4 font-medium">
                  <li>
                    <a href="{{route('admin.dashboard')}}" class="flex items-center gap-2 group flex space-x-2 rounded-lg px-4 py-2.5 tracking-wide outline-none transition-all hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100 py-2 text-xs+ tracking-wide text-slate-500 outline-none transition-[color,padding-left] duration-300 ease-in-out hover:text-slate-800 dark:text-navy-200 dark:hover:text-navy-50">
                      <i class="fa-solid fa-gauge"></i> Dashboard
                    </a>
                  </li>



                    <li x-data="accordionItem('menu-item-1')">
                        <a :class="expanded &amp;&amp; 'text-slate-800 font-semibold dark:text-navy-50'"
                        @click="expanded = !expanded"
                        class="flex items-center justify-between group flex space-x-2 rounded-lg px-4 py-2.5 tracking-wide outline-none transition-all hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100 py-2 text-xs+ tracking-wide text-slate-500 outline-none transition-[color,padding-left] duration-300 ease-in-out hover:text-slate-800 dark:text-navy-200 dark:hover:text-navy-50"
                        href="javascript:void(0);"
                        >
                        <div>
                            <i class="fa-solid fa-users" style="margin-right:3px;"></i>
                            <span>Users</span>
                           </div>
                          <svg
                            :class="expanded && 'rotate-90'"
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-4 w-4 text-slate-400 transition-transform ease-in-out"
                            fill="none"
                            viewbox="0 0 24 24"
                            stroke="currentColor"
                          >
                            <path
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M9 5l7 7-7 7"
                            />
                          </svg>
                        </a>
                        <ul x-collapse x-show="expanded">
                          <li>
                            <a
                              href="{{ route('admin.users');}}"
                              class="flex items-center justify-between p-2 text-xs+ tracking-wide text-slate-500 outline-none transition-[color,padding-left] duration-300 ease-in-out hover:pl-4 hover:text-slate-800 dark:text-navy-200 dark:hover:text-navy-50"
                            >
                              <div class="flex items-center space-x-2">
                                <div
                                  class="h-1.5 w-1.5 rounded-full border border-current opacity-40"
                                ></div>
                                <span>List</span>
                              </div>
                            </a>
                          </li>
                          <li>
                            <a href="{{ route('admin.t_referrals');}}"
                             class="flex items-center justify-between p-2 text-xs+ tracking-wide text-slate-500 outline-none transition-[color,padding-left] duration-300 ease-in-out hover:pl-4 hover:text-slate-800 dark:text-navy-200 dark:hover:text-navy-50"
                            >
                              <div class="flex items-center space-x-2">
                                <div
                                  class="h-1.5 w-1.5 rounded-full border border-current opacity-40"
                                ></div>
                                <span>Referrals</span>
                              </div>
                            </a>
                          </li>
                          <li>
                            <a href="{{ route('admin.tracker');}}"
                             class="flex items-center justify-between p-2 text-xs+ tracking-wide text-slate-500 outline-none transition-[color,padding-left] duration-300 ease-in-out hover:pl-4 hover:text-slate-800 dark:text-navy-200 dark:hover:text-navy-50"
                            >
                              <div class="flex items-center space-x-2">
                                <div
                                  class="h-1.5 w-1.5 rounded-full border border-current opacity-40"
                                ></div>
                                <span>User Tracker</span>
                              </div>
                            </a>
                          </li>
             
                        </ul>
                      </li>

                      <li x-data="accordionItem('menu-item-2')">
                          <a
                          :class="expanded &amp;&amp; 'text-slate-800 font-semibold dark:text-navy-50'"
                          @click="expanded = !expanded"
                          class="flex items-center justify-between group flex space-x-2 rounded-lg px-4 py-2.5 tracking-wide outline-none transition-all hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100 py-2 text-xs+ tracking-wide text-slate-500 outline-none transition-[color,padding-left] duration-300 ease-in-out hover:text-slate-800 dark:text-navy-200 dark:hover:text-navy-50"
                          href="javascript:void(0);"
                          >
                          <div>
                            <i class="fa-solid fa-gamepad" style="margin-right:3px;"></i>
                            <span>Games</span>
                           </div>
                            <svg
                              :class="expanded && 'rotate-90'"
                              xmlns="http://www.w3.org/2000/svg"
                              class="h-4 w-4 text-slate-400 transition-transform ease-in-out"
                              fill="none"
                              viewbox="0 0 24 24"
                              stroke="currentColor"
                            >
                              <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M9 5l7 7-7 7"
                              />
                            </svg>
                          </a>
                          <ul x-collapse x-show="expanded">
                            <li>
                              <a
                                href="{{ route('admin.games')}}"
                                class="flex items-center justify-between p-2 text-xs+ tracking-wide text-slate-500 outline-none transition-[color,padding-left] duration-300 ease-in-out hover:pl-4 hover:text-slate-800 dark:text-navy-200 dark:hover:text-navy-50"
                              >
                                <div class="flex items-center space-x-2">
                                  <div
                                    class="h-1.5 w-1.5 rounded-full border border-current opacity-40"
                                  ></div>
                                  <span>All Games</span>
                                </div>
                              </a>
                            </li>
                            <li>
                              <a
                                href="{{ route('admin.csm_add_game')}}"
                                class="flex items-center justify-between p-2 text-xs+ tracking-wide text-slate-500 outline-none transition-[color,padding-left] duration-300 ease-in-out hover:pl-4 hover:text-slate-800 dark:text-navy-200 dark:hover:text-navy-50"
                              >
                                <div class="flex items-center space-x-2">
                                  <div
                                    class="h-1.5 w-1.5 rounded-full border border-current opacity-40"
                                  ></div>
                                  <span>Add Game</span>
                                </div>
                              </a>
                            </li>
                          </ul>
                        </li>

                        <li>
                        <a href="{{ route('admin.offerwalls')}}" class="flex items-center gap-2 group flex space-x-2 rounded-lg px-4 py-2.5 tracking-wide outline-none transition-all hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100 py-2 text-xs+ tracking-wide text-slate-500 outline-none transition-[color,padding-left] duration-300 ease-in-out hover:text-slate-800 dark:text-navy-200 dark:hover:text-navy-50">
                            <i class="fa-solid fa-sack-dollar"></i> OfferWalls
                        </a>
                        </li>

                        <li>
                        <a href="{{ route('admin.ads')}}" class="flex items-center gap-2 group flex space-x-2 rounded-lg px-4 py-2.5 tracking-wide outline-none transition-all hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100 py-2 text-xs+ tracking-wide text-slate-500 outline-none transition-[color,padding-left] duration-300 ease-in-out hover:text-slate-800 dark:text-navy-200 dark:hover:text-navy-50">
                            <i class="fa-solid fa-bullhorn"></i> Ad Networks
                        </a>
                        </li>

                        <li x-data="accordionItem('menu-item-3')">
                            <a
                            :class="expanded &amp;&amp; 'text-slate-800 font-semibold dark:text-navy-50'"
                            @click="expanded = !expanded"
                            class="flex items-center justify-between group flex space-x-2 rounded-lg px-4 py-2.5 tracking-wide outline-none transition-all hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100 py-2 text-xs+ tracking-wide text-slate-500 outline-none transition-[color,padding-left] duration-300 ease-in-out hover:text-slate-800 dark:text-navy-200 dark:hover:text-navy-50"
                            href="javascript:void(0);"
                            >
                            <div>
                                <i class="fa-solid fa-link" style="margin-right:3px;"></i>
                                <span>Visit & Earn</span>
                               </div>
                              <svg
                                :class="expanded && 'rotate-90'"
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-4 w-4 text-slate-400 transition-transform ease-in-out"
                                fill="none"
                                viewbox="0 0 24 24"
                                stroke="currentColor"
                              >
                                <path
                                  stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M9 5l7 7-7 7"
                                />
                              </svg>
                            </a>
                            <ul x-collapse x-show="expanded">
                              <li>
                                <a
                                  href="{{ route('admin.visit')}}"
                                  class="flex items-center justify-between p-2 text-xs+ tracking-wide text-slate-500 outline-none transition-[color,padding-left] duration-300 ease-in-out hover:pl-4 hover:text-slate-800 dark:text-navy-200 dark:hover:text-navy-50"
                                >
                                  <div class="flex items-center space-x-2">
                                    <div
                                      class="h-1.5 w-1.5 rounded-full border border-current opacity-40"
                                    ></div>
                                    <span>All Websites</span>
                                  </div>
                                </a>
                              </li>
                              <li>
                                <a
                                  href="{{ route('admin.csm_add_visit')}}"
                                  class="flex items-center justify-between p-2 text-xs+ tracking-wide text-slate-500 outline-none transition-[color,padding-left] duration-300 ease-in-out hover:pl-4 hover:text-slate-800 dark:text-navy-200 dark:hover:text-navy-50"
                                >
                                  <div class="flex items-center space-x-2">
                                    <div
                                      class="h-1.5 w-1.5 rounded-full border border-current opacity-40"
                                    ></div>
                                    <span>Add Website</span>
                                  </div>
                                </a>
                              </li>
                            </ul>
                          </li>

                      <li x-data="accordionItem('menu-item-5')">
                        <a
                        :class="expanded &amp;&amp; 'text-slate-800 font-semibold dark:text-navy-50'"
                        @click="expanded = !expanded"
                        class="flex items-center justify-between group flex space-x-2 rounded-lg px-4 py-2.5 tracking-wide outline-none transition-all hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100 py-2 text-xs+ tracking-wide text-slate-500 outline-none transition-[color,padding-left] duration-300 ease-in-out hover:text-slate-800 dark:text-navy-200 dark:hover:text-navy-50"
                        href="javascript:void(0);"
                        >
                        <div>
                            <i class="fa-solid fa-filter-circle-dollar" style="margin-right:3px;"></i>
                            <span>Referral Missions</span>
                           </div>
                          <svg
                            :class="expanded && 'rotate-90'"
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-4 w-4 text-slate-400 transition-transform ease-in-out"
                            fill="none"
                            viewbox="0 0 24 24"
                            stroke="currentColor"
                          >
                            <path
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M9 5l7 7-7 7"
                            />
                          </svg>
                        </a>
                        <ul x-collapse x-show="expanded">
                          <li>
                            <a
                              href="{{ route('admin.refer')}}"
                              class="flex items-center justify-between p-2 text-xs+ tracking-wide text-slate-500 outline-none transition-[color,padding-left] duration-300 ease-in-out hover:pl-4 hover:text-slate-800 dark:text-navy-200 dark:hover:text-navy-50"
                            >
                              <div class="flex items-center space-x-2">
                                <div
                                  class="h-1.5 w-1.5 rounded-full border border-current opacity-40"
                                ></div>
                                <span>All Missions</span>
                              </div>
                            </a>
                          </li>
                          <li>
                            <a
                              href="{{ route('admin.csm_add_refer')}}"
                              class="flex items-center justify-between p-2 text-xs+ tracking-wide text-slate-500 outline-none transition-[color,padding-left] duration-300 ease-in-out hover:pl-4 hover:text-slate-800 dark:text-navy-200 dark:hover:text-navy-50"
                            >
                              <div class="flex items-center space-x-2">
                                <div
                                  class="h-1.5 w-1.5 rounded-full border border-current opacity-40"
                                ></div>
                                <span>Add Missions</span>
                              </div>
                            </a>
                          </li>
                        </ul>
                      </li>

                        <li x-data="accordionItem('menu-item-4')">
                            <a
                            :class="expanded &amp;&amp; 'text-slate-800 font-semibold dark:text-navy-50'"
                            @click="expanded = !expanded"
                            class="flex items-center justify-between group flex space-x-2 rounded-lg px-4 py-2.5 tracking-wide outline-none transition-all hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100 py-2 text-xs+ tracking-wide text-slate-500 outline-none transition-[color,padding-left] duration-300 ease-in-out hover:text-slate-800 dark:text-navy-200 dark:hover:text-navy-50"
                            href="javascript:void(0);"
                            >
                            <div>
                                <i class="fa-solid fa-dollar-sign" style="margin-right:3px;"></i>
                              <span>Withdrawals</span>
                             </div>
                            <svg
                              :class="expanded && 'rotate-90'"
                              xmlns="http://www.w3.org/2000/svg"
                              class="h-4 w-4 text-slate-400 transition-transform ease-in-out"
                              fill="none"
                              viewbox="0 0 24 24"
                              stroke="currentColor"
                            >
                              <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M9 5l7 7-7 7"
                              />
                            </svg>
                          </a>
                          <ul x-collapse x-show="expanded">
                            <li>
                              <a
                                href="{{ route('admin.redeem') }}"
                                class="flex items-center justify-between p-2 text-xs+ tracking-wide text-slate-500 outline-none transition-[color,padding-left] duration-300 ease-in-out hover:pl-4 hover:text-slate-800 dark:text-navy-200 dark:hover:text-navy-50"
                              >
                                <div class="flex items-center space-x-2">
                                  <div
                                    class="h-1.5 w-1.5 rounded-full border border-current opacity-40"
                                  ></div>
                                  <span>Redeem Requests</span>
                                </div>
                              </a>
                            </li>
                            <li>
                              <a
                                href="{{route('admin.redeem_methods')}}"
                                class="flex items-center justify-between p-2 text-xs+ tracking-wide text-slate-500 outline-none transition-[color,padding-left] duration-300 ease-in-out hover:pl-4 hover:text-slate-800 dark:text-navy-200 dark:hover:text-navy-50"
                              >
                                <div class="flex items-center space-x-2">
                                  <div
                                    class="h-1.5 w-1.5 rounded-full border border-current opacity-40"
                                  ></div>
                                  <span>Redeem Methods</span>
                                </div>
                              </a>
                            </li>
                          </ul>
                        </li>

                       <li>
                        <a href="{{ route('admin.csm_noti')}}" class="flex items-center gap-2 group flex space-x-2 rounded-lg px-4 py-2.5 tracking-wide outline-none transition-all hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100 py-2 text-xs+ tracking-wide text-slate-500 outline-none transition-[color,padding-left] duration-300 ease-in-out hover:text-slate-800 dark:text-navy-200 dark:hover:text-navy-50">
                            <i class="fa-solid fa-bell"></i> Notification
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.csm_banners')}}" class="flex items-center gap-2 group flex space-x-2 rounded-lg px-4 py-2.5 tracking-wide outline-none transition-all hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100 py-2 text-xs+ tracking-wide text-slate-500 outline-none transition-[color,padding-left] duration-300 ease-in-out hover:text-slate-800 dark:text-navy-200 dark:hover:text-navy-50">
                            <i class="fa-solid fa-bookmark"></i> Banners
                        </a>
                    </li> 
                    
                    <li>
                        <a href="{{ route('admin.csm_app_settings')}}" class="flex items-center gap-2 group flex space-x-2 rounded-lg px-4 py-2.5 tracking-wide outline-none transition-all hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100 py-2 text-xs+ tracking-wide text-slate-500 outline-none transition-[color,padding-left] duration-300 ease-in-out hover:text-slate-800 dark:text-navy-200 dark:hover:text-navy-50">
                             <i class="fa-solid fa-screwdriver-wrench"></i> App settings
                        </a>
                    </li>
                    
                        <li x-data="accordionItem('menu-item-5')">
                            <a
                            :class="expanded &amp;&amp; 'text-slate-800 font-semibold dark:text-navy-50'"
                            @click="expanded = !expanded"
                            class="flex items-center justify-between group flex space-x-2 rounded-lg px-4 py-2.5 tracking-wide outline-none transition-all hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100 py-2 text-xs+ tracking-wide text-slate-500 outline-none transition-[color,padding-left] duration-300 ease-in-out hover:text-slate-800 dark:text-navy-200 dark:hover:text-navy-50"
                            href="javascript:void(0);"
                            >
                            <div>
                                 <i class="fa-solid fa-gear" style="margin-right:3px;"></i>
                              <span>Settings</span>
                             </div>
                            <svg
                              :class="expanded && 'rotate-90'"
                              xmlns="http://www.w3.org/2000/svg"
                              class="h-4 w-4 text-slate-400 transition-transform ease-in-out"
                              fill="none"
                              viewbox="0 0 24 24"
                              stroke="currentColor"
                            >
                              <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M9 5l7 7-7 7"
                              />
                            </svg>
                          </a>
                          <ul x-collapse x-show="expanded">
                              <li>
                              <a
                                href="{{ route('admin.settings')}}"
                                class="flex items-center justify-between p-2 text-xs+ tracking-wide text-slate-500 outline-none transition-[color,padding-left] duration-300 ease-in-out hover:pl-4 hover:text-slate-800 dark:text-navy-200 dark:hover:text-navy-50"
                              >
                                <div class="flex items-center space-x-2">
                                  <div
                                    class="h-1.5 w-1.5 rounded-full border border-current opacity-40"
                                  ></div>
                                  <span>Admin Settings</span>
                                </div>
                              </a>
                            </li>
                            <li>
                              <a
                                href="{{ route('admin.fraud_prevention')}}"
                                class="flex items-center justify-between p-2 text-xs+ tracking-wide text-slate-500 outline-none transition-[color,padding-left] duration-300 ease-in-out hover:pl-4 hover:text-slate-800 dark:text-navy-200 dark:hover:text-navy-50"
                              >
                                <div class="flex items-center space-x-2">
                                  <div
                                    class="h-1.5 w-1.5 rounded-full border border-current opacity-40"
                                  ></div>
                                  <span>Fraud Prevention</span>
                                </div>
                              </a>
                            </li>
                            <li>
                              <a
                                href="{{ route('admin.pages')}}"
                                class="flex items-center justify-between p-2 text-xs+ tracking-wide text-slate-500 outline-none transition-[color,padding-left] duration-300 ease-in-out hover:pl-4 hover:text-slate-800 dark:text-navy-200 dark:hover:text-navy-50"
                              >
                                <div class="flex items-center space-x-2">
                                  <div
                                    class="h-1.5 w-1.5 rounded-full border border-current opacity-40"
                                  ></div>
                                  <span>Pages</span>
                                </div>
                              </a>
                            </li>
                             <li>
                              <a
                                href="{{route('admin.postbacks')}}"
                                class="flex items-center justify-between p-2 text-xs+ tracking-wide text-slate-500 outline-none transition-[color,padding-left] duration-300 ease-in-out hover:pl-4 hover:text-slate-800 dark:text-navy-200 dark:hover:text-navy-50"
                              >
                                <div class="flex items-center space-x-2">
                                  <div
                                    class="h-1.5 w-1.5 rounded-full border border-current opacity-40"
                                  ></div>
                                  <span>Postbacks</span>
                                </div>
                              </a>
                            </li>
                              <li>
                              <a
                                href="{{ route('admin.file_resources')}}"
                                class="flex items-center justify-between p-2 text-xs+ tracking-wide text-slate-500 outline-none transition-[color,padding-left] duration-300 ease-in-out hover:pl-4 hover:text-slate-800 dark:text-navy-200 dark:hover:text-navy-50"
                              >
                                <div class="flex items-center space-x-2">
                                  <div
                                    class="h-1.5 w-1.5 rounded-full border border-current opacity-40"
                                  ></div>
                                  <span>Resources</span>
                                </div>
                              </a>
                            </li>
                          </ul>
                        </li>
                    
                  </ul>

                <div class="p-5">

                  <form method="POST" action="{{ route('admin.logout') }}" x-data>
                    @csrf
                      <button type="submit" name="logout" class="btn mt-2 w-full space-x-2 bg-error/10 font-medium text-error hover:bg-error/20 focus:bg-error/20 active:bg-error/25">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        <span>Logout</span>
                      </button>
                    </form>
                </div>
              </div>

          </div>
        </div>
        <div class=""
        @click="$store.global.isSidebarExpanded = false"
        :class="$store.global.isSidebarExpanded && 's-off'"
        >
      </div>
      </div>

      <!-- App Header Wrapper-->
      <nav class="header print:hidden">
        <!-- App Header  -->
        <div
          class="header-container relative flex w-full bg-white dark:bg-navy-750 print:hidden"
        >
          <!-- Header Items -->
          <div class="flex w-full items-center justify-between">
            <!-- Left: Sidebar Toggle Button -->
            <div class="navp">
                <div class="h-7 w-7" id="menu_bar">
                  <button
                    class="menu-toggle ml-0.5 flex h-7 w-7 flex-col justify-center space-y-1.5 text-primary outline-none focus:outline-none dark:text-accent-light/80"
                    :class="$store.global.isSidebarExpanded && 'active'"
                    @click="$store.global.isSidebarExpanded = !$store.global.isSidebarExpanded"
                  >
                    <span></span>
                    <span></span>
                    <span></span>
                  </button>
                </div>

                <a class="logo" href="{{url('/')}}">
                    <img style="height: 25px;" src="{{url($admin_data->profile_logo)}}" alt="">
                </a>
                  </div>

            <!-- Right: Header buttons -->
            <div class="-mr-1.5 flex items-center space-x-1">
              <!-- Mobile Search Toggle -->


              <!-- Main Searchbar -->
              <template x-if="$store.breakpoints.smAndUp">

              </template>

              <!-- Dark Mode Toggle -->
              <button
                @click="$store.global.isDarkModeEnabled = !$store.global.isDarkModeEnabled"
                class="btn h-8 w-8 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25"
              >
                <svg
                  x-show="$store.global.isDarkModeEnabled"
                  x-transition:enter="transition-transform duration-200 ease-out absolute origin-top"
                  x-transition:enter-start="scale-75"
                  x-transition:enter-end="scale-100 static"
                  class="h-6 w-6 text-amber-400"
                  fill="currentColor"
                  viewbox="0 0 24 24"
                >
                  <path
                    d="M11.75 3.412a.818.818 0 01-.07.917 6.332 6.332 0 00-1.4 3.971c0 3.564 2.98 6.494 6.706 6.494a6.86 6.86 0 002.856-.617.818.818 0 011.1 1.047C19.593 18.614 16.218 21 12.283 21 7.18 21 3 16.973 3 11.956c0-4.563 3.46-8.31 7.925-8.948a.818.818 0 01.826.404z"
                  />
                </svg>
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  x-show="!$store.global.isDarkModeEnabled"
                  x-transition:enter="transition-transform duration-200 ease-out absolute origin-top"
                  x-transition:enter-start="scale-75"
                  x-transition:enter-end="scale-100 static"
                  class="h-6 w-6 text-amber-400"
                  viewbox="0 0 20 20"
                  fill="currentColor"
                >
                  <path
                    fill-rule="evenodd"
                    d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"
                    clip-rule="evenodd"
                  />
                </svg>
              </button>

            </div>
          </div>
        </div>
      </nav>

      {{$slot}}


    </div>
    <div id="x-teleport-target"></div>
    <script>
      window.addEventListener("DOMContentLoaded", () => Alpine.start());
    </script>
  </body>
</html>

