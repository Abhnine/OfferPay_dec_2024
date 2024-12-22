<x-header>
    <main class="main-content w-full px-[var(--margin-x)] pb-8">
        <div class="flex items-center space-x-4 py-5 lg:py-6">
            <h2 class="text-xl font-medium text-slate-800 dark:text-navy-50 lg:text-2xl">

            </h2>
        </div>


        <div class="card col-span-12 pb-4 sm:col-span-6">
            <div
                class="flex flex-col items-center space-y-4 border-b border-slate-200 p-4 dark:border-navy-500 sm:flex-row sm:justify-between sm:space-y-0 sm:px-5">
                <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100">
                    OfferWall Postbacks
                </h2>
                <div class="flex justify-center space-x-2">

                </div>
            </div>
            <div class="p-4 sm:p-5">

              <div>
              <span>AdGem Postback url</span>
              <div class="alert mt-1.5 flex items-center justify-between rounded-lg bg-slate-150 px-4 py-3 font-medium text-slate-800 dark:bg-accent sm:px-5">
              <input readonly id="clipboardContent1" class="pobkin" value="{{ url('/api/adgem?player_id={player_id}&amount={amount}&campaign_name={campaign_name}&campaign_id={campaign_id}&payout={payout}&ip={ip}&platform={platform}&device={device}&transaction_id={transaction_id}&device_name={device_name}&conversion_datetime={conversion_datetime}&click_datetime={click_datetime}') }}">
              <button
                class="btn h-6 shrink-0 rounded bg-primary px-2 text-xs text-white active:bg-primary/50"
                @click="$clipboard({
                  content:document.querySelector('#clipboardContent1').value,
                  success:()=>$notification({text:'Url Copied',variant:'success'}),
                  error:()=>$notification({text:'Error',variant:'error'})
                })"
              >
                Copy
              </button>
            </div>
           </div>

           <div class="mt-4">
            <span>IronSource Postback url</span>
            <div class="alert mt-1.5 flex items-center justify-between rounded-lg bg-slate-150 px-4 py-3 font-medium text-slate-800 dark:bg-accent sm:px-5">
            <input readonly id="clipboardContent2" class="pobkin" value="{{ url('/api/s2s_is/?USER_ID=[USER_ID]&REWARDS=[REWARDS]&EVENT_ID=[EVENT_ID]') }}">
            <button
              class="btn h-6 shrink-0 rounded bg-primary px-2 text-xs text-white active:bg-primary/50"
              @click="$clipboard({
                content:document.querySelector('#clipboardContent2').value,
                success:()=>$notification({text:'Url Copied',variant:'success'}),
                error:()=>$notification({text:'Error',variant:'error'})
              })"
            >
              Copy
            </button>
          </div>
         </div>

         <div class="mt-4">
            <span>TapJoy Postback url</span>
            <div class="alert mt-1.5 flex items-center justify-between rounded-lg bg-slate-150 px-4 py-3 font-medium text-slate-800 dark:bg-accent sm:px-5">
            <input readonly id="clipboardContent3" class="pobkin" value="{{ url('/api/tapjoy/?id={id}&snuid={snuid}&currency={currency}&verifier={verifier}') }}">
            <button
              class="btn h-6 shrink-0 rounded bg-primary px-2 text-xs text-white active:bg-primary/50"
              @click="$clipboard({
                content:document.querySelector('#clipboardContent3').value,
                success:()=>$notification({text:'Url Copied',variant:'success'}),
                error:()=>$notification({text:'Error',variant:'error'})
              })"
            >
              Copy
            </button>
          </div>
         </div>

         <div class="mt-4">
            <span>AdGetMedia Postback url</span>
            <div class="alert mt-1.5 flex items-center justify-between rounded-lg bg-slate-150 px-4 py-3 font-medium text-slate-800 dark:bg-accent sm:px-5">
            <input readonly id="clipboardContent4" class="pobkin" value="{{ url('/api/adget/?conversion_id={conversion_id}&user_id={s1}&point_value={points}&usd_value={payout}&offer_title={vc_title}') }}">
            <button
              class="btn h-6 shrink-0 rounded bg-primary px-2 text-xs text-white active:bg-primary/50"
              @click="$clipboard({
                content:document.querySelector('#clipboardContent4').value,
                success:()=>$notification({text:'Url Copied',variant:'success'}),
                error:()=>$notification({text:'Error',variant:'error'})
              })"
            >
              Copy
            </button>
          </div>
         </div>

         <div class="mt-4">
            <span>OfferToro Postback url</span>
            <div class="alert mt-1.5 flex items-center justify-between rounded-lg bg-slate-150 px-4 py-3 font-medium text-slate-800 dark:bg-accent sm:px-5">
            <input readonly id="clipboardContent5" class="pobkin" value="{{ url('/api/offertoro/?user_id={user_id}&amount={amount}&o_name={o_name}&oid={oid}&payout={payout}&ip_address={ip_address}&event={event}&conversion_ts={conversion_ts}') }}">
            <button
              class="btn h-6 shrink-0 rounded bg-primary px-2 text-xs text-white active:bg-primary/50"
              @click="$clipboard({
                content:document.querySelector('#clipboardContent5').value,
                success:()=>$notification({text:'Url Copied',variant:'success'}),
                error:()=>$notification({text:'Error',variant:'error'})
              })"
            >
              Copy
            </button>
          </div>
         </div>

         <div class="mt-4">
            <span>CPA Lead Postback url</span>
            <div class="alert mt-1.5 flex items-center justify-between rounded-lg bg-slate-150 px-4 py-3 font-medium text-slate-800 dark:bg-accent sm:px-5">
            <input readonly id="clipboardContent6" class="pobkin" value="{{ url('/api/cpalead/?subid={subid}&virtual_currency={virtual_currency}&&password={password}') }}">
            <button
              class="btn h-6 shrink-0 rounded bg-primary px-2 text-xs text-white active:bg-primary/50"
              @click="$clipboard({
                content:document.querySelector('#clipboardContent6').value,
                success:()=>$notification({text:'Url Copied',variant:'success'}),
                error:()=>$notification({text:'Error',variant:'error'})
              })"
            >
              Copy
            </button>
          </div>
         </div>


        </div>
        </div>

    </main>
</x-header>
