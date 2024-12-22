<x-header>

    <!-- Main Content Wrapper -->
    <main class="main-content w-full px-[var(--margin-x)] pb-8">
      <div
        class="mt-4 grid grid-cols-1 gap-4 sm:mt-5 sm:gap-5 lg:mt-6 lg:gap-6"
      >
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

        <div class="flex items-center justify-between mt-2">
            <h3 class="text-xl font-medium text-slate-800 dark:text-navy-50">
              All Redeem Methods
            </h3>
            <a href="{{ route('admin.add_rm_method') }}"
            class="btn space-x-2 bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus
            active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
            <span>Add Redeem</span>
            </a>
          </div>

        <div class="card">
          <div class="is-scrollbar-hidden min-w-full overflow-x-auto">
            <table class="is-hoverable w-full text-left">
              <thead>
                <tr>
                  <th class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                    #
                  </th>
                  <th class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                    Redeem Name
                    </th>
                    <th class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                        Availble redeems
                        </th>
                    <th class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                     Date
                    </th>
                  <th class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                    Status
                   </th>
                  <th class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                    Action
                  </th>
                </tr>
              </thead>
              <tbody>
                @php $count = 0; @endphp
                @foreach ($userdata as $user)
                @php $count++; @endphp
                <tr class="border-y border-transparent border-b-slate-200 dark:border-b-navy-500">
                  <td class="whitespace-nowrap px-4 py-3 sm:px-5">{{$count}}</td>
                  <td class="whitespace-nowrap px-4 py-3 font-medium text-slate-700 dark:text-navy-100 sm:px-5">
                   <a href="#" class="flex items-center space-x-2 text-xs hover:text-slate-800 dark:hover:text-navy-100">
                    <div class="avatar h-10 w-20">
                      <img class="rounded-lg" src="{{ url($user->image)}}" alt="avatar">
                    </div>
                    <span class="line-clamp-1">{{ $user->name }}</span>
                  </a>

                  </td>
                  <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                    @php
                    $all_count = DB::select(DB::raw("SELECT id FROM reward_amounts WHERE r_id = '$user->id'"));
                    @endphp
                    {{ count($all_count) }}
                 </td>
                  <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                    <p class="font-medium">{{date('jS F Y', strtotime($user->created_at))}} </p>
                    </td>
                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                    @if ($user->status=="1")
                    <div class="badge space-x-2.5 px-0 text-error">
                        <div class="h-2 w-2 rounded-full bg-current"></div>
                        <span>Disable</span>
                    </div>
                    @else
                    <div class="badge space-x-2.5 px-0 text-success">
                        <div class="h-2 w-2 rounded-full bg-current"></div>
                        <span>Enable</span>
                    </div>
                    @endif
                    </td>

                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                    <a href="{{route('admin.edit_rm_amounts', $user->id)}}"
                    class="btn h-7 rounded bg-info px-3 text-xs font-medium text-white
                    hover:bg-info-focus focus:bg-info-focus active:bg-info-focus/90" >
                    <i class="fa-solid fa-dollar-sign mr-1"></i> Add Amounts
                    </a>
                    <a href="{{route('admin.edit_rm', $user->id)}}"
                    class="btn h-7 rounded bg-primary px-3 text-xs font-medium text-white
                    hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90" >
                    <i class="fa-regular fa-pen-to-square mr-1"></i> Edit
                    </a>
                    <a href="{{route('admin.delete_rm', $user->id)}}"
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
              {{$userdata->links()}}
          </div>
        </div>

      </div>
    </main>

</x-header>
