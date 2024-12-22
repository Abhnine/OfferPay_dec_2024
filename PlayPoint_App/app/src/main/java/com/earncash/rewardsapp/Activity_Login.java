package com.earncash.rewardsapp;

import android.app.Activity;
import android.content.Intent;
import android.graphics.Color;
import android.os.Build;
import android.os.Bundle;

import android.provider.Settings;
import android.text.method.LinkMovementMethod;
import android.util.Log;
import android.view.View;
import android.view.WindowManager;
import android.widget.LinearLayout;
import android.widget.RelativeLayout;
import android.widget.TextView;

import androidx.activity.result.ActivityResult;
import androidx.activity.result.ActivityResultCallback;
import androidx.activity.result.ActivityResultLauncher;
import androidx.activity.result.contract.ActivityResultContracts;
import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.content.ContextCompat;
import androidx.core.text.HtmlCompat;

import com.android.volley.Request;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.earncash.rewardsapp.csm.MainActivity;
import com.earncash.rewardsapp.helper.AppController;
import com.earncash.rewardsapp.helper.JsonRequest;
import com.facebook.AccessToken;
import com.facebook.CallbackManager;
import com.facebook.FacebookCallback;
import com.facebook.FacebookException;
import com.facebook.login.LoginManager;
import com.facebook.login.LoginResult;
import com.google.android.gms.auth.api.signin.GoogleSignIn;
import com.google.android.gms.auth.api.signin.GoogleSignInAccount;
import com.google.android.gms.auth.api.signin.GoogleSignInClient;
import com.google.android.gms.auth.api.signin.GoogleSignInOptions;
import com.google.android.gms.common.api.ApiException;
import com.google.android.gms.tasks.OnCompleteListener;
import com.google.android.gms.tasks.Task;
import com.google.firebase.auth.AuthCredential;
import com.google.firebase.auth.AuthResult;
import com.google.firebase.auth.FacebookAuthProvider;
import com.google.firebase.auth.FirebaseAuth;
import com.google.firebase.auth.FirebaseUser;
import com.google.firebase.auth.GoogleAuthProvider;

import org.json.JSONException;
import org.json.JSONObject;

import java.util.Arrays;
import java.util.HashMap;
import java.util.Map;

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
import static com.earncash.rewardsapp.helper.PrefManager.setWindowFlag;

public class Activity_Login extends AppCompatActivity {

    GoogleSignInClient googleSignInClient;
    private FirebaseAuth firebaseAuth;
    LinearLayout google, fb_btn, emailLogin;
    CallbackManager mCallbackManager;
    boolean fb_clicked = false;
    TextView text, csm_firstTxt, csmName;
    RelativeLayout rEmail,rFb,rGoogle;

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
        setContentView(R.layout.activity_login);
        initpDialog(Activity_Login.this);
        google = findViewById(R.id.google);
        fb_btn = findViewById(R.id.fb_btn);
        text = findViewById(R.id.text);
        csm_firstTxt = findViewById(R.id.csm_firstTxt);
        csmName = findViewById(R.id.csmName);
        emailLogin = findViewById(R.id.emailLogin);
        rEmail = findViewById(R.id.rEmail);
        rFb = findViewById(R.id.rFb);
        rGoogle = findViewById(R.id.rGoogle);

        validateLogins();

        String appName = getString(R.string.app_name);
        String first = String.valueOf(appName.charAt(0));
        csm_firstTxt.setText(first);
        csmName.setText(appName.substring(1));

        AppController.transparentStatusAndNavigation(Activity_Login.this);
        initpDialog(Activity_Login.this);
        configureGoogleClient();
        google.setOnClickListener(v -> {
            signInToGoogle();
        });

        emailLogin.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                startActivity(new Intent(Activity_Login.this, LoginEmail.class));
            }
        });


        String url1 = "<font color='" + getColor(R.color.linksColor) + "'><a href='" + Main_Url + "page/terms" + "'>Terms And Conditions</a></font>";
        String url2 = "<font color='" + getColor(R.color.linksColor) + "'><a href='" + Main_Url + "page/privacy" + "'>Privacy Policy</a></font>";

        String formattedText = url1 + " And " + url2;
        text.setLinksClickable(true);
        text.setMovementMethod(LinkMovementMethod.getInstance());
        text.setText(HtmlCompat.fromHtml(formattedText, HtmlCompat.FROM_HTML_MODE_LEGACY));


        mCallbackManager = CallbackManager.Factory.create();
        fb_btn.setOnClickListener(v -> {
            fb_clicked = true;
            LoginManager.getInstance().logInWithReadPermissions(Activity_Login.this, Arrays.asList("email", "public_profile"));

            LoginManager.getInstance().registerCallback(mCallbackManager,
                    new FacebookCallback<LoginResult>() {
                        @Override
                        public void onSuccess(LoginResult loginResult) {
                            handleFacebookAccessToken(loginResult.getAccessToken());

                        }

                        @Override
                        public void onCancel() {
                            ShowToast(Activity_Login.this, "Login failed!", true);
                            fb_clicked = false;

                        }

                        @Override
                        public void onError(FacebookException exception) {
                            ShowToast(Activity_Login.this, exception.getMessage(), true);
                            fb_clicked = false;
                        }
                    });
        });


    }

    private void validateLogins() {
        if (!getResources().getBoolean(R.bool.Email)){
            rEmail.setVisibility(View.GONE);
        }
        if (!getResources().getBoolean(R.bool.Google)){
            rGoogle.setVisibility(View.GONE);
        }
        if (!getResources().getBoolean(R.bool.Facebook)){
            rFb.setVisibility(View.GONE);
        }
    }

    private void handleFacebookAccessToken(AccessToken token) {
        Log.d(TAG, "handleFacebookAccessToken:" + token);

        AuthCredential credential = FacebookAuthProvider.getCredential(token.getToken());
        firebaseAuth.signInWithCredential(credential)
                .addOnCompleteListener(this, new OnCompleteListener<AuthResult>() {
                    @Override
                    public void onComplete(@NonNull Task<AuthResult> task) {
                        if (task.isSuccessful()) {
                            // Sign in success, update UI with the signed-in user's information
                            Log.d(TAG, "signInWithCredential:success");
                            FirebaseUser user = firebaseAuth.getCurrentUser();
                            Log.d(TAG, "signInWithCredential:success: currentUser: " + user.getEmail());
                            String email = user.getEmail();
                            String name = user.getDisplayName();
                            String profile = String.valueOf(user.getPhotoUrl());
                            String uid = user.getUid();
                            check_user(uid, name, email, profile,"1");
                        } else {
                            // If sign in fails, display a message to the user.
                            Log.w(TAG, "signInWithCredential:failure", task.getException());
                            ShowToast(Activity_Login.this, "FB Authentication failed.", true);
                            // updateUI(null);
                        }
                    }
                });
    }


    //03. Check User
    public void check_user(String uid, String name, String email, String profile,String login_type) {
        showpDialog();
        if (isConnected(Activity_Login.this)) {
            String mId = Settings.Secure.getString(getContentResolver(), Settings.Secure.ANDROID_ID);
            if (mId == null) {
                ShowToast(this, "Cant get device id!!", true);
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
                                    ShowToast(Activity_Login.this, response.getString("message"), true);
                                }

                            } catch (JSONException e) {
                                e.printStackTrace();
                                ShowToast(Activity_Login.this, "Check User " + e.toString(), true);
                            }
                        }
                    }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    ShowToast(Activity_Login.this, "Error in Check User " + error.getLocalizedMessage(), true);
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
                    params.put("login_type", login_type);
                    return params;
                }
            };
            AppController.getInstance().addToRequestQueue(jsonReq);
        }

    }

    @Override
    public void onStart() {
        super.onStart();

    }


    @Override
    protected void onActivityResult(int requestCode, int resultCode, @Nullable Intent data) {
        super.onActivityResult(requestCode, resultCode, data);
        if (fb_clicked) {
            mCallbackManager.onActivityResult(requestCode, resultCode, data);
        }

    }


    public void signin(final String api_token) {
        if (isConnected(Activity_Login.this)) {
            JsonRequest jsonReq = new JsonRequest(Request.Method.POST, GET_USER, null,
                    new Response.Listener<JSONObject>() {
                        @Override
                        public void onResponse(JSONObject response) {
                            hidepDialog();
                            if (AppController.getInstance().authorize(response, api_token)) {
                                if (AppController.getInstance().getState().equals(ACCOUNT_STATE_ENABLED)) {
                                    try {
                                        if (response.getString("error").equalsIgnoreCase("true")) {
                                            ShowToast(Activity_Login.this, response.getString("message"), true);
                                        } else if (response.getString("error").equalsIgnoreCase("false")) {
                                            Intent i = new Intent(Activity_Login.this, MainActivity.class);
                                            i.addFlags(Intent.FLAG_ACTIVITY_NEW_TASK);
                                            i.addFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
                                            i.addFlags(Intent.FLAG_ACTIVITY_CLEAR_TASK);
                                            startActivity(i);
                                        }
                                    } catch (JSONException e) {
                                        e.printStackTrace();
                                    }

                                } else {
                                    AppController.getInstance().logout(Activity_Login.this);
                                    ShowToast((Activity) Activity_Login.this, (String) getText(R.string.msg_account_blocked), true);
                                }

                            } else {
                                ShowToast(Activity_Login.this, "Something Gone Wrong", true);
                            }
                        }
                    }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    ShowToast(Activity_Login.this, getString(R.string.error_data_loading), true);
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

    public void signInToGoogle() {
        // Intent signInIntent = googleSignInClient.getSignInIntent();
        //startActivityForResult(signInIntent, RC_SIGN_IN);
        startforresultt.launch(new Intent(googleSignInClient.getSignInIntent()));
    }

    ActivityResultLauncher<Intent> startforresultt = registerForActivityResult(
            new ActivityResultContracts.StartActivityForResult(),
            new ActivityResultCallback<ActivityResult>() {
                @Override
                public void onActivityResult(ActivityResult result) {
                    int result_code = result.getResultCode();
                    Intent data = result.getData();
                    // Result returned from launching the Intent from GoogleSignInApi.getSignInIntent(...);
                    if (result.getResultCode() == Activity.RESULT_OK) {
                        Task<GoogleSignInAccount> task = GoogleSignIn.getSignedInAccountFromIntent(data);
                        try {
                            // Google Sign In was successful, authenticate with Firebase
                            GoogleSignInAccount account = task.getResult(ApiException.class);
                            //register("12345",account.getId(),account.getDisplayName(),account.getEmail());
                            firebaseAuthWithGoogle(account);
                            Log.e("data", account.getDisplayName());
                        } catch (ApiException e) {
                            // Google Sign In failed, update UI appropriately
                            Log.w(TAG, "Google sign in failed", e);

                        }
                    } else {
                        ShowToast(Activity_Login.this, "Google sign in failed", true);
                    }
                }
            }
    );

    private void firebaseAuthWithGoogle(GoogleSignInAccount account) {
        Log.d(TAG, "firebaseAuthWithGoogle:" + account.getId());
        AuthCredential credential = GoogleAuthProvider.getCredential(account.getIdToken(), null);
        firebaseAuth.signInWithCredential(credential)
                .addOnCompleteListener(this, new OnCompleteListener<AuthResult>() {
                    @Override
                    public void onComplete(@NonNull Task<AuthResult> task) {
                        if (task.isSuccessful()) {
                            // Sign in success, update UI with the signed-in user's information
                            FirebaseUser user = firebaseAuth.getCurrentUser();
                            Log.d(TAG, "signInWithCredential:success: currentUser: " + user.getEmail());
                            String email = user.getEmail();
                            String name = user.getDisplayName();
                            String profile = String.valueOf(user.getPhotoUrl());
                            String uid = user.getUid();
                            check_user(uid, name, email, profile,"0");
                        } else {
                            // If sign in fails, display a message to the user.
                            Log.w(TAG, "signInWithCredential:failure", task.getException());
                            ShowToast(Activity_Login.this, "signInWithCredential:failure" + task.getException(), true);

                        }
                    }
                });
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