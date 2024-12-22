package com.earncash.rewardsapp.csm.DialogFrag;

import static com.earncash.rewardsapp.helper.AppController.hidepDialog;
import static com.earncash.rewardsapp.helper.AppController.initpDialog;
import static com.earncash.rewardsapp.helper.AppController.isConnected;
import static com.earncash.rewardsapp.helper.AppController.showpDialog;
import static com.earncash.rewardsapp.helper.Constatnt.ADD_REFER_CODE_COINS;
import static com.earncash.rewardsapp.helper.Constatnt.ID;

import android.os.Bundle;

import androidx.appcompat.app.AppCompatActivity;
import androidx.fragment.app.DialogFragment;

import android.text.TextUtils;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.EditText;
import android.widget.LinearLayout;
import android.widget.TextView;
import android.widget.Toast;

import com.android.volley.Request;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.earncash.rewardsapp.R;
import com.earncash.rewardsapp.helper.AppController;
import com.earncash.rewardsapp.helper.JsonRequest;

import org.json.JSONException;
import org.json.JSONObject;

import java.util.HashMap;
import java.util.Map;
import java.util.Objects;

public class DialogReferValidate extends DialogFragment {
    View view;
    EditText edit_text;
    TextView coins;
    LinearLayout submit;
    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        // Inflate the layout for this fragment
        view = inflater.inflate(R.layout.fragment_dialog_refer_validate, container, false);

        edit_text = view.findViewById(R.id.edit_text);
        coins = view.findViewById(R.id.coins);
        submit = view.findViewById(R.id.submit);

        coins.setText(AppController.getInstance().getRefer_bonus()+" COINS");

        initpDialog((AppCompatActivity) getActivity());


        submit.setOnClickListener(view1 -> {
            if (Objects.equals(AppController.getInstance().getRefer_id(), edit_text.getText().toString())){
                edit_text.setError("Enter valid referral code");
            }
            
            if (edit_text.length()>0 && !TextUtils.isEmpty(edit_text.getText().toString())){
                addReferCoins(edit_text.getText().toString());
            }else edit_text.setError("Enter valid referral code");


        });


        view.findViewById(R.id.close).setOnClickListener(view1 -> {
            dismiss();
        });



        return view;
    }

    private void addReferCoins(String code) {
        showpDialog();
        if (isConnected((AppCompatActivity) getActivity())) {
            JsonRequest jsonReq = new JsonRequest(Request.Method.POST, ADD_REFER_CODE_COINS, null,
                    new Response.Listener<JSONObject>() {
                        @Override
                        public void onResponse(JSONObject response) {
                            //Toast.makeText(getContext(), response.toString(), Toast.LENGTH_SHORT).show();
                            hidepDialog();
                            try {
                                if (response.getString("error").equalsIgnoreCase("false")) {
                                    Toast.makeText(getContext(), response.getString("message"), Toast.LENGTH_SHORT).show();


                                }else if(response.getString("error").equalsIgnoreCase("true")){
                                    Toast.makeText(getContext(), response.getString("message"), Toast.LENGTH_SHORT).show();
                                }
                            } catch (JSONException e) {
                                e.printStackTrace();
                                hidepDialog();
                                Toast.makeText(getContext(), e.getMessage(), Toast.LENGTH_SHORT).show();
                            }
                        }
                    }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    //Log.println(10)
                    Toast.makeText(getContext(), "Er-  "+error.getMessage(), Toast.LENGTH_LONG).show();
                    hidepDialog();
                }
            }) {

                @Override
                protected Map<String, String> getParams() {
                    Map<String, String> params = new HashMap<String, String>();
                    params.put(ID, AppController.getInstance().getApi_token());
                    params.put("code", code);

                    return params;
                }
            };
            AppController.getInstance().getRequestQueue().getCache().clear();
            AppController.getInstance().addToRequestQueue(jsonReq);
        }
    }
}