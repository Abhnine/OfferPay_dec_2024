package com.earncash.rewardsapp.csm.fragment;

import static com.earncash.rewardsapp.helper.AppController.get_uid;
import static com.earncash.rewardsapp.helper.AppController.hidepDialog;
import static com.earncash.rewardsapp.helper.AppController.isConnected;
import static com.earncash.rewardsapp.helper.Constatnt.ID;
import static com.earncash.rewardsapp.helper.Constatnt.LEADERS;

import android.os.Bundle;

import androidx.appcompat.app.AppCompatActivity;
import androidx.core.widget.NestedScrollView;
import androidx.fragment.app.Fragment;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import android.os.Handler;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.RelativeLayout;
import android.widget.TextView;

import com.android.volley.Request;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.bumptech.glide.Glide;
import com.earncash.rewardsapp.R;
import com.earncash.rewardsapp.csm.adapter.LeaderBoardAdapter;
import com.earncash.rewardsapp.csm.model.LeaderBoardModel;
import com.earncash.rewardsapp.helper.AppController;
import com.earncash.rewardsapp.helper.JsonRequest;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

import de.hdodenhof.circleimageview.CircleImageView;

public class LeaderboardFragment extends Fragment {

    RecyclerView recyclerView;
    List<LeaderBoardModel> model = new ArrayList<>();
    View root_view;
    CircleImageView img_1st,img_2nd,img_3rd;
    TextView txt_2nd,txt_1st,txt_3rd,coins_2nd,coins_1st,coins_3rd,csm_level_1,csm_level_2,csm_level_3;
    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        // Inflate the layout for this fragment
        root_view = inflater.inflate(R.layout.fragment_leaderboard, container, false);
        img_3rd = root_view.findViewById(R.id.img_3rd);
        img_1st = root_view.findViewById(R.id.img_1st);
        img_2nd = root_view.findViewById(R.id.img_2nd);
        txt_2nd = root_view.findViewById(R.id.txt_2nd);
        txt_1st = root_view.findViewById(R.id.txt_1st);
        txt_3rd = root_view.findViewById(R.id.txt_3rd);
        coins_2nd = root_view.findViewById(R.id.coins_2nd);
        coins_1st = root_view.findViewById(R.id.coins_1st);
        coins_3rd = root_view.findViewById(R.id.coins_3rd);
        csm_level_1 = root_view.findViewById(R.id.csm_level_1);
        csm_level_2 = root_view.findViewById(R.id.csm_level_2);
        csm_level_3 = root_view.findViewById(R.id.csm_level_3);
        recyclerView = root_view.findViewById(R.id.recyclerView);
        new Handler().postDelayed(new Runnable() {
            @Override
            public void run() {
                get_players();;
            }
        }, 200);



        return root_view;
    }

    private void get_players() {
        if (isConnected((AppCompatActivity) getActivity())) {
            RelativeLayout loading = root_view.findViewById(R.id.loading);
            TextView error_text = root_view.findViewById(R.id.error_text);
            NestedScrollView scroll = root_view.findViewById(R.id.scroll);
            loading.setVisibility(View.VISIBLE);
            recyclerView.setVisibility(View.GONE);
            error_text.setVisibility(View.GONE);
            model.clear();
            JsonRequest jsonReq = new JsonRequest(Request.Method.POST, LEADERS, null,
                    new Response.Listener<JSONObject>() {
                        @Override
                        public void onResponse(JSONObject response) {
                            //Toast.makeText(getContext(), response.toString(), Toast.LENGTH_SHORT).show();
                            try {
                                if (response.getString("error").equalsIgnoreCase("false")) {
                                    JSONArray offers = response.getJSONArray("data");
                                    int rank = 0;

                                    if (offers.length() > 0) {
                                        for (int i = 0; i < offers.length(); i++) {
                                            rank++;
                                            JSONObject offer = offers.getJSONObject(i);
                                            String rank_ = offer.getString("rank");
                                            String coins = offer.getString("coins");
                                            String name = offer.getString("name");
                                            String level = offer.getString("level");
                                            String profile = offer.getString("profile");
                                            if (rank==1){
                                                setLeaders(img_1st,txt_1st,coins_1st,coins,name,profile,level,csm_level_1);
                                            } else if (rank==2) {
                                                setLeaders(img_2nd,txt_2nd,coins_2nd,coins,name,profile,level,csm_level_2);
                                            } else if (rank==3) {
                                                setLeaders(img_3rd,txt_3rd,coins_3rd,coins,name,profile,level,csm_level_3);
                                            }else{
                                                LeaderBoardModel item = new LeaderBoardModel(name,coins,level,rank_,profile);
                                                model.add(item);
                                            }

                                        }
                                        LeaderBoardAdapter adapter = new LeaderBoardAdapter(model, getActivity());
                                        recyclerView.setLayoutManager(new LinearLayoutManager(getActivity()));
                                        recyclerView.setAdapter(adapter);
                                        loading.setVisibility(View.GONE);
                                        recyclerView.setVisibility(View.VISIBLE);
                                        scroll.setVisibility(View.VISIBLE);

                                    } else {
                                        error_text.setText("Players not found!!");
                                        error_text.setVisibility(View.VISIBLE);
                                    }
                                } else if (response.getString("error").equalsIgnoreCase("true")) {
                                    error_text.setText("Players not found!!");
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
                    params.put("uid", get_uid(getContext()));
                    return params;
                }
            };
            AppController.getInstance().getRequestQueue().getCache().clear();
            AppController.getInstance().addToRequestQueue(jsonReq);
        }
    }

    private void setLeaders(CircleImageView img,TextView name,TextView coins,String s_name,String s_coins, String profile, String level,TextView csm_level) {
        name.setText(s_coins);
        coins.setText(s_name);
        csm_level.setText("Lv."+level);
        Glide.with(getActivity()).load(profile).placeholder(R.mipmap.ic_launcher).into(img);
    }


    @Override
    public void onResume() {
        super.onResume();
        isConnected((AppCompatActivity) getActivity());
    }
}