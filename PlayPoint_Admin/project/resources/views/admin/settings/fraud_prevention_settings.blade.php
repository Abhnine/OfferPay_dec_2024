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
              <li>Fraud Prevention</li>
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
        <style>
            .app-i i{
            font-size: 21px;
            }
        </style>


        <div class="mt-3">


            <div class="card col-span-12 sm:col-span-6">
                <form method="POST" action="{{ route('admin.up_fraud_prevention') }}" id="up_fraud_prevention">
                    @csrf
                <div
                    class="flex flex-col items-center space-y-4 border-b border-slate-200 p-4 dark:border-navy-500 sm:flex-row sm:justify-between sm:space-y-0 sm:px-5">
                    <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100">
                        Fraud Prevention
                    </h2>
                    <div class="flex justify-center space-x-2">
                        <button form="up_fraud_prevention" type="submit"
                            class="btn min-w-[7rem] bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                            <i class="fa-regular fa-check-circle"></i> <span class="ml-2"> Apply Changes </span>
                        </button>
                    </div>
                </div>

                <div class="app-i p-4 sm:p-5">
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 mt-4">
                      
                  <div class="flex items-center justify-between space-x-2 rounded-lg border border-slate-200 p-3 dark:border-navy-600">
                    <div class="flex items-center space-x-3">
                      <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-lg bg-primary text-white dark:bg-navy-450 dark:text-navy-100">
                       <i class="fa-solid fa-mobile-screen-button"></i>
                      </div>
                      <div>
                        <p class="font-medium text-slate-700 dark:text-navy-100">
                          Single account per device
                        </p>
                        <p class="mt-0.5 text-xs line-clamp-1">Users can't open more than 1 account from a device.</p>
                      </div>
                    </div>
                     <input
                      class="form-switch h-5 w-10 rounded-lg bg-slate-300 before:rounded-md before:bg-slate-50 checked:bg-primary checked:before:bg-white dark:bg-navy-900 dark:before:bg-navy-300 dark:checked:bg-accent dark:checked:before:bg-white"
                      type="checkbox"
                      name="one_device"
                      id="o_device"
                      @if ($setting_data->one_device==0)
                      checked
                      value="{{ $setting_data->one_device }}"
                      @endif
                    />
                  </div>
                       
                    <div class="flex items-center justify-between space-x-2 rounded-lg border border-slate-200 p-3 dark:border-navy-600">
                    <div class="flex items-center space-x-3">
                      <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-lg bg-primary text-white dark:bg-navy-450 dark:text-navy-100">
                        <i class="fa-solid fa-user-slash"></i>
                      </div>
                      <div>
                        <p class="font-medium text-slate-700 dark:text-navy-100">
                          Block VPN access
                        </p>
                        <p class="mt-0.5 text-xs line-clamp-1">Users can not open application using VPN.</p>
                      </div>
                    </div>
                    <input
                      class="vpn form-switch h-5 w-10 rounded-lg bg-slate-300 before:rounded-md before:bg-slate-50 checked:bg-primary checked:before:bg-white dark:bg-navy-900 dark:before:bg-navy-300 dark:checked:bg-accent dark:checked:before:bg-white"
                      type="checkbox"
                      id="vpn"
                      name="vpn"
                      @if ($setting_data->vpn==0)
                      checked
                      value="{{ $setting_data->vpn }}"
                      @endif
                    />
                  </div>
                       
                    <div class="flex items-center justify-between space-x-2 rounded-lg border border-slate-200 p-3 dark:border-navy-600">
                    <div class="flex items-center space-x-3">
                      <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-lg bg-primary text-white dark:bg-navy-450 dark:text-navy-100">
                        <i class="fa-solid fa-user-slash"></i>
                      </div>
                      <div>
                        <p class="font-medium text-slate-700 dark:text-navy-100">
                           Auto ban VPN user
                        </p>
                        <p class="mt-0.5 text-xs line-clamp-1">Auto ban who attempts to use VPN connection.</p>
                      </div>
                    </div>
                    <input
                      class="vpn form-switch h-5 w-10 rounded-lg bg-slate-300 before:rounded-md before:bg-slate-50 checked:bg-primary checked:before:bg-white dark:bg-navy-900 dark:before:bg-navy-300 dark:checked:bg-accent dark:checked:before:bg-white"
                      type="checkbox"
                      id="vpn_ban"
                      name="vpn_ban"
                      @if ($setting_data->vpn_ban==0)
                      checked
                      value="{{ $setting_data->vpn_ban }}"
                      @endif
                    />
                  </div>
                  
                <div class="flex items-center justify-between space-x-2 rounded-lg border border-slate-200 p-3 dark:border-navy-600">
                    <div class="flex items-center space-x-3">
                      <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-lg bg-primary text-white dark:bg-navy-450 dark:text-navy-100">
                        <i class="fa-brands fa-android"></i>
                      </div>
                      <div>
                        <p class="font-medium text-slate-700 dark:text-navy-100">
                          Developer Mode Prevent
                        </p>
                        <p class="mt-0.5 text-xs line-clamp-1">App not work in developer mode (Release Mode Only).</p>
                      </div>
                    </div>
                    <input
                      class="vpn form-switch h-5 w-10 rounded-lg bg-slate-300 before:rounded-md before:bg-slate-50 checked:bg-primary checked:before:bg-white dark:bg-navy-900 dark:before:bg-navy-300 dark:checked:bg-accent dark:checked:before:bg-white"
                      type="checkbox"
                      id="devOption"
                      name="devOption"
                      @if ($setting_data->devOption==0)
                      checked
                      value="{{ $setting_data->devOption }}"
                      @endif
                    />
                  </div>
                  
                       </div>
                   </div>
                </form>

            </div>


        </div>

    </main>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script>
$("#vpn").on('change', function() {
  if ($(this).is(':checked')) {
    $(this).attr('value', '0');
  } else {
    $(this).attr('value', '1');
  }
});

$("#o_device").on('change', function() {
  if ($(this).is(':checked')) {
    $(this).attr('value', '0');
  } else {
    $(this).attr('value', '1');
  }
});
$("#vpn_ban").on('change', function() {
  if ($(this).is(':checked')) {
    $(this).attr('value', '0');
  } else {
    $(this).attr('value', '1');
  }
});

$("#devOption").on('change', function() {
  if ($(this).is(':checked')) {
    $(this).attr('value', '0');
  } else {
    $(this).attr('value', '1');
  }
});
</script>
</x-header>
