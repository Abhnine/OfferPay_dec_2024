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
                  <li>Uploaded Resources</li>
                </ul>
              </div>
              @if(session('status-alert'))
              <div class="alert flex rounded-lg bg-error px-4 py-4 text-white sm:px-5 sess_msg">
              {{ session('status-alert') }}
              </div>
              @elseif (session('status-success'))
              <div class="alert flex rounded-lg bg-success px-4 py-4 text-white sm:px-5 mb-3 sess_msg">
                {{ session('status-success') }}
              </div>
              @else

              @endif

                <div class="card mt-3">
                    <div class="is-scrollbar-hidden min-w-full overflow-x-auto" x-data="pages.tables.initExample1">
                      <table class="is-hoverable w-full text-left">
                        <thead>
                          <tr>
                            <th class="whitespace-nowrap rounded-tl-lg bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                              #
                            </th>
                            <th class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                              Image
                            </th>
                            <th class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                              Image Name
                            </th>
                            <th class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                              Delete
                            </th>
                          </tr>
                        </thead>
                        <tbody>
                            @php $count = 0; @endphp
                            @foreach(File::glob('images/csm/*') as $path)
                            @php $count++; @endphp
                            <tr class="border-y border-transparent border-b-slate-200 dark:border-b-navy-500">
                                <td class="whitespace-nowrap px-4 py-3 sm:px-5">{{$count}}</td>
                                <td class="whitespace-nowrap px-4 py-3 sm:px-5">

                                   <div class="avatar h-24 w-24">
                                       <img class="rounded-lg" src="{{ url(str_replace(public_path(), '', $path)); }}" alt="avatar">
                                     </div>
                                   </td>
                                <td class="whitespace-nowrap px-4 py-3 sm:px-5">{{ str_replace('images/csm/', '', $path) }}</td>
                                <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                 <a href="{{ route('admin.del_file_resources',str_replace('images/csm/', '', $path)) }}" class="btn h-9 w-9 p-0 font-medium text-error csm-delete-confirmation hover:bg-error/20 focus:bg-error/20 active:bg-error/25">
                                   <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                   </svg>
                               </a>
                               </td>
                               </tr>
                               @endforeach

                        </tbody>
                      </table>
                    </div>


                  </div>

              </div>
        </main>

    </x-header>
