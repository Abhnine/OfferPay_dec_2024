package com.earncash.rewardsapp.csm.DialogFrag;

import static com.earncash.rewardsapp.helper.Constatnt.Main_Url;
import static com.earncash.rewardsapp.helper.PrefManager.redeem_package;

import android.content.Context;
import android.os.Bundle;

import androidx.fragment.app.DialogFragment;

import android.text.InputType;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.TextView;

import com.bumptech.glide.Glide;
import com.bumptech.glide.request.RequestOptions;
import com.earncash.rewardsapp.R;

public class Dialog_Reward extends DialogFragment {
    View root_view;
    EditText pd;
    TextView value,note,value2,coins_;
    ImageView logo;
    LinearLayout close,redeem;
    String p_details;
    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        // Inflate the layout for this fragment

        root_view = inflater.inflate(R.layout.reward_dialog_csm, container, false);

        pd = root_view.findViewById(R.id.edit_text);
        logo = root_view.findViewById(R.id.logo);
        close = root_view.findViewById(R.id.close);
        redeem = root_view.findViewById(R.id.redeem);
        note = root_view.findViewById(R.id.note);
        value = root_view.findViewById(R.id.value);
        value2 = root_view.findViewById(R.id.value2);
        coins_ = root_view.findViewById(R.id.coins);

        String coins = getArguments().getString("coins");
        String id = getArguments().getString("id");
        String uri = getArguments().getString("uri");
        String symbol = getArguments().getString("symbol");
        String amount = getArguments().getString("amount");
        String type = getArguments().getString("type").trim();
        String hint = getArguments().getString("hint");
        String more = getArguments().getString("more");
        String amount_id = getArguments().getString("amount_id");
        pd.setHint(hint);
        if (type.equals("email"))
        {
            pd.setInputType(InputType.TYPE_TEXT_VARIATION_EMAIL_ADDRESS);
        }else if (type.equals("phone"))
        {
            pd.setEnabled(true);
            pd.setInputType(InputType.TYPE_CLASS_PHONE);
        }else if (type.equals("number"))
        {
            pd.setEnabled(true);
            pd.setInputType(InputType.TYPE_CLASS_NUMBER);
        }else if (type.equals("text"))
        {
            pd.setEnabled(true);
            pd.setInputType(InputType.TYPE_CLASS_TEXT);
        }
        value.setText(coins+" COINS = ");
        value2.setText(symbol+""+amount);
        coins_.setText(coins+" COINS");

        Glide.with(getContext()).load(Main_Url+uri)
                .apply(new RequestOptions().placeholder(R.mipmap.ic_launcher))
                .into(logo);

        close.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                dismiss();
            }
        });
        note.setText(more);

        Context contextt = getContext();

        redeem.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                p_details = String.valueOf(pd.getText());
                if (type.equals("email"))
                {
                    if (pd.length()>1)
                    {
                        dismiss();
                        redeem_package(contextt,id,p_details,amount_id,getActivity());

                    }

                }else if (type.equals("phone"))
                {
                    if (pd.length()>=10)
                    {
                        dismiss();
                        redeem_package(contextt,id,p_details,amount_id,getActivity());
                    }else
                    {
                        pd.setError("Enter valid number");
                    }
                }else if (type.equals("number"))
                {
                    if (pd.length()>=1)
                    {
                        dismiss();
                        redeem_package(contextt,id,p_details,amount_id,getActivity());
                    }else
                    {
                        dismiss();
                        pd.setError("Error");
                    }
                }else if (type.equals("text"))
                {
                    if (pd.length()>0)
                    {
                        dismiss();
                        redeem_package(contextt,id,p_details,amount_id,getActivity());
                    }else
                    {
                        pd.setError("Error");
                    }
                }else
                {
                    if (pd.length()>0)
                    {
                        dismiss();
                        redeem_package(contextt,id,p_details,amount_id,getActivity());
                    }else
                    {
                        pd.setError("Error");
                    }
                }
            }
        });

        return root_view;
    }
}