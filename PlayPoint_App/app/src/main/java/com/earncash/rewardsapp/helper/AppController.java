package com.earncash.rewardsapp.helper;

import android.app.Activity;
import android.app.Application;
import android.app.Dialog;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.SharedPreferences;
import android.graphics.Color;
import android.graphics.drawable.ColorDrawable;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;
import android.os.Build;

import android.os.Handler;
import android.os.Looper;
import android.text.TextUtils;
import android.util.Log;
import android.view.View;
import android.view.Window;
import android.view.WindowManager;
import android.view.animation.AccelerateDecelerateInterpolator;
import android.view.animation.Animation;
import android.view.animation.TranslateAnimation;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.RelativeLayout;
import android.widget.Toast;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.appcompat.app.AlertDialog;
import androidx.appcompat.app.AppCompatActivity;

import com.adcolony.sdk.AdColony;
import com.adcolony.sdk.AdColonyAdOptions;
import com.adcolony.sdk.AdColonyAppOptions;
import com.adcolony.sdk.AdColonyInterstitial;
import com.adcolony.sdk.AdColonyInterstitialListener;
import com.adcolony.sdk.AdColonyReward;
import com.adcolony.sdk.AdColonyRewardListener;
import com.adcolony.sdk.AdColonyZone;
import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.Volley;
import com.applovin.mediation.MaxAd;
import com.applovin.mediation.MaxAdListener;
import com.applovin.mediation.MaxError;
import com.applovin.mediation.MaxReward;
import com.applovin.mediation.MaxRewardedAdListener;
import com.applovin.mediation.ads.MaxInterstitialAd;
import com.applovin.mediation.ads.MaxRewardedAd;
import com.applovin.sdk.AppLovinSdk;
import com.applovin.sdk.AppLovinSdkConfiguration;
import com.chartboost.sdk.Chartboost;
import com.chartboost.sdk.ads.Interstitial;
import com.chartboost.sdk.ads.Rewarded;
import com.chartboost.sdk.callbacks.InterstitialCallback;
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
import com.facebook.ads.Ad;
import com.facebook.ads.AdError;
import com.facebook.ads.AudienceNetworkAds;
import com.facebook.ads.InterstitialAd;
import com.facebook.ads.InterstitialAdListener;
import com.facebook.ads.RewardedVideoAd;
import com.facebook.ads.RewardedVideoAdListener;
import com.google.android.gms.ads.AdRequest;
import com.google.android.gms.ads.LoadAdError;
import com.google.android.gms.ads.MobileAds;
import com.google.android.gms.ads.OnUserEarnedRewardListener;
import com.google.android.gms.ads.initialization.InitializationStatus;
import com.google.android.gms.ads.initialization.OnInitializationCompleteListener;
import com.google.android.gms.ads.interstitial.InterstitialAdLoadCallback;
import com.google.android.gms.ads.rewarded.RewardItem;
import com.google.android.gms.ads.rewarded.RewardedAd;
import com.google.android.gms.ads.rewarded.RewardedAdLoadCallback;
import com.google.firebase.FirebaseApp;
import com.onesignal.OneSignal;
import com.earncash.rewardsapp.R;
import com.startapp.sdk.adsbase.StartAppAd;
import com.startapp.sdk.adsbase.StartAppSDK;
import com.startapp.sdk.adsbase.adlisteners.VideoListener;
import com.unity3d.ads.IUnityAdsInitializationListener;
import com.unity3d.ads.IUnityAdsLoadListener;
import com.unity3d.ads.IUnityAdsShowListener;
import com.unity3d.ads.UnityAds;
import com.unity3d.ads.UnityAdsShowOptions;
import com.vungle.ads.AdConfig;
import com.vungle.ads.BaseAd;
import com.vungle.ads.InitializationListener;
import com.vungle.ads.RewardedAdListener;
import com.vungle.ads.VungleAds;
import com.vungle.ads.VungleError;

import org.json.JSONException;
import org.json.JSONObject;

import static com.earncash.rewardsapp.helper.Constatnt.BU;
import static com.earncash.rewardsapp.helper.Constatnt.EMAIL;
import static com.earncash.rewardsapp.helper.Constatnt.ID;
import static com.earncash.rewardsapp.helper.Constatnt.NAME;
import static com.earncash.rewardsapp.helper.Constatnt.POINTS;
import static com.earncash.rewardsapp.helper.Constatnt.STATTUS;
import static com.earncash.rewardsapp.helper.PrefManager.AddC;
import static com.earncash.rewardsapp.helper.PrefManager.ShowToast;

import java.net.NetworkInterface;
import java.net.SocketException;
import java.util.Collections;
import java.util.HashMap;
import java.util.Map;
import java.util.Objects;
import java.util.concurrent.Executors;
import java.util.concurrent.ScheduledExecutorService;
import java.util.concurrent.TimeUnit;

public class AppController extends Application {

    private RequestQueue mRequestQueue;
    private static AppController mInstance;

    public static final String TAG = AppController.class.getSimpleName();
    private SharedPreferences sharedPref;

    public String getName() {
        return name;
    }

    public void setName(String name) {
        this.name = name;
    }

    public String getEmail() {
        return email;
    }

    public void setEmail(String email) {
        this.email = email;
    }

    public String getProfile() {
        return profile;
    }

    public void setProfile(String profile) {
        this.profile = profile;
    }

    public String getStatus() {
        return status;
    }

    public void setStatus(String status) {
        this.status = status;
    }

    JSONObject unity, fb, admob, adColony, max,vungle,startapp,chartboost;
    String spin_ad, scratch_ad, back_ad, spin_ad_int, scratch_ad_int, back_ad_int,x2_ad,referMessage,game_ad,game_ad_int;
    private String name;
    private String email;
    private String points;
    private String profile;
    private String api_token;
    private String status;

    private int adget_api;

    private int badge;

    private String level;
    private String xp_need;
    private String lvlProgress;

    private int vpn;
    private int vpn_ban;
    private int devOption;
    private String diamond;

    public JSONObject getChartboost() {
        return chartboost;
    }

    public void setChartboost(JSONObject chartboost) {
        this.chartboost = chartboost;
    }

    public String getReferMessage() {
        return referMessage;
    }

    public void setReferMessage(String referMessage) {
        this.referMessage = referMessage;
    }

    public String getGame_ad() {
        return game_ad;
    }

    public void setGame_ad(String game_ad) {
        this.game_ad = game_ad;
    }

    public String getGame_ad_int() {
        return game_ad_int;
    }

    public void setGame_ad_int(String game_ad_int) {
        this.game_ad_int = game_ad_int;
    }

    public JSONObject getVungle() {
        return vungle;
    }

    public void setVungle(JSONObject vungle) {
        this.vungle = vungle;
    }

    public JSONObject getStartapp() {
        return startapp;
    }

    public void setStartapp(JSONObject startapp) {
        this.startapp = startapp;
    }

    public int getDevOption() {
        return devOption;
    }

    public void setDevOption(int devOption) {
        this.devOption = devOption;
    }

    public int getVpn() {
        return vpn;
    }

    public void setVpn(int vpn) {
        this.vpn = vpn;
    }

    public int getVpn_ban() {
        return vpn_ban;
    }

    public void setVpn_ban(int vpn_ban) {
        this.vpn_ban = vpn_ban;
    }

    public String getUid() {
        return uid;
    }

    public void setUid(String uid) {
        this.uid = uid;
    }

    public String getLvlProgress() {
        return lvlProgress;
    }

    public void setLvlProgress(String lvlProgress) {
        this.lvlProgress = lvlProgress;
    }

    private String uid;

    public String getFb_rewarded() {
        return fb_rewarded;
    }

    public void setFb_rewarded(String fb_rewarded) {
        this.fb_rewarded = fb_rewarded;
    }

    private String fb_rewarded;


    public String getDiamond() {
        return diamond;
    }

    public void setDiamond(String diamond) {
        this.diamond = diamond;
    }

    public String getLevel() {
        return level;
    }

    public void setLevel(String level) {
        this.level = level;
    }

    public String getXp_need() {
        return xp_need;
    }

    public void setXp_need(String xp_need) {
        this.xp_need = xp_need;
    }


    public static Dialog dialog;


    public int getBadge() {
        return badge;
    }

    public void setBadge(int badge) {
        this.badge = badge;
    }

    public String getRefer_points() {
        return refer_points;
    }

    public void setRefer_points(String refer_points) {
        this.refer_points = refer_points;
    }

    private String refer_points;
    private String refer_bonus;

    public String getTotal_earn() {
        return total_earn;
    }

    public void setTotal_earn(String total_earn) {
        this.total_earn = total_earn;
    }

    private String total_earn;

    public String getRedeem() {
        return redeem;
    }

    public void setRedeem(String redeem) {
        this.redeem = redeem;
    }

    private String redeem;

    public String getRefers() {
        return refers;
    }

    public void setRefers(String refers) {
        this.refers = refers;
    }

    private String refers;

    public String getRefer_bonus() {
        return refer_bonus;
    }

    public void setRefer_bonus(String refer_bonus) {
        this.refer_bonus = refer_bonus;
    }

    public String getRefer_id() {
        return refer_id;
    }

    public void setRefer_id(String refer_id) {
        this.refer_id = refer_id;
    }

    private String refer_id;
    private int refer_type;

    public int getRefer_type() {
        return refer_type;
    }

    public void setRefer_type(int refer_type) {
        this.refer_type = refer_type;
    }

    public String getUuid() {
        return uuid;
    }

    public void setUuid(String uuid) {
        this.uuid = uuid;
    }

    private String uuid;

    public JSONObject getUnity() {
        return unity;
    }

    public void setUnity(JSONObject unity) {
        this.unity = unity;
    }

    public JSONObject getFb() {
        return fb;
    }

    public void setFb(JSONObject fb) {
        this.fb = fb;
    }

    public JSONObject getAdmob() {
        return admob;
    }

    public void setAdmob(JSONObject admob) {
        this.admob = admob;
    }

    public JSONObject getAdColony() {
        return adColony;
    }

    public void setAdColony(JSONObject adColony) {
        this.adColony = adColony;
    }

    public String getSpin_ad() {
        return spin_ad;
    }

    public void setSpin_ad(String spin_ad) {
        this.spin_ad = spin_ad;
    }

    public String getScratch_ad() {
        return scratch_ad;
    }

    public void setScratch_ad(String scratch_ad) {
        this.scratch_ad = scratch_ad;
    }

    public String getBack_ad() {
        return back_ad;
    }

    public void setBack_ad(String back_ad) {
        this.back_ad = back_ad;
    }

    public String getSpin_ad_int() {
        return spin_ad_int;
    }

    public void setSpin_ad_int(String spin_ad_int) {
        this.spin_ad_int = spin_ad_int;
    }

    public String getScratch_ad_int() {
        return scratch_ad_int;
    }

    public void setScratch_ad_int(String scratch_ad_int) {
        this.scratch_ad_int = scratch_ad_int;
    }

    public String getBack_ad_int() {
        return back_ad_int;
    }

    public void setBack_ad_int(String back_ad_int) {
        this.back_ad_int = back_ad_int;
    }

    public JSONObject getMax() {
        return max;
    }

    public void setMax(JSONObject max) {
        this.max = max;
    }

    public String getX2_ad() {
        return x2_ad;
    }

    public void setX2_ad(String x2_ad) {
        this.x2_ad = x2_ad;
    }

    public int getAdget_api() {
        return adget_api;
    }

    public void setAdget_api(int adget_api) {
        this.adget_api = adget_api;
    }

    @Override
    public void onCreate() {
        super.onCreate();
        mInstance = this;
        sharedPref = this.getSharedPreferences(getString(R.string.settings_file), Context.MODE_PRIVATE);
        OneSignal.initWithContext(this);
        OneSignal.setAppId(getString(R.string.one_signal_app_id));
        OneSignal.setExternalUserId(AppController.get_uid(mInstance));
        this.readData();

        FirebaseApp.initializeApp(this);


    }


    public static void OnResume() {
        String iface = "";
        try {
            for (NetworkInterface networkInterface : Collections.list(NetworkInterface.getNetworkInterfaces())) {
                if (networkInterface.isUp())
                    iface = networkInterface.getName();
                Log.d("DEBUG", "IFACE NAME: " + iface);
                if (iface.contains("tun") || iface.contains("ppp") || iface.contains("pptp")) {
                    if (AppController.getInstance().getVpn() == 0) {
                        if (AppController.getInstance().getVpn_ban() == 0) {
                            buser();
                        } else {
                            Toast.makeText(mInstance.getApplicationContext(), "VPN is not allowed, Turn off the VPN and reopen the app!!", Toast.LENGTH_LONG).show();
                            System.exit(0);

                        }
                    }
                }
            }
        } catch (SocketException e1) {
            e1.printStackTrace();
        }
        // false;
    }

    private static void buser() {
        JsonRequest jsonReq = new JsonRequest(Request.Method.POST, BU, null,
                new Response.Listener<JSONObject>() {
                    @Override
                    public void onResponse(JSONObject response) {
                        hidepDialog();
                        try {
                            if (response.getString("error").equalsIgnoreCase("false")) {
                                Toast.makeText(mInstance.getApplicationContext(), "Your account has been permanently suspended for using VPN!", Toast.LENGTH_LONG).show();
                                System.exit(0);

                            } else if (response.getString("error").equalsIgnoreCase("true")) {
                            }
                        } catch (JSONException e) {
                            hidepDialog();
                            e.printStackTrace();
                            Toast.makeText(mInstance, e.getMessage(), Toast.LENGTH_SHORT).show();
                        }
                    }
                }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                //Log.println(10)
                Toast.makeText(mInstance, "Er-  " + error.getMessage(), Toast.LENGTH_LONG).show();
                hidepDialog();
            }
        }) {

            @Override
            protected Map<String, String> getParams() {
                Map<String, String> params = new HashMap<String, String>();
                params.put(ID, AppController.getInstance().getApi_token());
                return params;
            }
        };
        AppController.getInstance().getRequestQueue().getCache().clear();
        AppController.getInstance().addToRequestQueue(jsonReq);
    }

    public static synchronized AppController getInstance() {
        return mInstance;
    }

    public RequestQueue getRequestQueue() {
        if (mRequestQueue == null) {
            mRequestQueue = Volley.newRequestQueue(getApplicationContext());
        }
        return mRequestQueue;
    }

    public <T> void addToRequestQueue(Request<T> req, String tag) {
        // set the default tag if tag is empty
        req.setTag(TextUtils.isEmpty(tag) ? TAG : tag);
        getRequestQueue().add(req);
    }

    public <T> void addToRequestQueue(Request<T> req) {
        req.setTag(TAG);
        getRequestQueue().add(req);
    }


    public Boolean authorize(JSONObject authObj, String token) {

        try {

            if (authObj.getString("error").equalsIgnoreCase("true")) {
                return false;
            }
            if (!authObj.has("data")) {
                Toast.makeText(mInstance, "No data!", Toast.LENGTH_SHORT).show();

                return false;

            } else {
                JSONObject accountObj = authObj.getJSONObject("data");
                JSONObject ads = authObj.getJSONObject("ads");

                this.setApi_token(token);
                this.setName(accountObj.getString(NAME));
                this.setEmail(accountObj.getString(EMAIL));
                this.setState(accountObj.getString(STATTUS));
                this.setPoints(accountObj.getString(POINTS));
                this.setProfile(accountObj.getString("profile"));
                this.setRefer_id(accountObj.getString("refer_id"));
                this.setUid(accountObj.getString("id"));
                this.setDiamond(accountObj.getString("diamond"));
                this.setUuid(accountObj.getString("uid"));
                this.setXp_need(authObj.getString("xp_need"));
                this.setLvlProgress(authObj.getString("lvlProgress"));
                this.setLevel(authObj.getString("level"));
                this.setRefer_points(authObj.getString("refer_points"));
                this.setRefer_bonus(authObj.getString("refer_bonus"));
                this.setRefers(authObj.getString("refers"));
                this.setTotal_earn(authObj.getString("total_earn"));
                this.setRedeem(authObj.getString("redeem"));
                this.setFb_rewarded(authObj.getString("fb_rewarded"));
                this.setBadge(authObj.getInt("badge"));
                this.setVpn(authObj.getInt("vpn"));
                this.setVpn_ban(authObj.getInt("vpn_ban"));
                this.setDevOption(authObj.getInt("devOption"));
                this.setReferMessage(authObj.getString("referMessage"));

                this.setAdColony(ads.getJSONObject("adColony"));
                this.setAdmob(ads.getJSONObject("admob"));
                this.setFb(ads.getJSONObject("fb"));
                this.setUnity(ads.getJSONObject("unity"));
                this.setMax(ads.getJSONObject("max"));
                this.setVungle(ads.getJSONObject("vungle"));
                this.setStartapp(ads.getJSONObject("startapp"));
                this.setChartboost(ads.getJSONObject("chartboost"));
                this.setSpin_ad(authObj.getString("spin_ad"));
                this.setScratch_ad(authObj.getString("scratch_ad"));
                this.setBack_ad(authObj.getString("back_ad"));
                this.setX2_ad(authObj.getString("x2_ad"));
                this.setSpin_ad_int(authObj.getString("spin_ad_int"));
                this.setScratch_ad_int(authObj.getString("scratch_ad_int"));
                this.setBack_ad_int(authObj.getString("back_ad_int"));
                this.setGame_ad(authObj.getString("game_ad"));
                this.setGame_ad_int(authObj.getString("game_ad_int"));
                this.setAdget_api(authObj.getInt("adget_api"));
                this.setRefer_type(authObj.getInt("refer_type"));
                initAdNetworks();
                this.saveData();
                OnResume();
                return true;
            }


        } catch (JSONException e) {
            Toast.makeText(mInstance, e.getMessage(), Toast.LENGTH_SHORT).show();

            e.printStackTrace();
            return false;
        }
    }


    public static Boolean isConnected(final AppCompatActivity activity) {
        Boolean check = false;
        ConnectivityManager ConnectionManager = (ConnectivityManager) activity.getSystemService(Context.CONNECTIVITY_SERVICE);
        NetworkInfo networkInfo = ConnectionManager.getActiveNetworkInfo();

        if (networkInfo != null && networkInfo.isConnected() == true) {
            check = true;
        } else {
            AlertDialog.Builder builder = new AlertDialog.Builder(activity, R.style.MyDialogTheme);
            builder.setTitle("No network connection");
            builder.setMessage("check your internet connection and try again!!");
            builder.setCancelable(false);

            builder.setPositiveButton("Retry", (DialogInterface.OnClickListener) (dialog, which) -> {
                Intent intent = activity.getIntent();
                intent.setFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
                intent.setFlags(Intent.FLAG_ACTIVITY_CLEAR_TASK);
                activity.startActivity(intent);
                activity.finish();
            });

            AlertDialog alertDialog = builder.create();
            alertDialog.setCancelable(false);
            alertDialog.show();


        }
        return check;
    }

    public void logout(AppCompatActivity activity) {

        AppController.getInstance().removeData();
        AppController.getInstance().readData();
    }

    public static void initpDialog(AppCompatActivity activity) {
        dialog = new Dialog(activity);
        dialog.setCancelable(false);
        dialog.setContentView(R.layout.loading);
        dialog.getWindow().setBackgroundDrawable(new ColorDrawable
                (Color.TRANSPARENT));

    }

    public static void showpDialog() {
        try {
            if (!dialog.isShowing())
                dialog.show();
        } catch (Exception e) {
        }
    }

    public static void hidepDialog() {
        try {
            if (dialog.isShowing())
                dialog.dismiss();
        } catch (Exception e) {

        }

    }

    public void readData() {
        this.setApi_token(sharedPref.getString(getString(R.string.settings_account_id), "0"));
    }

    public void saveData() {
        sharedPref.edit().putString(getString(R.string.settings_account_id), this.getApi_token()).apply();
    }

    public Boolean readFCM() {


        return sharedPref.getBoolean("FCM", false);
    }

    public void saveFCM(Boolean fcm) {

        sharedPref.edit().putBoolean("FCM", fcm).apply();
    }

    public String readToken() {

        return sharedPref.getString("TOKEN", "");
    }

    public void saveToken(String fcm) {

        sharedPref.edit().putString("TOKEN", fcm).apply();
    }

    public void removeData() {

        sharedPref.edit().putString(getString(R.string.settings_account_id), "0").apply();

    }

    public String getApi_token() {

        return this.api_token;
    }

    public void setApi_token(String api_token) {

        this.api_token = api_token;
    }

    public void setState(String state) {

        this.status = state;
    }

    public String getState() {

        return this.status;
    }

    public String getPoints() {

        return this.points;
    }

    public void setPoints(String username) {

        this.points = username;
    }


    public static void transparentStatusAndNavigation(AppCompatActivity context) {
        //make full transparent statusBar
        if (Build.VERSION.SDK_INT >= 19 && Build.VERSION.SDK_INT < 21) {
            setWindowFlag(WindowManager.LayoutParams.FLAG_TRANSLUCENT_STATUS
                    | WindowManager.LayoutParams.FLAG_TRANSLUCENT_NAVIGATION, true, context);
        }
        if (Build.VERSION.SDK_INT >= 19) {
            context.getWindow().getDecorView().setSystemUiVisibility(
                    View.SYSTEM_UI_FLAG_LAYOUT_STABLE
                            | View.SYSTEM_UI_FLAG_LAYOUT_FULLSCREEN
                            | View.SYSTEM_UI_FLAG_LAYOUT_HIDE_NAVIGATION
            );
        }
        if (Build.VERSION.SDK_INT >= 21) {
            setWindowFlag(WindowManager.LayoutParams.FLAG_TRANSLUCENT_STATUS
                    | WindowManager.LayoutParams.FLAG_TRANSLUCENT_NAVIGATION, false, context);
            context.getWindow().setStatusBarColor(Color.TRANSPARENT);
            context.getWindow().setNavigationBarColor(Color.TRANSPARENT);
        }
    }

    private static void setWindowFlag(final int bits, boolean on, AppCompatActivity context) {
        Window win = context.getWindow();
        WindowManager.LayoutParams winParams = win.getAttributes();
        if (on) {
            winParams.flags |= bits;
        } else {
            winParams.flags &= ~bits;
        }
        win.setAttributes(winParams);
    }

    public static String get_uid(Context context) {
        return AppController.getInstance().getUid();
    }

    public static void shineStart(Activity activity, LinearLayout img, ImageView shine, int time) {
        ScheduledExecutorService executorService =
                Executors.newSingleThreadScheduledExecutor();

        executorService.scheduleAtFixedRate(new Runnable() {
            @Override
            public void run() {

                activity.runOnUiThread(new Runnable() {
                    @Override
                    public void run() {
                        Animation animation = new TranslateAnimation(
                                0, img.getWidth() + shine.getWidth(), 0, 0);
                        animation.setDuration(time);
                        animation.setFillAfter(false);
                        animation.setInterpolator(new AccelerateDecelerateInterpolator());
                        shine.startAnimation(animation);
                    }
                });
            }
        }, 3, 3, TimeUnit.SECONDS);


    }

    public static void shineStart_lin(Activity activity, RelativeLayout img, ImageView shine, int time) {
        ScheduledExecutorService executorService =
                Executors.newSingleThreadScheduledExecutor();

        executorService.scheduleAtFixedRate(new Runnable() {
            @Override
            public void run() {

                activity.runOnUiThread(new Runnable() {
                    @Override
                    public void run() {
                        Animation animation = new TranslateAnimation(
                                0, img.getWidth() + shine.getWidth(), 0, 0);
                        animation.setDuration(time);
                        animation.setFillAfter(false);
                        animation.setInterpolator(new AccelerateDecelerateInterpolator());
                        shine.startAnimation(animation);
                    }
                });
            }
        }, 3, 3, TimeUnit.SECONDS);


    }

    private void initAdNetworks() {
        StartAppAd.disableSplash();
        StartAppSDK.setTestAdsEnabled(true);
        StartAppSDK.init(this, str(getStartapp(), "app_id"), false);
        UnityAds.initialize(getApplicationContext(), str(getUnity(), "game_id"), false, new IUnityAdsInitializationListener() {
            @Override
            public void onInitializationComplete() {
                Log.d("Unity Initialization Complete", "Complete");
            }

            @Override
            public void onInitializationFailed(UnityAds.UnityAdsInitializationError error, String message) {
                Log.d("Unity Initialization Failed", message);
                Toast.makeText(mInstance, message, Toast.LENGTH_SHORT).show();
            }
        });

        MobileAds.initialize(this, new OnInitializationCompleteListener() {
            @Override
            public void onInitializationComplete(InitializationStatus initializationStatus) {
            }
        });

        AudienceNetworkAds.initialize(this);

        AdColonyAppOptions appOptions = new AdColonyAppOptions().setUserID(AppController.getInstance().getUid());
        AdColony.configure(this, appOptions, str(AppController.getInstance().getAdColony(), "app_id"));

        AppLovinSdk.getInstance(this).setMediationProvider("max");
        AppLovinSdk.initializeSdk(this, new AppLovinSdk.SdkInitializationListener() {
            @Override
            public void onSdkInitialized(final AppLovinSdkConfiguration configuration) {
                // AppLovin SDK is initialized, start loading ads
            }
        });



        VungleAds.init(mInstance, str(AppController.getInstance().getVungle(), "app_id"), new InitializationListener() {
            @Override
            public void onSuccess() {
                Log.d(TAG, "Vungle SDK init onSuccess()");
            }
            @Override
            public void onError(@NonNull VungleError vungleError) {
                Log.d(TAG, "onError():" + vungleError.getErrorMessage());
            }
        });

        Chartboost.startWithAppId(getApplicationContext(), str(AppController.getInstance().getChartboost(), "app_id"), str(AppController.getInstance().getChartboost(), "appSignature"), startError -> {
            if (startError == null) {
                //Toast.makeText(mInstance, "SDK is initialized", Toast.LENGTH_SHORT).show();

            } else {
                //Toast.makeText(mInstance, "SDK initialized with error: "+startError.getCode().name(), Toast.LENGTH_SHORT).show();
            }
        });

    }


    public static void ShowInterstitialAd(Activity activity, String provider) {
        Dialog  dialogd = new Dialog(activity);
        dialogd.setCancelable(false);
        dialogd.setContentView(R.layout.loading);
        dialogd.getWindow().setBackgroundDrawable(new ColorDrawable
                (Color.TRANSPARENT));

        switch (provider) {
            case "unity":
                dialogd.show();
                IUnityAdsShowListener showListener = new IUnityAdsShowListener() {
                    @Override
                    public void onUnityAdsShowFailure(String placementId, UnityAds.UnityAdsShowError error, String message) {
                        Log.e("UnityAdsExample", "Unity Ads failed to show ad for " + placementId + " with error: [" + error + "] " + message);
                        if (dialogd.isShowing()){
                            dialogd.dismiss();
                        }
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
                        if (dialogd.isShowing()){
                            dialogd.dismiss();
                        }
                    }
                };


                IUnityAdsLoadListener loadListener = new IUnityAdsLoadListener() {
                    @Override
                    public void onUnityAdsAdLoaded(String placementId) {
                        if (dialogd.isShowing()){
                            dialogd.dismiss();
                        }
                        UnityAds.show(activity, str(AppController.getInstance().getUnity(), "interstitial_ad_id"), new UnityAdsShowOptions(), showListener);
                    }

                    @Override
                    public void onUnityAdsFailedToLoad(String placementId, UnityAds.UnityAdsLoadError error, String message) {
                        Log.e("UnityAdsExample", "Unity Ads failed to load ad for " + placementId + " with error: [" + error + "] " + message);
                        if (dialogd.isShowing()){
                            dialogd.dismiss();
                        }
                    }
                };
                UnityAds.load(str(AppController.getInstance().getUnity(), "interstitial_ad_id"), loadListener);
                break;
            case "fb":
                dialogd.show();
                InterstitialAd interstitialAd = new InterstitialAd(activity, str(AppController.getInstance().getFb(), "interstitial_ad_id"));
                // Create listeners for the Interstitial Ad
                InterstitialAdListener interstitialAdListener = new InterstitialAdListener() {
                    @Override
                    public void onInterstitialDisplayed(Ad ad) {
                        // Interstitial ad displayed callback
                        Log.e(TAG, "Interstitial ad displayed.");
                    }

                    @Override
                    public void onInterstitialDismissed(Ad ad) {
                        // Interstitial dismissed callback
                        Log.e(TAG, "Interstitial ad dismissed.");
                        if (dialogd.isShowing()){
                            dialogd.dismiss();
                        }
                    }

                    @Override
                    public void onError(Ad ad, AdError adError) {
                        // Ad error callback
                        Log.e(TAG, "Interstitial ad failed to load: " + adError.getErrorMessage());
                        if (dialogd.isShowing()){
                            dialogd.dismiss();
                        }
                    }

                    @Override
                    public void onAdLoaded(Ad ad) {
                        // Interstitial ad is loaded and ready to be displayed
                        Log.d(TAG, "Interstitial ad is loaded and ready to be displayed!");
                        // Show the ad
                        if (dialogd.isShowing()){
                            dialogd.dismiss();
                        }
                        interstitialAd.show();
                    }

                    @Override
                    public void onAdClicked(Ad ad) {
                        // Ad clicked callback
                        Log.d(TAG, "Interstitial ad clicked!");
                    }

                    @Override
                    public void onLoggingImpression(Ad ad) {
                        // Ad impression logged callback
                        Log.d(TAG, "Interstitial ad impression logged!");
                    }
                };

                // For auto play video ads, it's recommended to load the ad
                // at least 30 seconds before it is shown
                interstitialAd.loadAd(
                        interstitialAd.buildLoadAdConfig()
                                .withAdListener(interstitialAdListener)
                                .build());

                break;

            case "max":
                dialogd.show();
                MaxInterstitialAd maxInterstitialAd = new MaxInterstitialAd(Objects.requireNonNull(str(AppController.getInstance().getMax(), "Interstitial_Ad_Unit")), activity);
                maxInterstitialAd.setListener(new MaxAdListener() {
                    @Override
                    public void onAdLoaded(MaxAd maxAd) {
                        if (dialogd.isShowing()){
                            dialogd.dismiss();
                        }
                        maxInterstitialAd.showAd();
                    }

                    @Override
                    public void onAdDisplayed(MaxAd maxAd) {

                    }

                    @Override
                    public void onAdHidden(MaxAd maxAd) {
                        if (dialogd.isShowing()){
                            dialogd.dismiss();
                        }
                    }

                    @Override
                    public void onAdClicked(MaxAd maxAd) {

                    }

                    @Override
                    public void onAdLoadFailed(String s, MaxError maxError) {
                        if (dialogd.isShowing()){
                            dialogd.dismiss();
                        }
                    }

                    @Override
                    public void onAdDisplayFailed(MaxAd maxAd, MaxError maxError) {
                        if (dialogd.isShowing()){
                            dialogd.dismiss();
                        }
                    }
                });

                // Load the first ad
                maxInterstitialAd.loadAd();
                break;

            case "adColony":
                dialogd.show();
                AdColonyInterstitialListener adColonyInterstitialListener = new AdColonyInterstitialListener() {
                    @Override
                    public void onRequestFilled(AdColonyInterstitial adReward) {
                        if (dialogd.isShowing()){
                            dialogd.dismiss();
                        }
                        adReward.show();
                    }

                    @Override
                    public void onRequestNotFilled(AdColonyZone zone) {
                        if (dialogd.isShowing()){
                            dialogd.dismiss();
                        }
                    }

                    @Override
                    public void onOpened(AdColonyInterstitial ad) {
                        super.onOpened(ad);
                    }

                    @Override
                    public void onClosed(AdColonyInterstitial ad) {
                        if (dialogd.isShowing()){
                            dialogd.dismiss();
                        }

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
                        if (dialogd.isShowing()){
                            dialogd.dismiss();
                        }
                    }
                };

                AdColonyAdOptions rewardAdOptions = new AdColonyAdOptions()
                        .enableConfirmationDialog(false)
                        .enableResultsDialog(false);
                AdColony.requestInterstitial(str(AppController.getInstance().getAdColony(), "Interstitial_Ad_Id"), adColonyInterstitialListener, rewardAdOptions);
                break;
            case "vungle":
                dialogd.show();
                com.vungle.ads.InterstitialAd vungleAd;
                vungleAd = new com.vungle.ads.InterstitialAd(activity, str(AppController.getInstance().getVungle(), "InterstitialPlacementId"), new AdConfig());
                vungleAd.setAdListener(new com.vungle.ads.InterstitialAdListener() {
                    @Override
                    public void onAdLoaded(@NonNull BaseAd baseAd) {
                        if (dialogd.isShowing()){
                            dialogd.dismiss();
                        }
                        if (vungleAd != null && vungleAd.canPlayAd()) {
                            vungleAd.play();
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
                        if (dialogd.isShowing()){
                            dialogd.dismiss();
                        }
                    }

                    @Override
                    public void onAdClicked(@NonNull BaseAd baseAd) {

                    }

                    @Override
                    public void onAdLeftApplication(@NonNull BaseAd baseAd) {

                    }

                    @Override
                    public void onAdFailedToLoad(@NonNull BaseAd baseAd, @NonNull VungleError vungleError) {
                        if (dialogd.isShowing()){
                            dialogd.dismiss();
                        }
                    }

                    @Override
                    public void onAdFailedToPlay(@NonNull BaseAd baseAd, @NonNull VungleError vungleError) {
                        if (dialogd.isShowing()){
                            dialogd.dismiss();
                        }
                    }
                });
                vungleAd.load(null);
                break;
            case "startapp":
                StartAppAd.showAd(activity);
                break;
            case "chartboost":
                dialogd.show();
                  Interstitial chartboostInterstitial = null;
                  chartboostInterstitial = new Interstitial(str(AppController.getInstance().getChartboost(), "interstitial_location_name"), new InterstitialCallback() {
                    @Override
                    public void onAdDismiss(@NonNull DismissEvent dismissEvent) {

                    }

                    @Override
                    public void onAdLoaded(@NonNull CacheEvent cacheEvent, @Nullable CacheError cacheError) {
                        // after this is successful ad can be shown
                           cacheEvent.getAd().show();
                        if (dialogd.isShowing()){
                            dialogd.dismiss();
                        }

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
                }, null);

                chartboostInterstitial.cache();
                break;
            case "admob":
                dialogd.show();
                AdRequest adRequest = new AdRequest.Builder().build();
                com.google.android.gms.ads.interstitial.InterstitialAd.load(activity,str(AppController.getInstance().getAdmob(), "Interstitial_Ad_Unit"), adRequest,
                        new InterstitialAdLoadCallback() {
                            @Override
                            public void onAdLoaded(@NonNull com.google.android.gms.ads.interstitial.InterstitialAd interstitialAd) {
                                super.onAdLoaded(interstitialAd);
                                if (dialogd.isShowing()){
                                    dialogd.dismiss();
                                }
                                interstitialAd.show(activity);
                            }

                            @Override
                            public void onAdFailedToLoad(@NonNull LoadAdError loadAdError) {
                                super.onAdFailedToLoad(loadAdError);
                                if (dialogd.isShowing()){
                                    dialogd.dismiss();
                                }
                            }
                        });
                break;
            default:
                Log.e("No provider","no provider available with "+provider);
        }

    }

    public static void Show2X(Activity activity, String provider, String coins, String from) {
        Dialog  dialogd = new Dialog(activity);
        dialogd.setCancelable(false);
        dialogd.setContentView(R.layout.loading);
        dialogd.getWindow().setBackgroundDrawable(new ColorDrawable
                (Color.TRANSPARENT));

        switch (provider) {
            case "unity":
                dialogd.show();
                IUnityAdsShowListener showListener = new IUnityAdsShowListener() {
                    @Override
                    public void onUnityAdsShowFailure(String placementId, UnityAds.UnityAdsShowError error, String message) {
                        Log.e("UnityAdsExample", "Unity Ads failed to show ad for " + placementId + " with error: [" + error + "] " + message);
                        if (dialogd.isShowing()){
                            dialogd.dismiss();
                        }
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
                        if (dialogd.isShowing()){
                            dialogd.dismiss();
                        }
                        if (state.equals(UnityAds.UnityAdsShowCompletionState.COMPLETED)) {
                            // Reward the user for watching the ad to completion
                            AddC(activity, coins, from + " 2x", false, null, false);
                        } else {
                            // Do not reward the user for skipping the ad
                            Toast.makeText(activity, "You need to watch full video ad to get rewarded!!", Toast.LENGTH_SHORT).show();
                        }

                    }
                };


                IUnityAdsLoadListener loadListener = new IUnityAdsLoadListener() {
                    @Override
                    public void onUnityAdsAdLoaded(String placementId) {
                        if (dialogd.isShowing()){
                            dialogd.dismiss();
                        }
                        UnityAds.show(activity, str(AppController.getInstance().getUnity(), "interstitial_ad_id"), new UnityAdsShowOptions(), showListener);
                    }

                    @Override
                    public void onUnityAdsFailedToLoad(String placementId, UnityAds.UnityAdsLoadError error, String message) {
                        Log.e("UnityAdsExample", "Unity Ads failed to load ad for " + placementId + " with error: [" + error + "] " + message);
                        if (dialogd.isShowing()){
                            dialogd.dismiss();
                        }
                    }
                };
                UnityAds.load(str(AppController.getInstance().getUnity(), "interstitial_ad_id"), loadListener);
                break;

            case "fb":
                dialogd.show();
                RewardedVideoAd rewardedVideoAd;
                final Boolean[] isFBReward = {false};
                rewardedVideoAd = new RewardedVideoAd(activity, str(AppController.getInstance().getFb(), "reward_ad_id"));
                RewardedVideoAdListener rewardedVideoAdListener = new RewardedVideoAdListener() {
                    @Override
                    public void onError(Ad ad, AdError error) {
                        // Rewarded video ad failed to load
                        Log.e(TAG, "Rewarded video ad failed to load: " + error.getErrorMessage());
                        if (dialogd.isShowing()){
                            dialogd.dismiss();
                        }
                        Toast.makeText(activity, "Video Not available !", Toast.LENGTH_SHORT).show();
                    }

                    @Override
                    public void onAdLoaded(Ad ad) {
                        // Rewarded video ad is loaded and ready to be displayed
                        Log.d(TAG, "Rewarded video ad is loaded and ready to be displayed!");
                        if (dialogd.isShowing()){
                            dialogd.dismiss();
                        }
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
                        isFBReward[0] = true;
                    }

                    @Override
                    public void onRewardedVideoClosed() {
                        // The Rewarded Video ad was closed - this can occur during the video
                        // by closing the app, or closing the end card.
                        if (dialogd.isShowing()){
                            dialogd.dismiss();
                        }
                        Log.d(TAG, "Rewarded video ad closed!");
                        if (isFBReward[0]) {
                            isFBReward[0] = false;
                            AddC(activity, coins, from + " 2x", false, null, false);
                        }
                    }
                };
                rewardedVideoAd.loadAd(
                        rewardedVideoAd.buildLoadAdConfig()
                                .withAdListener(rewardedVideoAdListener)
                                .build());
                break;
            case "admob":
                dialogd.show();
                AdRequest adRequest = new AdRequest.Builder().build();
                RewardedAd.load(activity, str(AppController.getInstance().getAdmob(), "reward_ad_id"),
                        adRequest, new RewardedAdLoadCallback() {
                            @Override
                            public void onAdFailedToLoad(@NonNull LoadAdError loadAdError) {
                                // Handle the error.
                                Log.d(TAG, loadAdError.toString());
                                if (dialogd.isShowing()){
                                    dialogd.dismiss();
                                }
                            }

                            @Override
                            public void onAdLoaded(@NonNull RewardedAd rewardedAd) {
                                if (dialogd.isShowing()){
                                    dialogd.dismiss();
                                }
                                rewardedAd.show(activity, new OnUserEarnedRewardListener() {
                                    @Override
                                    public void onUserEarnedReward(@NonNull RewardItem rewardItem) {
                                        AddC(activity, coins, from + " 2x", false, null, false);
                                    }
                                });
                                Log.d(TAG, "Ad was loaded.");
                            }
                        });
                break;
            case "adColony":
                dialogd.show();
                AdColony.setRewardListener(new AdColonyRewardListener() {
                    @Override
                    public void onReward(AdColonyReward reward) {
// Query reward object for info here
//here reward vid is seen by user
//you can use this listener inside activity also
                        if (dialogd.isShowing()){
                            dialogd.dismiss();
                        }
                        if (reward.success()) {
                            //AddC(activity, str(model, "video_coins"), "Video Reward", true, id,false);
                        } else {
                            Toast.makeText(activity.getApplicationContext(), "Kindly watch full video to get reward!", Toast.LENGTH_SHORT).show();
                        }
                    }
                });
                AdColonyInterstitialListener adColonyInterstitialListener = new AdColonyInterstitialListener() {
                    @Override
                    public void onRequestFilled(AdColonyInterstitial adColonyInterstitial) {
                        if (dialogd.isShowing()){
                            dialogd.dismiss();
                        }
                    }

                    @Override
                    public void onClosed(AdColonyInterstitial ad) {
                        super.onClosed(ad);
                    }
                };
// Set up listener for interstitial ad callbacks. You only need to implement the callbacks
// that you care about. The only required callback is onRequestFilled, as this is the only
// way to get an ad object.
                AdColonyInterstitialListener  rewardListener = new AdColonyInterstitialListener() {
                    @Override
                    public void onRequestFilled(AdColonyInterstitial adReward) {
// Ad passed back in request filled callback, ad can now be shown
                        if (dialogd.isShowing()){
                            dialogd.dismiss();
                        }
                        adReward.show();
                    }

                    @Override
                    public void onRequestNotFilled(AdColonyZone zone) {
                        if (dialogd.isShowing()){
                            dialogd.dismiss();
                        }
                        Toast.makeText(activity, "Video not available!", Toast.LENGTH_SHORT).show();
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
                                AddC(activity, coins, from + " 2x", false, null, false);
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
                        if (dialogd.isShowing()){
                            dialogd.dismiss();
                        }
                    }
                };
// Ad specific options to be sent with request
                AdColonyAdOptions   rewardAdOptions = new AdColonyAdOptions()
                        .enableConfirmationDialog(false)
                        .enableResultsDialog(false);
                AdColony.requestInterstitial(str(AppController.getInstance().getAdColony(), "reward_ad_id"), rewardListener, rewardAdOptions);
                break;
            case "vungle":
                dialogd.show();
                com.vungle.ads.RewardedAd rewardedAd;
                rewardedAd = new com.vungle.ads.RewardedAd(activity, str(AppController.getInstance().getVungle(), "RewardPlacementId"), new AdConfig());
                rewardedAd.setAdListener(new RewardedAdListener() {
                    @Override
                    public void onAdRewarded(@NonNull BaseAd baseAd) {
                        if (dialogd.isShowing()){
                            dialogd.dismiss();
                        }
                        AddC(activity, coins, from + " 2x", false, null, false);
                    }

                    @Override
                    public void onAdLoaded(@NonNull BaseAd baseAd) {
                        if (dialogd.isShowing()){
                            dialogd.dismiss();
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
                        if (dialogd.isShowing()){
                            dialogd.dismiss();
                        }
                    }

                    @Override
                    public void onAdClicked(@NonNull BaseAd baseAd) {

                    }

                    @Override
                    public void onAdLeftApplication(@NonNull BaseAd baseAd) {

                    }

                    @Override
                    public void onAdFailedToLoad(@NonNull BaseAd baseAd, @NonNull VungleError vungleError) {
                        if (dialogd.isShowing()){
                            dialogd.dismiss();
                        }
                    }

                    @Override
                    public void onAdFailedToPlay(@NonNull BaseAd baseAd, @NonNull VungleError vungleError) {
                        if (dialogd.isShowing()){
                            dialogd.dismiss();
                        }
                    }
                });
                rewardedAd.load(null);
                break;
            case "startapp":
                StartAppAd startAppAd = new StartAppAd(activity);
                startAppAd.loadAd(StartAppAd.AdMode.REWARDED_VIDEO);
                startAppAd.setVideoListener(new VideoListener() {
                    @Override
                    public void onVideoCompleted() {
                        // Grant user with the reward
                        AddC(activity, coins, from + " 2x", false, null, false);
                    }
                });
                break;
            case "chartboost":
                dialogd.show();
                Rewarded rewarded = new Rewarded(str(AppController.getInstance().getChartboost(), "reward_location_name"), new RewardedCallback() {
                    @Override
                    public void onRewardEarned(@NonNull RewardEvent rewardEvent) {
                        AddC(activity, coins, from + " 2x", false, null, false);
                    }

                    @Override
                    public void onAdDismiss(@NonNull DismissEvent dismissEvent) {

                    }

                    @Override
                    public void onAdLoaded(@NonNull CacheEvent cacheEvent, @Nullable CacheError cacheError) {
                        if (dialogd.isShowing()){
                            dialogd.dismiss();
                        }
                        if(cacheEvent.getAd().isCached()){
                            cacheEvent.getAd().show();
                        }
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
                break;
            case "max":
                dialogd.show();
                final boolean[] isRewarded = {false};
                isRewarded[0] = false;
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
                        if (dialogd.isShowing()){
                            dialogd.dismiss();
                        }
                        maxRewardedAd.showAd();

                    }

                    @Override
                    public void onAdDisplayed(MaxAd maxAd) {

                    }

                    @Override
                    public void onAdHidden(MaxAd maxAd) {
                        if (isRewarded[0]) {
                            AddC(activity, coins, from + " 2x", false, null, false);
                            isRewarded[0] = false;

                        }

                    }

                    @Override
                    public void onAdClicked(MaxAd maxAd) {

                    }

                    @Override
                    public void onAdLoadFailed(String s, MaxError maxError) {
                        ShowToast(activity, "Video not available!!", true);
                        if (dialogd.isShowing()){
                            dialogd.dismiss();
                        }
                    }

                    @Override
                    public void onAdDisplayFailed(MaxAd maxAd, MaxError maxError) {
                        ShowToast(activity, "Video not available!!", true);
                        hidepDialog();
                    }
                });

                maxRewardedAd.loadAd();

        }
    }


    public static String str(JSONObject obj, String name) {
        try {
            return obj.getString(name);
        } catch (JSONException e) {
            Toast.makeText(mInstance, "Error - " + e.getMessage(), Toast.LENGTH_SHORT).show();
            return null;
        }
    }

    public Boolean bool(JSONObject obj, String name) {
        try {
            return obj.getBoolean(name);
        } catch (JSONException e) {
            Toast.makeText(mInstance, "Error - " + e.getMessage(), Toast.LENGTH_SHORT).show();
            return null;
        }
    }


}
