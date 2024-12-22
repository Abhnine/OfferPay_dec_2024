<x-header>

    <!-- Main Content Wrapper -->
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
                    <a class="text-primary transition-colors hover:text-primary-focus dark:text-accent-light dark:hover:text-accent"
                        href="{{ route('admin.dashboard') }}">
                        Dashboard</a>

                </li>
            </ul>
        </div>


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


        <div class="grid grid-cols-12 gap-4 sm:mt-1 sm:gap-5 lg:mt-1 lg:gap-1 mt-0">
            <div class="col-span-12 space-y-4 sm:space-y-5 lg:col-span-8 lg:space-y-6">


                <div class="">

                    <div class="grid grid-cols-1 gap-4 sm:col-span-2 sm:grid-cols-3 sm:gap-5 lg:gap-6">

                        <div class="card flex-row justify-between p-4 sm:p-5">
                            <div>
                                <p class="text-base font-medium text-slate-700 dark:text-navy-100">
                                    Today's Coins
                                </p>
                                <div>
                                    <div class="mt-4 flex items-baseline space-x-1">
                                        <p class="text-2xl font-semibold text-slate-700 dark:text-navy-100">
                                            {{ $earn_today }}
                                        </p>
                                    </div>
                                    <p class="text-xs+">today's coins earn by users</p>
                                </div>
                            </div>
                            <div class="mask is-squircle flex h-10 w-10 items-center justify-center bg-warning/10">
                                <i class="fa fa-gift text-xl text-warning"></i>
                            </div>
                            <div class="absolute bottom-0 right-0 overflow-hidden rounded-lg">
                                <i class="fa fa-gift translate-x-1/4 translate-y-1/4 text-5xl opacity-15"></i>
                            </div>
                        </div>

                        <div class="card justify-center p-4.5">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-base font-semibold text-slate-700 dark:text-navy-100">
                                        {{ shorten($t_points); }}
                                    </p>
                                    <p class="text-xs+ line-clamp-1">Total Coins</p>
                                </div>
                                <div
                                    class="mask is-star flex h-10 w-10 shrink-0 items-center justify-center bg-success">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z">
                                        </path>
                                    </svg>
                                </div>
                            </div>
                            <div>
                                @if($coi_to_grf>$coi_yes_grf)
                                <div
                                    class="badge mt-2 space-x-1 bg-success/10 py-1 px-1.5 text-success dark:bg-success/15">
                                    <span>{{ shorten($coi_to_grf); }}</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                @else
                                <div
                                    class="badge mt-2 space-x-1 bg-error/10 py-1 px-1.5 text-error dark:bg-error/15">
                                    <span>{{ shorten($coi_to_grf); }}</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 one80d" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                @endif

                            </div>
                        </div>
                        <div class="card justify-center p-4.5">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-base font-semibold text-slate-700 dark:text-navy-100">
                                        {{ $total_user }}
                                    </p>
                                    <p class="text-xs+ line-clamp-1">Total Users</p>
                                </div>
                                <div class="mask is-star flex h-10 w-10 shrink-0 items-center justify-center bg-info">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div>
                               @if($tday_u>$yday_u)
                                <div
                                    class="badge mt-2 space-x-1 bg-success/10 py-1 px-1.5 text-success dark:bg-success/15">
                                    <span>{{$tday_u}}</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                @else
                                <div
                                    class="badge mt-2 space-x-1 bg-error/10 py-1 px-1.5 text-error dark:bg-error/15">
                                    <span>{{$tday_u}}</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 one80d" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                @endif
                            </div>
                        </div>

                        <div class="card flex-row justify-between p-4 sm:p-5">
                            <div>
                                <p class="text-base font-medium text-slate-700 dark:text-navy-100">
                                    Today's User
                                </p>
                                <div>
                                    <div class="mt-4 flex items-baseline space-x-1">
                                        <p class="text-2xl font-semibold text-slate-700 dark:text-navy-100">
                                            {{ $u_jointoday }}
                                        </p>
                                    </div>
                                    <p class="text-xs+">today's new joined users</p>
                                </div>
                            </div>
                            <div
                                class="mask is-squircle flex h-10 w-10 items-center justify-center bg-primary/10 dark:bg-accent-light/10">
                                <i class="fa fa-user text-xl text-primary dark:text-accent-light"></i>
                            </div>
                            <div class="absolute bottom-0 right-0 overflow-hidden rounded-lg">
                                <i class="fa fa-user translate-x-1/4 translate-y-1/4 text-5xl opacity-15"></i>
                            </div>
                        </div>

                        <div class="card justify-center p-4.5">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-base font-semibold text-slate-700 dark:text-navy-100">
                                        {{ $t_refers }}
                                    </p>
                                    <p class="text-xs+ line-clamp-1">Total Referrals</p>
                                </div>
                                <div
                                    class="mask is-star flex h-10 w-10 shrink-0 items-center justify-center bg-secondary">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z">
                                        </path>
                                    </svg>
                                </div>
                            </div>
                            <div>
                                @if($tday_r>$yday_r)
                                <div
                                    class="badge mt-2 space-x-1 bg-success/10 py-1 px-1.5 text-success dark:bg-success/15">
                                    <span>{{$tday_r}}</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                @else
                                <div
                                    class="badge mt-2 space-x-1 bg-error/10 py-1 px-1.5 text-error dark:bg-error/15">
                                    <span>{{$tday_r}}</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 one80d" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                @endif
                            </div>
                        </div>
                        <a href="{{route('admin.redeem')}}" class="card justify-center p-4.5">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-base font-semibold text-slate-700 dark:text-navy-100">
                                        {{ $total_withd }}
                                    </p>
                                    <p class="text-xs+ line-clamp-1">Total Redeem</p>
                                </div>
                                <div
                                    class="mask is-star flex h-10 w-10 shrink-0 items-center justify-center bg-warning">
                                    <svg class="h-5 w-5 text-white" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M12.5293 18L20.9999 8.40002" stroke-width="1.5"
                                            stroke-linecap="round" stroke-linejoin="round"></path>
                                        <path d="M3 13.2L7.23529 18L17.8235 6" stroke-width="1.5"
                                            stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <div
                                    class="badge mt-2 space-x-1 bg-warning/10 py-1 px-1.5 text-warning dark:bg-warning/15">
                                    <span>{{ $pen_withd }} Pending</span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <!--App data-->
                <div class="col-span-12">
                    <div class="grid grid-cols-2 gap-3 sm:grid-cols-3 sm:gap-5 lg:grid-cols-3">
                        <a href="{{ route('admin.visit') }}" class="rounded-lg bg-slate-150 p-4 dark:bg-navy-700">
                            <div class="flex justify-between space-x-1">
                                <p class="text-xl font-semibold text-slate-700 dark:text-navy-100">
                                    {{ $t_web }}
                                </p>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary dark:text-accent"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                            </div>
                            <p class="mt-1 text-xs+">Total Websites</p>
                        </a>
                        <a href="{{ route('admin.redeem_methods') }}"
                            class="rounded-lg bg-slate-150 p-4 dark:bg-navy-700">
                            <div class="flex justify-between">
                                <p class="text-xl font-semibold text-slate-700 dark:text-navy-100">
                                    {{ $t_red_meth }}
                                </p>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-error" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z">
                                    </path>
                                </svg>
                            </div>
                            <p class="mt-1 text-xs+">Redeem Methods</p>
                        </a>
                        <a href="{{ route('admin.games') }}" class="rounded-lg bg-slate-150 p-4 dark:bg-navy-700">
                            <div class="flex justify-between">
                                <p class="text-xl font-semibold text-slate-700 dark:text-navy-100">
                                    {{ $t_game }}
                                </p>
                                <i class="fa-solid fa-gamepad f17 text-warning"></i>
                            </div>
                            <p class="mt-1 text-xs+">Total Games</p>
                        </a>
                        <a href="{{ route('admin.refer') }}" class="rounded-lg bg-slate-150 p-4 dark:bg-navy-700">
                            <div class="flex justify-between">
                                <p class="text-xl font-semibold text-slate-700 dark:text-navy-100">
                                    {{ $t_ref_m }}
                                </p>
                                <i class="fa-solid fa-fire f17 text-info"></i>
                            </div>
                            <p class="mt-1 text-xs+">Referral Missions</p>
                        </a>
                        <a href="{{ route('admin.csm_banners') }}"
                            class="rounded-lg bg-slate-150 p-4 dark:bg-navy-700">
                            <div class="flex justify-between space-x-1">
                                <p class="text-xl font-semibold text-slate-700 dark:text-navy-100">
                                    {{ $t_banner }}
                                </p>
                                <i class="fa-regular fa-file-lines f17 text-g"></i>
                            </div>
                            <p class="mt-1 text-xs+">Total Banner</p>
                        </a>
                        <div class="rounded-lg bg-slate-150 p-4 dark:bg-navy-700">
                            <div class="flex justify-between">
                                <p class="text-xl font-semibold text-slate-700 dark:text-navy-100">
                                    {{shorten($t_rewards) }}
                                </p>
                                <i class="fa-solid fa-dollar-sign f17 text-success"></i>
                            </div>
                            <p class="mt-1 text-xs+">Total Redeem Rewards</p>
                        </div>
                    </div>
                </div>

                <div class="mt-4 sm:mt-5 lg:mt-6">
                    <div class="flex items-center justify-between">
                        <h2 class="text-base font-medium tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100">
                            Top 10 Referral Users
                        </h2>

                    </div>
                    <div class="card mt-3">
                        <div class="is-scrollbar-hidden min-w-full overflow-x-auto">
                            <table class="is-hoverable w-full text-left">
                                <thead>
                                    <tr>
                                        <th
                                            class="whitespace-nowrap rounded-tl-lg bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                                            User
                                        </th>
                                        <th
                                            class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                                            Referrals
                                        </th>
                                        <th
                                            class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                                            Withdrawals
                                        </th>
                                        <th
                                            class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                                            Points
                                        </th>

                                        <th
                                            class="whitespace-nowrap rounded-tr-lg bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>

                                @forelse ($top_ref_users as $user)
                                <tr class="border-y border-transparent border-b-slate-200 dark:border-b-navy-500">
                                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                        <div class="flex items-center space-x-4">
                                            <div
                                                class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-primary/10 text-primary dark:bg-accent dark:text-white">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5.5 w-5.5"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                    stroke-width="1.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                                    </path>
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="font-medium text-slate-700 dark:text-navy-100">
                                                   {{$user->name}}
                                                </p>
                                                <p class="mt-0.5 text-xs text-slate-400 dark:text-navy-300">
                                                    {{$user->email}}
                                                </p>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                    <div class="flex items-center">
                                    <p class="font-semibold text-black">{{ $user->t_ref }}</p>
                                    @if ($user->t_ref>0)
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-success" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"></path>
                                    </svg>
                                    @endif
                                    </div>
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                        <div class="flex items-center gap-2">
                                            <div>
                                            @php
                                            $with_count = DB::select( DB::raw("SELECT u_id FROM reward_lists WHERE status = 0 AND u_id = '$user->id'") );
                                            @endphp
                                            <p class="font-semibold text-warning">{{count($with_count)}}</p>
                                            </div>
                                            @if (count($with_count) > 0)
                                            <ol class="steps line-space [--size:.75rem] [--line:1px]">
                                            <li class="step before:bg-slate-200 dark:before:bg-navy-500">
                                            <div class="step-header rounded-full bg-success dark:bg-success-light" style="margin: 0;">
                                            <span class="inline-flex h-full w-full animate-ping rounded-full bg-success opacity-80 dark:bg-secondary-light"></span>
                                            </div>
                                            </li>
                                            </ol>
                                            @else
                                            <span style="background:#b3b3b3;height: 10px;width: 10px;border-radius: 99px;"></span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                    <p class="font-semibold text-success">{{$user->points}}</p>
                                    </td>

                                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                    <a href="{{url('/admin/tracker')}}/{{$user->id}}"
                                    class="btn h-6 rounded bg-primary px-3 text-xs font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90
                                    dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                                    Track
                                    </a>
                                    </td>
                                </tr>
                                @empty

                                @endforelse


                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-span-12 lg:col-span-4">
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 sm:gap-5 lg:grid-cols-1 lg:gap-6">

                    <div class="card col-span-2 px-4 pb-5 sm:px-5">
                        <div class="my-3 flex h-8 items-center justify-between">
                            <h2
                                class="text-sm+ font-medium tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100">
                                Statistic
                            </h2>
                            <div x-data="usePopper({ placement: 'bottom-end', offset: 4 })" @click.outside="if(isShowPopper) isShowPopper = false"
                                class="inline-flex">
                                <button x-ref="popperRef" @click="isShowPopper = !isShowPopper"
                                    class="btn -mr-1.5 h-8 w-8 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z">
                                        </path>
                                    </svg>
                                </button>

                                <div x-ref="popperRoot" class="popper-root" :class="isShowPopper & amp; & amp;
                                'show'"
                                    style="position: fixed; inset: 0px 0px auto auto; margin: 0px; transform: translate(-30px, 688px);"
                                    data-popper-placement="bottom-end">
                                    <div
                                        class="popper-box rounded-md border border-slate-150 bg-white py-1.5 font-inter dark:border-navy-500 dark:bg-navy-700">
                                        <ul>
                                            <li>
                                                <a href="#"
                                                    class="flex h-8 items-center px-3 pr-8 font-medium tracking-wide outline-none transition-all hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">Action</a>
                                            </li>
                                            <li>
                                                <a href="#"
                                                    class="flex h-8 items-center px-3 pr-8 font-medium tracking-wide outline-none transition-all hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">Another
                                                    Action</a>
                                            </li>
                                            <li>
                                                <a href="#"
                                                    class="flex h-8 items-center px-3 pr-8 font-medium tracking-wide outline-none transition-all hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">Something
                                                    else</a>
                                            </li>
                                        </ul>
                                        <div class="my-1 h-px bg-slate-150 dark:bg-navy-500"></div>
                                        <ul>
                                            <li>
                                                <a href="#"
                                                    class="flex h-8 items-center px-3 pr-8 font-medium tracking-wide outline-none transition-all hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">Separated
                                                    Link</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="space-y-4">
                            <div class="flex items-center space-x-3">
                                <div class="mask is-squircle flex h-10 w-10 items-center justify-center bg-warning/10">
                                    <i class="fa-solid fa-history text-xl text-warning"></i>
                                </div>
                                <div class="grow space-y-1">
                                    <div class="flex justify-between">
                                        <p class="font-medium">Pending</p>
                                        <p class="text-warning">{{ $t_re }}%</p>
                                    </div>
                                    <div class="progress h-1.5 bg-slate-150 dark:bg-navy-500">
                                        <div class="rounded-full bg-warning" style="width:{{ $t_re }}%;"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center space-x-3">
                                <div
                                    class="mask is-squircle flex h-10 w-10 items-center justify-center bg-primary/10 dark:bg-accent-light/10">
                                    <i class="fa-solid fa-spinner text-xl text-primary dark:text-accent-light"></i>
                                </div>
                                <div class="grow space-y-1">
                                    <div class="flex justify-between">
                                        <p class="font-medium">In Progress</p>
                                        <p class="text-primary dark:text-accent-light">{{ $t_apre }}%</p>
                                    </div>
                                    <div class="progress h-1.5 bg-slate-150 dark:bg-navy-500">
                                        <div class="rounded-full bg-primary dark:bg-accent" style="width:{{ $t_apre }}%;"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center space-x-3">
                                <div class="mask is-squircle flex h-10 w-10 items-center justify-center bg-success/10">
                                    <i class="fa-regular fa-circle-check text-xl text-success"></i>
                                </div>
                                <div class="grow space-y-1">
                                    <div class="flex justify-between">
                                        <p class="font-medium">Completed</p>
                                        <p class="text-success">{{ $t_com }}%</p>
                                    </div>
                                    <div class="progress h-1.5 bg-slate-150 dark:bg-navy-500">
                                        <div class="rounded-full bg-success" style="width:{{ $t_com }}%;"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center space-x-3">
                                <div class="mask is-squircle flex h-10 w-10 items-center justify-center bg-error/10">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-error" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div class="grow space-y-1">
                                    <div class="flex justify-between">
                                        <p class="font-medium">Cancelled</p>
                                        <p class="text-error">{{ $t_rej }}%</p>
                                    </div>
                                    <div class="progress h-1.5 bg-slate-150 dark:bg-navy-500">
                                        <div class="rounded-full bg-error" style="width:{{ $t_rej }}%;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card col-span-2 px-4 pb-5 sm:px-5">
                        <div class="my-3 flex h-8 items-center justify-between">
                            <h2 class="font-medium tracking-wide text-slate-700 dark:text-navy-100">
                                Pending Transactions
                            </h2>
                            <a href="{{ route('admin.redeem') }}"
                                class="border-b border-dotted border-current pb-0.5 text-xs+ font-medium text-primary outline-none transition-colors duration-300 hover:text-primary/70 focus:text-primary/70 dark:text-accent-light dark:hover:text-accent-light/70 dark:focus:text-accent-light/70">
                                View All
                            </a>
                        </div>
                        <div class="space-y-4">
                            <div class="is-scrollbar-hidden min-w-full overflow-x-auto">
                                <table class="is-hoverable w-full text-left">
                                    <tbody>
                                        @php $count = 0; @endphp
                                        @forelse ($top_reedem as $data)
                                        @php $count++; @endphp
                                        <tr class="border-y border-transparent border-b-slate-200 dark:border-b-navy-500">
                                            <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                                <p class="font-medium text-primary dark:text-accent-light">
                                                 #{{$count}}
                                                </p>
                                            </td>
                                            <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                                 <p class="font-medium">{{date('j M Y', strtotime($data->created_at))}}</p>
                                                <p class="mt-0.5 text-xs">{{date('h:i A', $data->time)}}</p>
                                            </td>
                                            <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                                <div class="badge bg-warning/10 text-warning dark:bg-warning/15">
                                                    Pending
                                                </div>
                                            </td>

                                            <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                                <p class="text-sm+ font-medium text-slate-700 dark:text-navy-100">
                                                {{$data->symbol}}{{$data->amount}}
                                                </p>
                                            </td>
                                            <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                                <a href="{{url('/admin/withdrawal/request-view', $data->id)}}"
                                                    class="btn h-7 rounded-md bg-primary px-4 text-xs+
                                                    font-medium text-white hover:bg-primary-focus focus:bg-primary-focus
                                                    active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus
                                                    dark:focus:bg-accent-focus dark:active:bg-accent/90">
                                                   View
                                                </a>
                                            </td>
                                        </tr>
                                        @empty

                                        @endforelse

                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>




                </div>
            </div>
        </div>
    </main>

</x-header>
