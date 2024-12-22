<x-header>

    <main class="main-content w-full px-[var(--margin-x)] pb-8">
      <div
        class="mt-4 grid grid-cols-1 gap-4 sm:mt-5 sm:gap-5 lg:mt-6 lg:gap-6"
      >
      <div class="col-span-12 lg:col-span-8">
        @if(session('status'))
        <div class="alert flex rounded-lg bg-success px-4 py-4 text-white sm:px-5 mb-3 sess_msg">
        {{ session('status') }}
        </div>
        @endif
        <div class="card">
          <div class="flex flex-col items-center space-y-4 border-b border-slate-200 p-4 dark:border-navy-500 sm:flex-row sm:justify-between sm:space-y-0 sm:px-5">
            <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100">
              Edit Page
            </h2>
            <div class="flex justify-center space-x-2">
              <a href="{{ url('/admin/pages'); }}" class="btn min-w-[7rem] rounded-full border border-slate-300 font-medium text-slate-700 hover:bg-slate-150 focus:bg-slate-150 active:bg-slate-150/80 dark:border-navy-450 dark:text-navy-100 dark:hover:bg-navy-500 dark:focus:bg-navy-500 dark:active:bg-navy-500/90">
                Cancel
              </a>
              <button class="btn min-w-[7rem] rounded-full bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90"
              form="myform"
              type="submit">
              Save
              </button>
            </div>
          </div>
          <div class="p-4 sm:p-5">

            <form method="POST" action="" id="myform" enctype="multipart/form-data">
            @csrf
            @METHOD('PUT')
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
              <label class="block">
                <span>Title </span>
                <span class="relative mt-1.5 flex">
                  <input class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                  placeholder="Enter title"
                  type="text"
                  name="title"
                  value="{{$page_data->title}}">
                  <span class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                    <i class="fa-solid fa-pen"></i>
                  </span>
                </span>
              </label>


            <label class="block">
                <span>Status</span>
                <select name="status" class="form-select mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent">
                  @if ($page_data->status==1)
                  <option value="1">Published</option>
                  <option value="0">Draft</option>
                  @else
                  <option value="0">Draft</option>
                  <option value="1">Published</option>
                  @endif
                </select>
              </label>

            </div>

            <lable class="block mt-3">
            <span>Description</span>
            <div class="w-full mt-1.5">
            <textarea class="ckeditor" id="ckeditor" name="desc">{{$page_data->desc}}</textarea>
            </div>
            </lable>
            </form>
            <div>
            </div>
          </div>
        </div>
      </div>

      </div>
    </main>
      <script src="//cdn.ckeditor.com/4.10.1/full/ckeditor.js"></script>
    <script type="text/javascript">
    $(document).ready(function() {
    $('.ckeditor').ckeditor();
    });
    </script>
</x-header>
