
<x-header>
    <!-- Main Content Wrapper -->
    <main class="main-content w-full px-[var(--margin-x)] pb-8">
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

      <form method="POST" action="" id="myform" enctype="multipart/form-data">
        @csrf
        <div class="col-span-12 grid lg:col-span-8">
            <div class="card">
              <div class="border-b border-slate-200 p-4 dark:border-navy-500 sm:px-5">
                <div class="flex items-center space-x-2">

                  <h4 class="text-lg font-medium text-slate-700 dark:text-navy-100">
                    Add Redeem Method
                  </h4>
                </div>
              </div>

              <div class="space-y-4 p-4 sm:p-5 mb-0">
              <div class="avatar mt-1.5 h-20 w-36 upk border">
                <img  id="img-preview" class="mask is-" src="{{ url('/images/banner/csm-banner.png') }}" alt="avatar" style="object-fit: contain;">
                <div class="absolute bottom-0 right-0 flex items-center justify-center rounded-full bg-white dark:bg-navy-700">
                  <label
                  class="btn h-6 w-6 rounded-full border border-slate-200 p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:border-navy-500 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25"
                >
                  <input
                    id="choose-file"
                    tabindex="-1"
                    type="file"
                    name="csmimage"
                    class="pointer-events-none absolute inset-0 h-full w-full opacity-0"
                    required
                  />
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                  </svg>
                </label>
                </div>
              </div>
            </div>
            <div class="h-px bg-slate-200 dark:bg-navy-500 mt-0"></div>

              <div class="space-y-4 p-4 sm:p-5">
                <label class="block">
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <label class="block">
                            <span>Name</span>
                            <span class="relative mt-1.5 flex">
                              <input
                              name="name"
                              class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                              placeholder="Name" type="text">
                              <span class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                <i class="fa-solid fa-pen"></i>
                              </span>
                            </span>
                          </label>

                          <label class="block">
                            <span>Input Hint</span>
                            <span class="relative mt-1.5 flex">
                              <input
                              name="hint"
                              class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                              placeholder="Hint" type="text">
                              <span class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                <i class="fa-solid fa-pen"></i>
                              </span>
                            </span>
                          </label>

                          <label class="block">
                            <span>Symbol</span>
                            <span class="relative mt-1.5 flex">
                              <input
                              name="symbol"
                              class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                              placeholder="Symbol" type="text">
                              <span class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                <i class="fa-solid fa-pen"></i>
                              </span>
                            </span>
                          </label>

                        <label class="block">
                        <span>Input Type</span>
                        <select name="input_type" value="0" type="select" class="form-select mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent">
                        <option value="text">Text</option>
                        <option value="email">Email</option>
                        <option value="phone">Phone</option>
                        <option value="number">Number</option>
                        </select>
                        </label>

                       <label class="block">
                          <span>Note:</span>
                          <span class="relative mt-1.5 flex">
                            <input
                            name="note"
                            class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                            placeholder="note" type="text">
                            <span class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                            <i class="fa-solid fa-pen"></i>
                            </span>
                          </span>
                        </label>

                        <label class="block">
                            <span>Status</span>
                            <select
                            name="status"
                            type="select"
                            class="form-select mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 hover:border-slate-400
                            focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent">
                            <option value="0">Active</option>
                            <option value="1">Deactivate</option>
                            </select>
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
