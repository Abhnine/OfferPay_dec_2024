package com.earncash.rewardsapp.csm.fragment;

import static com.earncash.rewardsapp.helper.AppController.get_uid;
import static com.earncash.rewardsapp.helper.AppController.hidepDialog;
import static com.earncash.rewardsapp.helper.AppController.isConnected;
import static com.earncash.rewardsapp.helper.Constatnt.ID;
import static com.earncash.rewardsapp.helper.Constatnt.TRANS;

import android.os.Bundle;

import androidx.appcompat.app.AppCompatActivity;
import androidx.fragment.app.Fragment;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.TextView;
import android.widget.Toast;

import com.android.volley.Request;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.earncash.rewardsapp.R;
import com.earncash.rewardsapp.csm.adapter.TransAdapter;
import com.earncash.rewardsapp.csm.model.TransItems;
import com.earncash.rewardsapp.helper.AppController;
import com.earncash.rewardsapp.helper.JsonRequest;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

public class TransFragment extends Fragment {
    View root_view;
    RecyclerView list;
    TransAdapter transAdapter;
    List<TransItems> transItems = new ArrayList<>();

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        // Inflate the layout for this fragment
        root_view = inflater.inflate(R.layout.fragment_trans, container, false);
        list = root_view.findViewById(R.id.list);


        if (isConnected((AppCompatActivity) getActivity())) {
            TextView loading = root_view.findViewById(R.id.loading);
            JsonRequest jsonReq = new JsonRequest(Request.Method.POST, TRANS, null,
                    new Response.Listener<JSONObject>() {
                        @Override
                        public void onResponse(JSONObject response) {
                            //Toast.makeText(getContext(), response.toString(), Toast.LENGTH_SHORT).show();
                            try {
                                if (response.getString("error").equalsIgnoreCase("false")) {
                                    JSONArray trans = response.getJSONArray("data");
                                    if (trans.length()>0) {
                                        for (int i = 0; i < trans.length(); i++) {
                                            JSONObject offer = trans.getJSONObject(i);
                                            String from = offer.getString("from");
                                            String date = offer.getString("date");
                                            String amount = offer.getString("amount");
                                            int type = offer.getInt("type");

                                            TransItems item = new TransItems(from,date,amount,type);
                                            transItems.add(item);
                                        }

                                        list.setLayoutManager(new LinearLayoutManager(getContext()));
                                        transAdapter = new TransAdapter(transItems,getActivity());
                                        list.setAdapter(transAdapter);
                                        loading.setVisibility(View.GONE);
                                        list.setVisibility(View.VISIBLE);

                                    }else{
                                        loading.setText("No Transactions!");
                                    }
                                }else if(response.getString("error").equalsIgnoreCase("true")){
                                    loading.setText("No Transactions!");
                                }
                            } catch (JSONException e) {
                                e.printStackTrace();
                                loading.setText(e.getMessage());
                                Toast.makeText(getContext(), e.getMessage(), Toast.LENGTH_SHORT).show();
                            }
                        }
                    }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    //Log.println(10)
                    Toast.makeText(getContext(), "Er-  "+error.getMessage(), Toast.LENGTH_LONG).show();
                    hidepDialog();
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

        return root_view;
    }
}