
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


    <div class="grid grid-cols-1 gap-4 sm:gap-5 lg:gap-6">
      <div class="card px-4 pb-4 sm:px-5">
            <div class="my-3 flex h-8 items-center justify-center">
              <h2 class="mt-1 text-xl font-medium text-slate-700 dark:text-navy-100">
               Data Deletion Instructions!
              </h2>
            </div>
            <div>
              <h3 class="text-error mt-3 font-small text-slate-700 dark:text-navy-100">
                  Deleting your account will permanently remove all data associated with it. This action cannot be undone.
              </h3>
              
              <div class="mt-5 space-y-2.5">
                    <div class="flex justify-between space-x-2">
                      <p class="line-clamp-1"><b>1.</b> Open the application.</p>
                    </div>
                    <div class="flex justify-between space-x-2">
                      <p class="line-clamp-1"><b>2.</b> Go to your profile section.</p>
                    </div>
                    <div class="flex justify-between space-x-2">
                      <p class="line-clamp-1"><b>3.</b> Locate and click on the "Account".</p>
                    </div>
                    <div class="flex justify-between space-x-2">
                      <p class=""><b>4.</b> Look for the red color <b class="text-error">"Delete Account"</b> button.</p>
                    </div>
                    <div class="flex justify-between space-x-2">
                      <p class=""><b>5.</b> Follow the on-screen instructions to confirm the deletion.</p>
                    </div>
                  </div>
              <div class="mt-2"></div>
            </div>
          </div>
      </div>

      </main>

    </div>
    <div id="x-teleport-target"></div>
    <script>
      window.addEventListener("DOMContentLoaded", () => Alpine.start());
    </script>
  </body>
</html>


