package com.earncash.rewardsapp.csm.activity;

import static com.earncash.rewardsapp.helper.AppController.hidepDialog;
import static com.earncash.rewardsapp.helper.AppController.isConnected;
import static com.earncash.rewardsapp.helper.Constatnt.ID;
import static com.earncash.rewardsapp.helper.Constatnt.OFFERS_;
import static com.earncash.rewardsapp.helper.PrefManager.setWindowFlag;

import androidx.appcompat.app.AppCompatActivity;
import androidx.recyclerview.widget.GridLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import android.content.pm.ActivityInfo;
import android.graphics.Color;
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
import com.earncash.rewardsapp.csm.adapter.AdapterVideo;
import com.earncash.rewardsapp.csm.model.ModelVideos;
import com.earncash.rewardsapp.helper.AppController;
import com.earncash.rewardsapp.helper.JsonRequest;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

public class VideoActivity extends AppCompatActivity {
    ImageView back;
    RecyclerView list;
    AdapterVideo adapter;
    List<ModelVideos> model = new ArrayList<>();
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        getWindow().addFlags(WindowManager.LayoutParams.FLAG_KEEP_SCREEN_ON);
        setRequestedOrientation(ActivityInfo.SCREEN_ORIENTATION_PORTRAIT);//Set Portrait
        getWindow().getDecorView().setSystemUiVisibility(View.SYSTEM_UI_FLAG_LAYOUT_STABLE | View.SYSTEM_UI_FLAG_LAYOUT_FULLSCREEN);
        setWindowFlag(this, WindowManager.LayoutParams.FLAG_TRANSLUCENT_STATUS, false);
        getWindow().setStatusBarColor(Color.TRANSPARENT);
        setContentView(R.layout.activity_video);

        list = findViewById(R.id.list);
        back = findViewById(R.id.back);


        back.setOnClickListener(v->{
            finish();
        });

    }

    @Override
    public void onResume() {
        super.onResume();
        updateVideos();
        TextView coins = findViewById(R.id.coins);
        coins.setText(AppController.getInstance().getPoints());
        TextView diamond = findViewById(R.id.diamond);
        diamond.setText(AppController.getInstance().getDiamond());
    }

    private void updateVideos() {
        if (isConnected(this)) {
            LinearLayout loading = findViewById(R.id.loading);
            model.clear();
            JsonRequest jsonReq = new JsonRequest(Request.Method.POST, OFFERS_, null,
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
                                            if (offer.getBoolean("status")) {
                                                String id = offer.getString("id");
                                                String name = offer.getString("name");
                                                String image = offer.getString("image");
                                                String net_id = offer.getString("net_id");
                                                Boolean status = offer.getBoolean("status");
                                                JSONObject ids = offer.getJSONObject("ids");
                                                ModelVideos item = new ModelVideos(id, name, image, ids,status,net_id);
                                                model.add(item);
                                            }
                                        }

                                        for (int i = 0; i < trans.length(); i++) {
                                            JSONObject offer = trans.getJSONObject(i);
                                            if (!offer.getBoolean("status")) {
                                                String id = offer.getString("id");
                                                String name = offer.getString("name");
                                                String image = offer.getString("image");
                                                String net_id = offer.getString("net_id");
                                                Boolean status = offer.getBoolean("status");
                                                JSONObject ids = offer.getJSONObject("ids");
                                                ModelVideos item = new ModelVideos(id, name, image, ids,status,net_id);
                                                model.add(item);
                                            }
                                        }


                                        list.setLayoutManager(new GridLayoutManager(VideoActivity.this,2));
                                        adapter = new AdapterVideo(model,VideoActivity.this,AppController.getInstance().getUid());
                                        list.setAdapter(adapter);
                                        loading.setVisibility(View.GONE);
                                        list.setVisibility(View.VISIBLE);

                                    }else{
                                    }
                                }else if(response.getString("error").equalsIgnoreCase("true")){
                                }
                            } catch (JSONException e) {
                                e.printStackTrace();
                                Toast.makeText(VideoActivity.this, e.getMessage(), Toast.LENGTH_SHORT).show();
                            }
                        }
                    }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    //Log.println(10)
                    Toast.makeText(VideoActivity.this, "Er-  "+error.getMessage(), Toast.LENGTH_LONG).show();
                    hidepDialog();
                }
            }) {

                @Override
                protected Map<String, String> getParams() {
                    Map<String, String> params = new HashMap<String, String>();
                    params.put(ID, AppController.getInstance().getApi_token());
                    params.put("id", AppController.getInstance().getUid());
                    params.put("type", "0");
                    return params;
                }
            };
            AppController.getInstance().getRequestQueue().getCache().clear();
            AppController.getInstance().addToRequestQueue(jsonReq);
        }
    }
}