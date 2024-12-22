package com.earncash.rewardsapp.csm.DialogFrag;

import static com.earncash.rewardsapp.helper.AppController.Show2X;
import static com.earncash.rewardsapp.helper.AppController.initpDialog;

import android.content.res.Configuration;
import android.os.Bundle;

import androidx.appcompat.app.AppCompatActivity;
import androidx.fragment.app.DialogFragment;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.TextView;

import com.earncash.rewardsapp.R;
import com.earncash.rewardsapp.helper.AppController;

public class Coins extends DialogFragment {
    View root_view;
    TextView coins,xp;
    ImageView close,bg,csm_back;
    LinearLayout x2,btn_xp;
    Boolean isFBReward = false;
    DialogFragment dialogFragment = (DialogFragment) getParentFragment();
    Coins ff = (Coins) getParentFragment();
    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        // Inflate the layout for this fragment
        root_view = inflater.inflate(R.layout.fragment_coins, container, false);
        coins = root_view.findViewById(R.id.coins);
        close = root_view.findViewById(R.id.close);
        x2 = root_view.findViewById(R.id.x2);
        bg = root_view.findViewById(R.id.bg);
        btn_xp = root_view.findViewById(R.id.btn_xp);
        xp = root_view.findViewById(R.id.xp);
        csm_back = root_view.findViewById(R.id.csm_back);
        coins.setText(getArguments().getString("coins")+" Coins");
        initpDialog((AppCompatActivity) getActivity());

        if (getResources().getConfiguration().orientation == Configuration.ORIENTATION_LANDSCAPE) {
            csm_back.setVisibility(View.VISIBLE);
            close.setVisibility(View.GONE);
            csm_back.setOnClickListener(v->{
                dismiss();
            });
        }




        if (getArguments().getBoolean("x2")){
            x2.setVisibility(View.VISIBLE);

            bg.setImageResource(R.drawable.bg_csm_reward_dialog_new);
            x2.setOnClickListener(v->{
                dismiss();
                Show2X(getActivity(),AppController.getInstance().getX2_ad(),getArguments().getString("coins"),getArguments().getString("from"));
            });

        }
        else {
            btn_xp.setVisibility(View.VISIBLE);
            int coins = Integer.parseInt(getArguments().getString("coins"))*2;
            xp.setText(coins+"XP");

        }

        close.setOnClickListener(v->{
            dismiss();
        });
        return root_view;

    }
}