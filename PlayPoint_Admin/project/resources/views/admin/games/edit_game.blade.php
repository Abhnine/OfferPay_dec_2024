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
                Edit Game
              </h2>
              <div class="flex justify-center space-x-2">
                <a href="{{ url('/admin/games'); }}" class="btn min-w-[7rem] rounded-full border border-slate-300 font-medium text-slate-700 hover:bg-slate-150 focus:bg-slate-150 active:bg-slate-150/80 dark:border-navy-450 dark:text-navy-100 dark:hover:bg-navy-500 dark:focus:bg-navy-500 dark:active:bg-navy-500/90">
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
              <div class="flex flex-col">
                <div class="avatar mt-1.5 h-24 w-24">
                    <img  id="img-preview" class="mask is-squircle" src="{{url($game_data->image)}}" alt="avatar">
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
                      />
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                      </svg>
                    </label>
                    </div>
                  </div>
              </div>
              <div class="my-7 h-px bg-slate-200 dark:bg-navy-500"></div>
              <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <label class="block">
                  <span>Title </span>
                  <span class="relative mt-1.5 flex">
                    <input class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                    placeholder="Enter title"
                    type="text"
                    name="title"
                    value="{{$game_data->title}}">
                    <span class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                      <i class="fa-solid fa-pen"></i>
                    </span>
                  </span>
                </label>
                <label class="block">
                  <span>Game Url </span>
                  <span class="relative mt-1.5 flex">
                    <input class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                    placeholder="Game Url"
                    type="text"
                    name="g_url"
                    value="{{$game_data->game}}">
                    <span class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                      <i class="fa-solid fa-link"></i>
                    </span>
                  </span>
                </label>
                <label class="block">
                  <span>Coins </span>
                  <span class="relative mt-1.5 flex">
                    <input class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                    placeholder="Coins"
                    type="number"
                    name="coins"
                    value="{{$game_data->coins}}">
                    <span class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                        <i class="fa-solid fa-coins"></i>
                    </span>
                  </span>
                </label>
                <label class="block">
                    <span>Set Time (Min) </span>
                    <span class="relative mt-1.5 flex">
                      <input class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                      placeholder="minutes"
                      type="number"
                      name="time"
                      value="{{$game_data->time}}">
                      <span class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                        <i class="fa-solid fa-stopwatch"></i>
                      </span>
                    </span>
                  </label>

                <label class="block">
                  <span>Category</span>
                    <select name="category" class="form-select mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent">
                        <option value="{{$game_data->category}}">Active category : {{$game_data->category}}</option>
                        <option value="action">Action</option>
                        <option value="adventure">Adventure</option>
                        <option value="rpg">Role-Playing Game (RPG)</option>
                        <option value="fps">First-Person Shooter (FPS)</option>
                        <option value="tps">Third-Person Shooter</option>
                        <option value="platformer">Platformer</option>
                        <option value="racing">Racing</option>
                        <option value="sports">Sports</option>
                        <option value="simulation">Simulation</option>
                        <option value="strategy">Strategy</option>
                        <option value="puzzle">Puzzle</option>
                        <option value="fighting">Fighting</option>
                        <option value="survival">Survival</option>
                        <option value="horror">Horror</option>
                        <option value="sandbox">Sandbox</option>
                        <option value="stealth">Stealth</option>
                        <option value="educational">Educational</option>
                        <option value="casual">Casual</option>
                        <option value="card-board">Card/Board Games</option>
                        <option value="moba">MOBA (Multiplayer Online Battle Arena)</option>
                        <option value="mmo">MMO (Massively Multiplayer Online)</option>
                        <option value="party">Party Games</option>
                    </select>

                </label>
                <label class="block">
                <span>Screen Orientation</span>
                <select name="screen" class="form-select mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent">
                  @if ($game_data->screen==0)
                  <option value="0">Portrait</option>
                  <option value="1">Landscape</option>
                  @else
                  <option value="1">Landscape</option>
                  <option value="0">Portrait</option>
                  @endif
                </select>
              </label>

                </label>
              </div>

              </form>
              <div>
              </div>
            </div>
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
