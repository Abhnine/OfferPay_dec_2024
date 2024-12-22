package com.earncash.rewardsapp;

import static com.earncash.rewardsapp.helper.AppController.TAG;
import static com.earncash.rewardsapp.helper.AppController.hidepDialog;
import static com.earncash.rewardsapp.helper.AppController.initpDialog;
import static com.earncash.rewardsapp.helper.AppController.showpDialog;
import static com.earncash.rewardsapp.helper.PrefManager.ShowToast;
import static com.earncash.rewardsapp.helper.PrefManager.isValidEmail;
import static com.earncash.rewardsapp.helper.PrefManager.setWindowFlag;

import androidx.annotation.NonNull;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.content.ContextCompat;

import android.graphics.Color;
import android.os.Build;
import android.os.Bundle;
import android.text.TextUtils;
import android.util.Log;
import android.view.View;
import android.view.WindowManager;
import android.widget.Button;
import android.widget.EditText;
import android.widget.LinearLayout;
import android.widget.Toast;

import com.google.android.gms.auth.api.signin.GoogleSignIn;
import com.google.android.gms.auth.api.signin.GoogleSignInClient;
import com.google.android.gms.auth.api.signin.GoogleSignInOptions;
import com.google.android.gms.tasks.OnCompleteListener;
import com.google.android.gms.tasks.Task;
import com.google.firebase.auth.FirebaseAuth;

public class ForgotPass extends AppCompatActivity {

    Button reset;
    EditText edEmail;
    GoogleSignInClient googleSignInClient;
    private FirebaseAuth firebaseAuth;
    LinearLayout sign;

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
        setContentView(R.layout.activity_forgot_pass);
        initpDialog(this);

        reset = findViewById(R.id.reset);
        edEmail = findViewById(R.id.edEmail);
        sign = findViewById(R.id.sign);
        configureGoogleClient();
        reset.setOnClickListener(v -> {
            if (TextUtils.isEmpty(edEmail.getText().toString().trim())) {
                edEmail.setError("Enter email!");

            } else {
                if (!isValidEmail(edEmail.getText().toString())) {
                    edEmail.setError("Invalid email!");
                }
            }

            if (!TextUtils.isEmpty(edEmail.getText().toString().trim()) && isValidEmail(edEmail.getText().toString())) {
                loginWithEmail(edEmail.getText().toString().trim());

            }

        });
        sign.setOnClickListener(v -> {
            finish();
        });


    }

    private void loginWithEmail(String email) {
        showpDialog();
        firebaseAuth.sendPasswordResetEmail(email).addOnCompleteListener(new OnCompleteListener<Void>() {
            @Override
            public void onComplete(@NonNull Task<Void> task) {
                if (task.isSuccessful()) {
                    hidepDialog();
                    Toast.makeText(ForgotPass.this, "Email successfully send to " + email, Toast.LENGTH_SHORT).show();
                    finish();
                }else {
                    // If sign in fails, display a message to the user.
                    Log.w(TAG, "signInWithCredential:failure", task.getException());
                    ShowToast(ForgotPass.this, "" + task.getException().getMessage(),true);
                    hidepDialog();

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