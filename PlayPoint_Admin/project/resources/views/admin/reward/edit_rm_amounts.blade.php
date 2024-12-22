<x-header>

    <!-- Main Content Wrapper -->
    <main class="main-content w-full px-[var(--margin-x)] pb-8">
      <div
        class="mt-4 grid grid-cols-1 gap-4 sm:mt-5 sm:gap-5 lg:mt-6 lg:gap-6"
      >

        <div class="mt-4 grid grid-cols-1 gap-4 sm:mt-5 sm:gap-5 lg:mt-6 lg:gap-6">

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
                @if ($errors->any())
                <div class="alert flex rounded-lg bg-error px-4 py-4 text-white sm:px-5 sess_msg">
                @foreach ($errors->all() as $error)
                {{ $error }}<br>
                @endforeach
                </div>
                @endif

                <div class="flex items-center justify-between mt-2">
                    <h5 class="text-medium font-medium text-slate-800 dark:text-navy-50">
                      Add Redeem Amount
                    </h5>

                  </div>

            <form method="POST" action="" id="myform" enctype="multipart/form-data">
              @csrf
              <div class="col-span-12 grid lg:col-span-8">
                  <div class="card">
                    <div class="border-b border-slate-200 p-4 dark:border-navy-500 sm:px-5">
                      <div class="flex items-center space-x-2">

                          <h4 class="text-lg font-medium text-slate-700 dark:text-navy-100">
                          Add
                        </h4>
                      </div>
                    </div>
                    <div class="space-y-4 p-4 sm:p-5">
                      <label class="block">
                          <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">

                             <label class="block">
                                <span>Amount</span>
                                <span class="relative mt-1.5 flex">
                                  <input
                                  name="amount"
                                  class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                  placeholder="$" type="number">
                                  <span class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                      <i class="fa-solid fa-trophy"></i>
                                  </span>
                                </span>
                              </label>

                              <label class="block">
                                <span>Coins</span>
                                <span class="relative mt-1.5 flex">
                                  <input
                                  name="coins"
                                  class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                  placeholder="©" type="number">
                                  <span class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                      <i class="fa-solid fa-trophy"></i>
                                  </span>
                                </span>
                              </label>

                            </div>
                      </label>

                      <div class="flex justify-center space-x-2 pt-4">
                      <a href="{{ route('admin.redeem_methods') }}"
                       class="btn space-x-2 bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus
                       active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                       <i class="fa-solid fa-arrow-left"></i> &nbsp;&nbsp;Back
                      </a>

                      <button type="submit" class="btn space-x-2 bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                      <span>Add</span>
                      </button>
                      </div>

                    </div>
                  </div>
                </div>
            </form>

            </div>

        <div class="flex items-center justify-between mt-2">
            <h5 class="text-medium font-medium text-slate-800 dark:text-navy-50">
              All Redeem Amount Lists
            </h5>

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
                    amount
                    </th>
                    <th class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                        Coins
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
                @php
                $tmp = App\Models\rewards::find($user->r_id);
                @endphp
                @php $count++; @endphp
                <tr class="border-y border-transparent border-b-slate-200 dark:border-b-navy-500">
                  <td class="whitespace-nowrap px-4 py-3 sm:px-5">{{$count}}</td>
                  <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                   {{ $tmp->symbol }}{{ $user->amount }}
                 </td>
                  <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                     {{ $user->coins }}
                 </td>
                  <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                    <p class="font-medium">{{date('jS F Y', strtotime($user->created_at))}} </p>
                    </td>
                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                        <div class="badge space-x-2.5 px-0 text-success">
                            <div class="h-2 w-2 rounded-full bg-current"></div>
                            <span>Active</span>
                        </div>
                    </td>

                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                    <a href="{{route('admin.delete_rm_amounts', $user->id)}}"
                    class="btn h-6 rounded bg-error px-3 text-xs font-medium text-white
                    hover:bg-error-focus focus:bg-error-focus active:bg-error-focus/90" >
                    <i class="fa-solid fa-trash mr-1"></i> Delete
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
