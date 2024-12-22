package com.earncash.rewardsapp.csm.activity;

import static com.earncash.rewardsapp.helper.PrefManager.setWindowFlag;

import androidx.appcompat.app.AppCompatActivity;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import android.content.pm.ActivityInfo;
import android.graphics.Color;
import android.os.Build;
import android.os.Bundle;
import android.view.View;
import android.view.WindowManager;
import android.widget.ImageView;
import android.widget.TextView;

import com.earncash.rewardsapp.R;
import com.earncash.rewardsapp.csm.adapter.ApiOfferAdapter;
import com.earncash.rewardsapp.csm.model.ApiOfferModel;
import com.earncash.rewardsapp.helper.AppController;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.List;

public class OffersActivity extends AppCompatActivity {

    ApiOfferAdapter apiOfferAdapter;
    List<ApiOfferModel> apiOfferModels = new ArrayList<>();
    RecyclerView list_offers;
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
        setRequestedOrientation(ActivityInfo.SCREEN_ORIENTATION_PORTRAIT);//Set Portrait
        setContentView(R.layout.activity_offers2);

        list_offers = findViewById(R.id.list_offers);
        back = findViewById(R.id.back);

        JSONArray offers = null;
        try {
            offers = new JSONArray(getIntent().getStringExtra("offers"));

            if (offers.length()>0) {
                for (int i = 0; i < offers.length(); i++) {
                    JSONObject api_offer = offers.getJSONObject(i);
                    String id = api_offer.getString("id");
                    String title = api_offer.getString("title");
                    String steps = api_offer.getString("steps");
                    String requirements = api_offer.getString("requirements");
                    String desc = api_offer.getString("desc");
                    String click_url = api_offer.getString("click_url");
                    String icon = api_offer.getString("icon");
                    String coins = api_offer.getString("coins");
                    String cats = api_offer.getString("cats");
                    String time = api_offer.getString("time");
                    String events = api_offer.getString("events");
                    ApiOfferModel item = new ApiOfferModel(id,title,steps,requirements,desc,click_url,icon,coins,cats,time,events);
                    apiOfferModels.add(item);
                }

                list_offers.setLayoutManager(new LinearLayoutManager(this));
                apiOfferAdapter = new ApiOfferAdapter(apiOfferModels,this,1);
                list_offers.setAdapter(apiOfferAdapter);
                list_offers.setVisibility(View.VISIBLE);


            }else{
                list_offers.setVisibility(View.GONE);
            }

        } catch (JSONException e) {
            throw new RuntimeException(e);
        }

        back.setOnClickListener(v->{
            finish();
        });

    }

    @Override
    public void onResume() {
        super.onResume();
        TextView coins = findViewById(R.id.coins);
        coins.setText(AppController.getInstance().getPoints());
        TextView diamond = findViewById(R.id.diamond);
        diamond.setText(AppController.getInstance().getDiamond());
    }

    @Override
    public void onBackPressed() {
        super.onBackPressed();
    }
}