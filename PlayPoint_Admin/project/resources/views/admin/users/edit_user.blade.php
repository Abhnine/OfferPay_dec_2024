
<x-header>
@php 
$location = \Location::get($user_data->ip);
@endphp
    <!-- Main Content Wrapper -->
    <main class="main-content w-full px-[var(--margin-x)] pb-8">
        <div
          class="mt-4 grid grid-cols-1 gap-4 sm:mt-5 sm:gap-5 lg:mt-6 lg:gap-6"
        >
        <div class="col-span-12 lg:col-span-8">
          @if(session('status-success'))
          <div class="alert flex rounded-lg bg-success px-4 py-4 text-white sm:px-5 mb-3 sess_msg">
          {{ session('status-success') }}
          </div>
          @endif
          
          <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
          <div class="col-span-12 lg:col-span-3">
           <div class="card">
              <div class="border-b border-slate-200 p-4 dark:border-navy-500 sm:px-5">
                <h2 class="font-medium tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100 lg:text-base">
                 Manage User
                </h2>
              </div>
              <div class="p-4 sm:px-5">
                <ul class="space-y-3.5 font-inter font-medium">
                  <li>
                    <a class="inline-flex items-center space-x-2 tracking-wide text-primary outline-none dark:text-accent-light" href="#">
                      <i class="fa-solid fa-user-tie"></i>
                      <span>Profile</span>
                    </a>
                  </li>
                   <li>
                    <a href="{{url('/admin/tracker/'.$user_data->id)}}" class="group inline-flex items-center space-x-2 tracking-wide outline-none transition-colors hover:text-slate-800 focus:text-navy-800 dark:hover:text-navy-100 dark:focus:text-navy-100" href="#">
                      <i class="fa-solid fa-database"></i>
                      <span>User Activity</span>
                    </a>
                  </li>
                  <li>
                    <a href="{{route('admin.del_user',$user_data->id)}}" class="group inline-flex items-center csm-delete-confirmation space-x-2 tracking-wide outline-none transition-colors hover:text-slate-800 focus:text-navy-800 dark:hover:text-navy-100 dark:focus:text-navy-100" href="#">
                     <i class="fa-solid fa-trash-can"></i>
                      <span>Delete Account</span>
                    </a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
          
          <div class="col-span-12 lg:col-span-8">
                     
          <div class="card">
            <div class="flex flex-col items-center space-y-4 border-b border-slate-200 p-4 dark:border-navy-500 sm:flex-row sm:justify-between sm:space-y-0 sm:px-5">
              <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100">
                Edit User
              </h2>
              <div class="flex justify-center space-x-2">
                <a href="{{ url('/admin/users'); }}" class="btn min-w-[7rem] border border-slate-300 font-medium text-slate-800 hover:bg-slate-150 focus:bg-slate-150 active:bg-slate-150/80 dark:border-navy-450 dark:text-navy-50 dark:hover:bg-navy-500 dark:focus:bg-navy-500 dark:active:bg-navy-500/90">
                  Cancel
                </a>
                <button class="btn min-w-[7rem] bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90"
                form="myform"
                type="submit">
                Save
                </button>
              </div>
            </div>
            <div class="p-4 sm:p-5">
              <div class="flex flex-col">
                <span class="text-base font-medium text-slate-600 dark:text-navy-100">Avatar</span>
                <div class="avatar mt-1.5 h-20 w-20">
                  <img class="mask is-squircle" src="{{$user_data->profile}}" alt="avatar">
                </div>
              </div>
              <div class="my-7 h-px bg-slate-200 dark:bg-navy-500"></div>
              <form method="POST" action="" id="myform" enctype="multipart/form-data">
              @csrf
              @METHOD('PUT')
              <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <label class="block">
                  <span>Full Name </span>
                  <span class="relative mt-1.5 flex">
                    <input class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                    placeholder="Enter full name"
                    type="text"
                    name="name"
                    value="{{$user_data->name}}">
                    <span class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                      <i class="fa-regular fa-user text-base"></i>
                    </span>
                  </span>
                </label>
                <label class="block">
                  <span>Email Address </span>
                  <span class="relative mt-1.5 flex">
                    <input class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                    placeholder="Enter email address"
                    type="text"
                    name="email"
                    disabled
                    value="{{$user_data->email}}">
                    <span class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                      <i class="fa-regular fa-envelope text-base"></i>
                    </span>
                  </span>
                </label>
                <label class="block">
                  <span>Points </span>
                  <span class="relative mt-1.5 flex">
                    <input class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                    placeholder="Enter name"
                    type="text"
                    name="points"
                    value="{{$user_data->points}}">
                    <span class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                      <i class="fa-regular fa-user text-base"></i>
                    </span>
                  </span>
                </label>
                <label class="block">
                <span>Status</span>
                <select name="status" class="form-select mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent">
                  @if ($user_data->status==0)
                  <option value="0">Active</option>
                  <option value="1">Deactivate</option>
                  @else
                  <option value="1">Deactivate</option>
                  <option value="0">Active</option>
                  @endif
                </select>
              </label>
              </div>
            </form>
              <div class="grid grid-cols-4 gap-4 mt-4">
                <label class="block">
                  <span>Country</span>
                  <input class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary disabled:pointer-events-none disabled:select-none disabled:border-none disabled:bg-zinc-100 dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent dark:disabled:bg-navy-600" placeholder="Country" value="{{ucfirst($location->countryName)}}" type="text" disabled>
                </label>

                <label class="block">
                  <span>Account IP</span>
                  <input class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary disabled:pointer-events-none disabled:select-none disabled:border-none disabled:bg-zinc-100 dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent dark:disabled:bg-navy-600" placeholder="IP" type="text" value="{{$user_data->ip}}" disabled>
                </label>
                <label class="block">
                  <span>Joined On</span>
                  <input class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary disabled:pointer-events-none disabled:select-none disabled:border-none disabled:bg-zinc-100 dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent dark:disabled:bg-navy-600" placeholder="Joined" value="{{date('d-m-Y - h:i A',$user_data->join_time)}}" type="text" disabled>
                </label>
                <label class="block">
                  <span>Account Type</span>
                  <input class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary disabled:pointer-events-none disabled:select-none disabled:border-none disabled:bg-zinc-100 dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent dark:disabled:bg-navy-600" placeholder="Account Type" type="text" value="@if($user_data->login_type==0) Google @elseif($user_data->login_type==1) Facebook @elseif($user_data->login_type==2) Email Login @endif" disabled>
                </label>
                
              </div>

            </div>
          </div>
          
          </div>
        </div>
          
        </div>

        </div>
      </main>
</x-header>
