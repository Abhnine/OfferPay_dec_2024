package com.earncash.rewardsapp.csm.fragment;

import static com.earncash.rewardsapp.helper.AppController.hidepDialog;
import static com.earncash.rewardsapp.helper.AppController.isConnected;
import static com.earncash.rewardsapp.helper.Constatnt.ID;
import static com.earncash.rewardsapp.helper.Constatnt.Main_Url;
import static com.earncash.rewardsapp.helper.Constatnt.REFER;
import static com.earncash.rewardsapp.helper.PrefManager.ShowToast;

import android.content.ClipData;
import android.content.ClipboardManager;
import android.content.Context;
import android.content.Intent;
import android.os.Bundle;

import androidx.appcompat.app.AppCompatActivity;
import androidx.fragment.app.Fragment;
import androidx.fragment.app.FragmentManager;
import androidx.fragment.app.FragmentTransaction;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.LinearLayout;
import android.widget.TextView;
import android.widget.Toast;

import com.android.volley.Request;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.earncash.rewardsapp.R;
import com.earncash.rewardsapp.csm.DialogFrag.DialogReferValidate;
import com.earncash.rewardsapp.csm.activity.ReferTask;
import com.earncash.rewardsapp.csm.adapter.AdapterReferTask;
import com.earncash.rewardsapp.csm.model.ModelReferTask;
import com.earncash.rewardsapp.helper.AppController;
import com.earncash.rewardsapp.helper.JsonRequest;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

public class ReferFragment extends Fragment {
    View root_view;
    LinearLayout share, copy,see_All;
    TextView invite_points, link, coins, refers, total_earn, redeem,code;
    RecyclerView list;
    AdapterReferTask adapter;
    List<ModelReferTask> model = new ArrayList<>();
    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        // Inflate the layout for this fragment

        root_view = inflater.inflate(R.layout.fragment_refer_, container, false);
        share = root_view.findViewById(R.id.share);
        invite_points = root_view.findViewById(R.id.invite_points);
        link = root_view.findViewById(R.id.link);
        copy = root_view.findViewById(R.id.copy);
        coins = root_view.findViewById(R.id.coins);
        total_earn = root_view.findViewById(R.id.total_earn);
        redeem = root_view.findViewById(R.id.redeem);
        list = root_view.findViewById(R.id.list);
        refers = root_view.findViewById(R.id.refers);
        see_All = root_view.findViewById(R.id.see_All);
        code = root_view.findViewById(R.id.code);

        code.setText(AppController.getInstance().getRefer_id());

        invite_points.setText("you get " + AppController.getInstance().getRefer_points() + " coins and signup user will get " + AppController.getInstance().getRefer_bonus() + " coins");
        share.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Allshare();
            }
        });
        link.setText(Main_Url + "refer/" + AppController.getInstance().getRefer_id());
        copy.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                ClipboardManager clipboard = (ClipboardManager) getActivity().getSystemService(Context.CLIPBOARD_SERVICE);
                ClipData clip = ClipData.newPlainText("Copied Text", Main_Url + "refer/" + AppController.getInstance().getRefer_id());
                clipboard.setPrimaryClip(clip);
                ShowToast(getActivity(),"Copied",false);
               // Toast.makeText(getContext(), "Copied!", Toast.LENGTH_SHORT).show();
            }
        });

        root_view.findViewById(R.id.copy_code).setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                ClipboardManager clipboard = (ClipboardManager) getActivity().getSystemService(Context.CLIPBOARD_SERVICE);
                ClipData clip = ClipData.newPlainText("Copied Text", AppController.getInstance().getRefer_id());
                clipboard.setPrimaryClip(clip);
                ShowToast(getActivity(),"Copied",false);
                // Toast.makeText(getContext(), "Copied!", Toast.LENGTH_SHORT).show();
            }
        });

        coins.setText(AppController.getInstance().getPoints());
        refers.setText(AppController.getInstance().getRefers());
        total_earn.setText(AppController.getInstance().getTotal_earn());
        redeem.setText(AppController.getInstance().getRedeem());

        see_All.setOnClickListener(v->{
            startActivity(new Intent(getContext(), ReferTask.class));
        });

        root_view.findViewById(R.id.add_refer).setOnClickListener(view -> {
            FragmentManager fragmentManager = getActivity().getSupportFragmentManager();
            DialogReferValidate newFragment = new DialogReferValidate();
            Bundle args = new Bundle();

            newFragment.setArguments(args);
            FragmentTransaction transaction = fragmentManager.beginTransaction();
            transaction.setTransition(FragmentTransaction.TRANSIT_FRAGMENT_OPEN);
            transaction.add(android.R.id.content, newFragment).addToBackStack(null).commit();
        });

        if (AppController.getInstance().getRefer_type()==0){
            root_view.findViewById(R.id.refer_link).setVisibility(View.VISIBLE);
            root_view.findViewById(R.id.code_refer).setVisibility(View.GONE);
        }else{
            root_view.findViewById(R.id.refer_link).setVisibility(View.GONE);
            root_view.findViewById(R.id.code_refer).setVisibility(View.VISIBLE);
        }


        return root_view;

    }

    private void getTask() {
        model.clear();
        if (isConnected((AppCompatActivity) getActivity())) {
            LinearLayout loading = root_view.findViewById(R.id.loading);
            list.setVisibility(View.GONE);
            loading.setVisibility(View.VISIBLE);
            JsonRequest jsonReq = new JsonRequest(Request.Method.POST, REFER, null,
                    new Response.Listener<JSONObject>() {
                        @Override
                        public void onResponse(JSONObject response) {
                            //Toast.makeText(getContext(), response.toString(), Toast.LENGTH_SHORT).show();
                            try {
                                if (response.getString("error").equalsIgnoreCase("false")) {
                                    JSONArray trans = response.getJSONArray("data");
                                    if (trans.length() > 0) {
                                        for (int i = 0; i < trans.length(); i++) {
                                            JSONObject offer = trans.getJSONObject(i);
                                            String id = offer.getString("id");
                                            String title = offer.getString("title");
                                            int refers = offer.getInt("refers");
                                            int coins = offer.getInt("coins");
                                            int total_ref = offer.getInt("total_ref");
                                            int status = offer.getInt("status");
                                            ModelReferTask item = new ModelReferTask(id, title, refers, coins, total_ref, status);
                                            model.add(item);
                                        }


                                        list.setLayoutManager(new LinearLayoutManager(getContext()));
                                        adapter = new AdapterReferTask(model, getActivity());
                                        list.setAdapter(adapter);
                                        loading.setVisibility(View.GONE);
                                        list.setVisibility(View.VISIBLE);

                                    } else {
                                    }
                                } else if (response.getString("error").equalsIgnoreCase("true")) {
                                }
                            } catch (JSONException e) {
                                e.printStackTrace();
                                Toast.makeText(getContext(), e.getMessage(), Toast.LENGTH_SHORT).show();
                            }
                        }
                    }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    //Log.println(10)
                    Toast.makeText(getContext(), "Er-  " + error.getMessage(), Toast.LENGTH_LONG).show();
                    hidepDialog();
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

    public void Allshare() {
        String msg = AppController.getInstance().getReferMessage();
        String message = msg.replace("{app_link}", Main_Url + "refer/" + AppController.getInstance().getRefer_id());
        Intent waIntent = new Intent(Intent.ACTION_SEND);
        waIntent.setType("text/plain");
        if (waIntent != null) {
            waIntent.putExtra(Intent.EXTRA_TEXT, message);//
            getActivity().startActivity(Intent.createChooser(waIntent, "Share with"));
        } else {
        }

    }

    @Override
    public void onResume() {
        super.onResume();
        getTask();
        isConnected((AppCompatActivity) getActivity());
    }


}