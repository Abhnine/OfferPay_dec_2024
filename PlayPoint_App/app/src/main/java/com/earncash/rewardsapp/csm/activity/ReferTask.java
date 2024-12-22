package com.earncash.rewardsapp.csm.activity;

import static com.earncash.rewardsapp.helper.AppController.hidepDialog;
import static com.earncash.rewardsapp.helper.AppController.isConnected;
import static com.earncash.rewardsapp.helper.Constatnt.ID;
import static com.earncash.rewardsapp.helper.Constatnt.REFER;
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
import android.widget.LinearLayout;
import android.widget.TextView;
import android.widget.Toast;

import com.android.volley.Request;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.earncash.rewardsapp.R;
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

public class ReferTask extends AppCompatActivity {
    ImageView back;
    RecyclerView list;
    AdapterReferTask adapter;
    List<ModelReferTask> model = new ArrayList<>();
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

        setContentView(R.layout.activity_refer_task);
        list = findViewById(R.id.list);
        back = findViewById(R.id.back);



        if (isConnected(this)) {
            LinearLayout loading = findViewById(R.id.loading);
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


                                        list.setLayoutManager(new LinearLayoutManager(ReferTask.this));
                                        adapter = new AdapterReferTask(model, ReferTask.this);
                                        list.setAdapter(adapter);
                                        loading.setVisibility(View.GONE);
                                        list.setVisibility(View.VISIBLE);

                                    } else {
                                    }
                                } else if (response.getString("error").equalsIgnoreCase("true")) {
                                }
                            } catch (JSONException e) {
                                e.printStackTrace();
                                Toast.makeText(ReferTask.this, e.getMessage(), Toast.LENGTH_SHORT).show();
                            }
                        }
                    }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    //Log.println(10)
                    Toast.makeText(ReferTask.this, "Er-  " + error.getMessage(), Toast.LENGTH_LONG).show();
                    hidepDialog();
                }
            }) {

                @Override
                protected Map<String, String> getParams() {
                    Map<String, String> params = new HashMap<String, String>();
                    params.put(ID, AppController.getInstance().getApi_token());
                    params.put("type", "1");
                    return params;
                }
            };
            AppController.getInstance().getRequestQueue().getCache().clear();
            AppController.getInstance().addToRequestQueue(jsonReq);
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

}