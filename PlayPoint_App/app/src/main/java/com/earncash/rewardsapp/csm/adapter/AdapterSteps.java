package com.earncash.rewardsapp.csm.adapter;

import android.app.Activity;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.recyclerview.widget.RecyclerView;

import com.earncash.rewardsapp.R;
import com.earncash.rewardsapp.csm.model.StepModel;

import java.util.List;

public class AdapterSteps extends RecyclerView.Adapter<AdapterSteps.MyViewHolder> {
    public AdapterSteps(List<StepModel> mList, Activity activity) {
        this.mList = mList;
        this.activity = activity;
    }

    List<StepModel> mList;
    Activity activity;

    @NonNull
    @Override
    public MyViewHolder onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
        LayoutInflater layoutInflater = LayoutInflater.from(parent.getContext());
        View view = layoutInflater.inflate(R.layout.item_csm_offer_steps, parent, false);
        return new MyViewHolder(view);
    }

    @Override
    public void onBindViewHolder(@NonNull MyViewHolder holder, int position) {
        StepModel model = mList.get(position);
        holder.step.setText(model.getStep());
        holder.text.setText(model.getText());
    }

    @Override
    public int getItemCount() {
        return mList.size();
    }

    public class MyViewHolder extends RecyclerView.ViewHolder {
        TextView step,text;

        public MyViewHolder(@NonNull View itemView) {
            super(itemView);
            step = itemView.findViewById(R.id.step);
            text = itemView.findViewById(R.id.text);

        }
    }
}