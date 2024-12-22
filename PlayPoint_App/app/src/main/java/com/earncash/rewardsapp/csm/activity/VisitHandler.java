package com.earncash.rewardsapp.csm.activity;

import static com.earncash.rewardsapp.helper.PrefManager.AddC;
import static com.earncash.rewardsapp.helper.PrefManager.setWindowFlag;

import androidx.appcompat.app.AppCompatActivity;
import androidx.browser.customtabs.CustomTabsIntent;

import android.app.Activity;
import android.content.Intent;
import android.content.pm.ActivityInfo;
import android.graphics.Color;
import android.net.Uri;
import android.os.Build;
import android.os.Bundle;
import android.os.CountDownTimer;
import android.view.View;
import android.view.WindowManager;
import android.widget.Toast;

import com.earncash.rewardsapp.R;

public class VisitHandler extends AppCompatActivity {
    int coins,time,id;
    String url;
    Boolean isover = false;

    CountDownTimer countDownTimer;
    Boolean isStart = false;
    int t_intervel=0;
    int left;
    int secc = 60;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);

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

        setContentView(R.layout.activity_visit_handler);


        Intent i = getIntent();
        coins = Integer.parseInt(i.getStringExtra("points"));
        time = Integer.parseInt(i.getStringExtra("time"));
        id = Integer.parseInt(i.getStringExtra("id"));
        url = i.getStringExtra("url");

        CustomTabsIntent.Builder customIntent = new CustomTabsIntent.Builder();

        // below line is setting toolbar color
        // for our custom chrome tab.


        // we are calling below method after
        // setting our toolbar color.
        openCustomTab(VisitHandler.this, customIntent.build(), Uri.parse(url));
    }


    public static void openCustomTab(Activity activity, CustomTabsIntent customTabsIntent, Uri uri) {
        // package name is the default package
        // for our custom chrome tab
        String packageName = "com.android.chrome";
        if (packageName != null) {

            // we are checking if the package name is not null
            // if package name is not null then we are calling
            // that custom chrome tab with intent by passing its
            // package name.
            customTabsIntent.intent.setPackage(packageName);

            // in that custom tab intent we are passing
            // our url which we have to browse.
            customTabsIntent.launchUrl(activity, uri);
        } else {
            // if the custom tabs fails to load then we are simply
            // redirecting our user to users device default browser.
            activity.startActivity(new Intent(Intent.ACTION_VIEW, uri));
        }

    }


    @Override
    protected void onPause() {
        super.onPause();
        if (!isStart)
            count(time);
        else
            finish();
    }

    @Override
    protected void onResume() {
        super.onResume();
        if (isover)
        {
            AddC(this,""+coins,"Visit Reward",false,""+id,false);
            finish();
        }else
        {
            if (isStart) {
                finish();
                Toast.makeText(this, "Please wait until timer finish to get coins!", Toast.LENGTH_SHORT).show();
            }
        }
    }

    private void count(int sec) {
        isStart = true;
        sec= sec*60;
        sec=sec*1000;
        // Toast.makeText(PlayActivity.this, ""+total_sec_current, Toast.LENGTH_SHORT).show();

        countDownTimer =  new CountDownTimer(sec, 1000) {
            public void onFinish() {
                // When timer is finished
                // Execute your code here
                Toast.makeText(VisitHandler.this, "Finished!", Toast.LENGTH_SHORT).show();
                isover = true;
            }

            public void onTick(long millisUntilFinished) {
                // millisUntilFinished    The amount of time until finished.

                //  toastm(ReadHandler.this,""+millisUntilFinished/1000);
                if (t_intervel>=2)
                {
                    t_intervel = 0;
                    int t = (int) (millisUntilFinished/1000);
                    left = t / 60;


                    String time_in_sec = String.valueOf(secc);
                    if (secc<9)
                    { time_in_sec=":0"+secc;
                    }else
                    { time_in_sec=":"+secc; }
                    if (left>0)
                    {
                        //left=left-1;
                    }

                    if (left>0)
                    {
                        if (left>9)
                        {
                            Toast.makeText(VisitHandler.this, "Time left "+left+time_in_sec, Toast.LENGTH_SHORT).show();
                        }else
                        {
                            Toast.makeText(VisitHandler.this, "Time left 0"+left+time_in_sec, Toast.LENGTH_SHORT).show();
                        }

                    }else
                    {
                        Toast.makeText(VisitHandler.this, "Time left 0"+left+time_in_sec, Toast.LENGTH_SHORT).show();
                    }

                }else
                {
                    t_intervel=t_intervel+1;
                }

                if (secc >0)
                {

                    secc=secc-1;
                }else
                {
                    secc = 60;
                }


            }
        }.start();
    }

    @Override
    protected void onDestroy() {
        super.onDestroy();
        countDownTimer.cancel();
    }



}