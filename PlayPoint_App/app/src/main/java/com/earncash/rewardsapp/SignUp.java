package com.earncash.rewardsapp;

import static com.earncash.rewardsapp.helper.AppController.TAG;
import static com.earncash.rewardsapp.helper.AppController.hidepDialog;
import static com.earncash.rewardsapp.helper.AppController.initpDialog;
import static com.earncash.rewardsapp.helper.AppController.isConnected;
import static com.earncash.rewardsapp.helper.AppController.showpDialog;
import static com.earncash.rewardsapp.helper.Constatnt.ACCOUNT_STATE_ENABLED;
import static com.earncash.rewardsapp.helper.Constatnt.CHECK_USER;
import static com.earncash.rewardsapp.helper.Constatnt.GET_USER;
import static com.earncash.rewardsapp.helper.Constatnt.ID;
import static com.earncash.rewardsapp.helper.Constatnt.Main_Url;
import static com.earncash.rewardsapp.helper.PrefManager.ShowToast;
import static com.earncash.rewardsapp.helper.PrefManager.isValidEmail;
import static com.earncash.rewardsapp.helper.PrefManager.setWindowFlag;

import androidx.annotation.NonNull;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.content.ContextCompat;
import androidx.core.text.HtmlCompat;

import android.app.Activity;
import android.content.Intent;
import android.graphics.Color;
import android.os.Build;
import android.os.Bundle;
import android.provider.Settings;
import android.text.TextUtils;
import android.text.method.LinkMovementMethod;
import android.util.Log;
import android.view.View;
import android.view.WindowManager;
import android.widget.Button;
import android.widget.EditText;
import android.widget.LinearLayout;
import android.widget.TextView;

import com.android.volley.Request;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.earncash.rewardsapp.csm.MainActivity;
import com.earncash.rewardsapp.helper.AppController;
import com.earncash.rewardsapp.helper.JsonRequest;
import com.google.android.gms.auth.api.signin.GoogleSignIn;
import com.google.android.gms.auth.api.signin.GoogleSignInClient;
import com.google.android.gms.auth.api.signin.GoogleSignInOptions;
import com.google.android.gms.tasks.OnCompleteListener;
import com.google.android.gms.tasks.Task;
import com.google.firebase.auth.AuthResult;
import com.google.firebase.auth.FirebaseAuth;
import com.google.firebase.auth.FirebaseUser;

import org.json.JSONException;
import org.json.JSONObject;

import java.util.HashMap;
import java.util.Map;

public class SignUp extends AppCompatActivity {
    EditText edName,edEmail,edPass,edCPass;
    Button signup_btn;
    FirebaseAuth firebaseAuth;
    GoogleSignInClient googleSignInClient;
    LinearLayout login;
    TextView text;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        if (Build.VERSION.SDK_INT >= 19 && Build.VERSION.SDK_INT < 21) {
            setWindowFlag(this, WindowManager.LayoutParams.FLAG_TRANSLUCENT_STATUS, true);
        }
        if (Build.VERSION.SDK_INT >= 19) {
            getWindow().getDecorView().setSystemUiVisibility(View.SYSTEM_UI_FLAG_LAYOUT_STABLE | View.SYSTEM_UI_FLAG_LAYOUT_FULLSCREEN);
        }
        if (Build.VERSION.SDK_INT >= 21) {
            setWindowFlag(this, WindowManager.LayoutParams.FLAG_TRANSLUCENT_STATUS, false);
            getWindow().setStatusBarColor(Color.TRANSPARENT);
        }

        getWindow().setNavigationBarColor(ContextCompat.getColor(this, R.color.colorPrimaryDark));
        setContentView(R.layout.activity_sign_up);

        edName = findViewById(R.id.edName);
        edEmail = findViewById(R.id.edEmail);
        edPass = findViewById(R.id.edPass);
        edCPass = findViewById(R.id.edCPass);
        signup_btn = findViewById(R.id.signup_btn);
        login = findViewById(R.id.login);
        text = findViewById(R.id.text);

        String url1 = "<font color='" + getColor(R.color.linksColor) + "'><a href='" + Main_Url + "page/terms" + "'>Terms And Conditions</a></font>";
        String url2 = "<font color='" + getColor(R.color.linksColor) + "'><a href='" + Main_Url + "page/privacy" + "'>Privacy Policy</a></font>";

        String formattedText = url1 + " And " + url2;
        text.setLinksClickable(true);
        text.setMovementMethod(LinkMovementMethod.getInstance());
        text.setText(HtmlCompat.fromHtml(formattedText, HtmlCompat.FROM_HTML_MODE_LEGACY));

        initpDialog(this);
        configureGoogleClient();
        login.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                finish();
            }
        });

        signup_btn.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                if (TextUtils.isEmpty(edEmail.getText().toString().trim())){
                    edEmail.setError("Enter email!");
                    if (!isValidEmail(edEmail.getText().toString())){
                        edEmail.setError("Invalid email!");
                    }
                    if (TextUtils.isEmpty(edName.getText().toString().trim())) {edName.setError("Enter name");}else
                    {if (!(edName.getText().toString().trim().length() >3)) {edName.setError("Name must be at least 3 characters long!");}}

                    if (TextUtils.isEmpty(edPass.getText().toString().trim())) {edPass.setError("Enter password");}else
                    {if (!(edPass.getText().toString().trim().length() >5)) {edPass.setError("Password must be at least 6 characters long!");}}

                    if (TextUtils.isEmpty(edCPass.getText().toString().trim())) {
                        edCPass.setError("Enter confirm password!");
                        if (!edCPass.getText().toString().trim().equals(edPass.getText().toString().trim())){
                            edCPass.setError("Password and confirm password does not match!");
                        }
                    }

                }

                if (!TextUtils.isEmpty(edEmail.getText().toString().trim())
                        && !TextUtils.isEmpty(edName.getText().toString().trim())
                        && !TextUtils.isEmpty(edEmail.getText().toString().trim())
                        && !TextUtils.isEmpty(edCPass.getText().toString().trim())
                        && edPass.getText().toString().trim().length() >5
                        && edCPass.getText().toString().trim().equals(edPass.getText().toString().trim())
                        && edName.getText().toString().trim().length() >3
                        && isValidEmail(edEmail.getText().toString())
                )
                {
                    loginWithEmail(edEmail.getText().toString().trim(),edPass.getText().toString().trim(),edName.getText().toString().trim());

                }
            }
        });

    }

    private void loginWithEmail(String email, String pass, String name) {
        showpDialog();
        firebaseAuth.createUserWithEmailAndPassword(email,pass)
                .addOnCompleteListener(new OnCompleteListener<AuthResult>() {
                    @Override
                    public void onComplete(@NonNull Task<AuthResult> task) {
                        if (task.isSuccessful()) {
                            // Sign in success, update UI with the signed-in user's information
                            FirebaseUser user = firebaseAuth.getCurrentUser();
                            Log.d(TAG, "signInWithCredential:success: currentUser: " + user.getEmail());
                            String email = user.getEmail();
                            // String name = user.getDisplayName();
                            String profile = String.valueOf(user.getPhotoUrl());
                            String uid = user.getUid();
                            check_user(uid, name, email, profile);
                        } else {
                            hidepDialog();
                            // If sign in fails, display a message to the user.
                            Log.w(TAG, "signInWithCredential:failure", task.getException());
                            ShowToast(SignUp.this, ""+task.getException().getMessage(),true);

                        }
                    }
                });

    }


    public void check_user(String uid, String name, String email, String profile) {
        if (isConnected(SignUp.this)) {
            String mId = Settings.Secure.getString(getContentResolver(), Settings.Secure.ANDROID_ID);
            if (mId == null) {
                ShowToast(this,"Cant get device id!!",true);
                return;
            }

            JsonRequest jsonReq = new JsonRequest(Request.Method.POST, CHECK_USER, null,
                    new Response.Listener<JSONObject>() {
                        @Override
                        public void onResponse(JSONObject response) {
                            try {
                                if (response.getString("error").equalsIgnoreCase("false")) {
                                    signin(response.getString("token"));
                                } else if (response.getString("error").equalsIgnoreCase("true")) {
                                    firebaseAuth.signOut();
                                    hidepDialog();
                                    ShowToast(SignUp.this, response.getString("message"),true);
                                }

                            } catch (JSONException e) {
                                e.printStackTrace();
                                hidepDialog();
                                ShowToast(SignUp.this, "Check User " + e.toString(),true);
                            }
                        }
                    }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    ShowToast(SignUp.this, "Error in Check User " + error.getLocalizedMessage(),true);
                    hidepDialog();
                }
            }) {
                @Override
                protected Map<String, String> getParams() {
                    Map<String, String> params = new HashMap<String, String>();
                    params.put("uid", uid);
                    params.put("name", name);
                    params.put("email", email);
                    params.put("profile", profile);
                    params.put("device", mId);
                    params.put("login_type", "2");
                    return params;
                }
            };
            AppController.getInstance().addToRequestQueue(jsonReq);
        }

    }

    public void signin(final String api_token) {
        if (isConnected(SignUp.this)) {
            JsonRequest jsonReq = new JsonRequest(Request.Method.POST, GET_USER, null,
                    new Response.Listener<JSONObject>() {
                        @Override
                        public void onResponse(JSONObject response) {
                            hidepDialog();
                            if (AppController.getInstance().authorize(response, api_token)) {
                                if (AppController.getInstance().getState().equals(ACCOUNT_STATE_ENABLED)) {
                                    try {
                                        if (response.getString("error").equalsIgnoreCase("true")) {
                                            ShowToast(SignUp.this, response.getString("message"),true);
                                        } else if (response.getString("error").equalsIgnoreCase("false")) {
                                            Intent i = new Intent(SignUp.this, MainActivity.class);
                                            i.addFlags(Intent.FLAG_ACTIVITY_NEW_TASK);
                                            i.addFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
                                            i.addFlags(Intent.FLAG_ACTIVITY_CLEAR_TASK);
                                            startActivity(i);
                                        }
                                    } catch (JSONException e) {
                                        e.printStackTrace();
                                    }

                                } else {
                                    AppController.getInstance().logout(SignUp.this);
                                    ShowToast((Activity) SignUp.this, (String) getText(R.string.msg_account_blocked),true);
                                }

                            } else {
                                ShowToast(SignUp.this, "Something Gone Wrong",true);
                            }
                        }
                    }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    ShowToast(SignUp.this, getString(R.string.error_data_loading),true);
                    hidepDialog();
                }
            }) {

                @Override
                protected Map<String, String> getParams() {
                    Map<String, String> params = new HashMap<String, String>();
                    params.put(ID, api_token);
                    return params;
                }
            };
            AppController.getInstance().getRequestQueue().getCache().clear();
            AppController.getInstance().addToRequestQueue(jsonReq);
        }

    }


    private void configureGoogleClient() {
        // Configure Google Sign In
        GoogleSignInOptions gso = new GoogleSignInOptions.Builder(GoogleSignInOptions.DEFAULT_SIGN_IN)
                // for the requestIdToken, this is in the values.xml file that
                // is generated from your google-services.json
                .requestIdToken(getString(R.string.default_web_client_id))
                .requestEmail()
                .build();
        // Build a GoogleSignInClient with the options specified by gso.
        googleSignInClient = GoogleSignIn.getClient(this, gso);
        // Set the dimensions of the sign-in button.
        // Initialize Firebase Auth
        firebaseAuth = FirebaseAuth.getInstance();
    }
}