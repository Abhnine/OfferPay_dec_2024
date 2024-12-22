package com.earncash.rewardsapp.csm.adapter;

import android.app.Activity;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.recyclerview.widget.RecyclerView;

import com.earncash.rewardsapp.R;
import com.earncash.rewardsapp.csm.model.TransItems;

import java.util.List;

public class TransAdapter extends RecyclerView.Adapter<TransAdapter.MyViewHolder> {
    public TransAdapter(List<TransItems> mList, Activity activity) {
        this.mList = mList;
        this.activity = activity;
    }

    List<TransItems> mList;
    Activity activity;

    @NonNull
    @Override
    public MyViewHolder onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
        LayoutInflater layoutInflater = LayoutInflater.from(parent.getContext());
        View view = layoutInflater.inflate(R.layout.item_csm_trans, parent, false);
        return new MyViewHolder(view);
    }

    @Override
    public void onBindViewHolder(@NonNull MyViewHolder holder, int position) {
        TransItems transItems = mList.get(position);

        holder.from.setText(transItems.getFrom());
        holder.date.setText(transItems.getDate());
        if (transItems.getType()==0){
            holder.amount.setText(""+transItems.getAmount());
            holder.type.setTextColor(activity.getColor(R.color.green_500));
            holder.type.setText("+");
        }else {
            holder.type.setText("-");
            holder.type.setTextColor(activity.getColor(R.color.red));
            holder.amount.setText(""+transItems.getAmount());
        }


    }

    @Override
    public int getItemCount() {
        return mList.size();
    }

    public class MyViewHolder extends RecyclerView.ViewHolder {
        TextView from, date, amount,type;

        public MyViewHolder(@NonNull View itemView) {
            super(itemView);
            from = itemView.findViewById(R.id.from);
            date = itemView.findViewById(R.id.date);
            amount = itemView.findViewById(R.id.amount);
            type = itemView.findViewById(R.id.type);
        }
    }
}
