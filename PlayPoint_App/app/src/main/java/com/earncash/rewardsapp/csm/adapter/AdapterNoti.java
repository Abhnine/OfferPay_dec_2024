package com.earncash.rewardsapp.csm.adapter;

import android.app.Activity;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.RelativeLayout;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.fragment.app.FragmentActivity;
import androidx.fragment.app.FragmentManager;
import androidx.fragment.app.FragmentTransaction;
import androidx.recyclerview.widget.RecyclerView;

import com.earncash.rewardsapp.R;
import com.earncash.rewardsapp.csm.DialogFrag.DialogNoti;
import com.earncash.rewardsapp.csm.model.ModelNoti;

import java.util.List;


public class AdapterNoti extends RecyclerView.Adapter<AdapterNoti.MyViewHolder> {
    public AdapterNoti(List<ModelNoti> mList, Activity activity) {
        this.mList = mList;
        this.activity = activity;
    }

    List<ModelNoti> mList;
    Activity activity;

    @NonNull
    @Override
    public MyViewHolder onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
        LayoutInflater layoutInflater = LayoutInflater.from(parent.getContext());
        View view = layoutInflater.inflate(R.layout.item_csm_noti, parent, false);
        return new MyViewHolder(view);
    }

    @Override
    public void onBindViewHolder(@NonNull MyViewHolder holder, int position) {
        ModelNoti model = mList.get(position);
        holder.title.setText(model.getTitle());
        holder.sub.setText(model.getSub());
        holder.date.setText(model.getDate());

        holder.click.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                FragmentManager fragmentManager = ((FragmentActivity)activity).getSupportFragmentManager();
                DialogNoti newFragment = new DialogNoti();
                Bundle args = new Bundle();
                args.putString("title", model.getTitle());
                args.putString("sub", model.getSub());

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
        TextView title,sub,date;
        RelativeLayout click;

        public MyViewHolder(@NonNull View itemView) {
            super(itemView);
            title = itemView.findViewById(R.id.title);
            click = itemView.findViewById(R.id.click);
            sub = itemView.findViewById(R.id.sub);
            date = itemView.findViewById(R.id.date);

        }
    }
}