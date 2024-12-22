package com.earncash.rewardsapp.csm.adapter;

import androidx.annotation.NonNull;
import androidx.fragment.app.Fragment;
import androidx.fragment.app.FragmentActivity;
import androidx.viewpager2.adapter.FragmentStateAdapter;

import com.earncash.rewardsapp.csm.fragment.RewardStatus;
import com.earncash.rewardsapp.csm.fragment.TransFragment;

public class CSM_Trans_Adapter extends FragmentStateAdapter {
    public CSM_Trans_Adapter(@NonNull FragmentActivity fragmentActivity) {
        super(fragmentActivity);
    }

    @NonNull
    @Override
    public Fragment createFragment(int position) {
        switch (position)
        {
            case 0:
                return new TransFragment();
            case 1:
                return new RewardStatus();
            default:
                return new TransFragment();

        }
    }

    @Override
    public int getItemCount() {
        return 2;
    }
}