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
              <li>Refer Missions</li>
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
          <div>
            <div class="flex items-center justify-between">
              <h2 class="text-base font-medium tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100">
               Referral Missions
              </h2>
              <div class="flex">
                <div class="flex items-center" x-data="{isInputActive:false}">
                    <a href="{{ route('admin.csm_add_refer')}}"
                    class="btn bg-slate-150 font-medium text-slate-800 hover:bg-slate-200 focus:bg-slate-200 active:bg-slate-200/80 dark:bg-navy-500 dark:text-navy-50 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90"
                  >
                    Add Mission
                </a>
                </div>

              </div>
            </div>
            <div class="card mt-3">
              <div class="is-scrollbar-hidden min-w-full overflow-x-auto" x-data="pages.tables.initExample1">
                <table class="is-hoverable w-full text-left">
                  <thead>
                    <tr>
                      <th class="whitespace-nowrap rounded-tl-lg bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                        #
                      </th>
                      <th class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                        Coins
                      </th>
                      <th class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                        Refers
                      </th>
                      <th class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                        Status
                      </th>

                      <th class="whitespace-nowrap rounded-tr-lg bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                        Action
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                   @php $count = 0; @endphp
                   @foreach ($games as $game)
                   @php $count++; @endphp
                     <tr class="border-y border-transparent border-b-slate-200 dark:border-b-navy-500">
                        <td class="whitespace-nowrap px-4 py-3 sm:px-5">{{$count}}</td>
                        <td class="whitespace-nowrap px-4 py-3 sm:px-5">{{$game->coins}}</td>
                        <td class="whitespace-nowrap px-4 py-3 sm:px-5">{{$game->refers}}</td>
                        <td class="whitespace-nowrap px-4 py-3 sm:px-5">

                        @if ($game->status==0)
                        <div class="badge space-x-2.5 rounded-full bg-success/10 text-success dark:bg-success/15">
                        <div class="h-2 w-2 rounded-full bg-current"></div>
                        <span>Active</span>
                        </div>
                        @else
                        <div class="badge space-x-2.5 rounded-full bg-warning/10 text-warning dark:bg-warning/15">
                        <div class="h-2 w-2 rounded-full bg-current"></div>
                        <span>Deactive</span>
                        </div>
                        @endif

                        </td>
                        <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                        <a href="{{route('admin.edit_refer', $game->id)}}"
                            class="btn h-7 rounded bg-primary px-3 text-xs font-medium text-white
                            hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90" >
                            <i class="fa-regular fa-pen-to-square mr-1"></i> Edit
                        </a>
                        <a href="{{route('admin.csm_delete_refer',$game->id)}}"
                            class="btn h-7 rounded bg-error px-3 text-xs font-medium text-white
                            hover:bg-error-focus csm-delete-confirmation focus:bg-error-focus active:bg-error-focus/90" >
                            <i class="fa-regular fa-trash-can mr-1"></i> Delete
                        </a>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>

              <div class="flex flex-col justify-between space-y-4 px-4 py-4 sm:flex-row sm:items-center sm:space-y-0 sm:px-5">

             {{$games->links()}}

            </div>
            </div>
          </div>
    </main>

</x-header>
