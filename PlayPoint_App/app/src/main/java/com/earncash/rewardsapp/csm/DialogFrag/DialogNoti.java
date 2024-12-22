package com.earncash.rewardsapp.csm.DialogFrag;

import android.os.Bundle;

import androidx.fragment.app.DialogFragment;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.TextView;

import com.earncash.rewardsapp.R;

public class DialogNoti extends DialogFragment {
    View root_view;
    TextView title,sub;
    ImageView close;
    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        // Inflate the layout for this fragment
        root_view = inflater.inflate(R.layout.fragment_dialog__noti, container, false);
        title = root_view.findViewById(R.id.title);
        sub = root_view.findViewById(R.id.sub);
        close = root_view.findViewById(R.id.close);

        title.setText(getArguments().getString("title"));
        sub.setText(getArguments().getString("sub"));

        close.setOnClickListener(v->{
            dismiss();
        });

        return root_view;
    }
}