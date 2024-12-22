package com.earncash.rewardsapp.csm.adapter;

import static com.earncash.rewardsapp.helper.Constatnt.Main_Url;

import android.content.Context;
import android.content.Intent;
import android.net.Uri;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.LinearLayout;
import android.widget.RelativeLayout;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.recyclerview.widget.RecyclerView;
import androidx.viewpager2.widget.ViewPager2;

import com.bumptech.glide.Glide;
import com.earncash.rewardsapp.R;
import com.earncash.rewardsapp.csm.activity.DailyActivity;
import com.earncash.rewardsapp.csm.model.SliderItems;
import com.makeramen.roundedimageview.RoundedImageView;

import java.util.List;


public class SliderAdapter extends RecyclerView.Adapter {
    private List<SliderItems> sliderItems;
    private ViewPager2 viewPager2;
    private Boolean daily = false;
    String p;
    Context context;
    public SliderAdapter(List<SliderItems> sliderItems, ViewPager2 viewPager2, Context context) {
        this.sliderItems = sliderItems;
        this.viewPager2 = viewPager2;
        this.context = context;
    }
    @NonNull

    @Override
    public int getItemCount() {
        return sliderItems.size();
    }

    @NonNull
    @Override
    public RecyclerView.ViewHolder onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
        if (viewType == 1) {
            View view = LayoutInflater.from(parent.getContext()).inflate(R.layout.item_csm_daily_bonus, parent, false);
            return new SliderAdapter.BannerHolder(view);
        } else {
            View view = LayoutInflater.from(parent.getContext()).inflate(R.layout.item_slider, parent, false);
            return new SliderAdapter.SliderViewHolder(view);
        }
    }

    @Override
    public void onBindViewHolder(@NonNull RecyclerView.ViewHolder viewHolder, int position) {
        if (viewHolder.getItemViewType()==1){
            SliderAdapter.BannerHolder holder = (SliderAdapter.BannerHolder) viewHolder;
            holder.click.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {
                    context.startActivity(new Intent(context, DailyActivity.class));
                }
            });
        }else {
            SliderViewHolder holder = (SliderViewHolder) viewHolder;
            final SliderItems model = sliderItems.get(position);
            Glide.with(context).load(Main_Url+model.getImage()).into(holder.img);
            holder.title.setText(model.getTitle());
            holder.sub.setText(model.getSub());
            holder.sub.setSelected(true);

            holder.click.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {
                    Uri uri = Uri.parse(model.getUrl()); // missing 'http://' will cause crashed
                    Intent intent = new Intent(Intent.ACTION_VIEW, uri);
                    context.startActivity(intent);
                }
            });
        }

    }

    @Override
    public int getItemViewType(int position) {
        if (position==0) {
            return 1;
        } else {
            return 0;
        }
    }


    class SliderViewHolder extends RecyclerView.ViewHolder {
        RelativeLayout click;
        TextView title,sub;
        RoundedImageView img;

        SliderViewHolder(@NonNull View itemView) {
            super(itemView);
            title = itemView.findViewById(R.id.title);
            sub = itemView.findViewById(R.id.sub);
            img = itemView.findViewById(R.id.img);
            click = itemView.findViewById(R.id.click);


        }
        void setImage(SliderItems sliderItems){
//use glide or picasso in case you get image from internet
            //  imageView.setImageResource(sliderItems.getImage());
        }
    }


     static class BannerHolder extends RecyclerView.ViewHolder {
        LinearLayout click;
       public BannerHolder(@NonNull View itemView) {
            super(itemView);
            click = itemView.findViewById(R.id.click);
        }
    }


    public Runnable runnable = new Runnable() {
        @Override
        public void run() {
            sliderItems.addAll(sliderItems);
            notifyDataSetChanged();
        }
    };
}