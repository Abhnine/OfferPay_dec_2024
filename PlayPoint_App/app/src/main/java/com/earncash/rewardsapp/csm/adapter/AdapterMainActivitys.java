package com.earncash.rewardsapp.csm.adapter;

import androidx.annotation.NonNull;
import androidx.fragment.app.Fragment;
import androidx.fragment.app.FragmentActivity;
import androidx.viewpager2.adapter.FragmentStateAdapter;

import com.earncash.rewardsapp.csm.fragment.HomeFragment;
import com.earncash.rewardsapp.csm.fragment.LeaderboardFragment;
import com.earncash.rewardsapp.csm.fragment.ProfileFragment;
import com.earncash.rewardsapp.csm.fragment.ReferFragment;
import com.earncash.rewardsapp.csm.fragment.RewardFragment;

public class AdapterMainActivitys extends FragmentStateAdapter {
    public AdapterMainActivitys(@NonNull FragmentActivity fragmentActivity) {
        super(fragmentActivity);
    }

    @NonNull
    @Override
    public Fragment createFragment(int position) {
        switch (position)
        {
            case 0:
                return new HomeFragment();
            case 1:
                return new RewardFragment();
            case 2:
                return new LeaderboardFragment();
            case 3:
                return new ReferFragment();
            case 4:
                return new ProfileFragment();
            default:
                return new RewardFragment();

        }
    }

    @Override
    public int getItemCount() {
        return 5;
    }
}
