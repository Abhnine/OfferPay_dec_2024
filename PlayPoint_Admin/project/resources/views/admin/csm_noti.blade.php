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
              <li>Notification</li>
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
                Notification
              </h2>
              <div class="flex">
                <div class="flex items-center" x-data="{isInputActive:false}">

                <div x-data="{showModal:false}">
                    <button
                    @click="showModal = true"
                    x-ref="popperRef"
                    class="btn bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90
                    dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90"
                  >
                  <i class="fa-solid fa-bell"></i>&nbsp; Send Notification
                  </button>
                    <template x-teleport="#x-teleport-target">
                      <div
                        class="fixed inset-0 z-[100] flex flex-col items-center justify-center overflow-hidden px-4 py-6 sm:px-5"
                        x-show="showModal"
                        role="dialog"
                        @keydown.window.escape="showModal = false"
                      >
                        <div
                          class="absolute inset-0 bg-slate-900/60 transition-opacity duration-300"
                          @click="showModal = false"
                          x-show="showModal"
                          x-transition:enter="ease-out"
                          x-transition:enter-start="opacity-0"
                          x-transition:enter-end="opacity-100"
                          x-transition:leave="ease-in"
                          x-transition:leave-start="opacity-100"
                          x-transition:leave-end="opacity-0"
                        ></div>
                        <div
                          class="relative w-full max-w-lg origin-top rounded-lg bg-white transition-all duration-300 dark:bg-navy-700"
                          x-show="showModal"
                          x-transition:enter="easy-out"
                          x-transition:enter-start="opacity-0 scale-95"
                          x-transition:enter-end="opacity-100 scale-100"
                          x-transition:leave="easy-in"
                          x-transition:leave-start="opacity-100 scale-100"
                          x-transition:leave-end="opacity-0 scale-95"
                        >
                          <div
                            class="flex justify-between rounded-t-lg bg-slate-200 px-4 py-3 dark:bg-navy-800 sm:px-5"
                          >
                            <h3 class="text-base font-medium text-slate-700 dark:text-navy-100">
                              Send Push Notification
                            </h3>
                            <button
                              @click="showModal = !showModal"
                              class="btn -mr-1.5 h-7 w-7 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25"
                            >
                              <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-4.5 w-4.5"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2"
                              >
                                <path
                                  stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M6 18L18 6M6 6l12 12"
                                ></path>
                              </svg>
                            </button>
                          </div>

                          <form method="POST" action="{{ route('admin.push') }}" id="myform" enctype="multipart/form-data">
                          @csrf
                          <div class="px-4 py-4 sm:px-5">

                            <div class="mt-4 space-y-4">
                                <label class="block">
                                    <span>Title:</span>
                                    <input
                                      class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                      placeholder="Title"
                                      type="text"
                                      name="title"
                                      required
                                    />
                                  </label>

                                  <label class="block">
                                    <span>Image Url:(Optional)</span>
                                    <input
                                      class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                      placeholder="Upload Image"
                                      type="file"
                                      name="csmimage"
                                    />
                                  </label>

                                  <label class="block">
                                    <span>Open Url:(Optional)</span>
                                    <input
                                      class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                      placeholder="Open Url"
                                      type="url"
                                      name="url"
                                    />
                                  </label>

                              <label class="block">
                                <span>Message:</span>
                                <textarea
                                  required
                                  name="sub"
                                  rows="4"
                                  placeholder=" Enter message"
                                  class="form-textarea mt-1.5 w-full resize-none rounded-lg border border-slate-300 bg-transparent p-2.5 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                ></textarea>
                              </label>

                              <div class="space-x-2 text-right">
                                <button
                                type="button"
                                  @click="showModal = false"
                                  class="btn min-w-[7rem] rounded-full border border-slate-300 font-medium text-slate-800 hover:bg-slate-150 focus:bg-slate-150 active:bg-slate-150/80 dark:border-navy-450 dark:text-navy-50 dark:hover:bg-navy-500 dark:focus:bg-navy-500 dark:active:bg-navy-500/90"
                                >
                                  Cancel
                                </button>
                                <button
                                  class="btn min-w-[7rem] rounded-full bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90"
                                >
                                  Send
                                </button>
                              </div>
                            </div>
                          </div>
                        </form>
                        </div>
                      </div>
                    </template>
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
                        #
                      </th>
                      <th class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                        Image
                      </th>
                      <th class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                        Name
                      </th>
                      <th class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                        Message
                      </th>
                      <th class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                        Date
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
                   @foreach ($noti as $game)
                   @php $count++; @endphp
                     <tr class="border-y border-transparent border-b-slate-200 dark:border-b-navy-500">
                        <td class="whitespace-nowrap px-4 py-3 sm:px-5">{{$count}}</td>
                        <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                        @if(empty($game->image))
                        No Image
                        @else
                        <div class="avatar h-12 w-12">
                        <img
                        class="rounded-lg"
                        src="{{url($game->image)}}"
                        alt="avatar"/>
                        </div>
                        @endif
                        </td>
                        <td class="whitespace-nowrap px-3 py-3 font-medium text-slate-700 dark:text-navy-100 lg:px-5">{{$game->title}}</td>
                        <td class="whitespace-nowrap px-4 py-3 sm:px-5">{{$game->sub}}</td>
                        <td class="whitespace-nowrap px-4 py-3 sm:px-5">{{$game->date}}</td>
                        <td class="whitespace-nowrap px-4 py-3 sm:px-5">

                        <div class="badge space-x-2.5 rounded-full bg-success/10 text-success dark:bg-success/15">
                        <div class="h-2 w-2 rounded-full bg-current"></div>
                        <span>Send</span>
                        </div>

                        </td>
                        <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                        <a href="{{route('admin.csm_delete_noti',$game->id)}}" class="csm-delete-confirmation btn h-7 rounded bg-error px-3 text-xs font-medium text-white
                        hover:bg-error-focus focus:bg-error-focus active:bg-error-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus
                        dark:active:bg-accent/90">Delete</a>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>

              <div class="flex flex-col justify-between space-y-4 px-4 py-4 sm:flex-row sm:items-center sm:space-y-0 sm:px-5">

             {{$noti->links()}}

            </div>
            </div>
          </div>

    </main>
    <script>
        const chooseFile = document.getElementById("choose-file");
        const imgPreview = document.getElementById("img-preview");
        function getImgData() {
          const files = chooseFile.files[0];
          if (files) {
            const fileReader = new FileReader();
            fileReader.readAsDataURL(files);
            fileReader.addEventListener("load", function () {
              imgPreview.style.display = "block";
              imgPreview.src = this.result;
            });
          }
        }
        chooseFile.addEventListener("change", function () {
          getImgData();
        });
    </script>
</x-header>
