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
              <li>App Settings</li>
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

          <div x-data="{activeTab:'spin'}" class="tabs flex flex-col">
            <div
              class="is-scrollbar-hidden overflow-x-auto rounded-lg bg-slate-200 text-slate-600 dark:bg-navy-800 dark:text-navy-200"
            >
              <div class="tabs-list flex px-1.5 py-1">
                <button
                  @click="activeTab = 'spin'"
                  :class="activeTab === 'spin' ? 'bg-white shadow dark:bg-navy-500 dark:text-navy-100' : 'hover:text-slate-800 focus:text-slate-800 dark:hover:text-navy-100 dark:focus:text-navy-100'"
                  class="btn shrink-0 space-x-2 px-3 py-1.5 font-medium"
                >
                 <i class="fa-solid fa-dharmachakra"></i>
                  <span>Lucky Spin</span>
                </button>
                <button
                  @click="activeTab = 'scratch'"
                  :class="activeTab === 'scratch' ? 'bg-white shadow dark:bg-navy-500 dark:text-navy-100' : 'hover:text-slate-800 focus:text-slate-800 dark:hover:text-navy-100 dark:focus:text-navy-100'"
                  class="btn shrink-0 space-x-2 px-3 py-1.5 font-medium"
                >
                 <i class="fa-solid fa-rug"></i>
                  <span>Scratch</span>
                </button>
                <button
                  @click="activeTab = 'game'"
                  :class="activeTab === 'game' ? 'bg-white shadow dark:bg-navy-500 dark:text-navy-100' : 'hover:text-slate-800 focus:text-slate-800 dark:hover:text-navy-100 dark:focus:text-navy-100'"
                  class="btn shrink-0 space-x-2 px-3 py-1.5 font-medium"
                >
                 <i class="fa-solid fa-gamepad"></i>
                  <span>Games</span>
                </button>
                 <button
                  @click="activeTab = 'daily'"
                  :class="activeTab === 'daily' ? 'bg-white shadow dark:bg-navy-500 dark:text-navy-100' : 'hover:text-slate-800 focus:text-slate-800 dark:hover:text-navy-100 dark:focus:text-navy-100'"
                  class="btn shrink-0 space-x-2 px-3 py-1.5 font-medium"
                >
                 <i class="fa-solid fa-gift"></i>
                  <span>Daily Bonus</span>
                </button>
                <button
                  @click="activeTab = 'csm_refer'"
                  :class="activeTab === 'csm_refer' ? 'bg-white shadow dark:bg-navy-500 dark:text-navy-100' : 'hover:text-slate-800 focus:text-slate-800 dark:hover:text-navy-100 dark:focus:text-navy-100'"
                  class="btn shrink-0 space-x-2 px-3 py-1.5 font-medium"
                >
                 <i class="fa-solid fa-user"></i>
                  <span> Referrel</span>
                </button>
                 <button
                  @click="activeTab = 'csm_app_ad'"
                  :class="activeTab === 'csm_app_ad' ? 'bg-white shadow dark:bg-navy-500 dark:text-navy-100' : 'hover:text-slate-800 focus:text-slate-800 dark:hover:text-navy-100 dark:focus:text-navy-100'"
                  class="btn shrink-0 space-x-2 px-3 py-1.5 font-medium"
                >
                 <i class="fa-solid fa-wrench"></i>
                  <span> App Ad Managment</span>
                </button>
              </div>
            </div>
            
            <!--tabs-->
            <div class="tab-content pt-4">
             
              <div
                x-show="activeTab === 'spin'"
                x-transition:enter="transition-all duration-500 easy-in-out"
                x-transition:enter-start="opacity-0 [transform:translate3d(1rem,0,0)]"
                x-transition:enter-end="opacity-100 [transform:translate3d(0,0,0)]"
              >
                 <div class="card col-span-12 pb-4 sm:col-span-6">
                <div class="flex flex-col items-center space-y-4 border-b border-slate-200 p-4 dark:border-navy-500 sm:flex-row sm:justify-between sm:space-y-0 sm:px-5">
                    <h5 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100">
                        Lucky Spin Configuration
                    </h5>
                    <div class="flex justify-center space-x-2">
                        <button name="spin_frm" form="app-spin" type="submit" class="btn min-w-[7rem] bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                            <i class="fa-regular fa-check-circle"></i> <span class="ml-2"> Apply Changes </span>
                        </button>
                    </div>
                </div>
                <div class="p-4 sm:p-5">

                  <form method="POST" action="" id="app-spin">
                   @csrf
                        
                    <label class="block">
                    <span>Daily Spin Limit</span>
                    <span class="relative mt-1.5 flex">
                    <input class="form-input mt-1.5 w-full rounded-lg bg-slate-150 px-3 py-2 ring-primary/50 placeholder:text-slate-400 hover:bg-slate-200 focus:ring dark:bg-navy-900/90 dark:ring-accent/50
                     dark:placeholder:text-navy-300 dark:hover:bg-navy-900 dark:focus:bg-navy-900" placeholder="Daily Spin Limit" value="{{$settings->daily_spin}}" type="number" name="spin">
                    </span>
                    </label>

                   <label class="block mt-3">
                    <span>Select Ad Network</span>
                     <select name="net" class="form-select mt-1.5 w-full rounded-lg bg-slate-150 px-3 py-2 ring-primary/50 hover:bg-slate-200 focus:ring dark:bg-navy-900/90 dark:ring-accent/50 dark:hover:bg-navy-900 dark:focus:bg-navy-900">
                     <option value="0">No Ads</option>
                     @foreach($ads as $ad)
                     <option value="{{$ad->net_id}}" @if($settings->spin_ad == $ad->net_id) selected @endif>{{$ad->name}}</option>
                     @endforeach
                    </select>
                   </label>
                      
                   <label class="block mt-3">
                    <span>Spin Wheel Ad</span>
                     <select name="ad_spin_int" class="form-select mt-1.5 w-full rounded-lg bg-slate-150 px-3 py-2 ring-primary/50 hover:bg-slate-200 focus:ring dark:bg-navy-900/90 dark:ring-accent/50 dark:hover:bg-navy-900 dark:focus:bg-navy-900">
                    <option value="1" @if($settings->spin_ad_int == 1) selected @endif>Show Ad After 1 Spin</option>
                     <option value="2" @if($settings->spin_ad_int == 2) selected @endif>Show Ad After 2 Spin's</option>
                     <option value="3" @if($settings->spin_ad_int == 3) selected @endif>Show Ad After 3 Spin's</option>
                     <option value="4" @if($settings->spin_ad_int == 4) selected @endif>Show Ad After 4 Spin's</option>
                     <option value="5" @if($settings->spin_ad_int == 5) selected @endif>Show Ad After 5 Spin's</option>
                     <option value="6" @if($settings->spin_ad_int == 6) selected @endif>Show Ad After 6 Spin's</option>
                     <option value="7" @if($settings->spin_ad_int == 7) selected @endif>Show Ad After 7 Spin's</option>
                     <option value="8" @if($settings->spin_ad_int == 8) selected @endif>Show Ad After 8 Spin's</option>
                     <option value="9" @if($settings->spin_ad_int == 9) selected @endif>Show Ad After 9 Spin's</option>
                     <option value="10" @if($settings->spin_ad_int == 10) selected @endif>Show Ad After 10 Spin's</option>
                     <option value="11" @if($settings->spin_ad_int == 11) selected @endif>Show Ad After 11 Spin's</option>
                     <option value="12" @if($settings->spin_ad_int == 12) selected @endif>Show Ad After 12 Spin's</option>
                     <option value="13" @if($settings->spin_ad_int == 13) selected @endif>Show Ad After 13 Spin's</option>
                     <option value="14" @if($settings->spin_ad_int == 14) selected @endif>Show Ad After 14 Spin's</option>
                     <option value="15" @if($settings->spin_ad_int == 15) selected @endif>Show Ad After 15 Spin's</option>
                    </select>
                  </label>

                  </form>
                </div>
                </div>
              </div>
              <div
                x-show="activeTab === 'scratch'"
                x-transition:enter="transition-all duration-500 easy-in-out"
                x-transition:enter-start="opacity-0 [transform:translate3d(1rem,0,0)]"
                x-transition:enter-end="opacity-100 [transform:translate3d(0,0,0)]"
              >
               <div class="card col-span-12 pb-4 sm:col-span-6">
                <div class="flex flex-col items-center space-y-4 border-b border-slate-200 p-4 dark:border-navy-500 sm:flex-row sm:justify-between sm:space-y-0 sm:px-5">
                    <h5 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100">
                        Scratch & Earn Configuration
                    </h5>
                    <div class="flex justify-center space-x-2">
                        <button form="app-scratch" type="submit" class="btn min-w-[7rem] bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                            <i class="fa-regular fa-check-circle"></i> <span class="ml-2"> Apply Changes </span>
                        </button>
                    </div>
                </div>
                <div class="p-4 sm:p-5">

                    <form method="POST" action="" id="app-scratch">
                      @csrf
                      <label class="block">
                        <span>Daily Scratch Limit</span>
                        <span class="relative mt-1.5 flex">
                        <input class="form-input mt-1.5 w-full rounded-lg bg-slate-150 px-3 py-2 ring-primary/50 placeholder:text-slate-400 hover:bg-slate-200 focus:ring dark:bg-navy-900/90 dark:ring-accent/50 dark:placeholder:text-navy-300 dark:hover:bg-navy-900 dark:focus:bg-navy-900" placeholder="Daily Scratch Limit" value="{{$settings->daily_scratch}}" type="number" name="scratch">
                        </span>
                        </label>
                        
                        <label class="block mt-3">
                        <span>Scratch Coins (Random)</span>
                        <input class="form-input mt-1.5 w-full rounded-lg bg-slate-150 px-3 py-2 ring-primary/50 placeholder:text-slate-400 hover:bg-slate-200 focus:ring dark:bg-navy-900/90 dark:ring-accent/50
                         dark:placeholder:text-navy-300 dark:hover:bg-navy-900 dark:focus:bg-navy-900" placeholder="Scratch Coins 0-∞" value="{{$settings->scratch_coins}}" type="text" name="scratch_coins">
                        </label>

                       <label class="block mt-3">
                        <span>Select Ad Network</span>
                         <select name="net" class="form-select mt-1.5 w-full rounded-lg bg-slate-150 px-3 py-2 ring-primary/50 hover:bg-slate-200 focus:ring dark:bg-navy-900/90 dark:ring-accent/50 dark:hover:bg-navy-900 dark:focus:bg-navy-900">
                         <option value="0">No Ads</option>
                         @foreach($ads as $ad)
                         <option value="{{$ad->net_id}}" @if($settings->scratch_ad == $ad->net_id) selected @endif>{{$ad->name}}</option>
                         @endforeach
                        </select>
                      </label>
                      
                       <label class="block mt-3">
                        <span>Scratch Ad</span>
                         <select name="ad_scratch_int" class="form-select mt-1.5 w-full rounded-lg bg-slate-150 px-3 py-2 ring-primary/50 hover:bg-slate-200 focus:ring dark:bg-navy-900/90 dark:ring-accent/50 dark:hover:bg-navy-900 dark:focus:bg-navy-900">
                         <option value="1" @if($settings->scratch_ad_int == 1) selected @endif>Show Ad After 1 Scratch</option>
                         <option value="2" @if($settings->scratch_ad_int == 2) selected @endif>Show Ad After 2 Scratch's</option>
                         <option value="3" @if($settings->scratch_ad_int == 3) selected @endif>Show Ad After 3 Scratch's</option>
                         <option value="4" @if($settings->scratch_ad_int == 4) selected @endif>Show Ad After 4 Scratch's</option>
                         <option value="5" @if($settings->scratch_ad_int == 5) selected @endif>Show Ad After 5 Scratch's</option>
                         <option value="6" @if($settings->scratch_ad_int == 6) selected @endif>Show Ad After 6 Scratch's</option>
                         <option value="7" @if($settings->scratch_ad_int == 7) selected @endif>Show Ad After 7 Scratch's</option>
                         <option value="8" @if($settings->scratch_ad_int == 8) selected @endif>Show Ad After 8 Scratch's</option>
                         <option value="9" @if($settings->scratch_ad_int == 9) selected @endif>Show Ad After 9 Scratch's</option>
                         <option value="10" @if($settings->scratch_ad_int == 10) selected @endif>Show Ad After 10 Scratch's</option>
                         <option value="11" @if($settings->scratch_ad_int == 11) selected @endif>Show Ad After 11 Scratch's</option>
                         <option value="12" @if($settings->scratch_ad_int == 12) selected @endif>Show Ad After 12 Scratch's</option>
                         <option value="13" @if($settings->scratch_ad_int == 13) selected @endif>Show Ad After 13 Scratch's</option>
                         <option value="14" @if($settings->scratch_ad_int == 14) selected @endif>Show Ad After 14 Scratch's</option>
                         <option value="15" @if($settings->scratch_ad_int == 15) selected @endif>Show Ad After 15 Scratch's</option>
                        </select>
                      </label>

                    </form>
                </div>
             </div>
              </div>
              
              <div
                x-show="activeTab === 'game'"
                x-transition:enter="transition-all duration-500 easy-in-out"
                x-transition:enter-start="opacity-0 [transform:translate3d(1rem,0,0)]"
                x-transition:enter-end="opacity-100 [transform:translate3d(0,0,0)]"
              >
                <div class="card col-span-12 pb-4 sm:col-span-6">
                <div class="flex flex-col items-center space-y-4 border-b border-slate-200 p-4 dark:border-navy-500 sm:flex-row sm:justify-between sm:space-y-0 sm:px-5">
                    <h5 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100">
                        Games Coin Claim Configuration
                    </h5>
                    <div class="flex justify-center space-x-2">
                        <button form="app-game" type="submit" class="btn min-w-[7rem] bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                            <i class="fa-regular fa-check-circle"></i> <span class="ml-2"> Apply Changes </span>
                        </button>
                    </div>
                </div>
                <div class="p-4 sm:p-5">

                    <form method="POST" action="" id="app-game">
                      @csrf
                        <input value="0" type="hidden" name="games">
                       <label class="block mt-3">
                        <span>Select Ad Network</span>
                         <select name="net" class="form-select mt-1.5 w-full rounded-lg bg-slate-150 px-3 py-2 ring-primary/50 hover:bg-slate-200 focus:ring dark:bg-navy-900/90 dark:ring-accent/50 dark:hover:bg-navy-900 dark:focus:bg-navy-900">
                         <option value="0">No Ads</option>
                         @foreach($ads as $ad)
                         <option value="{{$ad->net_id}}" @if($settings->game_ad == $ad->net_id) selected @endif>{{$ad->name}}</option>
                         @endforeach
                        </select>
                      </label>
                      
                       <label class="block mt-3">
                        <span>Game Coin Claim Ad</span>
                         <select name="ad_claim_int" class="form-select mt-1.5 w-full rounded-lg bg-slate-150 px-3 py-2 ring-primary/50 hover:bg-slate-200 focus:ring dark:bg-navy-900/90 dark:ring-accent/50 dark:hover:bg-navy-900 dark:focus:bg-navy-900">
                         <option value="1" @if($settings->game_ad_int == 1) selected @endif>Show Ad After 1 Claim</option>
                         <option value="2" @if($settings->game_ad_int == 2) selected @endif>Show Ad After 2 Claim's</option>
                         <option value="3" @if($settings->game_ad_int == 3) selected @endif>Show Ad After 3 Claim's</option>
                         <option value="4" @if($settings->game_ad_int == 4) selected @endif>Show Ad After 4 Claim's</option>
                         <option value="5" @if($settings->game_ad_int == 5) selected @endif>Show Ad After 5 Claim's</option>
                         <option value="6" @if($settings->game_ad_int == 6) selected @endif>Show Ad After 6 Claim's</option>
                         <option value="7" @if($settings->game_ad_int == 7) selected @endif>Show Ad After 7 Claim's</option>
                         <option value="8" @if($settings->game_ad_int == 8) selected @endif>Show Ad After 8 Claim's</option>
                         <option value="9" @if($settings->game_ad_int == 9) selected @endif>Show Ad After 9 Claim's</option>
                         <option value="10" @if($settings->game_ad_int == 10) selected @endif>Show Ad After 10 Claim's</option>
                         <option value="11" @if($settings->game_ad_int == 11) selected @endif>Show Ad After 11 Claim's</option>
                         <option value="12" @if($settings->game_ad_int == 12) selected @endif>Show Ad After 12 Claim's</option>
                         <option value="13" @if($settings->game_ad_int == 13) selected @endif>Show Ad After 13 Claim's</option>
                         <option value="14" @if($settings->game_ad_int == 14) selected @endif>Show Ad After 14 Claim's</option>
                         <option value="15" @if($settings->game_ad_int == 15) selected @endif>Show Ad After 15 Claim's</option>
                        </select>
                      </label>

                    </form>
                </div>
             </div>
              </div>
               <div
                x-show="activeTab === 'daily'"
                x-transition:enter="transition-all duration-500 easy-in-out"
                x-transition:enter-start="opacity-0 [transform:translate3d(1rem,0,0)]"
                x-transition:enter-end="opacity-100 [transform:translate3d(0,0,0)]"
              >
              <div class="card col-span-12 pb-4 sm:col-span-6">
              
                <div class="">
                @php $addata = json_decode($setting_data->days, TRUE); @endphp

                <form method="POST" action="{{ route('admin.up_daily_streak_settings') }}" id="up_daily_streak_settings">
                 @csrf
                <div class="flex flex-col items-center space-y-4 border-b border-slate-200 p-4 dark:border-navy-500 sm:flex-row sm:justify-between sm:space-y-0 sm:px-5">
                    <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100">
                        7 Day Login Coins Configuration
                    </h2>
                    <div class="flex justify-center space-x-2">
                        <button form="up_daily_streak_settings" type="submit"
                            class="btn min-w-[7rem] bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                            <i class="fa-regular fa-check-circle"></i> <span class="ml-2"> Apply Changes </span>
                        </button>
                    </div>
                </div>

                <div class="p-4 sm:p-5">
                    <div class="grid grid-cols-3 gap-4 mt-1">
                        <label class="block">
                            <span>Day 1 (Monday)</span>
                            <input
                                class="form-input mt-1.5 w-full rounded-lg bg-slate-150 px-3 py-2 ring-primary/50 placeholder:text-slate-400 hover:bg-slate-200 focus:ring dark:bg-navy-900/90 dark:ring-accent/50
                         dark:placeholder:text-navy-300 dark:hover:bg-navy-900 dark:focus:bg-navy-900"
                                placeholder="Monday" type="number" name="day_1" value="{{ $addata['day_1'] }}">
                        </label>
                        <label class="block">
                            <span>Day 2 (Tuesday)</span>
                            <input
                                class="form-input mt-1.5 w-full rounded-lg bg-slate-150 px-3 py-2 ring-primary/50 placeholder:text-slate-400 hover:bg-slate-200 focus:ring dark:bg-navy-900/90 dark:ring-accent/50
                         dark:placeholder:text-navy-300 dark:hover:bg-navy-900 dark:focus:bg-navy-900"
                                placeholder="Tuesday" type="number" name="day_2" value="{{ $addata['day_2'] }}">
                        </label>
                        <label class="block">
                            <span>Day 3 (Wednesday)</span>
                            <input
                                class="form-input mt-1.5 w-full rounded-lg bg-slate-150 px-3 py-2 ring-primary/50 placeholder:text-slate-400 hover:bg-slate-200 focus:ring dark:bg-navy-900/90 dark:ring-accent/50
                         dark:placeholder:text-navy-300 dark:hover:bg-navy-900 dark:focus:bg-navy-900"
                                placeholder="Wednesday" type="number" name="day_3" value="{{ $addata['day_3'] }}">
                        </label>
                        <label class="block">
                            <span>Day 4 (Thursday)</span>
                            <input
                                class="form-input mt-1.5 w-full rounded-lg bg-slate-150 px-3 py-2 ring-primary/50 placeholder:text-slate-400 hover:bg-slate-200 focus:ring dark:bg-navy-900/90 dark:ring-accent/50
                         dark:placeholder:text-navy-300 dark:hover:bg-navy-900 dark:focus:bg-navy-900"
                                 placeholder="Thursday" type="number" name="day_4" value="{{ $addata['day_4'] }}">
                        </label>
                        <label class="block">
                            <span>Day 5 (Friday)</span>
                            <input
                                class="form-input mt-1.5 w-full rounded-lg bg-slate-150 px-3 py-2 ring-primary/50 placeholder:text-slate-400 hover:bg-slate-200 focus:ring dark:bg-navy-900/90 dark:ring-accent/50
                         dark:placeholder:text-navy-300 dark:hover:bg-navy-900 dark:focus:bg-navy-900"
                                placeholder="Friday" type="number" name="day_5" value="{{ $addata['day_5'] }}">
                        </label>
                        <label class="block">
                            <span>Day 6 (Saturday)</span>
                            <input
                                class="form-input mt-1.5 w-full rounded-lg bg-slate-150 px-3 py-2 ring-primary/50 placeholder:text-slate-400 hover:bg-slate-200 focus:ring dark:bg-navy-900/90 dark:ring-accent/50
                         dark:placeholder:text-navy-300 dark:hover:bg-navy-900 dark:focus:bg-navy-900"
                                placeholder="Saturday" type="number" name="day_6" value="{{ $addata['day_6'] }}">
                        </label>
                        <label class="block">
                            <span>Day 7 (Sunday)</span>
                            <input
                                class="form-input mt-1.5 w-full rounded-lg bg-slate-150 px-3 py-2 ring-primary/50 placeholder:text-slate-400 hover:bg-slate-200 focus:ring dark:bg-navy-900/90 dark:ring-accent/50
                         dark:placeholder:text-navy-300 dark:hover:bg-navy-900 dark:focus:bg-navy-900"
                                placeholder="Sunday" type="number" name="day_7" value="{{ $addata['day_7'] }}">
                        </label>
                    </div>
                </div>
              </form>
                </div>
            </div>
              </div>
              <div
                x-show="activeTab === 'csm_refer'"
                x-transition:enter="transition-all duration-500 easy-in-out"
                x-transition:enter-start="opacity-0 [transform:translate3d(1rem,0,0)]"
                x-transition:enter-end="opacity-100 [transform:translate3d(0,0,0)]"
              >
                  
                <div class="card col-span-12 pb-4 sm:col-span-6">
                <div class="flex flex-col items-center space-y-4 border-b border-slate-200 p-4 dark:border-navy-500 sm:flex-row sm:justify-between sm:space-y-0 sm:px-5">
                    <h5 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100">
                        Refer & Share Configuration
                    </h5>
                    <div class="flex justify-center space-x-2">
                        <button form="app-refer" type="submit" class="btn min-w-[7rem] bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                            <i class="fa-regular fa-check-circle"></i> <span class="ml-2"> Apply Changes </span>
                        </button>
                    </div>
                </div>
                <div class="p-4 sm:p-5">

                    <form method="POST" action="" id="app-refer">
                        @csrf
                         <input value="0" type="hidden" name="refers">
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">

                            <label class="block mt-3">
                              <span>Refer System type</span>
                                <select name="refer_type" class="form-select mt-1.5 w-full rounded-lg bg-slate-150 px-3 py-2 ring-primary/50 hover:bg-slate-200 focus:ring dark:bg-navy-900/90 dark:ring-accent/50 dark:hover:bg-navy-900 dark:focus:bg-navy-900">
                                @if($setting_data->refer_type == "0")
                                 <option value="0" selected>Link Sharing</option>
                                 <option value="1">Refer Code</option>
                                 @elseif($setting_data->refer_type == "1")
                                 <option value="1" selected>Refer Code</option>
                                 <option value="0">Link Sharing</option>
                                 @endif
                               </select>
                            </label>
                            
                            <label class="block">
                                <span>App Package Name</span>
                                <span class="relative mt-1.5 flex">
                                    <input
                                        class="form-input mt-1.5 w-full rounded-lg bg-slate-150 px-3 py-2 ring-primary/50 placeholder:text-slate-400 hover:bg-slate-200 focus:ring dark:bg-navy-900/90 dark:ring-accent/50 dark:placeholder:text-navy-300 dark:hover:bg-navy-900 dark:focus:bg-navy-900"
                                        placeholder="Refer Bonus" value="{{ $setting_data->package_name }}"
                                        type="text" name="package_name">
                                </span>
                            </label>
                            
                            <label class="block">
                                <span>Refer Bonus</span>
                                <span class="relative mt-1.5 flex">
                                    <input
                                        class="form-input mt-1.5 w-full rounded-lg bg-slate-150 px-3 py-2 ring-primary/50 placeholder:text-slate-400 hover:bg-slate-200 focus:ring dark:bg-navy-900/90 dark:ring-accent/50 dark:placeholder:text-navy-300 dark:hover:bg-navy-900 dark:focus:bg-navy-900"
                                        placeholder="Refer Bonus" value="{{ $setting_data->refer_points }}"
                                        type="number" name="refer_points">

                                </span>
                            </label>

                            <label class="block">
                                <span>Refer Join Bonus</span>
                                <span class="relative mt-1.5 flex">
                                    <input
                                        class="form-input mt-1.5 w-full rounded-lg bg-slate-150 px-3 py-2 ring-primary/50 placeholder:text-slate-400 hover:bg-slate-200 focus:ring dark:bg-navy-900/90 dark:ring-accent/50 dark:placeholder:text-navy-300 dark:hover:bg-navy-900 dark:focus:bg-navy-900"
                                        placeholder="Refer Join User Bonus" value="{{ $setting_data->refer_bonus }}"
                                        type="number" name="refer_bonus">

                                </span>
                            </label>
                            
                        </div>
                        
                       <label class="block mt-3">
                      <span>App Share Message</span>
                       <span class="relative mt-1.5 flex">
                      <textarea rows="4" placeholder="Refer Message" name="refer_msg" class="form-input mt-1.5 w-full rounded-lg bg-slate-150 px-3 py-2 ring-primary/50 placeholder:text-slate-400 hover:bg-slate-200 focus:ring dark:bg-navy-900/90 dark:ring-accent/50 dark:placeholder:text-navy-300 dark:hover:bg-navy-900 dark:focus:bg-navy-900">{{ $setting_data->referMessage }}</textarea>
                      </span>
                    </label>

                    </form>
                   </div>
                 </div>
            
              </div>
              <div
                x-show="activeTab === 'csm_app_ad'"
                x-transition:enter="transition-all duration-500 easy-in-out"
                x-transition:enter-start="opacity-0 [transform:translate3d(1rem,0,0)]"
                x-transition:enter-end="opacity-100 [transform:translate3d(0,0,0)]"
              >
                <div class="card col-span-12 pb-4 sm:col-span-6">
                <div class="flex flex-col items-center space-y-4 border-b border-slate-200 p-4 dark:border-navy-500 sm:flex-row sm:justify-between sm:space-y-0 sm:px-5">
                    <h5 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100">
                       App Ads Configuration
                    </h5>
                    <div class="flex justify-center space-x-2">
                        <button form="app-ads_" type="submit" class="btn min-w-[7rem] bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                            <i class="fa-regular fa-check-circle"></i> <span class="ml-2"> Apply Changes </span>
                        </button>
                    </div>
                </div>
                 <div class="p-4 sm:p-5">

                <form method="POST" action="" id="app-ads_">
                 @csrf
                    <input value="0" type="hidden" name="app_ads">
                   <label class="block mt-3">
                    <span>Select 2X Video Ad Network</span>
                     <select name="x2_ad" class="form-select mt-1.5 w-full rounded-lg bg-slate-150 px-3 py-2 ring-primary/50 hover:bg-slate-200 focus:ring dark:bg-navy-900/90 dark:ring-accent/50 dark:hover:bg-navy-900 dark:focus:bg-navy-900">
                     <option value="0">No Ads</option>
                     @foreach($ads as $ad)
                     <option value="{{$ad->net_id}}" @if($settings->x2_ad == $ad->net_id) selected @endif>{{$ad->name}}</option>
                     @endforeach
                    </select>
                  </label>
                  
                  <label class="block mt-3">
                     <span>Select Back Press Ad Network</span>
                     <select name="back_net" class="form-select mt-1.5 w-full rounded-lg bg-slate-150 px-3 py-2 ring-primary/50 hover:bg-slate-200 focus:ring dark:bg-navy-900/90 dark:ring-accent/50 dark:hover:bg-navy-900 dark:focus:bg-navy-900">
                     <option value="0">No Ads</option>
                     @foreach($ads as $ad)
                     <option value="{{$ad->net_id}}" @if($settings->back_ad == $ad->net_id) selected @endif>{{$ad->name}}</option>
                     @endforeach
                    </select>
                  </label>
                  
                  <label class="block mt-3">
                        <span>Back Press Ad</span>
                         <select name="ad_back_int" class="form-select mt-1.5 w-full rounded-lg bg-slate-150 px-3 py-2 ring-primary/50 hover:bg-slate-200 focus:ring dark:bg-navy-900/90 dark:ring-accent/50 dark:hover:bg-navy-900 dark:focus:bg-navy-900">
                         <option value="1" @if($settings->back_ad_int == 1) selected @endif>Show Ad After 1 Back Press</option>
                         <option value="2" @if($settings->back_ad_int == 2) selected @endif>Show Ad After 2 Back Press</option>
                         <option value="3" @if($settings->back_ad_int == 3) selected @endif>Show Ad After 3 Back Press</option>
                         <option value="4" @if($settings->back_ad_int == 4) selected @endif>Show Ad After 4 Back Press</option>
                         <option value="5" @if($settings->back_ad_int == 5) selected @endif>Show Ad After 5 Back Press</option>
                         <option value="6" @if($settings->back_ad_int == 6) selected @endif>Show Ad After 6 Back Press</option>
                         <option value="7" @if($settings->back_ad_int == 7) selected @endif>Show Ad After 7 Back Press</option>
                         <option value="8" @if($settings->back_ad_int == 8) selected @endif>Show Ad After 8 Back Press</option>
                         <option value="9" @if($settings->back_ad_int == 9) selected @endif>Show Ad After 9 Back Press</option>
                         <option value="10" @if($settings->back_ad_int == 10) selected @endif>Show Ad After 10 Back Press</option>
                         <option value="11" @if($settings->back_ad_int == 11) selected @endif>Show Ad After 11 Back Press</option>
                         <option value="12" @if($settings->back_ad_int == 12) selected @endif>Show Ad After 12 Back Press</option>
                         <option value="13" @if($settings->back_ad_int == 13) selected @endif>Show Ad After 13 Back Press</option>
                         <option value="14" @if($settings->back_ad_int == 14) selected @endif>Show Ad After 14 Back Press</option>
                         <option value="15" @if($settings->back_ad_int == 15) selected @endif>Show Ad After 15 Back Press</option>
                        </select>
                      </label>

                </form>
                </div>
                </div>
            </div>
            </div>
          </div>

    </main>

</x-header>
