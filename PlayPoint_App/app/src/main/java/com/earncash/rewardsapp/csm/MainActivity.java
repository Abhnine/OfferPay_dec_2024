package com.earncash.rewardsapp.csm;


import static com.earncash.rewardsapp.helper.AppController.ShowInterstitialAd;
import static com.earncash.rewardsapp.helper.AppController.get_uid;
import static com.earncash.rewardsapp.helper.AppController.hidepDialog;
import static com.earncash.rewardsapp.helper.AppController.isConnected;
import static com.earncash.rewardsapp.helper.AppController.showpDialog;
import static com.earncash.rewardsapp.helper.Constatnt.DAILY;
import static com.earncash.rewardsapp.helper.Constatnt.GET_USER;
import static com.earncash.rewardsapp.helper.Constatnt.ID;
import static com.earncash.rewardsapp.helper.PrefManager.setWindowFlag;

import android.annotation.SuppressLint;
import android.app.Dialog;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.pm.ActivityInfo;
import android.graphics.Color;
import android.graphics.drawable.ColorDrawable;
import android.os.Build;
import android.os.Bundle;
import android.provider.Settings;
import android.view.View;
import android.view.WindowManager;
import android.widget.LinearLayout;
import android.widget.TextView;
import android.widget.Toast;

import androidx.appcompat.app.AlertDialog;
import androidx.appcompat.app.AppCompatActivity;
import androidx.viewpager.widget.ViewPager;
import androidx.viewpager2.widget.ViewPager2;

import com.adgatemedia.sdk.classes.AdGateMedia;
import com.adgem.android.AdGem;
import com.android.volley.Request;
import com.android.volley.Response;
import com.android.volley.VolleyError;

import com.earncash.rewardsapp.BuildConfig;
import com.earncash.rewardsapp.csm.adapter.AdapterMainActivitys;
import com.ironsource.mediationsdk.IronSource;
import com.earncash.rewardsapp.R;
import com.earncash.rewardsapp.helper.AppController;
import com.earncash.rewardsapp.helper.JsonRequest;
import com.ismaeldivita.chipnavigation.ChipNavigationBar;

import com.tapjoy.TJConnectListener;
import com.tapjoy.Tapjoy;
import com.tapjoy.TapjoyConnectFlag;


import org.json.JSONException;
import org.json.JSONObject;

import java.util.HashMap;
import java.util.Hashtable;
import java.util.Map;
import java.util.Objects;
import java.util.Timer;
import java.util.TimerTask;

public class MainActivity extends AppCompatActivity {
    //This is our viewPager
    AdGem adGem;
    ViewPager2 viewPager;
    AdapterMainActivitys adapterMainActivitys;
    ChipNavigationBar chipNav;
    int count = 0;
    Boolean isBack = false,isAd = true;

    @SuppressLint("SourceLockedOrientationActivity")
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.mainactivity);

        getWindow().addFlags(WindowManager.LayoutParams.FLAG_KEEP_SCREEN_ON);
        setRequestedOrientation(ActivityInfo.SCREEN_ORIENTATION_PORTRAIT);//Set Portrait
        if (Build.VERSION.SDK_INT >= 19 && Build.VERSION.SDK_INT < 21) {
            setWindowFlag(this, WindowManager.LayoutParams.FLAG_TRANSLUCENT_STATUS, true);
        }
        if (Build.VERSION.SDK_INT >= 19) {
            getWindow().getDecorView().setSystemUiVisibility(View.SYSTEM_UI_FLAG_LAYOUT_STABLE | View.SYSTEM_UI_FLAG_LAYOUT_FULLSCREEN);
        }
        if (Build.VERSION.SDK_INT >= 21) {
            setWindowFlag(this, WindowManager.LayoutParams.FLAG_TRANSLUCENT_STATUS, false);
            getWindow().setStatusBarColor(Color.TRANSPARENT);
        }

        setRequestedOrientation(ActivityInfo.SCREEN_ORIENTATION_PORTRAIT);//Set Portrait


        AppController.getInstance();
        viewPager = findViewById(R.id.viewPager);


        viewPager.setAdapter(new AdapterMainActivitys(MainActivity.this));

        AdGateMedia.initializeSdk(this);
        viewPager.setUserInputEnabled(false);
        viewPager.setOffscreenPageLimit(5);
        chipNav = findViewById(R.id.chipNav);
        chipNav.setItemSelected(R.id.play,true);
        chipNav.setOnItemSelectedListener(new ChipNavigationBar.OnItemSelectedListener() {
            @Override
            public void onItemSelected(int i) {
                switch (i)
                {
                    case R.id.play:
                        viewPager.setCurrentItem(0,false);
                        break;
                    case R.id.redeem:
                        viewPager.setCurrentItem(1,false);
                        break;
                    case R.id.battle:
                        viewPager.setCurrentItem(2,false);
                        break;
                    case R.id.refer:
                        viewPager.setCurrentItem(3,false);
                        break;
                    case R.id.profile:
                        viewPager.setCurrentItem(4,false);
                        break;
                }
            }
        });
        adGem = AdGem.get();

/*        coins.setText(AppController.getInstance().getPoints());
        if (AppController.getInstance().getDaily()==0){
            is_claim.setText("Claim Reward");
        }else{
            is_claim.setText("Claimed");
        }*/

        time_update();


        Hashtable<String, Object> connectFlags = new Hashtable<String, Object>();
        connectFlags.put(TapjoyConnectFlag.ENABLE_LOGGING, "true"); // Disable this in production builds
        connectFlags.put(TapjoyConnectFlag.USER_ID, "10"); // Important for self-managed currency

        Tapjoy.connect(getApplicationContext(), "Wyigs4OzSQOmPuXfmsFBkAECf5CRjwrpgsQGlsxKwQUDcDqew1dNUUABwWb5", connectFlags, new TJConnectListener() {
            @Override
            public void onConnectSuccess() {
            }

            @Override
            public void onConnectFailure() {
                hidepDialog();
            }
        });

    }

    public static void change(int position, ViewPager viewPager) {
        viewPager.setCurrentItem(position);

    }


    public void time_update() {
        int delay = 0; // delay for 0 sec.
        int period = 10000; // repeat every 10 sec.
        Timer timer = new Timer();
        timer.scheduleAtFixedRate(new TimerTask() {
            public void run() {
                update_point();
            }
        }, delay, period);
    }

    public static void update_point() {
        JsonRequest jsonReq = new JsonRequest(Request.Method.POST, GET_USER, null,
                new Response.Listener<JSONObject>() {
                    @Override
                    public void onResponse(JSONObject response) {

                        if (AppController.getInstance().authorize(response, AppController.getInstance().getApi_token())) {

                        }


                    }
                }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
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
        // toast(this,FirebaseInstanceId.getInstance().getToken());
    }

    public static void toast(Context context, String message) {
        Toast.makeText(context, message, Toast.LENGTH_LONG).show();
    }

    @Override
    protected void onResume() {
        update_point();
        super.onResume();
        IronSource.onResume(this);
        update(this);
        show_ad();
        if (!BuildConfig.DEBUG && AppController.getInstance().getDevOption()==0) {
            if (Settings.Secure.getInt(getContentResolver(), Settings.Global.DEVELOPMENT_SETTINGS_ENABLED, 0) != 0){
                showDev();
            }
        }

    }

    @Override
    protected void onPause() {
        super.onPause();
        IronSource.onPause(this);
    }

    @Override
    protected void onDestroy() {
        getWindow().clearFlags(android.view.WindowManager.LayoutParams.FLAG_KEEP_SCREEN_ON);
        super.onDestroy();

    }

    @Override
    protected void onActivityResult(int requestCode, int resultCode, Intent data) {
        super.onActivityResult(requestCode, resultCode, data);

    }


    @Override
    public void onBackPressed() {

        if (isBack.equals(false))
        {
            isBack = true;
            android.app.Dialog dialog = new Dialog(this);
            dialog.setCancelable(false);
            dialog.setContentView(R.layout.dialog_csm_exit);
            dialog.getWindow().setBackgroundDrawable(new ColorDrawable
                    (Color.TRANSPARENT));

            LinearLayout no = dialog.findViewById(R.id.no);
            LinearLayout yes = dialog.findViewById(R.id.yes);
            TextView sub = dialog.findViewById(R.id.sub);
            sub.setText("Are you sure do you want to exit this\napp?");

            yes.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View view) {
                    System.exit(0);
                    finish();
                }
            });

            no.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View view) {
                    isBack = false;
                    dialog.dismiss();
                }
            });
            dialog.setCancelable(false);

            dialog.show();


        }

    }
    private void showDev() {
        AlertDialog.Builder builder = new AlertDialog.Builder(MainActivity.this, R.style.MyDialogTheme);
        builder.setTitle("Alert!");
        builder.setMessage("Disable developer option to continue using "+getString(R.string.app_name)+".");
        builder.setCancelable(false);

        builder.setPositiveButton("Ok", (DialogInterface.OnClickListener) (dialog, which) -> {
            System.exit(0);
        });
        AlertDialog alertDialog = builder.create();
        alertDialog.show();
        alertDialog.setCancelable(false);
    }

    private void daily_bonus() {
        if (isConnected(MainActivity.this)) {
            showpDialog();
            JsonRequest jsonReq = new JsonRequest(Request.Method.POST, DAILY, null,
                    new Response.Listener<JSONObject>() {
                        @Override
                        public void onResponse(JSONObject response) {
                            //Toast.makeText(getContext(), response.toString(), Toast.LENGTH_SHORT).show();
                            try {
                                if (response.getString("error").equalsIgnoreCase("false")) {
                                    AlertDialog.Builder builder = new AlertDialog.Builder(MainActivity.this, R.style.MyDialogTheme);

                                    // Set the message show for the Alert time
                                    builder.setMessage(response.getString("message"));


                                    update_point();
                                    // Set Alert Title
                                    //builder.setTitle("Alert !");

                                    // Set Cancelable false for when the user clicks on the outside the Dialog Box then it will remain show
                                    builder.setCancelable(false);

                                    // Set the positive button with yes name Lambda OnClickListener method is use of DialogInterface interface.
                                    builder.setPositiveButton("ok", (DialogInterface.OnClickListener) (dialog, which) -> {
                                        // When the user click yes button then app will close
                                        dialog.dismiss();
                                    });
                                    // Create the Alert dialog
                                    AlertDialog alertDialog = builder.create();
                                    // Show the Alert Dialog box
                                    alertDialog.show();
                                    hidepDialog();

                                } else if (response.getString("error").equalsIgnoreCase("true")) {
                                    hidepDialog();
                                }
                            } catch (JSONException e) {
                                e.printStackTrace();
                                hidepDialog();
                            }
                        }
                    }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    //Log.println(10)
                    Toast.makeText(MainActivity.this, "Er-  " + error.getMessage(), Toast.LENGTH_LONG).show();
                    hidepDialog();
                }
            }) {

                @Override
                protected Map<String, String> getParams() {
                    Map<String, String> params = new HashMap<String, String>();
                    params.put(ID, AppController.getInstance().getApi_token());
                    params.put("uid", get_uid(MainActivity.this));
                    return params;
                }
            };
            AppController.getInstance().getRequestQueue().getCache().clear();
            AppController.getInstance().addToRequestQueue(jsonReq);
        }
    }

    public void update(Context context) {

        if (AppController.getInstance().isConnected((AppCompatActivity) context) && !(AppController.getInstance().getApi_token().equals("0"))) {
            JsonRequest jsonReq = new JsonRequest(Request.Method.POST, GET_USER, null,
                    new Response.Listener<JSONObject>() {
                        @Override
                        public void onResponse(JSONObject response) {
                            if (AppController.getInstance().authorize(response, AppController.getInstance().getApi_token())) {

                            } else {


                            }
                        }
                    }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    Toast.makeText(context, "error - " + error.getLocalizedMessage(), Toast.LENGTH_SHORT).show();

                }
            }) {

                @Override
                protected Map<String, String> getParams() {
                    Map<String, String> params = new HashMap<String, String>();
                    params.put(ID, "" + AppController.getInstance().getApi_token());
                    return params;
                }
            };

            AppController.getInstance().addToRequestQueue(jsonReq);

        } else {

        }


    }

    private void show_ad() {
        if (isAd){
            isAd = false;
        }else {
            count++;
        }

        int adint = Integer.parseInt(AppController.getInstance().getBack_ad_int());
        if (count>=adint && !Objects.equals(AppController.getInstance().getBack_ad(), "0")){
            count = 0;
            isAd = true;
            ShowInterstitialAd(MainActivity.this,AppController.getInstance().getBack_ad());
        }
    }

}
