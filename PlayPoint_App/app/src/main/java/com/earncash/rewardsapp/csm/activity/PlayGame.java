package com.earncash.rewardsapp.csm.activity;

import static com.earncash.rewardsapp.helper.AppController.ShowInterstitialAd;
import static com.earncash.rewardsapp.helper.AppController.shineStart;
import static com.earncash.rewardsapp.helper.PrefManager.AddC;

import android.app.Dialog;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.pm.ActivityInfo;
import android.graphics.Color;
import android.graphics.drawable.ColorDrawable;
import android.os.Bundle;
import android.os.CountDownTimer;
import android.view.View;
import android.view.WindowManager;
import android.webkit.WebResourceRequest;
import android.webkit.WebSettings;
import android.webkit.WebView;
import android.webkit.WebViewClient;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.ProgressBar;
import android.widget.RelativeLayout;
import android.widget.TextView;
import android.widget.Toast;

import androidx.annotation.NonNull;
import androidx.appcompat.app.AlertDialog;
import androidx.appcompat.app.AppCompatActivity;
import androidx.cardview.widget.CardView;

import com.earncash.rewardsapp.R;
import com.earncash.rewardsapp.helper.AppController;

import java.text.DecimalFormat;
import java.text.NumberFormat;
import java.util.Objects;

import io.github.hyuwah.draggableviewlib.DraggableListener;
import io.github.hyuwah.draggableviewlib.DraggableView;

public class PlayGame extends AppCompatActivity {
    WebView webView;
    LinearLayout shine, close;
    Intent data;
    CountDownTimer countDownTimer;
    long time_left;
    Boolean isOver = false, isAlpha = false, reward = false;
    RelativeLayout drag, loading;
    ProgressBar progress_bar;
    int time_ = 0, alpha_time = 0;
    ImageView img_shine;
    TextView coins;
    int adCount = 0;
    CardView card;
    Boolean isWebLoaded = false, isBack = false;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);

        if (getIntent().getStringExtra("type").equals("1")) {
            setRequestedOrientation(ActivityInfo.SCREEN_ORIENTATION_LANDSCAPE);
        } else {
            setRequestedOrientation(ActivityInfo.SCREEN_ORIENTATION_PORTRAIT);
        }

        getWindow().setFlags(WindowManager.LayoutParams.FLAG_FULLSCREEN,
                WindowManager.LayoutParams.FLAG_FULLSCREEN);

        setContentView(R.layout.activity_play_game2);
        drag = findViewById(R.id.drag);
        progress_bar = findViewById(R.id.progress_bar);
        img_shine = findViewById(R.id.img_shine);
        shine = findViewById(R.id.shine);
        coins = findViewById(R.id.coins);
        card = findViewById(R.id.card);
        close = findViewById(R.id.close);
        // Find the WebView by its unique ID
        data = getIntent();
        coins.setText(data.getStringExtra("coins"));
        DraggableView draggableView = new DraggableView.Builder(drag).setStickyMode(DraggableView.Mode.STICKY_X).build();
        draggableView.setListener(new DraggableListener() {
            @Override
            public void onPositionChanged(@NonNull View view) {
                drag.setAlpha(1f);
                alpha_time = 0;
                isAlpha = false;
            }

            @Override
            public void onLongPress(@NonNull View view) {

            }
        });


        webView = findViewById(R.id.webView);
        loading = findViewById(R.id.loading);
        // this will enable the javascript.
        webView.getSettings().setJavaScriptEnabled(true);

        //webView cache

        webView.getSettings().setCacheMode(WebSettings.LOAD_DEFAULT);
        webView.getSettings().setDomStorageEnabled(true);
        webView.getSettings().setDatabaseEnabled(true);


        webView.getSettings().setSupportZoom(false);
        webView.getSettings().setBuiltInZoomControls(false);
        webView.loadUrl(data.getStringExtra("path"));


        // WebViewClient allows you to handle
        // onPageFinished and override Url loading.
        time_ = Integer.parseInt(data.getStringExtra("time")) * 60000;
        progress_bar.setMax(time_);
        time_left = time_;

        setTime(time_);
        webView.setWebViewClient(new PlayGame.webClint());
        close.setOnClickListener(v -> {
            exit();
        });

    }

    private void showAlert() {
        AlertDialog.Builder builder = new AlertDialog.Builder(PlayGame.this, R.style.MyDialogTheme);
        builder.setMessage("Are you sure, You want to exit ?");
        builder.setCancelable(false);

        builder.setPositiveButton("Yes", (DialogInterface.OnClickListener) (dialog, which) -> {
            finish();
        });
        builder.setNegativeButton("No", new DialogInterface.OnClickListener() {
            @Override
            public void onClick(DialogInterface dialog, int which) {
                dialog.dismiss();
            }
        });
        AlertDialog alertDialog = builder.create();
        alertDialog.show();
        alertDialog.setCancelable(false);
    }

    private void setTime(int time) {
        countDownTimer = new CountDownTimer(time, 1000) {
            public void onTick(long millisUntilFinished) {
                // Used for formatting digit to be in 2 digits only
                NumberFormat f = new DecimalFormat("00");
                time_left = millisUntilFinished;
                int t_left = (int) millisUntilFinished;
                progress_bar.setProgress(time_ - t_left);
                if (alpha_time > 3 && !isAlpha) {
                    drag.setAlpha(0.3f);
                    isAlpha = true;
                } else {
                    alpha_time++;
                }
            }

            // When the task is over it will print 00:00:00 there
            public void onFinish() {
                reward = true;
                progress_bar.setProgress(time_ + 1000);
                drag.setAlpha(1f);
                alpha_time = 0;
                isAlpha = false;
                card.setVisibility(View.VISIBLE);
                shineStart(PlayGame.this, shine, img_shine, 1500);
                setClicks(drag, data.getStringExtra("coins"));
            }
        }.start();

    }

    private void setClicks(RelativeLayout click, String coins) {
        click.setOnClickListener(v -> {
            if (reward) {
                reward = false;
                AddC(PlayGame.this, coins, "Game Reward", true, getIntent().getStringExtra("id"), true);
                card.setVisibility(View.GONE);
                progress_bar.setProgress(0);
                time_left = time_;
                setTime(time_);
            }

            adCount++;
            int ad = Integer.parseInt(AppController.getInstance().getGame_ad_int());
            if (adCount>= ad && !Objects.equals(AppController.getInstance().getGame_ad(), "0")){
                adCount = 0;
                ShowInterstitialAd(PlayGame.this,AppController.getInstance().getGame_ad());
            }
        });

    }

    private class webClint extends WebViewClient {
        @Override
        public void onPageFinished(WebView view, String url) {
            super.onPageFinished(view, url);
            loading.setVisibility(View.GONE);
            webView.setVisibility(View.VISIBLE);
            if (!isWebLoaded) {
                isWebLoaded = true;
                if (data.getStringExtra("time") != null) {


                } else {
                    Toast.makeText(PlayGame.this, "error in loading game!!", Toast.LENGTH_SHORT).show();
                }
            }
        }

        @Override
        public boolean shouldOverrideUrlLoading(WebView view, WebResourceRequest request) {
            String url = String.valueOf(request.getUrl());
            //startActivity(new Intent(Intent.ACTION_VIEW, Uri.parse(url)));


            return false;

        }
    }

    @Override
    protected void onDestroy() {
        super.onDestroy();
        webView.destroy();
        countDownTimer.cancel();
    }

    @Override
    protected void onResume() {
        super.onResume();
        webView.onResume();
        setTime((int) time_left);
    }

    @Override
    protected void onPause() {
        webView.onPause();
        countDownTimer.cancel();
        super.onPause();
    }

  /*  @Override
    public void onBackPressed() {
        showAlert();
    }*/

    @Override
    public void onBackPressed() {

        exit();



    }

    private void exit() {
        if (isBack.equals(false)) {
            isBack = true;
            android.app.Dialog dialog = new Dialog(this);
            dialog.setCancelable(false);
            dialog.setContentView(R.layout.dialog_csm_exit);
            dialog.getWindow().setBackgroundDrawable(new ColorDrawable
                    (Color.TRANSPARENT));

            LinearLayout no = dialog.findViewById(R.id.no);
            LinearLayout yes = dialog.findViewById(R.id.yes);
            TextView sub = dialog.findViewById(R.id.sub);
            sub.setText("Are you sure do you want to exit this\ngame?");
            yes.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View view) {
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


}