package com.earncash.rewardsapp.csm.adapter;

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
import androidx.recyclerview.widget.RecyclerView;

import com.earncash.rewardsapp.R;
import com.earncash.rewardsapp.csm.activity.VisitHandler;
import com.earncash.rewardsapp.csm.model.VisitModel;

import java.util.List;

public class AdapterVisit extends RecyclerView.Adapter<AdapterVisit.MyViewHolder> {
    public AdapterVisit(List<VisitModel> mList, Activity activity) {
        this.mList = mList;
        this.activity = activity;
    }

    List<VisitModel> mList;
    Activity activity;

    @NonNull
    @Override
    public MyViewHolder onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
        LayoutInflater layoutInflater = LayoutInflater.from(parent.getContext());
        View view = layoutInflater.inflate(R.layout.item_csm_visit, parent, false);
        return new MyViewHolder(view);
    }

    @Override
    public void onBindViewHolder(@NonNull MyViewHolder holder, int position) {
        VisitModel model = mList.get(position);
        holder.title.setText(model.getTitle());
        holder.coins.setText(""+model.getCoins());
        holder.time.setText(model.getTime()+" MIN");
        if (model.getStatus()){
            holder.status.setVisibility(View.VISIBLE);
            holder.open.setVisibility(View.GONE);
        }
        holder.click.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                if (!model.getStatus()){
                    Intent i = new Intent(activity, VisitHandler.class);
                    i.putExtra("time",model.getTime()+"");
                    i.putExtra("points",model.getCoins()+"");
                    i.putExtra("url",model.getLink());
                    i.putExtra("id",model.getId()+"");
                    activity.startActivity(i);
                }else {
                    Toast.makeText(activity, "Completed", Toast.LENGTH_SHORT).show();
                }


            }
        });


    }

    @Override
    public int getItemCount() {
        return mList.size();
    }

    public class MyViewHolder extends RecyclerView.ViewHolder {
        TextView title,coins,time;
        RelativeLayout click,open;
        ImageView status;

        public MyViewHolder(@NonNull View itemView) {
            super(itemView);
            title = itemView.findViewById(R.id.title);
            coins = itemView.findViewById(R.id.coins);
            time = itemView.findViewById(R.id.time);
            click = itemView.findViewById(R.id.click);
            status = itemView.findViewById(R.id.status);
            open = itemView.findViewById(R.id.open);
        }
    }
}