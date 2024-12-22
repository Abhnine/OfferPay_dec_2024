package com.earncash.rewardsapp.csm.adapter;

import static com.earncash.rewardsapp.helper.PrefManager.AddC;

import android.app.Activity;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.LinearLayout;
import android.widget.ProgressBar;
import android.widget.RelativeLayout;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.core.content.ContextCompat;
import androidx.recyclerview.widget.RecyclerView;

import com.earncash.rewardsapp.R;
import com.earncash.rewardsapp.csm.model.ModelReferTask;

import java.util.List;

public class AdapterReferTask extends RecyclerView.Adapter<AdapterReferTask.MyViewHolder> {
    public AdapterReferTask(List<ModelReferTask> mList, Activity activity) {
        this.mList = mList;
        this.activity = activity;
    }

    List<ModelReferTask> mList;
    Activity activity;

    @NonNull
    @Override
    public MyViewHolder onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
        LayoutInflater layoutInflater = LayoutInflater.from(parent.getContext());
        View view = layoutInflater.inflate(R.layout.item_csm_refer_mission, parent, false);
        return new MyViewHolder(view);
    }

    @Override
    public void onBindViewHolder(@NonNull MyViewHolder holder, int position) {
        ModelReferTask model = mList.get(position);
        holder.title.setText(model.getTitle());
        holder.coins.setText(""+model.getCoins());
        holder.progressBar.setMax(model.getRefers());
        if (model.getStatus()==0){
            holder.progressBar.setProgress(model.getTotal_ref());
            holder.left.setText(model.getTotal_ref()+"/"+model.getRefers());
            holder.status.setText("pending");
        } else if (model.getStatus()==1) {
            holder.lin_status.setBackground(ContextCompat.getDrawable(activity, R.drawable.bg_csm_complete));
            holder.left.setText(model.getRefers()+"/"+model.getRefers());
            holder.status.setText("claim");
            holder.progressBar.setProgress(model.getRefers());
        } else if (model.getStatus()==2) {
            holder.lin_status.setBackground(ContextCompat.getDrawable(activity, R.drawable.bg_csm_complete));
            holder.left.setText(model.getRefers()+"/"+model.getRefers());
            holder.status.setText("completed");
            holder.progressBar.setProgress(model.getRefers());

        }

        if (model.getStatus()==1){
            holder.click.setOnClickListener(v->{
                AddC(activity,""+model.getCoins(),"Referral Reward",true, ""+model.getId(),false);
                holder.status.setText("completed");
                holder.click.setEnabled(false);
            });
        }



    }

    @Override
    public int getItemCount() {
        return mList.size();
    }

    public class MyViewHolder extends RecyclerView.ViewHolder {
        TextView title,left,status,coins;
        RelativeLayout click;
        ProgressBar progressBar;
        LinearLayout lin_status;

        public MyViewHolder(@NonNull View itemView) {
            super(itemView);
            title = itemView.findViewById(R.id.title);
            left = itemView.findViewById(R.id.left);
            coins = itemView.findViewById(R.id.coins);
            status = itemView.findViewById(R.id.status);
            click = itemView.findViewById(R.id.click);
            lin_status = itemView.findViewById(R.id.lin_status);
            progressBar = itemView.findViewById(R.id.progressBar);
        }
    }
}