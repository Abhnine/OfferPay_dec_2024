package com.earncash.rewardsapp.csm.adapter;

import static com.earncash.rewardsapp.helper.Constatnt.Main_Url;
import static com.earncash.rewardsapp.helper.PrefManager.getInK;

import android.app.Activity;
import android.content.Intent;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.RelativeLayout;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.recyclerview.widget.RecyclerView;

import com.bumptech.glide.Glide;
import com.earncash.rewardsapp.R;
import com.earncash.rewardsapp.csm.activity.PlayGame;
import com.earncash.rewardsapp.csm.model.GameModel;
import com.makeramen.roundedimageview.RoundedImageView;

import java.util.List;

public class AdapterGameHome extends RecyclerView.Adapter<AdapterGameHome.MyViewHolder> {
    public AdapterGameHome(List<GameModel> mList, Activity activity) {
        this.mList = mList;
        this.activity = activity;
    }

    List<GameModel> mList;
    Activity activity;

    @NonNull
    @Override
    public MyViewHolder onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
        LayoutInflater layoutInflater = LayoutInflater.from(parent.getContext());
        View view = layoutInflater.inflate(R.layout.item_csm_game_home, parent, false);
        return new MyViewHolder(view);
    }

    @Override
    public void onBindViewHolder(@NonNull MyViewHolder holder, int position) {
        GameModel model = mList.get(position);
        holder.title.setText(model.getTitle());
        holder.plays.setText(getInK(model.getPlays())+" Plays");
        holder.coins.setText(""+model.getCoins());
        holder.time.setText(model.getTime()+" MIN");
        holder.cat.setText(model.getCategory());
        Glide.with(activity).load(Main_Url+model.getImage()).placeholder(R.mipmap.ic_launcher).into(holder.image);
        holder.click.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent i = new Intent(activity, PlayGame.class);
                i.putExtra("time",""+model.getTime());
                i.putExtra("type",""+model.getScreen());
                i.putExtra("path",""+model.getGame());
                i.putExtra("coins",""+model.getCoins());
                i.putExtra("id",""+model.getId());
                activity.startActivity(i);
            }
        });


    }

    @Override
    public int getItemCount() {
        return mList.size();
    }

    public class MyViewHolder extends RecyclerView.ViewHolder {
        TextView title,coins,time,plays,cat;
        RoundedImageView image;
        RelativeLayout click;

        public MyViewHolder(@NonNull View itemView) {
            super(itemView);
            title = itemView.findViewById(R.id.title);
            coins = itemView.findViewById(R.id.coins);
            time = itemView.findViewById(R.id.time);
            image = itemView.findViewById(R.id.image);
            click = itemView.findViewById(R.id.click);
            plays = itemView.findViewById(R.id.plays);
            cat = itemView.findViewById(R.id.cat);
        }
    }
}