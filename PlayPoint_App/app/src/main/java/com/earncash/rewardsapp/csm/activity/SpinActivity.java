package com.earncash.rewardsapp.csm.activity;

import static com.earncash.rewardsapp.helper.AppController.ShowInterstitialAd;
import static com.earncash.rewardsapp.helper.AppController.hidepDialog;
import static com.earncash.rewardsapp.helper.AppController.initpDialog;
import static com.earncash.rewardsapp.helper.AppController.showpDialog;
import static com.earncash.rewardsapp.helper.Constatnt.BG_SPIN;
import static com.earncash.rewardsapp.helper.Constatnt.CHECK_SPIN;
import static com.earncash.rewardsapp.helper.Constatnt.ID;
import static com.earncash.rewardsapp.helper.PrefManager.AddC;
import static com.earncash.rewardsapp.helper.PrefManager.setWindowFlag;

import androidx.annotation.Nullable;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.content.ContextCompat;

import android.content.pm.ActivityInfo;
import android.graphics.Color;
import android.graphics.drawable.Drawable;
import android.os.Build;
import android.os.Bundle;
import android.os.CountDownTimer;
import android.os.Handler;
import android.view.View;
import android.view.WindowManager;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.TextView;
import android.widget.Toast;

import com.android.volley.Request;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.bumptech.glide.Glide;
import com.bumptech.glide.load.DataSource;
import com.bumptech.glide.load.engine.GlideException;
import com.bumptech.glide.request.RequestListener;
import com.bumptech.glide.request.target.Target;
import com.earncash.rewardsapp.R;
import com.earncash.rewardsapp.csm.luckywheel.LuckyWheelView;
import com.earncash.rewardsapp.csm.luckywheel.model.LuckyItem;
import com.earncash.rewardsapp.helper.AppController;
import com.earncash.rewardsapp.helper.JsonRequest;

import org.json.JSONObject;

import java.text.DecimalFormat;
import java.text.NumberFormat;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Map;
import java.util.Random;

import de.hdodenhof.circleimageview.CircleImageView;

public class SpinActivity extends AppCompatActivity {
    LuckyWheelView luckyWheelView;
    List<LuckyItem> data = new ArrayList<>();
    LinearLayout spin_btn;
    ImageView back;
    TextView left_txt,coins_txt;
    CircleImageView pro_img;
    ImageView bg_spin;
    Boolean isSpin = false,is_loaded=false,isTime = false;
    int coin_earn = 0;
    int adCount = 0;
    CountDownTimer countDownTimer;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
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
        setContentView(R.layout.activity_spin);

        luckyWheelView = findViewById(R.id.viewLuckyWheel);
        spin_btn = findViewById(R.id.spin_btn);
        left_txt = findViewById(R.id.left);
        back = findViewById(R.id.back);
        coins_txt = findViewById(R.id.coins);


        initpDialog(this);

        coins_txt.setText(AppController.getInstance().getPoints());

      /*  back.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                if (isSpin) {
                    Toast.makeText(SpinActivity.this, "Wait for the spinner to finish!", Toast.LENGTH_SHORT).show();} else {finish();}
            }
        });*/

        spin_btn.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                spin_btn.setEnabled(false);
                isSpin = true;
                final int random = new Random().nextInt((9 - 0) + 1) + 0;
                luckyWheelView.startLuckyWheelWithTargetIndex(random);
            }
        });

        back.setOnClickListener(v->{
            if (!isSpin){
                finish();
            }else {
                Toast.makeText(this, "Wait for spinner to finish!", Toast.LENGTH_SHORT).show();
            }

        });

        spin_btn.setEnabled(false);
        check_spinner();
        bg_spin = findViewById(R.id.bg_spin);
        showpDialog();
        Glide.with(SpinActivity.this).load(BG_SPIN).addListener(new RequestListener<Drawable>() {
            @Override
            public boolean onLoadFailed(@Nullable GlideException e, Object model, Target<Drawable> target, boolean isFirstResource) {
                hidepDialog();
                return false;
            }

            @Override
            public boolean onResourceReady(Drawable resource, Object model, Target<Drawable> target, DataSource dataSource, boolean isFirstResource) {
                hidepDialog();
                return false;
            }
        }).into(bg_spin);

        luckyWheelView.setLuckyRoundItemSelectedListener(new LuckyWheelView.LuckyRoundItemSelectedListener() {
            @Override
            public void LuckyRoundItemSelected(int index) {

                String poss = ""+index;
                spin_btn.setEnabled(false);
                isSpin = false;
                String DAILY_TYPE = "Spin Reward";
                int coins = 0;

                switch (poss)
                {
                    case "0":
                        AddC(SpinActivity.this,getString(R.string.spin_coin_1),DAILY_TYPE,true,null,true);
                        coins = 5;
                        break;
                    case "1":
                        AddC(SpinActivity.this,getString(R.string.spin_coin_2),DAILY_TYPE,true,null,true);
                        coins = 7;
                        break;

                    case "2":
                        AddC(SpinActivity.this,getString(R.string.spin_coin_3),DAILY_TYPE,true,null,true);
                        coins = 8;
                        break;

                    case "3":
                        AddC(SpinActivity.this,getString(R.string.spin_coin_4),DAILY_TYPE,true,null,true);
                        coins = 10;
                        break;

                    case "4":
                        AddC(SpinActivity.this,getString(R.string.spin_coin_5),DAILY_TYPE,true,null,true);
                        coins = 4;
                        break;

                    case "5":
                        AddC(SpinActivity.this,getString(R.string.spin_coin_6),DAILY_TYPE,true,null,true);
                        coins = 5;
                        break;

                    case "6":
                        AddC(SpinActivity.this,getString(R.string.spin_coin_7),DAILY_TYPE,true,null,true);
                        coins = 20;
                        break;

                    case "7":
                        AddC(SpinActivity.this,getString(R.string.spin_coin_8),DAILY_TYPE,true,null,true);
                        coins = 1;
                        break;

                    case "8":
                        AddC(SpinActivity.this,getString(R.string.spin_coin_9),DAILY_TYPE,true,null,true);
                        coins = 10;
                        break;

                    case "9":
                        AddC(SpinActivity.this,getString(R.string.spin_coin_10),DAILY_TYPE,true,null,true);
                        coins = 6;
                        break;

                    default:
                        AddC(SpinActivity.this,getString(R.string.spin_coin_1),DAILY_TYPE,true,null,true);
                        coins = 5;
                }
                coin_earn = Integer.parseInt(AppController.getInstance().getPoints())+coins;
                coins_txt.setText(""+coin_earn);
                new Handler().postDelayed(new Runnable() {
                    @Override
                    public void run() {
                        check_spinner();
                    }
                }, 200);

                adCount++;
                int adint = Integer.parseInt(AppController.getInstance().getSpin_ad_int());
                if (adCount>=adint && adint!=0){
                    adCount = 0;
                    ShowInterstitialAd(SpinActivity.this,AppController.getInstance().getSpin_ad());
                }
            }
        });

        // luckyWheelView.setData();
        create(0,getString(R.string.spin_coin_1)+" ",R.drawable.ic_csm_spin_coin, ContextCompat.getColor(this, R.color.colorPrimary), new int[]{10},1,ContextCompat.getColor(this, R.color.wheel_b),ContextCompat.getColor(this, R.color.white));
        create(1,getString(R.string.spin_coin_2)+" ",R.drawable.ic_csm_spin_coin,ContextCompat.getColor(this, R.color.white), new int[]{10},2,ContextCompat.getColor(this, R.color.wheel_b),ContextCompat.getColor(this, R.color.colorPrimary));
        create(2,getString(R.string.spin_coin_3)+" ",R.drawable.ic_csm_spin_coin,ContextCompat.getColor(this, R.color.colorPrimary), new int[]{10},3,ContextCompat.getColor(this, R.color.wheel_b),ContextCompat.getColor(this, R.color.white));
        create(3,getString(R.string.spin_coin_4)+" ",R.drawable.ic_csm_spin_coin,ContextCompat.getColor(this, R.color.white), new int[]{10},20,ContextCompat.getColor(this, R.color.wheel_b),ContextCompat.getColor(this, R.color.colorPrimary));
        create(4,getString(R.string.spin_coin_5)+" ",R.drawable.ic_csm_spin_coin,ContextCompat.getColor(this, R.color.colorPrimary), new int[]{10},30,ContextCompat.getColor(this, R.color.wheel_b),ContextCompat.getColor(this, R.color.white));
        create(5,getString(R.string.spin_coin_6)+" ",R.drawable.ic_csm_spin_coin,ContextCompat.getColor(this, R.color.white), new int[]{10},40,ContextCompat.getColor(this, R.color.wheel_b),ContextCompat.getColor(this, R.color.colorPrimary));
        create(6,getString(R.string.spin_coin_7)+" ",R.drawable.ic_csm_spin_coin,ContextCompat.getColor(this, R.color.colorPrimary), new int[]{10},50,ContextCompat.getColor(this, R.color.wheel_b),ContextCompat.getColor(this, R.color.white));
        create(7,getString(R.string.spin_coin_8)+" ",R.drawable.ic_csm_spin_coin,ContextCompat.getColor(this, R.color.white), new int[]{10},60,ContextCompat.getColor(this, R.color.wheel_b),ContextCompat.getColor(this, R.color.colorPrimary));
        create(8,getString(R.string.spin_coin_9)+" ",R.drawable.ic_csm_spin_coin,ContextCompat.getColor(this, R.color.colorPrimary), new int[]{10},70,ContextCompat.getColor(this, R.color.wheel_b),ContextCompat.getColor(this, R.color.white));
        create(9,getString(R.string.spin_coin_10)+" ",R.drawable.ic_csm_spin_coin,ContextCompat.getColor(this, R.color.white), new int[]{10},80,ContextCompat.getColor(this, R.color.wheel_b),ContextCompat.getColor(this, R.color.colorPrimary));
        luckyWheelView.setData(data);
        //spin_btn.setEnabled(false);

    }

    public void check_spinner() {
        JsonRequest stringRequest = new JsonRequest(Request.Method.POST, CHECK_SPIN, null,
                new Response.Listener<JSONObject>() {
                    @Override
                    public void onResponse(JSONObject response) {
                        try {
                            // Toast.makeText(Spinner_Activity.this, response.toString(), Toast.LENGTH_SHORT).show();
                            if (response.getString("error").equalsIgnoreCase("false")) {
                                int daily = response.getInt("daily");
                                int left = response.getInt("left");
                                int leftt = daily - left;
                                if (left >= daily) {
                                    startTime(response.getInt("time"));
                                    spin_btn.setEnabled(false);
                                } else {
                                    left_txt.setText(leftt + "/" + daily);
                                    spin_btn.setEnabled(true);
                                }
                            } else {
                                Toast.makeText(SpinActivity.this, response.getString("message"), Toast.LENGTH_SHORT).show();
                            }
                        } catch (Exception e) {
                            Toast.makeText(getApplicationContext(), e.toString(), Toast.LENGTH_SHORT).show();

                        }
                    }

                },
                new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError error) {
                        Toast.makeText(SpinActivity.this, error.getMessage(), Toast.LENGTH_SHORT).show();
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

    public void create(int index, String partTitle, int partIcon, int partColor,int[] itemChance,int itemReward,int bColor, int textColor)
    {
        LuckyItem item = new LuckyItem(partTitle, partIcon, partColor, itemChance, itemReward,bColor,textColor);
        data.add(item);

    }

    @Override
    public void onResume() {
        super.onResume();
        TextView diamond = findViewById(R.id.diamond);
        diamond.setText(AppController.getInstance().getDiamond());
    }

    @Override
    public void onBackPressed() {
        if (!isSpin){
            finish();
        }else {
            Toast.makeText(this, "Wait for spinner to finish!", Toast.LENGTH_SHORT).show();
        }
    }


    private void startTime(int time) {
        isTime = true;
        countDownTimer = new CountDownTimer(time * 1000L, 1000) {
            public void onTick(long millisUntilFinished) {
                // Used for formatting digit to be in 2 digits only
                NumberFormat f = new DecimalFormat("00");
                long hour = (millisUntilFinished / 3600000) % 24;
                long min = (millisUntilFinished / 60000) % 60;
                long sec = (millisUntilFinished / 1000) % 60;
                left_txt.setText(f.format(hour) + ":" + f.format(min) + ":" + f.format(sec));
            }

            // When the task is over it will print 00:00:00 there
            public void onFinish() {
                left_txt.setText("00:00:00");
            }
        }.start();
    }

    @Override
    protected void onDestroy() {
        super.onDestroy();
        if (isTime) {
            countDownTimer.cancel();
        }

    }


}