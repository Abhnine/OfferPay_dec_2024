package com.earncash.rewardsapp.csm.adapter;

import android.app.Activity;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.recyclerview.widget.RecyclerView;

import com.earncash.rewardsapp.R;
import com.earncash.rewardsapp.csm.model.ModelOfferReward;

import java.util.List;

public class AdapterRewardStep extends RecyclerView.Adapter<AdapterRewardStep.MyViewHolder> {
    public AdapterRewardStep(List<ModelOfferReward> mList, Activity activity) {
        this.mList = mList;
        this.activity = activity;
    }

    List<ModelOfferReward> mList;
    Activity activity;

    @NonNull
    @Override
    public MyViewHolder onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
        LayoutInflater layoutInflater = LayoutInflater.from(parent.getContext());
        View view = layoutInflater.inflate(R.layout.item_offer_rewards, parent, false);
        return new MyViewHolder(view);
    }

    @Override
    public void onBindViewHolder(@NonNull MyViewHolder holder, int position) {
        ModelOfferReward model = mList.get(position);
        holder.name.setText(model.getName());
        holder.coins.setText(model.getCoins());

    }

    @Override
    public int getItemCount() {
        return mList.size();
    }

    public class MyViewHolder extends RecyclerView.ViewHolder {
        TextView name,coins;
        public MyViewHolder(@NonNull View itemView) {
            super(itemView);
            name = itemView.findViewById(R.id.name);
            coins = itemView.findViewById(R.id.coins);

        }
    }
}
