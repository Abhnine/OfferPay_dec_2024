package com.earncash.rewardsapp.csm.fragment;

import static com.earncash.rewardsapp.helper.AppController.hidepDialog;
import static com.earncash.rewardsapp.helper.AppController.isConnected;
import static com.earncash.rewardsapp.helper.Constatnt.ID;
import static com.earncash.rewardsapp.helper.Constatnt.USER_H;

import android.os.Bundle;

import androidx.appcompat.app.AppCompatActivity;
import androidx.fragment.app.Fragment;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
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

public class RewardStatus extends Fragment {
    View root_view;
    List<UserRewardHistoryModel> model = new ArrayList<>();
    RecyclerView recyclerView;
    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        // Inflate the layout for this fragment
        root_view = inflater.inflate(R.layout.fragment_reward_status, container, false);
        recyclerView = root_view.findViewById(R.id.recyclerView);
        get_redeems();

        return  root_view;
    }

    private void get_redeems() {
        if (isConnected((AppCompatActivity) getActivity())) {
            RelativeLayout loading = root_view.findViewById(R.id.loading);
            TextView error_text = root_view.findViewById(R.id.error_text);
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
                                        RewardStatusAdapter adapter = new RewardStatusAdapter(model, getActivity());
                                        recyclerView.setLayoutManager(new LinearLayoutManager(getContext()));
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
}