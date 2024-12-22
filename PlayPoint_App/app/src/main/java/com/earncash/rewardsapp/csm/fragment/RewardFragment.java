package com.earncash.rewardsapp.csm.fragment;

import static com.earncash.rewardsapp.helper.AppController.hidepDialog;
import static com.earncash.rewardsapp.helper.AppController.isConnected;
import static com.earncash.rewardsapp.helper.Constatnt.ID;
import static com.earncash.rewardsapp.helper.Constatnt.REW;
import static com.earncash.rewardsapp.helper.PrefManager.ShowToast;

import android.content.Intent;
import android.os.Bundle;

import androidx.appcompat.app.AppCompatActivity;
import androidx.fragment.app.Fragment;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.ProgressBar;
import android.widget.RelativeLayout;
import android.widget.TextView;

import com.android.volley.Request;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.earncash.rewardsapp.R;
import com.earncash.rewardsapp.csm.activity.TransActivity;
import com.earncash.rewardsapp.csm.adapter.Reward_adapter;
import com.earncash.rewardsapp.csm.model.Reward_model;
import com.earncash.rewardsapp.helper.AppController;
import com.earncash.rewardsapp.helper.JsonRequest;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

public class RewardFragment extends Fragment {
    View root_view;
    RecyclerView recyclerView;
    Reward_adapter reward_adapter;
    LinearLayout wallet,csmDiamondBtn;
    ImageView history;
    ProgressBar progressBar;
    TextView status,points;
    private List<Reward_model> model = new ArrayList<>();
    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        // Inflate the layout for this fragment
        root_view = inflater.inflate(R.layout.fragment_reward2, container, false);
        recyclerView = root_view.findViewById(R.id.recyclerView);
        history = root_view.findViewById(R.id.history);
        wallet = root_view.findViewById(R.id.wallet);
        progressBar = root_view.findViewById(R.id.progressBar);
        status = root_view.findViewById(R.id.status);
        points = root_view.findViewById(R.id.points);
        csmDiamondBtn = root_view.findViewById(R.id.csmDiamondBtn);
        history.setOnClickListener(v->{
            Intent i = new Intent(getContext(), TransActivity.class);
            startActivity(i);
        });
        csmDiamondBtn.setOnClickListener(v->{
            ShowToast(getActivity(),"Coming Soon!!",false);
        });

        wallet.setOnClickListener(v->{
            Intent i = new Intent(getContext(), TransActivity.class);
            startActivity(i);
        });

        rewards();
        return root_view;
    }
    private void rewards(){
        if (isConnected((AppCompatActivity) getActivity())) {
            RelativeLayout loading = root_view.findViewById(R.id.loading);
            TextView error_text = root_view.findViewById(R.id.error_text);
            loading.setVisibility(View.VISIBLE);
            recyclerView.setVisibility(View.GONE);
            error_text.setVisibility(View.GONE);
            model.clear();
            JsonRequest jsonReq = new JsonRequest(Request.Method.POST, REW, null,
                    new Response.Listener<JSONObject>() {
                        @Override
                        public void onResponse(JSONObject response) {
                            //Toast.makeText(getContext(), response.toString(), Toast.LENGTH_SHORT).show();
                            try {
                                if (response.getString("error").equalsIgnoreCase("false")) {
                                    JSONArray offers = response.getJSONArray("data");
                                    int currant_coins = Integer.parseInt(AppController.getInstance().getPoints());
                                    points.setText(AppController.getInstance().getPoints()+" Coins");
                                    if (currant_coins>=response.getInt("min")){
                                        status.setText("Eligible For Redeem");
                                        progressBar.setMax(1);
                                        progressBar.setProgress(1);
                                    }else {
                                        status.setText("Not Eligible For Redeem");
                                        progressBar.setMax(response.getInt("min"));
                                        progressBar.setProgress(Integer.parseInt(AppController.getInstance().getPoints()));
                                    }
                                    if (offers.length() > 0) {
                                        for (int i = 0; i < offers.length(); i++) {
                                            JSONObject feedObj = (JSONObject) offers.get(i);
                                            JSONArray array = (feedObj.getJSONArray("amounts"));
                                            Integer id = (feedObj.getInt("id"));
                                            String name=(feedObj.getString("name"));
                                            String image = (feedObj.getString("image"));
                                            String symbol = (feedObj.getString("symbol"));
                                            String hint = (feedObj.getString("hint"));
                                            String input_type = (feedObj.getString("input_type"));
                                            Integer minimum = (feedObj.getInt("minimum"));
                                            //Integer amount = (feedObj.getInt("amount"));
                                            String details = (feedObj.getString("details"));
                                            String arr = array.toString();

                                            Reward_model item = new Reward_model(name,image,symbol,hint,input_type,id,details,minimum,arr);
                                            model.add(item);

                                        }
                                        reward_adapter = new Reward_adapter(model, getActivity());

                                        recyclerView.setHasFixedSize(true);
                                        recyclerView.setLayoutManager(new LinearLayoutManager(getContext()));
                                        recyclerView.setAdapter(reward_adapter);
                                        loading.setVisibility(View.GONE);
                                        recyclerView.setVisibility(View.VISIBLE);

                                    } else {
                                        error_text.setText("Error!!");
                                        error_text.setVisibility(View.VISIBLE);
                                    }
                                } else if (response.getString("error").equalsIgnoreCase("true")) {
                                    error_text.setText("Error!!");
                                    error_text.setVisibility(View.VISIBLE);                                }
                            } catch (JSONException e) {
                                e.printStackTrace();
                                error_text.setText("Exception- "+e.getMessage());
                                error_text.setVisibility(View.VISIBLE);
                            }
                        }
                    }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    hidepDialog();
                    error_text.setText("Er- "+error.getLocalizedMessage());
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
    public void onResume() {
        super.onResume();

        isConnected((AppCompatActivity) getActivity());

    }


    


}