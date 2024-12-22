<x-header>
    <main class="main-content w-full px-[var(--margin-x)] pb-8">
        <div class="flex items-center space-x-4 py-5 lg:py-6">
            <h2 class="text-xl font-medium text-slate-800 dark:text-navy-50 lg:text-2xl">
              Admin
            </h2>
            <div class="hidden h-full py-1 sm:flex">
              <div class="h-full w-px bg-slate-300 dark:bg-navy-600"></div>
            </div>
            <ul class="hidden flex-wrap items-center space-x-2 sm:flex">
              <li class="flex items-center space-x-2">
                <a class="text-primary transition-colors hover:text-primary-focus dark:text-accent-light dark:hover:text-accent" href="{{ route('admin.dashboard');}}">
                Home</a>
                <svg x-ignore="" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
              </li>
              <li>Settings</li>
            </ul>
          </div>

        @foreach ($errors->all() as $error)
            <div class="alert flex rounded-lg bg-error px-4 py-4 text-white sm:px-5 sess_msg mb-3">
                {{ $error }}
            </div>
            <br>
        @endforeach

        @if (session('status-alert'))
            <div class="alert flex rounded-lg bg-error px-4 py-4 text-white sm:px-5 sess_msg mb-3">
                {{ session('status-alert') }}
            </div>
            <br>
        @elseif (session('status-success'))
            <div class="alert flex rounded-lg bg-success px-4 py-4 text-white sm:px-5 mb-3 sess_msg mb-3">
                {{ session('status-success') }}
            </div>
            <br>
        @else
        @endif

        <div class="mt-3">
            
            
          <div x-data="{activeTab:'admin'}" class="tabs flex flex-col">
            <div
              class="is-scrollbar-hidden overflow-x-auto rounded-lg bg-slate-200 text-slate-600 dark:bg-navy-800 dark:text-navy-200"
            >
              <div class="tabs-list flex px-1.5 py-1">
                <button
                  @click="activeTab = 'admin'"
                  :class="activeTab === 'admin' ? 'bg-white shadow dark:bg-navy-500 dark:text-navy-100' : 'hover:text-slate-800 focus:text-slate-800 dark:hover:text-navy-100 dark:focus:text-navy-100'"
                  class="btn shrink-0 space-x-2 px-3 py-1.5 font-medium"
                >
                <i class="fa-solid fa-user-tie"></i>
                  <span>Manage Admin</span>
                </button>
                <button
                  @click="activeTab = 'config'"
                  :class="activeTab === 'config' ? 'bg-white shadow dark:bg-navy-500 dark:text-navy-100' : 'hover:text-slate-800 focus:text-slate-800 dark:hover:text-navy-100 dark:focus:text-navy-100'"
                  class="btn shrink-0 space-x-2 px-3 py-1.5 font-medium"
                >
                 <i class="fa-solid fa-gear"></i>
                  <span>App Configuration</span>
                </button>
              </div>
            </div>
            
            <!--tabs-->
            <div class="tab-content pt-4">
             
              <div
                x-show="activeTab === 'admin'"
                x-transition:enter="transition-all duration-500 easy-in-out"
                x-transition:enter-start="opacity-0 [transform:translate3d(1rem,0,0)]"
                x-transition:enter-end="opacity-100 [transform:translate3d(0,0,0)]"
              >
                           <div class="card col-span-12 sm:col-span-6">
                <div
                    class="flex flex-col items-center space-y-4 border-b border-slate-200 p-4 dark:border-navy-500 sm:flex-row sm:justify-between sm:space-y-0 sm:px-5">
                    <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100">
                        Admin Details
                    </h2>
                    <div class="flex justify-center space-x-2">
                        <button form="myform" type="submit"
                            class="btn min-w-[7rem] bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                            <i class="fa-regular fa-check-circle"></i><span class="ml-2"> Apply Changes </span>
                        </button>
                    </div>
                </div>
                <form method="POST" action="" id="myform" enctype="multipart/form-data">
                    @csrf
                    <div class="p-4 sm:p-5">
                        <div class="flex gap-4 items-center">
                        <div class="flex flex-col">
                            <span class="text-base font-medium text-slate-600 dark:text-navy-100">Avatar</span>
                            <div class="avatar mt-1.5 h-20 w-20">
                                <img class="mask is-squircle" src="{{ url($admin_data->profile_image) }}" alt="avatar">
                                <div
                                    class="absolute bottom-0 right-0 flex items-center justify-center rounded-full bg-white dark:bg-navy-700">

                                    <label
                                        class="btn h-6 w-6 rounded-full border border-slate-200 p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:border-navy-500 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
                                        <input tabindex="-1" type="file" name="profile"
                                            class="pointer-events-none absolute inset-0 h-full w-full opacity-0" />
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5"
                                            viewBox="0 0 20 20" fill="currentColor">
                                            <path
                                                d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z">
                                            </path>
                                        </svg>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <style>
                        .imglogo___{
                        padding: 12px;
                        border-radius: 10px;
                        border: solid 1px #ccc;
                        background: #f1f1f1;
                        height: 50px !important;
                        }
                        </style>
                        <div>
                        <span class="text-base font-medium text-slate-600 dark:text-navy-100">Logo</span>
                        <img class="mt-2 imglogo___" src="{{ url($admin_data->profile_logo) }}" alt="avatar">
                        </div>
                        </div>
                        
                        <div class="mb-3 mt-4 h-px bg-slate-200 dark:bg-navy-500"></div>
                        
                        <label class="block mt-3">
                        <span>Logo</span>
                        <input class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent" placeholder="Upload Image" type="file" name="csmimage">
                      </label>
                        
                        <div class="mb-3 mt-4 h-px bg-slate-200 dark:bg-navy-500"></div>

                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 mt-4">
                            <label class="block">
                                <span>Display name </span>
                                <span class="relative mt-1.5 flex">
                                    <input
                                        class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                        placeholder="Enter name" type="text" name="name"
                                        value="{{ $admin_data->name }}">
                                    <span
                                        class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                        <i class="fa-regular fa-user text-base"></i>
                                    </span>
                                </span>
                            </label>
                            <label class="block">
                                <span>Email Address </span>
                                <span class="relative mt-1.5 flex">
                                    <input
                                        class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                        placeholder="Enter email address" type="text" name="email"
                                        value="{{ $admin_data->email }}">
                                    <span
                                        class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                        <i class="fa-regular fa-envelope text-base"></i>
                                    </span>
                                </span>
                            </label>

                            <label class="block">
                                <span>Password</span>
                                <span class="relative mt-1.5 flex">
                                    <input
                                        class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                        placeholder="" type="password" name="new_password" value="">
                                    <span
                                        class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                        <i class="fa-solid fa-lock"></i>
                                    </span>
                                </span>
                            </label>
                            <label class="block">
                                <span>Confirm Password</span>
                                <span class="relative mt-1.5 flex">
                                    <input
                                        class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                        placeholder="" type="password" name="new_confirm_password" value="">
                                    <span
                                        class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                        <i class="fa-solid fa-lock"></i>
                                    </span>
                                </span>
                            </label>

                        </div>

                        <br>
                    </div>
                </form>
             </div>
              </div>
              <div
                x-show="activeTab === 'config'"
                x-transition:enter="transition-all duration-500 easy-in-out"
                x-transition:enter-start="opacity-0 [transform:translate3d(1rem,0,0)]"
                x-transition:enter-end="opacity-100 [transform:translate3d(0,0,0)]"
              >
              <div class="card col-span-12 pb-4 sm:col-span-6">
                <div class="flex flex-col items-center space-y-4 border-b border-slate-200 p-4 dark:border-navy-500 sm:flex-row sm:justify-between sm:space-y-0 sm:px-5">
                    <h5 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100">
                     Configuration
                    </h5>
                    <div class="flex justify-center space-x-2">
                        <button form="app-myform_csm" type="submit" class="btn min-w-[7rem] bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                            <i class="fa-regular fa-check-circle"></i> <span class="ml-2"> Apply Changes </span>
                        </button>
                    </div>
                </div>
                <div class="p-4 sm:p-5">

                  <form method="POST" action="{{route('admin.app_mode')}}" id="app-myform_csm">
                   @csrf    
                    
                  <label class="block">
                    <span>App Mode</span>
                     <select name="app_mode" class="form-select mt-1.5 w-full rounded-lg bg-slate-150 px-3 py-2 ring-primary/50 hover:bg-slate-200 focus:ring dark:bg-navy-900/90 dark:ring-accent/50 dark:hover:bg-navy-900 dark:focus:bg-navy-900">
                     <option value="0" @if(env('APP_ENV')=="local") selected @endif>Development</option>
                      <option value="1" @if(env('APP_ENV')=="production") selected @endif>Production</option>
                     </select>
                   </label>
                  
                   <label class="block mt-3">
                    <span>Admin Panel Debug Mode</span>
                     <select name="debug_mode" class="form-select mt-1.5 w-full rounded-lg bg-slate-150 px-3 py-2 ring-primary/50 hover:bg-slate-200 focus:ring dark:bg-navy-900/90 dark:ring-accent/50 dark:hover:bg-navy-900 dark:focus:bg-navy-900">
                     <option value="1" @if(env('APP_DEBUG')==true) selected @endif>Debug</option>
                      <option value="0" @if(env('APP_DEBUG')==false) selected @endif>Production</option>
                     </select>
                   </label>
                  
                   <label class="block mt-3">
                    <span>APP URL</span>
                    <span class="relative flex">
                    <input class="form-input mt-1.5 w-full rounded-lg bg-slate-150 px-3 py-2 ring-primary/50 placeholder:text-slate-400 hover:bg-slate-200 focus:ring dark:bg-navy-900/90 dark:ring-accent/50 dark:placeholder:text-navy-300 dark:hover:bg-navy-900 dark:focus:bg-navy-900" value="{{env('APP_URL')}}" type="url" name="app_url">
                    </span>
                   </label>
                   </div>
                   </div>
                   
                   <div class="card col-span-12 pb-4 sm:col-span-6 mt-5">
                    <div class="flex flex-col items-center space-y-4 border-b border-slate-200 p-4 dark:border-navy-500 sm:flex-row sm:justify-between sm:space-y-0 sm:px-5">
                    <h5 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100">
                     One Signal Configuration
                    </h5>
                    <div class="flex justify-center space-x-2">
                        <button form="app-myform_csm" type="submit" class="btn min-w-[7rem] bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                            <i class="fa-regular fa-check-circle"></i> <span class="ml-2"> Apply Changes </span>
                        </button>
                    </div>
                </div>
                    <div class="p-4 sm:p-5">
                   <label class="block mt-3">
                    <span>Onesignal App ID</span>
                    <span class="relative flex">
                    <input class="form-input mt-1.5 w-full rounded-lg bg-slate-150 px-3 py-2 ring-primary/50 placeholder:text-slate-400 hover:bg-slate-200 focus:ring dark:bg-navy-900/90 dark:ring-accent/50 dark:placeholder:text-navy-300 dark:hover:bg-navy-900 dark:focus:bg-navy-900" value="{{env('ONESIGNAL_APP_ID')}}" type="text" name="one_app_id">
                    </span>
                   </label>
                   
                   <label class="block mt-3">
                    <span>Onesignal rest api key</span>
                    <span class="relative flex">
                    <input class="form-input mt-1.5 w-full rounded-lg bg-slate-150 px-3 py-2 ring-primary/50 placeholder:text-slate-400 hover:bg-slate-200 focus:ring dark:bg-navy-900/90 dark:ring-accent/50 dark:placeholder:text-navy-300 dark:hover:bg-navy-900 dark:focus:bg-navy-900" value="{{env('ONESIGNAL_REST_API_KEY')}}" type="text" name="one_rest_key">
                    </span>
                   </label>
                   </div>
                   </div>

                </form>
              
                
              </div>
              
     
            </div>
          </div>

        </div>

    </main>

</x-header>
