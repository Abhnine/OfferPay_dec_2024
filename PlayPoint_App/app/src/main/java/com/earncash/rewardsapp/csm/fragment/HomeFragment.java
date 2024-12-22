package com.earncash.rewardsapp.csm.fragment;

import static com.earncash.rewardsapp.helper.AppController.hidepDialog;
import static com.earncash.rewardsapp.helper.AppController.isConnected;
import static com.earncash.rewardsapp.helper.Constatnt.AG;
import static com.earncash.rewardsapp.helper.Constatnt.HOME;
import static com.earncash.rewardsapp.helper.Constatnt.ID;
import static com.earncash.rewardsapp.helper.Constatnt.SPIN_ANIME;

import android.content.Intent;
import android.os.Bundle;

import androidx.annotation.NonNull;
import androidx.appcompat.app.AppCompatActivity;
import androidx.cardview.widget.CardView;
import androidx.fragment.app.Fragment;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;
import androidx.viewpager2.widget.CompositePageTransformer;
import androidx.viewpager2.widget.MarginPageTransformer;
import androidx.viewpager2.widget.ViewPager2;

import android.os.Handler;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.RelativeLayout;
import android.widget.TextView;
import android.widget.Toast;

import com.android.volley.Request;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.bumptech.glide.Glide;
import com.earncash.rewardsapp.R;
import com.earncash.rewardsapp.csm.activity.GamesActivity;
import com.earncash.rewardsapp.csm.activity.NotificationActivity;
import com.earncash.rewardsapp.csm.activity.OffersActivity;
import com.earncash.rewardsapp.csm.activity.OfferwallsActivity;
import com.earncash.rewardsapp.csm.activity.ReferTask;
import com.earncash.rewardsapp.csm.activity.ScratchActivity;
import com.earncash.rewardsapp.csm.activity.SpinActivity;
import com.earncash.rewardsapp.csm.activity.VideoActivity;
import com.earncash.rewardsapp.csm.activity.VisitActivity;
import com.earncash.rewardsapp.csm.adapter.AdapterGameHome;
import com.earncash.rewardsapp.csm.adapter.ApiOfferAdapter;
import com.earncash.rewardsapp.csm.adapter.SliderAdapter;
import com.earncash.rewardsapp.csm.model.ApiOfferModel;
import com.earncash.rewardsapp.csm.model.GameModel;
import com.earncash.rewardsapp.csm.model.SliderItems;
import com.earncash.rewardsapp.helper.AppController;
import com.earncash.rewardsapp.helper.JsonRequest;
import com.facebook.shimmer.ShimmerFrameLayout;
import com.tbuonomo.viewpagerdotsindicator.DotsIndicator;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

import de.hdodenhof.circleimageview.CircleImageView;

public class HomeFragment extends Fragment {
    View root_view;
    ImageView img_spin;
    CardView spin;
    RelativeLayout scratch,offers,games,visit,videos,referTask,noti;
    LinearLayout all_games,b_bg;
    TextView name,level,badge;

    RecyclerView list,list_offers;
    AdapterGameHome adapter;
    List<GameModel> model = new ArrayList<>();

    private ViewPager2 viewPager2;
    private Handler sliderHandler = new Handler();
    private List<SliderItems> sliderItems = new ArrayList<>();
    int banner_size = 0;

    DotsIndicator worm_dots_indicator;
    CircleImageView profile;
    ShimmerFrameLayout skeletonLayout2;
    LinearLayout see_all_offers,offers_body;

    ApiOfferAdapter apiOfferAdapter;
    List<ApiOfferModel> apiOfferModels = new ArrayList<>();


    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        // Inflate the layout for this fragment
        root_view = inflater.inflate(R.layout.fragment_home, container, false);

        img_spin = root_view.findViewById(R.id.img_spin);
        spin = root_view.findViewById(R.id.spin);
        scratch = root_view.findViewById(R.id.scratch);
        offers = root_view.findViewById(R.id.offers);
        games = root_view.findViewById(R.id.games);

        list = root_view.findViewById(R.id.list);
        visit = root_view.findViewById(R.id.visit);
        videos = root_view.findViewById(R.id.videos);
        all_games = root_view.findViewById(R.id.all_games);
        viewPager2 = root_view.findViewById(R.id.viewPagerImageSlider);
        worm_dots_indicator = root_view.findViewById(R.id.worm_dots_indicator);
        noti = root_view.findViewById(R.id.noti);
        referTask = root_view.findViewById(R.id.referTask);
        level = root_view.findViewById(R.id.level);
        name = root_view.findViewById(R.id.name);
        b_bg = root_view.findViewById(R.id.b_bg);
        badge = root_view.findViewById(R.id.badge);
        skeletonLayout2 = root_view.findViewById(R.id.skeletonLayout2);
        see_all_offers = root_view.findViewById(R.id.see_all_offers);
        list_offers = root_view.findViewById(R.id.list_offers);
        offers_body = root_view.findViewById(R.id.offers_body);

        if (AppController.getInstance().getBadge()>0){
            b_bg.setVisibility(View.VISIBLE);
            badge.setText(""+AppController.getInstance().getBadge());
        }

        Glide.with(getContext()).load(SPIN_ANIME).placeholder(R.drawable.img_csm_spinner).into(img_spin);
        level.setText("Lv."+AppController.getInstance().getLevel());
         profile = root_view.findViewById(R.id.pro);

        name.setText(AppController.getInstance().getName());
        spin.setOnClickListener(v->{
            startActivity(new Intent(getContext(), SpinActivity.class));
        });
        scratch.setOnClickListener(v->{
            startActivity(new Intent(getContext(), ScratchActivity.class));
        });

        games.setOnClickListener(v->{
            startActivity(new Intent(getContext(), GamesActivity.class));
        });
        all_games.setOnClickListener(v->{
            startActivity(new Intent(getContext(), GamesActivity.class));
        });
        offers.setOnClickListener(v->{
            Intent i = new Intent(getContext(), OfferwallsActivity.class);
            startActivity(i);
        });
        visit.setOnClickListener(v->{
            Intent i = new Intent(getContext(), VisitActivity.class);
            startActivity(i);
        });

        videos.setOnClickListener(v->{
            Intent i = new Intent(getContext(), VideoActivity.class);
            startActivity(i);
        });

        referTask.setOnClickListener(v->{
            Intent i = new Intent(getContext(), ReferTask.class);
            startActivity(i);
        });

        noti.setOnClickListener(v->{
            Intent i = new Intent(getContext(), NotificationActivity.class);
            startActivity(i);
        });


        CompositePageTransformer compositePageTransformer = new CompositePageTransformer();
        compositePageTransformer.addTransformer(new MarginPageTransformer(10));
        compositePageTransformer.addTransformer(new ViewPager2.PageTransformer() {
            @Override
            public void transformPage(@NonNull View page, float position) {
                float r = 1 - Math.abs(position);
                page.setScaleY(0.85f + r * 0.15f);
            }
        });

        viewPager2.setPageTransformer(compositePageTransformer);

        viewPager2.registerOnPageChangeCallback(new ViewPager2.OnPageChangeCallback() {
            @Override
            public void onPageSelected(int position) {
                super.onPageSelected(position);
                sliderHandler.removeCallbacks(sliderRunnable);
                sliderHandler.postDelayed(sliderRunnable, 5000); // slide duration 2 seconds
            }
        });

        viewPager2.setClipToPadding(false);
        viewPager2.setClipChildren(false);
        viewPager2.setOffscreenPageLimit(3);
        //viewPager2.getChildAt(0).setOverScrollMode(RecyclerView.OVER_SCROLL_NEVER);

        if (AppController.getInstance().getAdget_api() != 0){
            skeletonLayout2.stopShimmer();
            skeletonLayout2.setVisibility(View.GONE);
            list_offers.setVisibility(View.GONE);
            offers_body.setVisibility(View.GONE);
        }


        if (isConnected((AppCompatActivity) getActivity())) {
            JsonRequest jsonReq = new JsonRequest(Request.Method.POST, HOME, null,
                    new Response.Listener<JSONObject>() {
                        @Override
                        public void onResponse(JSONObject response) {
                            //Toast.makeText(getContext(), response.toString(), Toast.LENGTH_SHORT).show();
                            try {
                                if (response.getString("error").equalsIgnoreCase("false")) {
                                    getAg();
                                    JSONArray trans = response.getJSONArray("data");
                                    if (trans.length()>0) {
                                        for (int i = 0; i < trans.length(); i++) {
                                            JSONObject offer = trans.getJSONObject(i);
                                            int id = offer.getInt("id");
                                            String title = offer.getString("title");
                                            String image = offer.getString("image");
                                            String game = offer.getString("game");
                                            String screen = offer.getString("screen");
                                            String category = offer.getString("category");
                                            int time = offer.getInt("time");
                                            int coins = offer.getInt("coins");
                                            int plays = offer.getInt("plays");

                                            GameModel item = new GameModel(title,image,game,screen,category,time,coins,plays,id);
                                            model.add(item);
                                        }

                                        list.setLayoutManager(new LinearLayoutManager(getContext(),LinearLayoutManager.HORIZONTAL,false));
                                        adapter = new AdapterGameHome(model,getActivity());
                                        list.setAdapter(adapter);
                                        list.setVisibility(View.VISIBLE);


                                    }else{
                                    }

                                    JSONArray banner_array = response.getJSONArray("banner");

                                    if (banner_array.length()>0) {
                                        SliderItems itemmm = new SliderItems(null,null,null,null,null);
                                        sliderItems.add(itemmm);
                                        banner_size = banner_array.length();
                                        for (int i = 0; i < banner_array.length(); i++) {
                                            JSONObject banner = banner_array.getJSONObject(i);
                                            String id = banner.getString("id");
                                            String title = banner.getString("title");
                                            String sub = banner.getString("sub");
                                            String image = banner.getString("image");
                                            String url = banner.getString("url");

                                            SliderItems itemm = new SliderItems(id,title,sub,image,url);
                                            sliderItems.add(itemm);

                                        }

                                        viewPager2.setAdapter(new SliderAdapter(sliderItems,viewPager2,getContext()));
                                        worm_dots_indicator.attachTo(viewPager2);
                                    }


                                }else if(response.getString("error").equalsIgnoreCase("true")){

                                }
                            } catch (JSONException e) {
                                e.printStackTrace();

                                Toast.makeText(getActivity(), e.getMessage(), Toast.LENGTH_SHORT).show();
                            }
                        }
                    }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    //Log.println(10)
                    Toast.makeText(getActivity(), "Er-  "+error.getMessage(), Toast.LENGTH_LONG).show();
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


        return root_view;
    }

    @Override
    public void onResume() {
        super.onResume();
        isConnected((AppCompatActivity) getActivity());
        TextView coins = root_view.findViewById(R.id.coins);
        coins.setText(AppController.getInstance().getPoints());
        TextView diamond = root_view.findViewById(R.id.diamond);
        diamond.setText(AppController.getInstance().getDiamond());
        Glide.with(getContext()).load(AppController.getInstance().getProfile()).placeholder(R.drawable.logoo).into(profile);
    }

    Runnable sliderRunnable = new Runnable() {
        @Override
        public void run() {
            if (banner_size>0 && viewPager2.getCurrentItem()>=banner_size){
                viewPager2.setCurrentItem(0);
            }else {
             //   Toast.makeText(getContext(), "---"+viewPager2.getCurrentItem(), Toast.LENGTH_SHORT).show();
                viewPager2.setCurrentItem(viewPager2.getCurrentItem() + 1);
            }

        }
    };

    private void getAg() {
        if (AppController.getInstance().getAdget_api() == 0){
            JsonRequest jsonReq = new JsonRequest(Request.Method.POST, AG, null,
                    new Response.Listener<JSONObject>() {
                        @Override
                        public void onResponse(JSONObject response) {
                            JSONArray offers = null;
                            try {
                                offers = response.getJSONArray("data");

                                if (offers.length()>0) {
                                    JSONArray finalOffers = offers;
                                    see_all_offers.setOnClickListener(v->{
                                        Intent i = new Intent(getContext(), OffersActivity.class);
                                        i.putExtra("offers", finalOffers.toString());
                                        startActivity(i);

                                    });
                                    for (int i = 0; i < offers.length(); i++) {
                                        if (i<=5) {
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

                                            ApiOfferModel item = new ApiOfferModel(id, title, steps, requirements, desc, click_url, icon, coins, cats,time,events);
                                            apiOfferModels.add(item);
                                        }
                                    }
                                    skeletonLayout2.stopShimmer();
                                    skeletonLayout2.setVisibility(View.GONE);

                                    list_offers.setLayoutManager(new LinearLayoutManager(getContext(),LinearLayoutManager.HORIZONTAL,false));
                                    apiOfferAdapter = new ApiOfferAdapter(apiOfferModels,getActivity(),0);
                                    list_offers.setAdapter(apiOfferAdapter);
                                    list_offers.setVisibility(View.VISIBLE);
                                    offers_body.setVisibility(View.VISIBLE);
                                    see_all_offers.setVisibility(View.VISIBLE);




                                }else{
                                    skeletonLayout2.stopShimmer();
                                    skeletonLayout2.setVisibility(View.GONE);
                                    list_offers.setVisibility(View.GONE);
                                    offers_body.setVisibility(View.GONE);
                                }

                            } catch (JSONException e) {
                                skeletonLayout2.stopShimmer();
                                skeletonLayout2.setVisibility(View.GONE);
                                list_offers.setVisibility(View.GONE);
                                offers_body.setVisibility(View.GONE);

                            }



                        }
                    }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    //Log.println(10)
                    //Toast.makeText(getContext(), "Er-  " + error.getMessage(), Toast.LENGTH_LONG).show();
                    hidepDialog();
                    skeletonLayout2.stopShimmer();
                    skeletonLayout2.setVisibility(View.GONE);
                    list_offers.setVisibility(View.GONE);
                    offers_body.setVisibility(View.GONE);
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
        else {
            skeletonLayout2.stopShimmer();
            skeletonLayout2.setVisibility(View.GONE);
            list_offers.setVisibility(View.GONE);
            offers_body.setVisibility(View.GONE);
        }



    }
}