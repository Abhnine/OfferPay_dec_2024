package com.earncash.rewardsapp.csm.DialogFrag;

import android.content.Intent;
import android.net.Uri;
import android.os.Bundle;

import androidx.fragment.app.DialogFragment;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.TextView;
import android.widget.Toast;

import com.bumptech.glide.Glide;
import com.earncash.rewardsapp.R;
import com.earncash.rewardsapp.csm.adapter.AdapterRewardStep;
import com.earncash.rewardsapp.csm.adapter.AdapterSteps;
import com.earncash.rewardsapp.csm.model.ModelOfferReward;
import com.earncash.rewardsapp.csm.model.StepModel;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.List;

public class OfferDialog extends DialogFragment {
    View root_view;
    TextView title, desc, coins, coinsBtn, cat;
    ImageView image;
    ImageView close;
    LinearLayout click;
    RecyclerView steps, rewards;
    AdapterSteps adapterSteps;
    List<StepModel> stepsModels = new ArrayList<>();

    AdapterRewardStep adapterRewardStep;
    List<ModelOfferReward> modelOfferRewards = new ArrayList<>();

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        // Inflate the layout for this fragment
        root_view = inflater.inflate(R.layout.fragment_offer_dialog, container, false);

        image = root_view.findViewById(R.id.image);
        title = root_view.findViewById(R.id.title);
        desc = root_view.findViewById(R.id.desc);
        coins = root_view.findViewById(R.id.coins);
        coinsBtn = root_view.findViewById(R.id.coins2);
        click = root_view.findViewById(R.id.click);
        close = root_view.findViewById(R.id.close);
        steps = root_view.findViewById(R.id.steps);
        rewards = root_view.findViewById(R.id.rewards);
        cat = root_view.findViewById(R.id.cat);


        Glide.with(getContext()).load(getArguments().getString("image")).placeholder(R.mipmap.ic_launcher).into(image);
        title.setText(getArguments().getString("title"));
        desc.setText(getArguments().getString("sub"));
        coins.setText(getArguments().getString("coins"));
        coinsBtn.setText(getArguments().getString("coins"));
        cat.setText(getArguments().getString("cat"));

        click.setOnClickListener(v -> {
            Uri uri = Uri.parse(getArguments().getString("url")); // missing 'http://' will cause crashed
            Intent intent = new Intent(Intent.ACTION_VIEW, uri);
            startActivity(intent);
        });

        close.setOnClickListener(v -> {
            dismiss();
        });


        int count = 0;

        try {
            JSONArray array = new JSONArray(getArguments().getString("steps"));
            for (int index = 0; index < array.length(); index++) {
                count++;
                String text = (String) array.getString(index);
                StepModel item = new StepModel(count + ".", text);
                stepsModels.add(item);
            }
            int last_step = count + 1;

            StepModel item = new StepModel(last_step + ".", getArguments().getString("time"));
            stepsModels.add(item);

            adapterSteps = new AdapterSteps(stepsModels, getActivity());
            steps.setLayoutManager(new LinearLayoutManager(getContext()));
            steps.setAdapter(adapterSteps);
        } catch (JSONException e) {
            Toast.makeText(getContext(), "" + e.getMessage(), Toast.LENGTH_SHORT).show();
            e.printStackTrace();
        }

        try {
            JSONArray array = new JSONArray(getArguments().getString("events"));
            for (int index = 0; index < array.length(); index++) {
                count++;
                JSONObject feedObj = (JSONObject) array.get(index);
                if (feedObj.getBoolean("payable")) {
                    ModelOfferReward item = new ModelOfferReward(feedObj.getString("name"), feedObj.getString("flat_points"));
                    modelOfferRewards.add(item);
                }

            }
            adapterRewardStep = new AdapterRewardStep(modelOfferRewards, getActivity());
            rewards.setLayoutManager(new LinearLayoutManager(getContext()));
            rewards.setAdapter(adapterRewardStep);
        } catch (JSONException e) {
            Toast.makeText(getContext(), "" + e.getMessage(), Toast.LENGTH_SHORT).show();
            e.printStackTrace();
        }

        return root_view;

    }
}