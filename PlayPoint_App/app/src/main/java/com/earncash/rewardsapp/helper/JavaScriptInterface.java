package com.earncash.rewardsapp.helper;

import android.app.Activity;
import android.webkit.JavascriptInterface;
import android.webkit.WebView;

import androidx.viewpager2.widget.ViewPager2;

import com.earncash.rewardsapp.R;

public class JavaScriptInterface {
    private Activity activity;
    ViewPager2 viewPager;
    WebView webView;

    public JavaScriptInterface(Activity activity, ViewPager2 viewPager, WebView webView) {
        this.activity = activity;
        this.viewPager = viewPager;
        this.webView = webView;
        viewPager.setOffscreenPageLimit(5);

        viewPager.setUserInputEnabled(false);
    }

    @JavascriptInterface
    public void setPage(int page){
        if (page == 0 || page == 1 || page == 2 || page == 3 || page == 4){
            viewPager.setCurrentItem(page);
        }
    }
}
