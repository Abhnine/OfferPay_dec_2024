package com.earncash.rewardsapp.csm.adapter;

import android.app.Activity;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.LinearLayout;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.recyclerview.widget.RecyclerView;

import com.earncash.rewardsapp.R;
import com.earncash.rewardsapp.csm.model.UserRewardHistoryModel;

import java.util.List;

public class RewardStatusAdapter extends RecyclerView.Adapter<RewardStatusAdapter.MyViewHolder> {
    public RewardStatusAdapter(List<UserRewardHistoryModel> mList, Activity activity) {
        this.mList = mList;
        this.activity = activity;
    }

    List<UserRewardHistoryModel> mList;
    Activity activity;

    @NonNull
    @Override
    public MyViewHolder onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
        LayoutInflater layoutInflater = LayoutInflater.from(parent.getContext());
        View view = layoutInflater.inflate(R.layout.item_csm_reward_status, parent, false);
        return new MyViewHolder(view);
    }

    @Override
    public void onBindViewHolder(@NonNull MyViewHolder holder, int position) {
        UserRewardHistoryModel model = mList.get(position);
        holder.name.setText(model.getPackage_name()+" Request");
        holder.amount.setText(model.getSymbol()+model.getAmount());
        holder.date.setText(model.getDate());
        int status = Integer.parseInt(model.getStatus());
        if (status==0){
            holder.pending.setVisibility(View.VISIBLE);
            holder.rejected.setVisibility(View.GONE);
            holder.completed.setVisibility(View.GONE);
            holder.csm_approved.setVisibility(View.GONE);

        } else if (status==1) {
            holder.pending.setVisibility(View.GONE);
            holder.rejected.setVisibility(View.GONE);
            holder.completed.setVisibility(View.GONE);
            holder.csm_approved.setVisibility(View.VISIBLE);

        }else if (status==2) {
            holder.pending.setVisibility(View.GONE);
            holder.rejected.setVisibility(View.VISIBLE);
            holder.completed.setVisibility(View.GONE);
            holder.csm_approved.setVisibility(View.GONE);
        }else if (status==3){
            holder.pending.setVisibility(View.GONE);
            holder.rejected.setVisibility(View.GONE);
            holder.completed.setVisibility(View.VISIBLE);
            holder.csm_approved.setVisibility(View.GONE);
        }

    }

    @Override
    public int getItemCount() {
        return mList.size();
    }

    public class MyViewHolder extends RecyclerView.ViewHolder {
        TextView name,date,amount;
        LinearLayout pending,completed,rejected,csm_approved;

        public MyViewHolder(@NonNull View itemView) {
            super(itemView);
            name = itemView.findViewById(R.id.name);
            date = itemView.findViewById(R.id.date);
            amount = itemView.findViewById(R.id.amount);
            pending = itemView.findViewById(R.id.pending);
            completed = itemView.findViewById(R.id.completed);
            rejected = itemView.findViewById(R.id.rejected);
            csm_approved = itemView.findViewById(R.id.csm_approved);

        }
    }
}

