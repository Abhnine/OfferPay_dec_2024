package com.earncash.rewardsapp.csm.adapter;

import android.app.Activity;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.recyclerview.widget.RecyclerView;

import com.bumptech.glide.Glide;
import com.earncash.rewardsapp.R;
import com.earncash.rewardsapp.csm.model.LeaderBoardModel;

import java.text.DecimalFormat;
import java.util.List;

import de.hdodenhof.circleimageview.CircleImageView;

public class LeaderBoardAdapter extends RecyclerView.Adapter<LeaderBoardAdapter.MyViewHolder> {
    public LeaderBoardAdapter(List<LeaderBoardModel> mList, Activity activity) {
        this.mList = mList;
        this.activity = activity;
    }

    List<LeaderBoardModel> mList;
    Activity activity;

    @NonNull
    @Override
    public MyViewHolder onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
        LayoutInflater layoutInflater = LayoutInflater.from(parent.getContext());
        View view = layoutInflater.inflate(R.layout.item_csm_leaderboard, parent, false);
        return new MyViewHolder(view);
    }

    @Override
    public void onBindViewHolder(@NonNull MyViewHolder holder, int position) {
        LeaderBoardModel model = mList.get(position);
        holder.rank.setText("#"+model.getRank());
        holder.name.setText(model.getName());
        holder.level.setText("Lv."+model.getLevel());

        Glide.with(activity).load(model.getProfile()).placeholder(R.mipmap.ic_launcher).into(holder.img);
        int score_ = Integer.parseInt(model.getCoins());
        holder.coins.setText(setA(score_));
    }

    @Override
    public int getItemCount() {
        return mList.size();
    }

    public class MyViewHolder extends RecyclerView.ViewHolder {
        TextView rank, name, coins,level;
        CircleImageView img;

        public MyViewHolder(@NonNull View itemView) {
            super(itemView);
            rank = itemView.findViewById(R.id.rank);
            name = itemView.findViewById(R.id.name);
            coins = itemView.findViewById(R.id.coins);
            level = itemView.findViewById(R.id.level);
            img = itemView.findViewById(R.id.img);

        }
    }

    private String setA(int score_) {
        DecimalFormat df = new DecimalFormat("0");
        int am = score_;
        if (am >= 10000) {
            float prize_pool = am / 1000;
            String amount = df.format(prize_pool) + "K";
            return amount;
        } else {
            String amount = String.valueOf(score_);
            return amount;
        }
    }

}
