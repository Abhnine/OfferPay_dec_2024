package com.earncash.rewardsapp.csm.activity;

import static com.earncash.rewardsapp.helper.AppController.hidepDialog;
import static com.earncash.rewardsapp.helper.AppController.initpDialog;
import static com.earncash.rewardsapp.helper.AppController.isConnected;
import static com.earncash.rewardsapp.helper.AppController.showpDialog;
import static com.earncash.rewardsapp.helper.Constatnt.DELETE;
import static com.earncash.rewardsapp.helper.Constatnt.ID;
import static com.earncash.rewardsapp.helper.Constatnt.UPDATE_P;
import static com.earncash.rewardsapp.helper.Constatnt.UP_PRO;
import static com.earncash.rewardsapp.helper.PrefManager.setWindowFlag;

import androidx.activity.result.ActivityResult;
import androidx.activity.result.ActivityResultCallback;
import androidx.activity.result.ActivityResultLauncher;
import androidx.activity.result.contract.ActivityResultContracts;
import androidx.appcompat.app.AlertDialog;
import androidx.appcompat.app.AppCompatActivity;

import android.app.Activity;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.pm.ActivityInfo;
import android.graphics.Bitmap;
import android.graphics.Color;
import android.net.Uri;
import android.os.Build;
import android.os.Bundle;
import android.provider.MediaStore;
import android.util.Base64;
import android.view.View;
import android.view.WindowManager;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.Toast;

import com.android.volley.Request;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.bumptech.glide.Glide;
import com.bumptech.glide.request.RequestOptions;
import com.earncash.rewardsapp.Activity_Login;
import com.earncash.rewardsapp.R;
import com.earncash.rewardsapp.helper.AppController;
import com.earncash.rewardsapp.helper.JsonRequest;
import com.makeramen.roundedimageview.RoundedImageView;

import org.json.JSONException;
import org.json.JSONObject;
import org.w3c.dom.Text;

import java.io.ByteArrayOutputStream;
import java.io.IOException;
import java.util.HashMap;
import java.util.Map;

public class Profile extends AppCompatActivity {

    EditText ed_name, ed_username, ed_email;
    LinearLayout update, delete;
    Text a;
    RoundedImageView logo;
    Bitmap bitmap = null;
    String image = null;
    ImageView back;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        getWindow().addFlags(WindowManager.LayoutParams.FLAG_KEEP_SCREEN_ON);
        setRequestedOrientation(ActivityInfo.SCREEN_ORIENTATION_PORTRAIT);//Set Portrait
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
        setContentView(R.layout.activity_profile);
        initpDialog(this);

        ActivityResultLauncher<Intent> activityResultLauncher =
                registerForActivityResult(new ActivityResultContracts.StartActivityForResult(), new ActivityResultCallback<ActivityResult>() {
                    @Override
                    public void onActivityResult(ActivityResult result) {
                        if (result.getResultCode() == Activity.RESULT_OK) {
                            Intent data = result.getData();
                            Uri uri = data.getData();
                            logo.setImageURI(uri);
                            try {
                                bitmap = MediaStore.Images.Media.getBitmap(getContentResolver(), uri);
                                if (bitmap != null) {
                                    image = base64(bitmap);
                                    update_profile_image();
                                }
                            } catch (IOException e) {
                                e.printStackTrace();
                            }
                        }

                    }
                });

        ed_name = findViewById(R.id.ed_name);
        ed_username = findViewById(R.id.ed_username);
        ed_email = findViewById(R.id.ed_email);
        update = findViewById(R.id.update);
        logo = findViewById(R.id.logo);
        back = findViewById(R.id.back);
        delete = findViewById(R.id.delete);
        ed_name.setText(AppController.getInstance().getName());
        ed_email.setText(AppController.getInstance().getEmail());
        ed_username.setText(AppController.getInstance().getEmail().split("@")[0]);
        back.setOnClickListener(v -> {
            finish();
        });
        initpDialog(this);
        Glide.with(this).load(AppController.getInstance().getProfile())
                .apply(new RequestOptions().placeholder(R.drawable.logoo))
                .into(logo);
        update.setOnClickListener(v -> {
            String name = ed_name.getText().toString().trim();
            if (!name.equals(AppController.getInstance().getName())) {
                if (!name.startsWith(" ") && name.length() >= 5) {
                    update_(name);
                } else {
                    ed_name.setError("Invalid name!!");
                }
            }


        });


        logo.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent intent = new Intent(Intent.ACTION_PICK);
                intent.setData(MediaStore.Images.Media.EXTERNAL_CONTENT_URI);
                activityResultLauncher.launch(intent);
            }
        });


        delete.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                AlertDialog.Builder builder = new AlertDialog.Builder(Profile.this, R.style.MyDialogTheme);
                builder.setTitle("ARE YOU SURE?");
                builder.setMessage("Do you want to delete your account? This action cannot undone. All data will be permanently delete.");
                builder.setCancelable(false);

                builder.setPositiveButton("YES", (DialogInterface.OnClickListener) (dialog, which) -> {
                    // calling delete api
                    Delete();
                }).setNegativeButton("NO", new DialogInterface.OnClickListener() {
                    @Override
                    public void onClick(DialogInterface dialog, int which) {
                        dialog.dismiss();
                    }
                });

                AlertDialog alertDialog = builder.create();
                alertDialog.show();
                alertDialog.setCancelable(false);
            }
        });


    }

    private void Delete() {
        showpDialog();
        if (isConnected(this)) {
            JsonRequest jsonReq = new JsonRequest(Request.Method.POST, DELETE, null,
                    new Response.Listener<JSONObject>() {
                        @Override
                        public void onResponse(JSONObject response) {
                            hidepDialog();
                            try {
                                if (response.getString("error").equalsIgnoreCase("false")) {
                                    AppController.getInstance().removeData();
                                    AppController.getInstance().setApi_token("0");
                                    AppController.getInstance().readData();
                                    Toast.makeText(Profile.this, "Account Deleted Successfully..!!", Toast.LENGTH_SHORT).show();
                                    Intent i = new Intent(Profile.this, Activity_Login.class);
                                    i.addFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
                                    i.addFlags(Intent.FLAG_ACTIVITY_NEW_TASK);
                                    i.addFlags(Intent.FLAG_ACTIVITY_CLEAR_TASK);
                                    startActivity(i);
                                } else if (response.getString("error").equalsIgnoreCase("true")) {
                                }
                            } catch (JSONException e) {
                                hidepDialog();
                                e.printStackTrace();
                                Toast.makeText(Profile.this, e.getMessage(), Toast.LENGTH_SHORT).show();
                            }
                        }
                    }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    //Log.println(10)
                    Toast.makeText(Profile.this, "Er-  " + error.getMessage(), Toast.LENGTH_LONG).show();
                    hidepDialog();
                }
            }) {

                @Override
                protected Map<String, String> getParams() {
                    Map<String, String> params = new HashMap<String, String>();
                    params.put(ID, AppController.getInstance().getApi_token());
                    return params;
                }
            };
            AppController.getInstance().getRequestQueue().getCache().clear();
            AppController.getInstance().addToRequestQueue(jsonReq);
        }
    }

    private void update_(String name) {
        showpDialog();
        if (isConnected(this)) {
            JsonRequest jsonReq = new JsonRequest(Request.Method.POST, UPDATE_P, null,
                    new Response.Listener<JSONObject>() {
                        @Override
                        public void onResponse(JSONObject response) {
                            hidepDialog();
                            try {
                                if (response.getString("error").equalsIgnoreCase("false")) {
                                    Toast.makeText(Profile.this, "Profile updated successfully!", Toast.LENGTH_SHORT).show();
                                } else if (response.getString("error").equalsIgnoreCase("true")) {
                                }
                            } catch (JSONException e) {
                                hidepDialog();
                                e.printStackTrace();
                                Toast.makeText(Profile.this, e.getMessage(), Toast.LENGTH_SHORT).show();
                            }
                        }
                    }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    //Log.println(10)
                    Toast.makeText(Profile.this, "Er-  " + error.getMessage(), Toast.LENGTH_LONG).show();
                    hidepDialog();
                }
            }) {

                @Override
                protected Map<String, String> getParams() {
                    Map<String, String> params = new HashMap<String, String>();
                    params.put(ID, AppController.getInstance().getApi_token());
                    params.put("name", name);
                    return params;
                }
            };
            AppController.getInstance().getRequestQueue().getCache().clear();
            AppController.getInstance().addToRequestQueue(jsonReq);
        }
    }

    @Override
    protected void onResume() {
        AppController.OnResume();
        super.onResume();
    }

    private String base64(Bitmap bitmap) {
        if (bitmap != null) {
            ByteArrayOutputStream byteArrayOutputStream;
            byteArrayOutputStream = new ByteArrayOutputStream();
            bitmap.compress(Bitmap.CompressFormat.JPEG, 100, byteArrayOutputStream);
            byte[] bytes = byteArrayOutputStream.toByteArray();
            final String base64Image = Base64.encodeToString(bytes, Base64.DEFAULT);
            return base64Image;
        } else
            return null;
    }

    private void update_profile_image() {
        showpDialog();
        if (isConnected(Profile.this)) {
            JsonRequest jsonReq = new JsonRequest(Request.Method.POST, UP_PRO, null,
                    new Response.Listener<JSONObject>() {
                        @Override
                        public void onResponse(JSONObject response) {
                            //Toast.makeText(Activity_Login.this,response.toString(),Toast.LENGTH_LONG).show();
                            try {
                                if (response.getString("error").equalsIgnoreCase("false")) {
                                    hidepDialog();
                                    Toast.makeText(Profile.this, "Profile image updated!", Toast.LENGTH_LONG).show();
                                    //Toast.makeText(IdCardActivity.this, "done", Toast.LENGTH_SHORT).show();
                                } else if (response.getString("error").equalsIgnoreCase("true")) {
                                    hidepDialog();

                                }

                            } catch (JSONException e) {
                                e.printStackTrace();
                                Toast.makeText(getApplicationContext(), "Error -> " + e.toString(), Toast.LENGTH_LONG).show();
                                hidepDialog();
                            }
                        }
                    }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    Toast.makeText(getApplicationContext(), getText(R.string.error_data_loading), Toast.LENGTH_LONG).show();
                    hidepDialog();
                }
            }) {
                @Override
                protected Map<String, String> getParams() {
                    Map<String, String> params = new HashMap<String, String>();
                    params.put(ID, AppController.getInstance().getApi_token());
                    params.put("img", image);
                    return params;
                }
            };
            AppController.getInstance().addToRequestQueue(jsonReq);
        }
    }
}