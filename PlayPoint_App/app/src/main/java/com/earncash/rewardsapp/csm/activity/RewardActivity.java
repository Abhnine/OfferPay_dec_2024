package com.earncash.rewardsapp.csm.activity;

import static com.earncash.rewardsapp.helper.PrefManager.setWindowFlag;

import androidx.appcompat.app.AppCompatActivity;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import android.content.Intent;
import android.content.pm.ActivityInfo;
import android.graphics.Color;
import android.os.Build;
import android.os.Bundle;
import android.view.View;
import android.view.WindowManager;
import android.widget.ImageView;
import android.widget.ProgressBar;
import android.widget.TextView;
import android.widget.Toast;

import com.earncash.rewardsapp.R;
import com.earncash.rewardsapp.csm.adapter.Redeem_adapter;
import com.earncash.rewardsapp.csm.model.Redeem_model;
import com.earncash.rewardsapp.helper.AppController;
import com.facebook.ads.AdView;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.List;

public class RewardActivity extends AppCompatActivity {
    private List<Redeem_model> model = new ArrayList<>();
    Redeem_adapter adapter;
    RecyclerView list;
    private AdView adView;
    ProgressBar progressBar;
    TextView points;
    ImageView back;

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
        setContentView(R.layout.activity_reward);
        list = findViewById(R.id.recyclerView);
        progressBar = findViewById(R.id.progressBar);
        points = findViewById(R.id.points);
        back = findViewById(R.id.back);
        back.setOnClickListener(v->{
            finish();
        });
/*        adView = new AdView(this, AppController.getInstance().getFb_banner(), AdSize.BANNER_HEIGHT_50);
        LinearLayout adContainer = (LinearLayout) findViewById(R.id.banner_container);
        adContainer.addView(adView);
        AdListener adListener = new AdListener() {
            @Override
            public void onError(Ad ad, AdError adError) {
            }

            @Override
            public void onAdLoaded(Ad ad) {
            }

            @Override
            public void onAdClicked(Ad ad) {
            }

            @Override
            public void onLoggingImpression(Ad ad) {
            }
        };

// Request an ad
        adView.loadAd(adView.buildLoadAdConfig().withAdListener(adListener).build());*/


        Intent i = getIntent();



        int currant_coins = Integer.parseInt(AppController.getInstance().getPoints());
        points.setText(AppController.getInstance().getPoints()+" Coins");
        if (currant_coins>=i.getIntExtra("min",0)){
            progressBar.setMax(1);
            progressBar.setProgress(1);
        }else {
            progressBar.setMax(i.getIntExtra("min",0));
            progressBar.setProgress(Integer.parseInt(AppController.getInstance().getPoints()));
        }


        try {
            JSONArray array = new JSONArray(i.getStringExtra("arry"));
            for (int index = 0; index < array.length(); index++) {
                JSONObject feedObj = (JSONObject) array.get(index);
                //  Integer id = (feedObj.getInt("id"));
                String coins = (feedObj.getString("coins"));
                String amount = (feedObj.getString("amount"));
                String amount_id = (feedObj.getString("id"));
                String image = i.getStringExtra("image");
                String input = i.getStringExtra("input");
                String hint = i.getStringExtra("hint");
                String title = i.getStringExtra("title");
                String symb = i.getStringExtra("symb");
                String id = i.getStringExtra("id");
                String type = i.getStringExtra("type");
                String details = i.getStringExtra("details");
                //GameModel item = new GameModel(id,title,image,game_link);
                //gameModel.add(item);
                Redeem_model item = new Redeem_model(image, coins, amount, symb, input, hint, title, id, type, details, amount_id);
                model.add(item);
            }
            adapter = new Redeem_adapter(model, RewardActivity.this);
            list.setLayoutManager(new LinearLayoutManager(RewardActivity.this,LinearLayoutManager.HORIZONTAL,false));
            list.setAdapter(adapter);

        } catch (JSONException e) {
            e.printStackTrace();
            Toast.makeText(this, e.getMessage(), Toast.LENGTH_SHORT).show();
        }

    }
}