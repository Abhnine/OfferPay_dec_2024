
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Meta tags  -->
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta
      name="viewport"
      content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"
    />

    <title>{{$admin_data->name}}</title>
    <link rel="icon" type="image/png" href="images/favicon.png" />

    <!-- CSS Assets -->
    <link rel="stylesheet" href="{{url('css/app.css')}}" />

    <!-- Javascript Assets -->
    <script src="{{url('js/app.js')}}" defer></script>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet"
    />
  </head>

  <body x-data class="is-header-blur" x-bind="$store.global.documentBody">
    <!-- App preloader-->
    <div
      class="app-preloader fixed z-50 grid h-full w-full place-content-center bg-slate-50 dark:bg-navy-900"
    >
      <div class="app-preloader-inner relative inline-block h-48 w-48"></div>
    </div>
        <style>
        :root {
        --main-sidebar-width: 0.2rem;
        }
        .bt{
        background: #fff;
        border: solid 1px #cccccc2e;
        padding: 12px 10px;
        font-weight: 600;
        }

        .main-form{
        width:50%;
        }

        @media only screen and (max-width: 830px) {
        .main-form{
        width:100%;
        }
        }
        </style>
        <!-- Page Wrapper -->
        <div
        id="root"
        class="min-h-100vh flex grow bg-slate-50 dark:bg-navy-900"
        x-cloak
      >
      <main class="main-content w-full px-[var(--margin-x)] pb-8" style="margin-top: 20px;">

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

    <div class="flex justify-center mt-10">
      <div class="card p-4 sm:p-5">
        <form method="POST" action="">
        @csrf
        @METHOD('POST')
        <div class="space-y-5">

          <label class="block">
            <span class="font-medium text-slate-600 dark:text-navy-100">Package name</span>
            <input class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
            placeholder="Package name" type="text" name="package" required>
          </label>

          <label class="block">
            <span class="font-medium text-slate-600 dark:text-navy-100">License key</span>
            <input class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
            placeholder="License key" type="text" name="license" required>
          </label>


          <div class="flex justify-end space-x-2">

            <button type="submit" class="btn space-x-2 bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
              <span>Activate</span>
            </button>
          </div>
        </div>
        </form>
      </div>
      </div>

      <div class="mt-8 flex justify-center text-xs text-slate-400 dark:text-navy-300">

            <a class="text-primary" href="https://wa.me/916375825529">By CSM Devs</a>
          </div>

      </main>

    </div>
    <div id="x-teleport-target"></div>
    <script>
      window.addEventListener("DOMContentLoaded", () => Alpine.start());
    </script>
  </body>
</html>


