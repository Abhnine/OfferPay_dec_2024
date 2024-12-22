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
              <li>Users</li>
            </ul>
          </div>

            @if(session('status-success'))
          <div class="alert flex rounded-lg bg-error px-4 py-4 text-white sm:px-5 mb-3 sess_msg">
          {{ session('status-success') }}
          </div>
          @endif

          <div>
            <div class="flex items-center justify-between">
              <h2 class="text-base font-medium tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100">
                Users Table
              </h2>
              <div class="flex">
                <div class="flex items-center" x-data="{isInputActive:false}">
                   <form action="" method="GET">
                    <div class="relative flex -space-x-px">
                        <input class="form-input peer w-full rounded-l-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:z-10 hover:border-slate-400 focus:z-10 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                        placeholder="User ID, Name, Email ..." type="text"
                        id="search"
                        required="">
                        <a OnClick="searching();" class="btn rounded-l-none bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90"
                       > Search </a>
                      </div>
                  
                </div>

              </div>
            </div>
            <div class="card mt-3">
              <div class="is-scrollbar-hidden min-w-full overflow-x-auto" x-data="pages.tables.initExample1">
                <table class="is-hoverable w-full text-left">
                  <thead>
                    <tr>
                      <th class="whitespace-nowrap rounded-tl-lg bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                        User id
                      </th>
                      <th class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                        Avatar
                      </th>
                      <th class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                        Name
                      </th>
                      <th class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                        Points
                      </th>
                      <th class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                        Referrals
                      </th>
                      <th class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                        Conutry
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
                   @foreach ($users as $user)
                   @php $count++; @endphp
                     <tr class="border-y border-transparent border-b-slate-200 dark:border-b-navy-500">
                    
                        <td class="whitespace-nowrap px-4 py-3 sm:px-5 font-medium text-primary dark:text-accent-light">{{$user->id}}</td>

                        <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                          <div class="avatar flex h-10 w-10">
                            <img class="mask is-squircle" alt="avatar" src="{{$user->profile}}">
                          </div>
                        </td>
                        <td class="whitespace-nowrap px-3 py-3 font-medium text-slate-700 dark:text-navy-100 lg:px-5"><a href="{{url('/admin/edit/user', $user->id)}}" class="text-primary">{{$user->name}}</a></td>
                        <td class="whitespace-nowrap px-4 py-3 sm:px-5">{{$user->points}}</td>
                        <td class="whitespace-nowrap px-4 py-3 sm:px-5">{{$user->t_ref}}</td>
                        <td class="whitespace-nowrap px-4 py-3 sm:px-5"><img class="h-5" src="http://purecatamphetamine.github.io/country-flag-icons/3x2/{{ $user->country.".svg" }}"></td>

                        <td class="whitespace-nowrap px-4 py-3 sm:px-5">

                        @if ($user->status==0)
                        <div class="badge space-x-2.5 rounded-full bg-success/10 text-success dark:bg-success/15">
                        <div class="h-2 w-2 rounded-full bg-current"></div>
                        <span>Active</span>
                        </div>
                        @else
                        <div class="badge space-x-2.5 rounded-full bg-error/10 text-error dark:bg-error/15">
                        <div class="h-2 w-2 rounded-full bg-current"></div>
                        <span>Blocked</span>
                        </div>
                        @endif

                         </td>
                         <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                          <div x-data="usePopper({placement:'bottom-end',offset:4})" @click.outside="if(isShowPopper) isShowPopper = false" class="inline-flex">
                            <button x-ref="popperRef" @click="isShowPopper = !isShowPopper" class="btn h-8 w-8 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
                              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"></path>
                              </svg>
                            </button>

                            <div x-ref="popperRoot" class="popper-root" :class="isShowPopper &amp;&amp; 'show'" style="position: fixed; inset: 0px 0px auto auto; margin: 0px; transform: translate(366px, 260px);" data-popper-placement="bottom-end" data-popper-reference-hidden="" data-popper-escaped="">
                              <div class="popper-box rounded-md border border-slate-150 bg-white py-1.5 font-inter dark:border-navy-500 dark:bg-navy-700">
                                <ul>
                                  <li>
                                  <a href="{{url('/admin/edit/user', $user->id)}}" class="flex h-8 items-center px-3 pr-8 font-medium tracking-wide outline-none transition-all hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">Edit</a>
                                  </li>
                                  <li>
                                  </li>
                                  <li>
                                    @if ($user->status=="0")
                                    <a href="{{url('/admin/user-status/')}}/{{$user->id}}/1" class="flex h-8 items-center px-3 pr-8 font-medium tracking-wide outline-none
                                    transition-all hover:bg-slate-100 hover:text-slate-800 csm-block focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100
                                     dark:focus:bg-navy-600 dark:focus:text-navy-100">Block</a>
                                    @else
                                    <a href="{{url('/admin/user-status/')}}/{{$user->id}}/0" class="flex h-8 items-center px-3 pr-8 font-medium tracking-wide outline-none
                                    transition-all hover:bg-slate-100 hover:text-slate-800 csm-unblock focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100
                                    dark:focus:bg-navy-600 dark:focus:text-navy-100">UnBlock</a>
                                    @endif
                                  </li>
                                </ul>
                                <div class="my-1 h-px bg-slate-150 dark:bg-navy-500"></div>
                                <ul>
                                <li>
                                <a href="{{url('/admin/tracker/'.$user->id)}}" class="flex h-8 items-center space-x-3 px-3 pr-8 font-medium tracking-wide outline-none transition-all hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="mt-px h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    <span style="margin-left:4px;">Track</span></a>
                                  </li>
                                </ul>
                              </div>
                            </div>
                          </div>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>

              <div class="flex flex-col justify-between space-y-4 px-4 py-4 sm:flex-row sm:items-center sm:space-y-0 sm:px-5">

                {{$users->links()}}

              </div>
            </div>
          </div>
    </main>
    <script>
    function searching(){
    var url = document.getElementById("search").value;
    if(!url){}else{
    window.location.replace("{{url('/admin/user/search')}}/"+url);
    }
    }
    </script>
</x-header>
