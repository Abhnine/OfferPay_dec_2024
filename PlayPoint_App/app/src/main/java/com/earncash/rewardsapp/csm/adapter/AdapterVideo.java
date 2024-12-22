package com.earncash.rewardsapp.csm.adapter;

import static com.earncash.rewardsapp.helper.AppController.TAG;
import static com.earncash.rewardsapp.helper.AppController.hidepDialog;
import static com.earncash.rewardsapp.helper.AppController.initpDialog;
import static com.earncash.rewardsapp.helper.AppController.showpDialog;
import static com.earncash.rewardsapp.helper.Constatnt.Main_Url;
import static com.earncash.rewardsapp.helper.PrefManager.AddC;
import static com.earncash.rewardsapp.helper.PrefManager.ShowToast;

import android.app.Activity;
import android.os.Handler;
import android.os.Looper;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.RelativeLayout;
import android.widget.TextView;
import android.widget.Toast;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.appcompat.app.AppCompatActivity;
import androidx.recyclerview.widget.RecyclerView;

import com.adcolony.sdk.AdColony;
import com.adcolony.sdk.AdColonyAdOptions;
import com.adcolony.sdk.AdColonyAppOptions;
import com.adcolony.sdk.AdColonyInterstitial;
import com.adcolony.sdk.AdColonyInterstitialListener;
import com.adcolony.sdk.AdColonyReward;
import com.adcolony.sdk.AdColonyRewardListener;
import com.adcolony.sdk.AdColonyZone;
import com.applovin.mediation.MaxAd;
import com.applovin.mediation.MaxError;
import com.applovin.mediation.MaxReward;
import com.applovin.mediation.MaxRewardedAdListener;
import com.applovin.mediation.ads.MaxRewardedAd;
import com.bumptech.glide.Glide;
import com.chartboost.sdk.ads.Rewarded;
import com.chartboost.sdk.callbacks.RewardedCallback;
import com.chartboost.sdk.events.CacheError;
import com.chartboost.sdk.events.CacheEvent;
import com.chartboost.sdk.events.ClickError;
import com.chartboost.sdk.events.ClickEvent;
import com.chartboost.sdk.events.DismissEvent;
import com.chartboost.sdk.events.ImpressionEvent;
import com.chartboost.sdk.events.RewardEvent;
import com.chartboost.sdk.events.ShowError;
import com.chartboost.sdk.events.ShowEvent;
import com.earncash.rewardsapp.R;
import com.earncash.rewardsapp.csm.model.ModelVideos;
import com.earncash.rewardsapp.helper.AppController;
import com.facebook.ads.Ad;
import com.facebook.ads.AdError;
import com.facebook.ads.RewardedVideoAd;
import com.facebook.ads.RewardedVideoAdListener;
import com.google.android.gms.ads.AdRequest;
import com.google.android.gms.ads.LoadAdError;
import com.google.android.gms.ads.OnUserEarnedRewardListener;
import com.google.android.gms.ads.rewarded.RewardItem;
import com.google.android.gms.ads.rewarded.RewardedAd;
import com.google.android.gms.ads.rewarded.RewardedAdLoadCallback;
import com.startapp.sdk.adsbase.StartAppAd;
import com.startapp.sdk.adsbase.adlisteners.AdEventListener;
import com.startapp.sdk.adsbase.adlisteners.VideoListener;
import com.unity3d.ads.IUnityAdsLoadListener;
import com.unity3d.ads.IUnityAdsShowListener;
import com.unity3d.ads.UnityAds;
import com.unity3d.ads.UnityAdsShowOptions;
import com.vungle.ads.AdConfig;
import com.vungle.ads.BaseAd;
import com.vungle.ads.RewardedAdListener;
import com.vungle.ads.VungleError;

import org.json.JSONException;
import org.json.JSONObject;

import java.util.List;

public class AdapterVideo extends RecyclerView.Adapter<AdapterVideo.MyViewHolder> {
    public AdapterVideo(List<ModelVideos> mList, Activity activity, String uid) {
        this.mList = mList;
        this.activity = activity;
        this.uid = uid;
    }

    List<ModelVideos> mList;
    Activity activity;
    Boolean isFBReward = false;

    AdColonyInterstitial rewardAdColony;
    Boolean isColonyRewardLoaded = false;
    AdColonyInterstitialListener rewardListener;
    AdColonyAdOptions rewardAdOptions;
    Boolean isAdcRewarded = false;
    Rewarded rewarded;
    String uid;
    private RewardedAd mRewardedAd;

    @NonNull
    @Override
    public MyViewHolder onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
        LayoutInflater layoutInflater = LayoutInflater.from(parent.getContext());
        View view = layoutInflater.inflate(R.layout.item_csm_videos, parent, false);
        return new MyViewHolder(view);
    }

    @Override
    public void onBindViewHolder(@NonNull MyViewHolder holder, int position) {
        ModelVideos model = mList.get(position);
        holder.name.setText(model.getName());
        holder.coins.setText(str(model.getIds(), "video_coins"));
        Glide.with(activity).load(Main_Url + model.getImage()).placeholder(R.mipmap.ic_launcher).into(holder.image);

        initpDialog((AppCompatActivity) activity);


        //start sdk
        switch (model.getNet_id()) {
            case "unity":

                break;
            case "adColony":
                AdColonyAppOptions appOptions = new AdColonyAppOptions().setUserID(AppController.getInstance().getUid());

                AdColony.configure(activity, appOptions, str(model.getIds(), "app_id"));
        }

        holder.click.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                if (model.getStatus()) {
                    switch (model.getNet_id()) {
                        case "unity":
                            showpDialog();
                            IUnityAdsShowListener showListener = new IUnityAdsShowListener() {
                                @Override
                                public void onUnityAdsShowFailure(String placementId, UnityAds.UnityAdsShowError error, String message) {
                                    Log.e("UnityAdsExample", "Unity Ads failed to show ad for " + placementId + " with error: [" + error + "] " + message);
                                }

                                @Override
                                public void onUnityAdsShowStart(String placementId) {
                                    Log.v("UnityAdsExample", "onUnityAdsShowStart: " + placementId);
                                }

                                @Override
                                public void onUnityAdsShowClick(String placementId) {
                                    Log.v("UnityAdsExample", "onUnityAdsShowClick: " + placementId);
                                }

                                @Override
                                public void onUnityAdsShowComplete(String placementId, UnityAds.UnityAdsShowCompletionState state) {
                                    Log.v("UnityAdsExample", "onUnityAdsShowComplete: " + placementId);
                                    if (state.equals(UnityAds.UnityAdsShowCompletionState.COMPLETED)) {
                                        // Reward the user for watching the ad to completion
                                        AddC(activity, str(model.getIds(), "video_coins"), "Video Reward", true, model.getId(), false);
                                    } else {
                                        // Do not reward the user for skipping the ad
                                    }
                                }
                            };
                            IUnityAdsLoadListener loadListener = new IUnityAdsLoadListener() {
                                @Override
                                public void onUnityAdsAdLoaded(String placementId) {
                                    hidepDialog();
                                    UnityAds.show((Activity) activity, str(model.getIds(), "reward_ad_id"), new UnityAdsShowOptions(), showListener);
                                }

                                @Override
                                public void onUnityAdsFailedToLoad(String placementId, UnityAds.UnityAdsLoadError error, String message) {
                                    hidepDialog();
                                    Toast.makeText(activity, message, Toast.LENGTH_SHORT).show();
                                    Log.e("UnityAdsExample", "Unity Ads failed to load ad for " + placementId + " with error: [" + error + "] " + message);
                                }
                            };
                            UnityAds.load(str(model.getIds(), "reward_ad_id"), loadListener);
                            break;
                        case "fb":
                            showpDialog();
                            RewardedVideoAd rewardedVideoAd;
                            rewardedVideoAd = new RewardedVideoAd(activity, str(model.getIds(), "reward_ad_id"));
                            RewardedVideoAdListener rewardedVideoAdListener = new RewardedVideoAdListener() {
                                @Override
                                public void onError(Ad ad, AdError error) {
                                    // Rewarded video ad failed to load
                                    Log.e(TAG, "Rewarded video ad failed to load: " + error.getErrorMessage());
                                    hidepDialog();
                                    Toast.makeText(activity, "Video Not available !", Toast.LENGTH_SHORT).show();
                                }

                                @Override
                                public void onAdLoaded(Ad ad) {
                                    // Rewarded video ad is loaded and ready to be displayed
                                    Log.d(TAG, "Rewarded video ad is loaded and ready to be displayed!");
                                    hidepDialog();
                                    rewardedVideoAd.show();
                                }

                                @Override
                                public void onAdClicked(Ad ad) {
                                    // Rewarded video ad clicked
                                    Log.d(TAG, "Rewarded video ad clicked!");
                                }

                                @Override
                                public void onLoggingImpression(Ad ad) {
                                    // Rewarded Video ad impression - the event will fire when the
                                    // video starts playing
                                    Log.d(TAG, "Rewarded video ad impression logged!");
                                }

                                @Override
                                public void onRewardedVideoCompleted() {
                                    // Rewarded Video View Complete - the video has been played to the end.
                                    // You can use this event to initialize your reward
                                    Log.d(TAG, "Rewarded video completed!");
                                    isFBReward = true;
                                }

                                @Override
                                public void onRewardedVideoClosed() {
                                    // The Rewarded Video ad was closed - this can occur during the video
                                    // by closing the app, or closing the end card.
                                    Log.d(TAG, "Rewarded video ad closed!");
                                    if (isFBReward) {
                                        isFBReward = false;
                                        AddC(activity, str(model.getIds(), "video_coins"), "Video Reward", true, model.getId(), false);
                                    }
                                }
                            };
                            rewardedVideoAd.loadAd(
                                    rewardedVideoAd.buildLoadAdConfig()
                                            .withAdListener(rewardedVideoAdListener)
                                            .build());
                            break;
                        case "adColony":
                            initRewardedAd(model.getIds(), model.getId());
                            break;
                        case "admob":
                            showpDialog();
                            AdRequest adRequest = new AdRequest.Builder().build();
                            RewardedAd.load(activity, str(model.getIds(), "reward_ad_id"),
                                    adRequest, new RewardedAdLoadCallback() {
                                        @Override
                                        public void onAdFailedToLoad(@NonNull LoadAdError loadAdError) {
                                            // Handle the error.
                                            Log.d(TAG, loadAdError.toString());
                                            mRewardedAd = null;
                                            hidepDialog();
                                            ShowToast(activity, "Video not available!!", true);
                                        }

                                        @Override
                                        public void onAdLoaded(@NonNull RewardedAd rewardedAd) {
                                            hidepDialog();
                                            mRewardedAd = rewardedAd;
                                            mRewardedAd.show(activity, new OnUserEarnedRewardListener() {
                                                @Override
                                                public void onUserEarnedReward(@NonNull RewardItem rewardItem) {
                                                    AddC(activity, str(model.getIds(), "video_coins"), "Video Reward", true, model.getId(), false);
                                                }
                                            });
                                            Log.d(TAG, "Ad was loaded.");
                                        }
                                    });
                            break;
                        case "startapp":
                            showpDialog();
                            StartAppAd startAppAd = new StartAppAd(activity);
                            startAppAd.setVideoListener(new VideoListener() {
                                @Override
                                public void onVideoCompleted() {
                                    // Grant user with the reward
                                    AddC(activity, str(model.getIds(), "video_coins"), "Video Reward", true, model.getId(), false);
                                }
                            });
                            startAppAd.loadAd(StartAppAd.AdMode.REWARDED_VIDEO, new AdEventListener() {
                                @Override
                                public void onReceiveAd(@NonNull com.startapp.sdk.adsbase.Ad ad) {
                                    hidepDialog();
                                    startAppAd.showAd();
                                }

                                @Override
                                public void onFailedToReceiveAd(@Nullable com.startapp.sdk.adsbase.Ad ad) {
                                   hidepDialog();
                                     ShowToast(activity, "Video not available!!", true);
                                }
                            });
                            break;
                        case "vungle":
                            vungleAd(str(model.getIds(), "video_coins"), model.getId(), str(AppController.getInstance().getVungle(), "RewardPlacementId"),activity);
                            break;
                        case "chartboost":
                            showpDialog();
                            rewarded = new Rewarded(str(AppController.getInstance().getChartboost(), "reward_location_name"), new RewardedCallback() {
                                @Override
                                public void onRewardEarned(@NonNull RewardEvent rewardEvent) {
                                    AddC(activity, str(model.getIds(), "video_coins"), "Video Reward", true, model.getId(), false);
                                }

                                @Override
                                public void onAdDismiss(@NonNull DismissEvent dismissEvent) {

                                }

                                @Override
                                public void onAdLoaded(@NonNull CacheEvent cacheEvent, @Nullable CacheError cacheError) {
                                    hidepDialog();
                                    rewarded.show();


                                }

                                @Override
                                public void onAdRequestedToShow(@NonNull ShowEvent showEvent) {

                                }

                                @Override
                                public void onAdShown(@NonNull ShowEvent showEvent, @Nullable ShowError showError) {

                                }

                                @Override
                                public void onAdClicked(@NonNull ClickEvent clickEvent, @Nullable ClickError clickError) {

                                }

                                @Override
                                public void onImpressionRecorded(@NonNull ImpressionEvent impressionEvent) {

                                }
                            },null);
                            rewarded.cache();
                            break;
                        case "max":
                            final boolean[] isRewarded = {false};
                            isRewarded[0] = false;
                            showpDialog();
                            MaxRewardedAd maxRewardedAd = MaxRewardedAd.getInstance(str(AppController.getInstance().getMax(), "Reward_Ad_Unit"), activity);
                            maxRewardedAd.setListener(new MaxRewardedAdListener() {
                                @Override
                                public void onUserRewarded(MaxAd maxAd, MaxReward maxReward) {
                                    isRewarded[0] = true;


                                }

                                @Override
                                public void onRewardedVideoStarted(MaxAd maxAd) {

                                }

                                @Override
                                public void onRewardedVideoCompleted(MaxAd maxAd) {

                                }

                                @Override
                                public void onAdLoaded(MaxAd maxAd) {
                                    hidepDialog();
                                    maxRewardedAd.showAd();

                                }

                                @Override
                                public void onAdDisplayed(MaxAd maxAd) {

                                }

                                @Override
                                public void onAdHidden(MaxAd maxAd) {
                                    if (isRewarded[0]) {
                                        AddC(activity, str(model.getIds(), "video_coins"), "Video Reward", true, model.getId(), false);
                                        isRewarded[0] = false;

                                    }

                                }

                                @Override
                                public void onAdClicked(MaxAd maxAd) {

                                }

                                @Override
                                public void onAdLoadFailed(String s, MaxError maxError) {
                                    ShowToast(activity, "Video not available!!", true);
                                    hidepDialog();
                                }

                                @Override
                                public void onAdDisplayFailed(MaxAd maxAd, MaxError maxError) {
                                    ShowToast(activity, "Video not available!!", true);
                                    hidepDialog();
                                }
                            });
                            maxRewardedAd.loadAd();
                    }
                }else {
                    Toast.makeText(activity, activity.getString(R.string.video_limit_msg), Toast.LENGTH_SHORT).show();
                }


            }
        });


    }

    @Override
    public int getItemCount() {
        return mList.size();
    }

    public class MyViewHolder extends RecyclerView.ViewHolder {
        TextView name, coins;
        ImageView image;
        RelativeLayout click;

        public MyViewHolder(@NonNull View itemView) {
            super(itemView);
            name = itemView.findViewById(R.id.name);
            coins = itemView.findViewById(R.id.coins);
            image = itemView.findViewById(R.id.image);
            click = itemView.findViewById(R.id.click);
        }
    }

    private String str(JSONObject obj, String name) {
        try {
            return obj.getString(name);
        } catch (JSONException e) {
            Toast.makeText(activity, "Error - " + e.getMessage(), Toast.LENGTH_SHORT).show();
            return null;
        }
    }

    private Boolean bool(JSONObject obj, String name) {
        try {
            return obj.getBoolean(name);
        } catch (JSONException e) {
            Toast.makeText(activity, "Error - " + e.getMessage(), Toast.LENGTH_SHORT).show();
            return null;
        }
    }

    private void initRewardedAd(JSONObject model, String id) {
// Create and set a reward listener
        showpDialog();

        AdColony.setRewardListener(new AdColonyRewardListener() {
            @Override
            public void onReward(AdColonyReward reward) {
// Query reward object for info here
//here reward vid is seen by user
//you can use this listener inside activity also
                if (reward.success()) {
                    //AddC(activity, str(model, "video_coins"), "Video Reward", true, id,false);
                } else {
                    Toast.makeText(activity.getApplicationContext(), "Kindly watch full video to get reward!", Toast.LENGTH_SHORT).show();
                }
            }
        });

        rewardListener = new AdColonyInterstitialListener() {
            @Override
            public void onRequestFilled(AdColonyInterstitial adReward) {
                rewardAdColony = adReward;
                hidepDialog();
                isColonyRewardLoaded = true;
                rewardAdColony.show();
            }

            @Override
            public void onRequestNotFilled(AdColonyZone zone) {
                hidepDialog();
            }

            @Override
            public void onOpened(AdColonyInterstitial ad) {
                super.onOpened(ad);
            }

            @Override
            public void onClosed(AdColonyInterstitial ad) {
                final Handler handler = new Handler(Looper.getMainLooper());
                handler.postDelayed(new Runnable() {
                    @Override
                    public void run() {
                        AddC(activity, str(model, "video_coins"), "Video Reward", true, id, false);
                    }
                }, 100);


                //AdColony.requestInterstitial(str(model, "ADCOLONY_REWARD_ZONE_ID"), rewardListener, rewardAdOptions);
            }

            @Override
            public void onClicked(AdColonyInterstitial ad) {
                super.onClicked(ad);
            }

            @Override
            public void onLeftApplication(AdColonyInterstitial ad) {
                super.onLeftApplication(ad);
            }

            @Override
            public void onExpiring(AdColonyInterstitial ad) {
                super.onExpiring(ad);
                hidepDialog();
            }
        };
// Ad specific options to be sent with request
        rewardAdOptions = new AdColonyAdOptions()
                .enableConfirmationDialog(false)
                .enableResultsDialog(false);
        AdColony.requestInterstitial(str(model, "reward_ad_id"), rewardListener, rewardAdOptions);
    }

    private void vungleAd(String video_coins, String id, String placementId, Activity activity) {
        showpDialog();
        final Handler handler = new Handler(Looper.getMainLooper());
        handler.postDelayed(new Runnable() {
            @Override
            public void run() {
                hidepDialog();
            }
        }, 10000);
        com.vungle.ads.RewardedAd rewardedAd;
        rewardedAd = new com.vungle.ads.RewardedAd(activity, placementId, new AdConfig());
        rewardedAd.setAdListener(new RewardedAdListener() {
            @Override
            public void onAdRewarded(@NonNull BaseAd baseAd) {
               AddC(activity, video_coins, "Video Reward", false, id, false);
            }
            

            @Override
            public void onAdLoaded(@NonNull BaseAd baseAd) {
                hidepDialog();
                if (rewardedAd != null && rewardedAd.canPlayAd()) {
                    rewardedAd.play();
                }
            }

            @Override
            public void onAdStart(@NonNull BaseAd baseAd) {

            }

            @Override
            public void onAdImpression(@NonNull BaseAd baseAd) {

            }

            @Override
            public void onAdEnd(@NonNull BaseAd baseAd) {
                hidepDialog();
            }

            @Override
            public void onAdClicked(@NonNull BaseAd baseAd) {

            }

            @Override
            public void onAdLeftApplication(@NonNull BaseAd baseAd) {

            }

            @Override
            public void onAdFailedToLoad(@NonNull BaseAd baseAd, @NonNull VungleError vungleError) {
                hidepDialog();
                Toast.makeText(activity, "Video not available!", Toast.LENGTH_SHORT).show();
            }

            @Override
            public void onAdFailedToPlay(@NonNull BaseAd baseAd, @NonNull VungleError vungleError) {

            }
        });
        rewardedAd.load(null);

    }

}