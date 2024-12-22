package com.earncash.rewardsapp.helper;


import static com.earncash.rewardsapp.helper.Constatnt.ACCOUNT_STATE_ENABLED;

import static com.earncash.rewardsapp.helper.Constatnt.ADD_POINTS;
import static com.earncash.rewardsapp.helper.Constatnt.GET_USER;
import static com.earncash.rewardsapp.helper.Constatnt.ID;
import static com.earncash.rewardsapp.helper.Constatnt.REDEEM_;
import static com.unity3d.services.core.properties.ClientProperties.getApplicationContext;

import android.app.Activity;

import android.app.Dialog;
import android.content.Context;

import android.content.Intent;

import android.graphics.Color;
import android.graphics.drawable.ColorDrawable;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;
import android.os.Bundle;
import android.text.TextUtils;
import android.util.Log;
import android.util.Patterns;
import android.view.Gravity;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.view.Window;
import android.view.WindowManager;
import android.widget.TextView;
import android.widget.Toast;

import androidx.appcompat.app.AppCompatActivity;
import androidx.fragment.app.FragmentActivity;
import androidx.fragment.app.FragmentManager;
import androidx.fragment.app.FragmentTransaction;

import com.android.volley.Request;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.earncash.rewardsapp.R;
import com.earncash.rewardsapp.WelcomeActivity;
import com.earncash.rewardsapp.csm.DialogFrag.Coins;
import com.earncash.rewardsapp.csm.MainActivity;

import org.json.JSONObject;

import java.text.DecimalFormat;
import java.util.HashMap;
import java.util.Map;


public class PrefManager {
    static Context context;
    static AppCompatActivity activity;

    public PrefManager(Context context) {
        this.context = context;
    }

    public static void setWindowFlag(Activity activity, final int bits, boolean on) {
        Window win = activity.getWindow();
        WindowManager.LayoutParams winParams = win.getAttributes();
        if (on) {
            winParams.flags |= bits;
        } else {
            winParams.flags &= ~bits;
        }
        win.setAttributes(winParams);
    }


    public static void algoratham(Context context) {
      //  Toast.makeText(context, "1", Toast.LENGTH_SHORT).show();

        if (AppController.getInstance().isConnected((AppCompatActivity) context) && !(AppController.getInstance().getApi_token().equals("0"))) {
            JsonRequest jsonReq = new JsonRequest(Request.Method.POST, GET_USER, null,
                    new Response.Listener<JSONObject>() {
                        @Override
                        public void onResponse(JSONObject response) {

                            if (AppController.getInstance().authorize(response, AppController.getInstance().getApi_token())) {

                                if (AppController.getInstance().getState().equalsIgnoreCase(ACCOUNT_STATE_ENABLED)) {

                                    Intent i = new Intent(context, MainActivity.class);
                                    i.putExtra("new_user", "old");
                                    i.addFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
                                    i.addFlags(Intent.FLAG_ACTIVITY_NEW_TASK);
                                    i.addFlags(Intent.FLAG_ACTIVITY_CLEAR_TASK);
                                    context.startActivity(i);

                                    ((Activity) context).finish();


                                } else {
                                    Intent i = new Intent(context, WelcomeActivity.class);
                                    i.addFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
                                    i.addFlags(Intent.FLAG_ACTIVITY_NEW_TASK);
                                    i.addFlags(Intent.FLAG_ACTIVITY_CLEAR_TASK);
                                    context.startActivity(i);
                                    AppController.getInstance().logout((AppCompatActivity) context);
                                    ((Activity) context).finish();
                                }

                            } else {
                                Intent i = new Intent(context, WelcomeActivity.class);
                                i.addFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
                                i.addFlags(Intent.FLAG_ACTIVITY_NEW_TASK);
                                i.addFlags(Intent.FLAG_ACTIVITY_CLEAR_TASK);
                                context.startActivity(i);
                                ((Activity) context).finish();
                            }
                        }
                    }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    Intent i = new Intent(context, WelcomeActivity.class);
                    i.addFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
                    i.addFlags(Intent.FLAG_ACTIVITY_NEW_TASK);
                    i.addFlags(Intent.FLAG_ACTIVITY_CLEAR_TASK);
                    context.startActivity(i);
                    ((Activity) context).finish();
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
            Intent i = new Intent(context, WelcomeActivity.class);
            i.addFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
            i.addFlags(Intent.FLAG_ACTIVITY_NEW_TASK);
            i.addFlags(Intent.FLAG_ACTIVITY_CLEAR_TASK);
            context.startActivity(i);
            ((Activity) context).finish();

        }


    }

    public static boolean isConnected(Context context) {
        boolean connected = false;
        try {
            ConnectivityManager cm = (ConnectivityManager) context.getSystemService(Context.CONNECTIVITY_SERVICE);
            NetworkInfo nInfo = cm.getActiveNetworkInfo();
            connected = nInfo != null && nInfo.isAvailable() && nInfo.isConnected();
            return connected;
        } catch (Exception e) {
            Log.e("Connectivity Exception", e.getMessage());
        }
        return connected;
    }

    public static void ShowToast(Activity activity,String msg, Boolean error){
        LayoutInflater inflater = activity.getLayoutInflater();
        View layout;
        if (error){
            layout = inflater.inflate(R.layout.csm_toast_error,
                    (ViewGroup) activity.findViewById(R.id.toast_layout_root));
        }else {
            layout = inflater.inflate(R.layout.csm_toast,
                    (ViewGroup) activity.findViewById(R.id.toast_layout_root));
        }

        TextView text = (TextView) layout.findViewById(R.id.text);

        Toast toast = new Toast(getApplicationContext());
        toast.setGravity(Gravity.BOTTOM, 0, -30);
        toast.setDuration(Toast.LENGTH_LONG);
        toast.setView(layout);
        text.setText(msg);
        toast.show();
    }

    public static void redeem_package(final Context contextt, String package_id, String p_details, String amount_id, Activity activity) {
        Dialog dialogg = new Dialog(contextt);
        dialogg.setContentView(R.layout.loading);
        dialogg.getWindow().setBackgroundDrawable(new ColorDrawable
                (Color.TRANSPARENT));
        dialogg.setCancelable(false);
        dialogg.show();






        JsonRequest stringRequest = new JsonRequest(Request.Method.POST, REDEEM_, null,
                new Response.Listener<JSONObject>() {
                    @Override
                    public void onResponse(JSONObject response) {
                        dialogg.dismiss();
                        try {
                            if (response.getString("error").equalsIgnoreCase("false")) {
                                if (response.getString("message").equals("Not enough points available to redeem")) {
                                    ShowToast(activity,response.getString("message"),true);
                                 //   Toast.makeText(contextt, response.getString("message"), Toast.LENGTH_SHORT).show();
                                } else {
                                    ShowToast(activity,response.getString("message"),false);
                                  //  Toast.makeText(contextt, response.getString("message"), Toast.LENGTH_SHORT).show();
                                }


                            } else {
                                ShowToast(activity,response.getString("message"),true);

                               // Toast.makeText(contextt, response.getString("message"), Toast.LENGTH_SHORT).show();
                            }
                        } catch (Exception e) {
                            dialogg.dismiss();
                        }
                    }

                },
                new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError error) {
                        Toast.makeText(contextt, error.getMessage(), Toast.LENGTH_SHORT).show();
                    }
                }) {
            @Override
            protected Map<String, String> getParams() {
                Map<String, String> params = new HashMap<String, String>();
                params.put(ID, AppController.getInstance().getApi_token());
                params.put("redeem", package_id);
                params.put("p_details", p_details);
                params.put("amount_id", amount_id);
                return params;
            }

        };

        AppController.getInstance().addToRequestQueue(stringRequest);

    }

    public static String setA() {
        DecimalFormat df = new DecimalFormat("0");
        int am = Integer.parseInt(AppController.getInstance().getPoints());
        if (am >= 10000) {
            float prize_pool = am / 1000;
            String amount = df.format(prize_pool) + "K";
            return amount;
        } else {
            String amount = String.valueOf(AppController.getInstance().getPoints());
            return amount;
        }
    }



    public static void AddC (Context context,String coins, String from, Boolean dialog,String extra, Boolean x2)
    {
        if (dialog) {
            FragmentManager fragmentManager = ((FragmentActivity) context).getSupportFragmentManager();
            Coins newFragment = new Coins();
            Bundle args = new Bundle();
            args.putString("coins", coins);
            args.putBoolean("x2",x2);
            args.putString("from",from);
            newFragment.setArguments(args);
            FragmentTransaction transaction = fragmentManager.beginTransaction();
            transaction.setTransition(FragmentTransaction.TRANSIT_FRAGMENT_OPEN);
            transaction.add(android.R.id.content, newFragment).addToBackStack(null).commit();
        }
        addPoint(context, coins, from,dialog,extra);
    }

    public static void addPoint(final Context context, final String points, final String from, Boolean toast,String extra) {
        JsonRequest stringRequest = new JsonRequest(Request.Method.POST, ADD_POINTS, null,
                new Response.Listener<JSONObject>() {
                    @Override
                    public void onResponse(JSONObject response) {

                        try {

                            if (response.getString("error").equalsIgnoreCase("false")) {
                                if (!toast) {
                                    ShowToast((Activity) context,response.getString("message"),false);
                                    //Toast.makeText(context, response.getString("message"), Toast.LENGTH_SHORT).show();
                                }
                            }
                        } catch (Exception e) {
                            Toast.makeText(context, "--"+e.getMessage(), Toast.LENGTH_SHORT).show();

                        }
                    }

                },
                new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError error) {
                        Toast.makeText(context, ""+error.getMessage(), Toast.LENGTH_SHORT).show();
                    }
                }) {
            @Override
            protected Map<String, String> getParams() {
                Map<String, String> params = new HashMap<String, String>();
                params.put(ID, AppController.getInstance().getApi_token());
                params.put("from", from);
                params.put("coins", points);
                if (extra!=null){params.put("extra", extra);}
                return params;
            }

        };

        AppController.getInstance().addToRequestQueue(stringRequest);

    }

    public static void updateDaily() {
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

    public static String getInK(long count) {
        if (count < 1000) return "" + count;
        int exp = (int) (Math.log(count) / Math.log(1000));
        return String.format("%.1f%c",
                count / Math.pow(1000, exp),
                "kMGTPE".charAt(exp-1));
    }

    public static boolean isValidEmail(CharSequence target) {
        return (!TextUtils.isEmpty(target) && Patterns.EMAIL_ADDRESS.matcher(target).matches());
    }

}
