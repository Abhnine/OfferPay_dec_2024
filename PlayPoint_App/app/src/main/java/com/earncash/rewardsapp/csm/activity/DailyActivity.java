package com.earncash.rewardsapp.csm.activity;

import static com.earncash.rewardsapp.helper.AppController.hidepDialog;
import static com.earncash.rewardsapp.helper.AppController.initpDialog;
import static com.earncash.rewardsapp.helper.AppController.shineStart_lin;
import static com.earncash.rewardsapp.helper.Constatnt.DAILY_B;
import static com.earncash.rewardsapp.helper.Constatnt.ID;
import static com.earncash.rewardsapp.helper.PrefManager.AddC;
import static com.earncash.rewardsapp.helper.PrefManager.setWindowFlag;

import androidx.appcompat.app.AppCompatActivity;
import androidx.core.content.ContextCompat;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import android.content.pm.ActivityInfo;
import android.graphics.Color;
import android.os.Build;
import android.os.Bundle;
import android.os.Handler;
import android.view.View;
import android.view.WindowManager;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.RelativeLayout;
import android.widget.TextView;
import android.widget.Toast;

import com.android.volley.Request;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.earncash.rewardsapp.R;
import com.earncash.rewardsapp.csm.adapter.AdapterDailyLoginTask;
import com.earncash.rewardsapp.csm.model.ModelDailyLoginTask;
import com.earncash.rewardsapp.helper.AppController;
import com.earncash.rewardsapp.helper.JsonRequest;

import org.json.JSONArray;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

public class DailyActivity extends AppCompatActivity {

    TextView coin_1, coin_2, coin_3, coin_4, coin_5, coin_6, coin_7;
    RelativeLayout btn_1, btn_2, btn_3, btn_4, btn_5, btn_6, btn_7, claim_1, claim_2, claim_3, claim_4, claim_5, claim_6, claim_7;
    int coin_earn = 0;
    ImageView back, done_1, done_2, done_3, done_4,
            done_5, done_6, done_7, lock_1, lock_2,
            lock_3, lock_4, lock_5, lock_6, lock_7,
            miss_1, miss_2, miss_3, miss_4, miss_5, miss_6, miss_7, img_shine_1,img_shine_2,img_shine_3,img_shine_4,img_shine_5,img_shine_6,img_shine_7;
    TextView coins_txt;
    RecyclerView list;
    AdapterDailyLoginTask adapter;
    List<ModelDailyLoginTask> model = new ArrayList<>();
    @Override
    protected void onCreate(Bundle savedInstanceState) {
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
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_daily);

        coin_1 = findViewById(R.id.coin_1);
        coin_2 = findViewById(R.id.coin_2);
        coin_3 = findViewById(R.id.coin_3);
        coin_4 = findViewById(R.id.coin_4);
        coin_5 = findViewById(R.id.coin_5);
        coin_6 = findViewById(R.id.coin_6);
        coin_7 = findViewById(R.id.coin_7);

        btn_1 = findViewById(R.id.btn_1);
        btn_2 = findViewById(R.id.btn_2);
        btn_3 = findViewById(R.id.btn_3);
        btn_4 = findViewById(R.id.btn_4);
        btn_5 = findViewById(R.id.btn_5);
        btn_6 = findViewById(R.id.btn_6);
        btn_7 = findViewById(R.id.btn_7);

        coins_txt = findViewById(R.id.coins);
        back = findViewById(R.id.back);

        done_1 = findViewById(R.id.done_1);
        done_2 = findViewById(R.id.done_2);
        done_3 = findViewById(R.id.done_3);
        done_4 = findViewById(R.id.done_4);
        done_5 = findViewById(R.id.done_5);
        done_6 = findViewById(R.id.done_6);
        done_7 = findViewById(R.id.done_7);

        lock_1 = findViewById(R.id.lock_1);
        lock_2 = findViewById(R.id.lock_2);
        lock_3 = findViewById(R.id.lock_3);
        lock_4 = findViewById(R.id.lock_4);
        lock_5 = findViewById(R.id.lock_5);
        lock_6 = findViewById(R.id.lock_6);
        lock_7 = findViewById(R.id.lock_7);

        claim_1 = findViewById(R.id.claim_1);
        claim_2 = findViewById(R.id.claim_2);
        claim_3 = findViewById(R.id.claim_3);
        claim_4 = findViewById(R.id.claim_4);
        claim_5 = findViewById(R.id.claim_5);
        claim_6 = findViewById(R.id.claim_6);
        claim_7 = findViewById(R.id.claim_7);

        miss_1 = findViewById(R.id.miss_1);
        miss_2 = findViewById(R.id.miss_2);
        miss_3 = findViewById(R.id.miss_3);
        miss_4 = findViewById(R.id.miss_4);
        miss_5 = findViewById(R.id.miss_5);
        miss_6 = findViewById(R.id.miss_6);
        miss_7 = findViewById(R.id.miss_7);

        img_shine_1 = findViewById(R.id.img_shine_1);
        img_shine_2 = findViewById(R.id.img_shine_2);
        img_shine_3 = findViewById(R.id.img_shine_3);
        img_shine_4 = findViewById(R.id.img_shine_4);
        img_shine_5 = findViewById(R.id.img_shine_5);
        img_shine_6 = findViewById(R.id.img_shine_6);
        img_shine_7 = findViewById(R.id.img_shine_7);

        list = findViewById(R.id.list);


        back.setOnClickListener(v -> {
            finish();
        });
        coins_txt.setText(AppController.getInstance().getPoints());
        initpDialog(this);
        btn_1.setEnabled(false);
        btn_2.setEnabled(false);
        btn_3.setEnabled(false);
        btn_4.setEnabled(false);
        btn_5.setEnabled(false);
        btn_6.setEnabled(false);
        btn_7.setEnabled(false);


    }

    public void get_daily() {
        model.clear();
        LinearLayout loading = findViewById(R.id.loading);
        JsonRequest stringRequest = new JsonRequest(Request.Method.POST, DAILY_B, null,
                new Response.Listener<JSONObject>() {
                    @Override
                    public void onResponse(JSONObject response) {
                        try {
                            hidepDialog();
                            // Toast.makeText(Spinner_Activity.this, response.toString(), Toast.LENGTH_SHORT).show();
                            if (response.getString("error").equalsIgnoreCase("false")) {
                                coin_1.setText(response.getString("reward_1"));
                                coin_2.setText(response.getString("reward_2"));
                                coin_3.setText(response.getString("reward_3"));
                                coin_4.setText(response.getString("reward_4"));
                                coin_5.setText(response.getString("reward_5"));
                                coin_6.setText(response.getString("reward_6"));
                                coin_7.setText(response.getString("reward_7"));

                                setStatus(response.getInt("day_s_1"), claim_1, done_1, lock_1, miss_1);
                                setStatus(response.getInt("day_s_2"), claim_2, done_2, lock_2, miss_2);
                                setStatus(response.getInt("day_s_3"), claim_3, done_3, lock_3, miss_3);
                                setStatus(response.getInt("day_s_4"), claim_4, done_4, lock_4, miss_4);
                                setStatus(response.getInt("day_s_5"), claim_5, done_5, lock_5, miss_5);
                                setStatus(response.getInt("day_s_6"), claim_6, done_6, lock_6, miss_6);
                                setStatus(response.getInt("day_s_7"), claim_7, done_7, lock_7, miss_7);

                                if (response.getInt("day_s_1") == 0) {
                                    setClick(btn_1, response.getInt("reward_1"),claim_1,done_1,img_shine_1);
                                } else if (response.getInt("day_s_2") == 0) {
                                    setClick(btn_2, response.getInt("reward_2"),claim_2,done_2,img_shine_2);
                                } else if (response.getInt("day_s_3") == 0) {
                                    setClick(btn_3, response.getInt("reward_3"),claim_3,done_3,img_shine_3);
                                } else if (response.getInt("day_s_4") == 0) {
                                    setClick(btn_4, response.getInt("reward_4"),claim_4,done_4,img_shine_4);
                                } else if (response.getInt("day_s_5") == 0) {
                                    setClick(btn_5, response.getInt("reward_5"),claim_5,done_5,img_shine_5);
                                } else if (response.getInt("day_s_6") == 0) {
                                    setClick(btn_6, response.getInt("reward_6"),claim_6,done_6,img_shine_6);
                                } else if (response.getInt("day_s_7") == 0) {
                                    setClick(btn_7, response.getInt("reward_7"),claim_7,done_7,img_shine_7);
                                }

                                JSONArray trans = response.getJSONArray("data");
                                if (trans.length()>0) {
                                    for (int i = 0; i < trans.length(); i++) {
                                        JSONObject offer = trans.getJSONObject(i);

                                        String id = offer.getString("id");
                                        String days = offer.getString("days");
                                        String coins = offer.getString("coins");
                                        Boolean status = offer.getBoolean("status");
                                        int total_days = response.getInt("total_days");

                                        ModelDailyLoginTask item = new ModelDailyLoginTask(id,days,coins,total_days,status);
                                        model.add(item);
                                    }

                                    list.setLayoutManager(new LinearLayoutManager(DailyActivity.this));
                                    adapter = new AdapterDailyLoginTask(model,DailyActivity.this);
                                    list.setAdapter(adapter);
                                    loading.setVisibility(View.GONE);
                                    list.setVisibility(View.VISIBLE);

                                }else{
                                }




                            } else {
                                Toast.makeText(DailyActivity.this, response.getString("message"), Toast.LENGTH_SHORT).show();
                            }
                        } catch (Exception e) {
                            Toast.makeText(getApplicationContext(), e.toString(), Toast.LENGTH_SHORT).show();

                        }
                    }

                },
                new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError error) {
                        Toast.makeText(DailyActivity.this, error.getMessage(), Toast.LENGTH_SHORT).show();
                    }
                }) {
            @Override
            protected Map<String, String> getParams() {
                Map<String, String> params = new HashMap<String, String>();
                params.put(ID, AppController.getInstance().getApi_token());
                params.put("id", AppController.getInstance().getUid());
                return params;
            }

        };

        AppController.getInstance().addToRequestQueue(stringRequest);

    }

    private void setClick(RelativeLayout btn, int coins,RelativeLayout claim,ImageView done,ImageView img_shine) {
        btn.setBackground(ContextCompat.getDrawable(this, R.drawable.bg_csm_home_golden_btn));
        shineStart_lin(DailyActivity.this,btn,img_shine,1500);
        btn.setOnClickListener(v -> {
            btn.setEnabled(false);
            AddC(DailyActivity.this, "" + coins, "Daily Reward", true,null,false);
            claim.setVisibility(View.GONE);
            done.setVisibility(View.VISIBLE);
            img_shine.setVisibility(View.GONE);
            btn.setBackground(ContextCompat.getDrawable(this, R.drawable.bg_csm_daily_bonus));
            coin_earn = Integer.parseInt(AppController.getInstance().getPoints()) + coins;
            coins_txt.setText("" + coin_earn);
            new Handler().postDelayed(new Runnable() {
                @Override
                public void run() {
                    get_daily();
                }
            }, 200);

        });

        btn.setEnabled(true);
    }

    private void setStatus(int status, RelativeLayout claim, ImageView done, ImageView lock, ImageView miss) {
        if (status == 0) {
            claim.setVisibility(View.VISIBLE);
            //claim
        } else if (status == 1) {
            //CLAIMED
            done.setVisibility(View.VISIBLE);

        } else if (status == 2) {
            //MISSED
            miss.setVisibility(View.VISIBLE);
        } else if (status == 3) {
            //upcoming
            lock.setVisibility(View.VISIBLE);
        }
    }

    @Override
    public void onResume() {
        super.onResume();
        LinearLayout loading = findViewById(R.id.loading);
        loading.setVisibility(View.VISIBLE);
        list.setVisibility(View.GONE);
        get_daily();
        TextView diamond = findViewById(R.id.diamond);
        diamond.setText(AppController.getInstance().getDiamond());
    }

}