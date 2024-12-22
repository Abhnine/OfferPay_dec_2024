package com.earncash.rewardsapp.csm.adapter;

import static com.earncash.rewardsapp.helper.AppController.hidepDialog;
import static com.earncash.rewardsapp.helper.AppController.initpDialog;
import static com.earncash.rewardsapp.helper.AppController.showpDialog;
import static com.earncash.rewardsapp.helper.Constatnt.Main_Url;

import android.app.Activity;
import android.content.Intent;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.RelativeLayout;
import android.widget.TextView;
import android.widget.Toast;

import androidx.annotation.NonNull;
import androidx.appcompat.app.AppCompatActivity;
import androidx.recyclerview.widget.RecyclerView;

import com.adgatemedia.sdk.classes.AdGateMedia;
import com.adgatemedia.sdk.network.OnOfferWallLoadFailed;
import com.adgatemedia.sdk.network.OnOfferWallLoadSuccess;
import com.bumptech.glide.Glide;
import com.earncash.rewardsapp.R;
import com.earncash.rewardsapp.csm.CpaLeadActivity;
import com.earncash.rewardsapp.csm.model.ModelVideos;
import com.earncash.rewardsapp.helper.AppController;
import com.ironsource.mediationsdk.IronSource;
import com.ironsource.mediationsdk.logger.IronSourceError;
import com.ironsource.mediationsdk.sdk.OfferwallListener;
import com.offertoro.sdk.OfferWall;
import com.offertoro.sdk.OfferWallListener;

import com.pollfish.Pollfish;
import com.tapjoy.TJActionRequest;
import com.tapjoy.TJConnectListener;
import com.tapjoy.TJError;
import com.tapjoy.TJPlacement;
import com.tapjoy.TJPlacementListener;
import com.tapjoy.Tapjoy;
import com.tapjoy.TapjoyConnectFlag;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.HashMap;
import java.util.Hashtable;
import java.util.List;
import java.util.concurrent.ThreadLocalRandom;

public class AdapterOfferwalls extends RecyclerView.Adapter<AdapterOfferwalls.MyViewHolder> {
    public AdapterOfferwalls(List<ModelVideos> mList, Activity activity) {
        this.mList = mList;
        this.activity = activity;
    }

    List<ModelVideos> mList;
    Activity activity;

    @NonNull
    @Override
    public MyViewHolder onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
        LayoutInflater layoutInflater = LayoutInflater.from(parent.getContext());
        View view = layoutInflater.inflate(R.layout.item_csm_offerwall, parent, false);
        return new MyViewHolder(view);
    }

    @Override
    public void onBindViewHolder(@NonNull MyViewHolder holder, int position) {
        ModelVideos model = mList.get(position);
        initpDialog((AppCompatActivity) activity);
        holder.title.setText(model.getName());
        holder.desc.setText("earn coins from " +model.getName());
        int randomNum = ThreadLocalRandom.current().nextInt(10, 20 + 1);
        holder.coins.setText(randomNum+"k");
        Glide.with(activity).load(Main_Url+model.getImage()).placeholder(R.mipmap.ic_launcher).into(holder.image);
        holder.click.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                switch (model.getNet_id()) {
                    case "adget":
                        showpDialog();
                        final HashMap<String, String> subids = new HashMap<String, String>();
                        subids.put("s2", "my sub id");
                        AdGateMedia adGateMedia = AdGateMedia.getInstance();
                        adGateMedia.loadOfferWall(activity,
                                str(model.getIds(), "AdGateMedia_Wallcode"),
                                AppController.getInstance().getUid(),
                                subids,
                                new OnOfferWallLoadSuccess() {
                                    @Override
                                    public void onOfferWallLoadSuccess() {
                                        hidepDialog();
                                        // Here you can call adGateMedia.showOfferWall();
                                        AdGateMedia.getInstance().showOfferWall(activity,
                                                new AdGateMedia.OnOfferWallClosed() {
                                                    @Override
                                                    public void onOfferWallClosed() {
                                                        // Here you handle the 'Offer wall has just been closed' event
                                                        hidepDialog();

                                                    }
                                                });
                                    }
                                },
                                new OnOfferWallLoadFailed() {
                                    @Override
                                    public void onOfferWallLoadFailed(String reason) {
                                        // Here you handle the errors with provided reason
                                        hidepDialog();
                                        Toast.makeText(activity, "Failed to load offerwall. Check your network!!", Toast.LENGTH_SHORT).show();
                                    }
                                });
                        break;
                    case "adgem":
                        Intent ii = new Intent(activity, CpaLeadActivity.class);
                        ii.putExtra("url",str(model.getIds(),"adgem_app_id"));
                        ii.putExtra("type",1);
                        activity.startActivity(ii);
                        break;

                    case "offertoro":
                        OfferWall.getInstance().setConfig(str(model.getIds(), "offertoro_app_id"), str(model.getIds(), "offertoro_secret_key"), AppController.getInstance().getUid());
                        showpDialog();
                        OfferWall.getInstance().setOfferWallListener(new OfferWallListener() {
                            @Override
                            public void onOfferWallInitSuccess() {
                                hidepDialog();

                            }

                            @Override
                            public void onOfferWallInitFail(String s) {
                                hidepDialog();

                            }

                            @Override
                            public void onOfferWallOpened() {
                                hidepDialog();
                            }

                            @Override
                            public void onOfferWallOfferClicked(String s) {

                            }

                            @Override
                            public void onOfferWallCredited(double v, double v1) {

                            }

                            @Override
                            public void onOfferLoadFail(String s) {
                                hidepDialog();
                                Toast.makeText(activity, "Offerwall not available!", Toast.LENGTH_SHORT).show();

                            }

                            @Override
                            public void onOfferWallClosed() {

                            }

                            @Override
                            public void onOfferWallGetUserCredits(JSONArray jsonArray) {

                            }

                            @Override
                            public void onOfferWallGetUserCreditsError(String s) {

                            }

                            @Override
                            public void onOfferWallMissingCreditsError() {

                            }
                        });
                        try {
                            OfferWall.getInstance().showOfferWall(activity);
                        } catch (Exception e) {
                            Toast.makeText(activity, "Offerwall not available!!", Toast.LENGTH_SHORT).show();
                        }
                        break;

                    case "is":
                        IronSource.setUserId(AppController.getInstance().getUid());
                        IronSource.init(activity, str(model.getIds(), "ironsource_appkey"));

                        showpDialog();
                        IronSource.setOfferwallListener(new OfferwallListener() {
                            @Override
                            public void onOfferwallAvailable(boolean isAvailable) {
                                IronSource.showOfferwall();
                            }

                            @Override
                            public void onOfferwallOpened() {
                                hidepDialog();
                            }

                            @Override
                            public void onOfferwallShowFailed(IronSourceError error) {
                                hidepDialog();
                                Toast.makeText(activity, error.getErrorMessage(), Toast.LENGTH_SHORT).show();
                            }

                            @Override
                            public boolean onOfferwallAdCredited(int credits, int totalCredits, boolean totalCreditsFlag) {
                                return true;
                            }

                            @Override
                            public void onGetOfferwallCreditsFailed(IronSourceError error) {
                            }

                            @Override
                            public void onOfferwallClosed() {
                            }
                        });
                        break;
                    case "tj":
                        showpDialog();
                        Hashtable<String, Object> connectFlags = new Hashtable<String, Object>();
                        connectFlags.put(TapjoyConnectFlag.ENABLE_LOGGING, "true"); // Disable this in production builds
                        connectFlags.put(TapjoyConnectFlag.USER_ID, AppController.getInstance().getUid()); // Important for self-managed currency

                        Tapjoy.connect(activity.getApplicationContext(), str(model.getIds(), "tapjoy_sdk_key"), connectFlags, new TJConnectListener() {
                            @Override
                            public void onConnectSuccess() {
                                TJPlacementListener placementListener = new TJPlacementListener() {
                                    @Override
                                    public void onRequestSuccess(TJPlacement tjPlacement) {

                                        hidepDialog();
                                    }

                                    @Override
                                    public void onRequestFailure(TJPlacement tjPlacement, TJError tjError) {
                                        Toast.makeText(activity, tjError.message, Toast.LENGTH_SHORT).show();
                                        hidepDialog();
                                    }

                                    @Override
                                    public void onContentReady(TJPlacement tjPlacement) {
                                        tjPlacement.showContent();
                                    }

                                    @Override
                                    public void onContentShow(TJPlacement tjPlacement) {

                                    }

                                    @Override
                                    public void onContentDismiss(TJPlacement tjPlacement) {

                                    }

                                    @Override
                                    public void onPurchaseRequest(TJPlacement tjPlacement, TJActionRequest tjActionRequest, String s) {

                                    }

                                    @Override
                                    public void onRewardRequest(TJPlacement tjPlacement, TJActionRequest tjActionRequest, String s, int i) {

                                    }

                                    @Override
                                    public void onClick(TJPlacement tjPlacement) {

                                    }
                                };
                                TJPlacement placement = Tapjoy.getPlacement(str(model.getIds(), "tapjoy_offerwall_name"), placementListener);
                                placement.requestContent();
                            }

                            @Override
                            public void onConnectFailure() {
                                hidepDialog();
                                Toast.makeText(activity, "Tapjoy offerwall is not available now!!", Toast.LENGTH_SHORT).show();
                            }
                        });
                        break;
                    case "cpalead":
                        Intent i = new Intent(activity, CpaLeadActivity.class);
                        i.putExtra("url",str(model.getIds(),"cpa_lead_offerwall_url"));
                        activity.startActivity(i);
                        break;
                    case "pf":
                        Pollfish.show();
                        break;
                }
            }
        });


    }

    @Override
    public int getItemCount() {
        return mList.size();
    }

    public class MyViewHolder extends RecyclerView.ViewHolder {
        TextView title,desc,coins;
        ImageView image;
        RelativeLayout click;

        public MyViewHolder(@NonNull View itemView) {
            super(itemView);
            title = itemView.findViewById(R.id.title);
            desc = itemView.findViewById(R.id.desc);
            coins = itemView.findViewById(R.id.coins);
            image = itemView.findViewById(R.id.image);
            click = itemView.findViewById(R.id.click);
        }
    }

    private String str(JSONObject obj, String name) {
        try {
            return obj.getString(name);
        } catch (JSONException e) {
            throw new RuntimeException(e);
        }
    }

}