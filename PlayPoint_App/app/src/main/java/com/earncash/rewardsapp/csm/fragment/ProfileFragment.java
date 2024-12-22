package com.earncash.rewardsapp.csm.fragment;

import static com.earncash.rewardsapp.helper.AppController.isConnected;
import static com.earncash.rewardsapp.helper.Constatnt.Main_Url;

import android.content.Intent;
import android.net.Uri;
import android.os.Bundle;

import androidx.appcompat.app.AppCompatActivity;
import androidx.fragment.app.Fragment;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.EditText;
import android.widget.LinearLayout;
import android.widget.ProgressBar;
import android.widget.RelativeLayout;
import android.widget.TextView;
import android.widget.Toast;

import com.bumptech.glide.Glide;
import com.earncash.rewardsapp.Activity_Login;
import com.earncash.rewardsapp.R;
import com.earncash.rewardsapp.csm.activity.Profile;
import com.earncash.rewardsapp.csm.activity.TransActivity;
import com.earncash.rewardsapp.helper.AppController;
import com.makeramen.roundedimageview.RoundedImageView;

public class ProfileFragment extends Fragment {


    View root_view;
    RelativeLayout t_and_c, p_policy, cont, rate, share, trans, logout;
    TextView coins, level, xp_need, refers, total_earn, redeem;
    ;
    ProgressBar progressBar;
    EditText name;
    RoundedImageView img_profile;
    LinearLayout account;

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        // Inflate the layout for this fragment
        root_view = inflater.inflate(R.layout.fragment_profile, container, false);
        t_and_c = root_view.findViewById(R.id.t_and_c);
        p_policy = root_view.findViewById(R.id.p_policy);
        cont = root_view.findViewById(R.id.cont);
        rate = root_view.findViewById(R.id.rate);
        share = root_view.findViewById(R.id.share);
        coins = root_view.findViewById(R.id.coins);
        progressBar = root_view.findViewById(R.id.progressBar);
        level = root_view.findViewById(R.id.level);
        xp_need = root_view.findViewById(R.id.xp_need);
        name = root_view.findViewById(R.id.name);
        img_profile = root_view.findViewById(R.id.img_profile);
        account = root_view.findViewById(R.id.account);
        total_earn = root_view.findViewById(R.id.total_earn);
        redeem = root_view.findViewById(R.id.redeem);
        refers = root_view.findViewById(R.id.refers);
        trans = root_view.findViewById(R.id.trans);
        logout = root_view.findViewById(R.id.logout);



        share.setOnClickListener(v -> {
            Allshare();
        });
        logout.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                AppController.getInstance().removeData();
                AppController.getInstance().setApi_token("0");
                AppController.getInstance().readData();
                Toast.makeText(getActivity(), "Logout Successfully..!!", Toast.LENGTH_SHORT).show();
                Intent i = new Intent(getActivity(), Activity_Login.class);
                i.addFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
                i.addFlags(Intent.FLAG_ACTIVITY_NEW_TASK);
                i.addFlags(Intent.FLAG_ACTIVITY_CLEAR_TASK);
                startActivity(i);
            }
        });

        refers.setText(AppController.getInstance().getRefers());
        total_earn.setText(AppController.getInstance().getTotal_earn());
        redeem.setText(AppController.getInstance().getRedeem());

        t_and_c.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Uri uri = Uri.parse(Main_Url+"page/terms");
                Intent intent = new Intent(Intent.ACTION_VIEW, uri);
                startActivity(intent);
            }
        });
        p_policy.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Uri uri = Uri.parse(Main_Url+"page/privacy");
                Intent intent = new Intent(Intent.ACTION_VIEW, uri);
                startActivity(intent);
            }
        });

        cont.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                startActivity(new Intent(Intent.ACTION_SENDTO, Uri.parse("mailto:" + getString(R.string.contect_email))));
            }
        });

        rate.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                String PACKAGE_NAME = "https://play.google.com/store/apps/details?id=" + getActivity().getPackageName();
                Uri uri = Uri.parse(PACKAGE_NAME); // missing 'http://' will cause crashed
                Intent intent = new Intent(Intent.ACTION_VIEW, uri);
                startActivity(intent);
            }
        });
        account.setOnClickListener(v -> {
            startActivity(new Intent(getContext(), Profile.class));
        });


        trans.setOnClickListener(v -> {
            Intent i = new Intent(getContext(), TransActivity.class);
            startActivity(i);
        });
        return root_view;


    }

    public void Allshare() {
        String msg = AppController.getInstance().getReferMessage();
        String message = msg.replace("{app_link}", Main_Url + "refer/" + AppController.getInstance().getRefer_id());
        Intent waIntent = new Intent(Intent.ACTION_SEND);
        waIntent.setType("text/plain");
        if (waIntent != null) {
            waIntent.putExtra(Intent.EXTRA_TEXT, message);//
            getActivity().startActivity(Intent.createChooser(waIntent, "Share with"));
        } else {
            Toast.makeText(getContext(), "Telegram is not installed", Toast.LENGTH_SHORT).show();
        }
    }

    @Override
    public void onResume() {
        super.onResume();
        isConnected((AppCompatActivity) getActivity());
        xp_need.setText(AppController.getInstance().getLvlProgress() + "/"+AppController.getInstance().getXp_need()+"XP");
        progressBar.setMax(Integer.parseInt(AppController.getInstance().getXp_need()));
        progressBar.setProgress(Integer.parseInt(AppController.getInstance().getLvlProgress()));
        level.setText("Lv." + AppController.getInstance().getLevel());
        name.setText(AppController.getInstance().getName());
        coins.setText(AppController.getInstance().getPoints());
        Glide.with(getContext()).load(AppController.getInstance().getProfile()).placeholder(R.mipmap.ic_launcher).into(img_profile);
        TextView coinss = root_view.findViewById(R.id.coins_);
        coinss.setText(AppController.getInstance().getPoints());
        TextView diamond = root_view.findViewById(R.id.diamond);
        diamond.setText(AppController.getInstance().getDiamond());


    }
}