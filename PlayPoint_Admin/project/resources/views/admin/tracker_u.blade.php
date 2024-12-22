<x-header>

    <!-- Main Content Wrapper -->
    <main class="main-content w-full px-[var(--margin-x)] pb-8">
      <div
        class="mt-8 grid grid-cols-1 gap-3 sm:mt-3 sm:gap-5 lg:mt-3 lg:gap-3"
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
        
          <div class="flex items-center justify-between">
              <h2 class="text-base font-medium tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100">
              User Tracker
              </h2>
              <div class="flex">
                <div class="flex items-center" x-data="{isInputActive:false}">
                  
                    
                     <a href="
                    {{url('/admin/edit/user', $uid)}}
                    " class="btn bg-info font-medium text-white hover:bg-info-focus focus:bg-info-focus active:bg-info-focus/90">
                    Edit/View User
                    </a>
               
                </div>

              </div>
            </div>

        <div class="card">
          <div class="is-scrollbar-hidden min-w-full overflow-x-auto">
            <table class="is-hoverable w-full text-left">
              <thead>
                <tr>
                  <th class="whitespace-nowrap rounded-tl-lg bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                    #
                  </th>
                  <th class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                    Transaction Type
                     </th>
                  <th class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                   USER ID
                  </th>
                   <th class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                   Coin
                  </th>
                  <th class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                    Date
                   </th>
                   <th class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                    IP
                   </th>
                  
                </tr>
              </thead>
              <tbody>
                @php $count = 0; @endphp
                @foreach ($userdata as $user)
                @php $count++; @endphp
                <tr class="border-y border-transparent border-b-slate-200 dark:border-b-navy-500">
                  <td class="whitespace-nowrap px-4 py-3 sm:px-5">{{$count}}</td>

                     <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                      {{$user->trans_from}}
                     </td>
                      <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                      <span class="text-primary">#{{$user->uid}}</span>
                     </td>
                  <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                   {{$user->amount}}
                  </td>
                  <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                    {{date('F j, Y, g:i a',$user->time)}}
                   </td>
                   <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                    {{$user->ip}}
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
