package com.earncash.rewardsapp.csm.adapter;

import android.app.Activity;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.RelativeLayout;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.fragment.app.FragmentActivity;
import androidx.fragment.app.FragmentManager;
import androidx.fragment.app.FragmentTransaction;
import androidx.recyclerview.widget.RecyclerView;

import com.bumptech.glide.Glide;
import com.earncash.rewardsapp.R;
import com.earncash.rewardsapp.csm.DialogFrag.OfferDialog;
import com.earncash.rewardsapp.csm.model.ApiOfferModel;

import java.util.List;

public class ApiOfferAdapter extends RecyclerView.Adapter<ApiOfferAdapter.MyViewHolder> {
    public ApiOfferAdapter(List<ApiOfferModel> mList, Activity activity, int type) {
        this.mList = mList;
        this.activity = activity;
        this.type = type;
    }

    List<ApiOfferModel> mList;
    Activity activity;

    int type;

    @NonNull
    @Override
    public MyViewHolder onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
        LayoutInflater layoutInflater = LayoutInflater.from(parent.getContext());
        View view;
        if (type==0){
            view = layoutInflater.inflate(R.layout.item_csm_offer, parent, false);
        }else {
            view = layoutInflater.inflate(R.layout.item_csm_offers_2, parent, false);
        }

        return new MyViewHolder(view);
    }

    @Override
    public void onBindViewHolder(@NonNull MyViewHolder holder, int position) {
        ApiOfferModel model = mList.get(position);
        holder.title.setText(model.getTitle());
        holder.coins.setText(model.getCoins());
        holder.cat.setText(model.getCats());
        holder.desc.setText(model.getRequirements());
        Glide.with(activity).load(model.getIcon()).placeholder(R.mipmap.ic_launcher).into(holder.image);

        holder.click.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                FragmentManager fragmentManager = ((FragmentActivity)activity).getSupportFragmentManager();
                OfferDialog newFragment = new OfferDialog();
                Bundle args = new Bundle();
                args.putString("title", model.getTitle());
                args.putString("sub", model.getRequirements());
                args.putString("url", model.getClick_url());
                args.putString("cat", model.getCats());
                args.putString("image", model.getIcon());
                args.putString("coins", model.getCoins());
                args.putString("steps", model.getSteps());
                args.putString("events", model.getEvents());
                args.putString("time", model.getTime());

                newFragment.setArguments(args);
                FragmentTransaction transaction = fragmentManager.beginTransaction();
                transaction.setTransition(FragmentTransaction.TRANSIT_FRAGMENT_OPEN);
                transaction.add(android.R.id.content, newFragment).addToBackStack(null).commit();
            }
        });



    }

    @Override
    public int getItemCount() {
        return mList.size();
    }

    public class MyViewHolder extends RecyclerView.ViewHolder {
        TextView title,coins,cat,desc;
        ImageView image;
        RelativeLayout click;

        public MyViewHolder(@NonNull View itemView) {
            super(itemView);
            title = itemView.findViewById(R.id.title);
            coins = itemView.findViewById(R.id.coins);
            cat = itemView.findViewById(R.id.cat);
            desc = itemView.findViewById(R.id.desc);
            image = itemView.findViewById(R.id.image);
            click = itemView.findViewById(R.id.click);
        }
    }
}
