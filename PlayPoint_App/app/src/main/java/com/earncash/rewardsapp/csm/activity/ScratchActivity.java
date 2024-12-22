package com.earncash.rewardsapp.csm.activity;

import static com.earncash.rewardsapp.helper.AppController.ShowInterstitialAd;
import static com.earncash.rewardsapp.helper.Constatnt.BG_SPIN;
import static com.earncash.rewardsapp.helper.Constatnt.CHECK_SCRATCH;
import static com.earncash.rewardsapp.helper.Constatnt.ID;
import static com.earncash.rewardsapp.helper.PrefManager.AddC;
import static com.earncash.rewardsapp.helper.PrefManager.setWindowFlag;

import androidx.appcompat.app.AppCompatActivity;
import androidx.core.content.ContextCompat;

import android.content.pm.ActivityInfo;
import android.graphics.Color;
import android.os.Build;
import android.os.Bundle;
import android.os.CountDownTimer;
import android.os.Handler;
import android.util.Log;
import android.view.View;
import android.view.WindowManager;
import android.widget.ImageView;
import android.widget.TextView;
import android.widget.Toast;

import com.android.volley.Request;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.bumptech.glide.Glide;
import com.earncash.rewardsapp.R;
import com.earncash.rewardsapp.helper.AppController;
import com.earncash.rewardsapp.helper.JsonRequest;

import org.json.JSONObject;

import java.text.DecimalFormat;
import java.text.NumberFormat;
import java.util.HashMap;
import java.util.Map;
import java.util.Objects;
import java.util.Random;

import in.myinnos.androidscratchcard.ScratchCard;


public class ScratchActivity extends AppCompatActivity {
    ScratchCard scratchCardLayout;
    TextView reward_coins;
    TextView left_txt,coins_txt;
    ImageView back,bg_spin;
    int scratch_coins;
    int coin_earn = 0;
    Boolean isDone = true;
    CountDownTimer countDownTimer;
    int adCount = 0;
    boolean scratched = false;
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
        setContentView(R.layout.activity_scratch);

        left_txt = findViewById(R.id.left);
        back = findViewById(R.id.back);
        coins_txt = findViewById(R.id.coins);
        scratchCardLayout = findViewById(R.id.scratchCard);
        reward_coins = findViewById(R.id.reward_coins);
        bg_spin = findViewById(R.id.bg_spin);
        back.setOnClickListener(v->{
            finish();
        });
        Glide.with(ScratchActivity.this).load(BG_SPIN).into(bg_spin);
        coins_txt.setText(AppController.getInstance().getPoints());
       // scratchCardLayout.setScratchEnabled(false);
       // scratchCardLayout.setRevealFullAtPercent(40);
        /*scratchCardLayout.setScratchListener(new ScratchListener() {
            @Override
            public void onScratchStarted() {

            }

            @Override
            public void onScratchProgress(@NonNull ScratchCardLayout scratchCardLayout, int i) {

            }

            @Override
            public void onScratchComplete() {
                if (isDone) {
                    isDone = false;
                    AddC(ScratchActivity.this, "" + scratch_coins, "Scratch Reward", true,null,true);
                    coin_earn = Integer.parseInt(AppController.getInstance().getPoints()) + scratch_coins;
                    coins_txt.setText("" + coin_earn);
                    new Handler().postDelayed(new Runnable() {
                        @Override
                        public void run() {
                            isDone = true;
                            check_spinner();
                        }
                    }, 1000);

                    adCount++;
                    int adint = Integer.parseInt(AppController.getInstance().getScratch_ad_int());
                    if (adCount>=adint && !Objects.equals(AppController.getInstance().getScratch_ad(), "0")){
                        adCount = 0;
                        ShowInterstitialAd(ScratchActivity.this,AppController.getInstance().getScratch_ad());
                    }

                }
            }
        });*/


        scratchCardLayout.setOnScratchListener(new ScratchCard.OnScratchListener() {
            @Override
            public void onScratch(ScratchCard scratchCard, float visiblePercent) {
                if (visiblePercent > 0.3) {

                    scratchCardLayout.setVisibility(View.GONE);

                    if (isDone) {
                        isDone = false;
                        AddC(ScratchActivity.this, "" + scratch_coins, "Scratch Reward", false,null,true);
                        coin_earn = Integer.parseInt(AppController.getInstance().getPoints()) + scratch_coins;
                        coins_txt.setText("" + coin_earn);
                        new Handler().postDelayed(new Runnable() {
                            @Override
                            public void run() {
                                isDone = true;
                                scratched = true;
                                check_spinner();
                            }
                        }, 1000);

                        adCount++;
                        int adint = Integer.parseInt(AppController.getInstance().getScratch_ad_int());
                        if (adCount>=adint && !Objects.equals(AppController.getInstance().getScratch_ad(), "0")){
                            adCount = 0;
                            ShowInterstitialAd(ScratchActivity.this,AppController.getInstance().getScratch_ad());
                        }

                    }

                }
            }
        });

        check_spinner();
    }




    public void check_spinner() {
        JsonRequest stringRequest = new JsonRequest(Request.Method.POST, CHECK_SCRATCH, null,
                new Response.Listener<JSONObject>() {
                    @Override
                    public void onResponse(JSONObject response) {
                        try {
                            // Toast.makeText(Spinner_Activity.this, response.toString(), Toast.LENGTH_SHORT).show();
                            if (response.getString("error").equalsIgnoreCase("false")) {


                                final int min = response.getInt("min");
                                final int max = response.getInt("max");
                                ;
                                final int coins_ = new Random().nextInt((max - min) + 1) + min;
                                scratch_coins = coins_;
                                int daily = response.getInt("daily");
                                int left = response.getInt("left");
                                int leftt = daily - left;

                                if (left >= daily) {
                                    startTime(response.getInt("time"));
                                    findViewById(R.id.blockScratch).setVisibility(View.VISIBLE);
                                } else {
                                    left_txt.setText(leftt + "/" + daily);
                                    scratchCardLayout.setActivated(true);

                                    scratchCardLayout.setScratchDrawable(ContextCompat.getDrawable(getApplicationContext(), R.drawable.img_csm_scratch_card) );
                                    scratchCardLayout.setVisibility(View.VISIBLE);
                                    scratchCardLayout.refreshDrawableState();
                                }
                                if (scratched){
                                    finish();
                                    startActivity(getIntent());
                                }else{
                                    reward_coins.setText("" + coins_);
                                }


                            } else {
                                Toast.makeText(ScratchActivity.this, response.getString("message"), Toast.LENGTH_SHORT).show();
                            }
                        } catch (Exception e) {
                            Toast.makeText(getApplicationContext(), "error1 "+ e.toString(), Toast.LENGTH_SHORT).show();
                            Log.e("Error", "onResponse: "+e.toString());

                        }
                    }

                },
                new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError error) {
                        Toast.makeText(ScratchActivity.this, "error2 "+error.getMessage(), Toast.LENGTH_SHORT).show();
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

    @Override
    public void onResume() {
        super.onResume();
        TextView diamond = findViewById(R.id.diamond);
        diamond.setText(AppController.getInstance().getDiamond());
    }


    private void startTime(int time) {
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
        if (countDownTimer!=null){
            countDownTimer.cancel();
        }

    }


}