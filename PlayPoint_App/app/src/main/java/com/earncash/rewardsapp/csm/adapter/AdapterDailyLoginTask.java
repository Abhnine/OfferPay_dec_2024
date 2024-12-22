package com.earncash.rewardsapp.csm.adapter;

import static com.earncash.rewardsapp.helper.PrefManager.AddC;

import android.app.Activity;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.RelativeLayout;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.recyclerview.widget.RecyclerView;

import com.earncash.rewardsapp.R;
import com.earncash.rewardsapp.csm.model.ModelDailyLoginTask;

import java.util.List;


public class AdapterDailyLoginTask extends RecyclerView.Adapter<AdapterDailyLoginTask.MyViewHolder> {
    public AdapterDailyLoginTask(List<ModelDailyLoginTask> mList, Activity activity) {
        this.mList = mList;
        this.activity = activity;
    }

    List<ModelDailyLoginTask> mList;
    Activity activity;

    @NonNull
    @Override
    public MyViewHolder onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
        LayoutInflater layoutInflater = LayoutInflater.from(parent.getContext());
        View view = layoutInflater.inflate(R.layout.item_csm_daily_task, parent, false);
        return new MyViewHolder(view);
    }

    @Override
    public void onBindViewHolder(@NonNull MyViewHolder holder, int position) {
        ModelDailyLoginTask model = mList.get(position);
        holder.title.setText("Sign in for " +model.getDays()+ " days");
        holder.desc.setText("Complete this task to get "+model.getCoins()+ " coins.");
        holder.coins.setText(""+model.getCoins());

        int days = Integer.parseInt(model.getDays());
        holder.days.setText(model.getDays());
        if (model.getTotal_days()>=days){
            holder.days_left.setText(days+"/"+days);
            if (!model.getStatus()) {
                holder.img_status_claim.setVisibility(View.VISIBLE);
                holder.img_status.setVisibility(View.GONE);
                holder.click.setOnClickListener(new View.OnClickListener() {
                    @Override
                    public void onClick(View v) {
                        AddC(activity, "" + model.getCoins(), "Daily Login Reward", true,model.getId(),false);
                        holder.days_left.setVisibility(View.GONE);
                        holder.done.setVisibility(View.VISIBLE);
                        holder.img_status_claim.setVisibility(View.GONE);
                        holder.img_status.setVisibility(View.VISIBLE);
                        holder.click.setEnabled(false);
                    }
                });
            }else {
                holder.days_left.setVisibility(View.GONE);
                holder.done.setVisibility(View.VISIBLE);
            }
        }else {
            holder.days_left.setText(model.getTotal_days()+"/"+days);
            holder.days_left.setVisibility(View.VISIBLE);
            holder.img_status.setVisibility(View.VISIBLE);
            holder.done.setVisibility(View.GONE);
        }




    }

    @Override
    public int getItemCount() {
        return mList.size();
    }

    public class MyViewHolder extends RecyclerView.ViewHolder {
        TextView title,desc,coins,days,days_left;
        RelativeLayout click,coinbar;
        ImageView done,img_status_claim,img_status;

        public MyViewHolder(@NonNull View itemView) {
            super(itemView);
            title = itemView.findViewById(R.id.title);
            desc = itemView.findViewById(R.id.desc);
            coins = itemView.findViewById(R.id.coins);
            click = itemView.findViewById(R.id.click);
            coinbar = itemView.findViewById(R.id.coinbar);
            done = itemView.findViewById(R.id.done);
            days = itemView.findViewById(R.id.days);
            days_left = itemView.findViewById(R.id.days_left);
            img_status_claim = itemView.findViewById(R.id.img_status_claim);
            img_status = itemView.findViewById(R.id.img_status);
        }
    }
}