package com.earncash.rewardsapp.csm;

import androidx.appcompat.app.AppCompatActivity;
import androidx.core.content.ContextCompat;

import android.content.Intent;
import android.content.pm.ActivityInfo;
import android.net.Uri;
import android.os.Bundle;
import android.view.View;
import android.view.Window;
import android.view.WindowManager;
import android.webkit.WebView;
import android.webkit.WebViewClient;
import android.widget.ImageView;

import com.earncash.rewardsapp.R;
import com.earncash.rewardsapp.helper.AppController;

public class CpaLeadActivity extends AppCompatActivity {

    WebView offerwall;
    ImageView back;
    String urll;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        Window window = this.getWindow();
        window.clearFlags(WindowManager.LayoutParams.FLAG_TRANSLUCENT_STATUS);
        window.addFlags(WindowManager.LayoutParams.FLAG_DRAWS_SYSTEM_BAR_BACKGROUNDS);
        window.setStatusBarColor(ContextCompat.getColor(this, R.color.color_header_2nd));
        getWindow().setNavigationBarColor(ContextCompat.getColor(this, R.color.color_header_2nd));
        setRequestedOrientation(ActivityInfo.SCREEN_ORIENTATION_PORTRAIT);//Set Portrait
        setContentView(R.layout.activity_cpa_lead);
        offerwall = findViewById(R.id.offerwall);
        back = findViewById(R.id.back);
        back.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                finish();
            }
        });
        if (getIntent().getIntExtra("type",0)==0){
            urll =getIntent().getStringExtra("url")+"&subid="+ AppController.getInstance().getUuid();
        }else {
            urll ="https://api.adgem.com/v1/wall?appid="+getIntent().getStringExtra("url")+"&playerid="+ AppController.getInstance().getUuid();
        }

        offerwall.setWebViewClient(new MyBrowser());
        offerwall.getSettings().setLoadsImagesAutomatically(true);
        offerwall.getSettings().setJavaScriptEnabled(true);
        offerwall.setScrollBarStyle(View.SCROLLBARS_INSIDE_OVERLAY);
        offerwall.loadUrl(urll);

    }


    private class MyBrowser extends WebViewClient {
        @Override
        public boolean shouldOverrideUrlLoading(WebView view, String url) {
            if (url.equals(urll)) {
                view.loadUrl(url);
            }else
            {
                Uri uri = Uri.parse(url);
                Intent intent = new Intent(Intent.ACTION_VIEW, uri);
                startActivity(intent);
            }

            return true;
        }
    }
}