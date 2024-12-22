package com.earncash.rewardsapp.csm.activity;

import static com.earncash.rewardsapp.helper.AppController.hidepDialog;
import static com.earncash.rewardsapp.helper.AppController.isConnected;
import static com.earncash.rewardsapp.helper.Constatnt.ID;
import static com.earncash.rewardsapp.helper.Constatnt.USER_H;

import androidx.appcompat.app.AppCompatActivity;
import androidx.core.content.ContextCompat;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import android.os.Bundle;
import android.view.View;
import android.view.Window;
import android.view.WindowManager;
import android.widget.RelativeLayout;
import android.widget.TextView;

import com.android.volley.Request;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.earncash.rewardsapp.R;
import com.earncash.rewardsapp.csm.adapter.RewardStatusAdapter;
import com.earncash.rewardsapp.csm.model.UserRewardHistoryModel;
import com.earncash.rewardsapp.helper.AppController;
import com.earncash.rewardsapp.helper.JsonRequest;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

public class RewardStatusActivity extends AppCompatActivity {
    List<UserRewardHistoryModel> model = new ArrayList<>();
    RecyclerView recyclerView;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        Window window = this.getWindow();
        window.clearFlags(WindowManager.LayoutParams.FLAG_TRANSLUCENT_STATUS);
        window.addFlags(WindowManager.LayoutParams.FLAG_DRAWS_SYSTEM_BAR_BACKGROUNDS);
        window.setStatusBarColor(ContextCompat.getColor(this, R.color.colorPrimaryDark));
        getWindow().setNavigationBarColor(ContextCompat.getColor(this, R.color.colorPrimaryDark));
        setContentView(R.layout.activity_reward_status);
        recyclerView = findViewById(R.id.recyclerView);

    }

    private void get_redeems() {
        if (isConnected(RewardStatusActivity.this)) {
            RelativeLayout loading = findViewById(R.id.loading);
            TextView error_text = findViewById(R.id.error_text);
            loading.setVisibility(View.VISIBLE);
            recyclerView.setVisibility(View.GONE);
            error_text.setVisibility(View.GONE);
            model.clear();
            JsonRequest jsonReq = new JsonRequest(Request.Method.POST, USER_H, null,
                    new Response.Listener<JSONObject>() {
                        @Override
                        public void onResponse(JSONObject response) {
                            //Toast.makeText(getContext(), response.toString(), Toast.LENGTH_SHORT).show();
                            try {
                                if (response.getString("error").equalsIgnoreCase("false")) {
                                    JSONArray offers = response.getJSONArray("data");
                                    if (offers.length() > 0) {
                                        for (int i = 0; i < offers.length(); i++) {
                                            JSONObject offer = offers.getJSONObject(i);
                                            String image = offer.getString("image");
                                            String package_name = offer.getString("package_name");
                                            String coins_used = offer.getString("coins_used");
                                            String symbol = offer.getString("symbol");
                                            String amount = offer.getString("amount");
                                            String date = offer.getString("date");
                                            String status = offer.getString("status");

                                            UserRewardHistoryModel item = new UserRewardHistoryModel(image,package_name,coins_used,symbol,amount,date,status);
                                            model.add(item);
                                        }
                                        RewardStatusAdapter adapter = new RewardStatusAdapter(model, RewardStatusActivity.this);
                                        recyclerView.setLayoutManager(new LinearLayoutManager(RewardStatusActivity.this));
                                        recyclerView.setAdapter(adapter);
                                        loading.setVisibility(View.GONE);
                                        recyclerView.setVisibility(View.VISIBLE);

                                    } else {
                                        error_text.setText("Redeem not found!!");
                                        error_text.setVisibility(View.VISIBLE);
                                    }
                                } else if (response.getString("error").equalsIgnoreCase("true")) {
                                    error_text.setText("Redeem not found!!");
                                    error_text.setVisibility(View.VISIBLE);
                                }
                            } catch (JSONException e) {
                                e.printStackTrace();
                                error_text.setText("Exception- " + e.getMessage());
                                error_text.setVisibility(View.VISIBLE);
                            }
                        }
                    }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    hidepDialog();
                    error_text.setText("Er- " + error.getLocalizedMessage());
                    error_text.setVisibility(View.VISIBLE);
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
    }
    @Override
    protected void onResume() {
        super.onResume();
        get_redeems();
    }
}