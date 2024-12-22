package com.earncash.rewardsapp.helper;

import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.os.AsyncTask;
import android.util.Log;
import android.view.View;
import android.widget.ImageView;
import android.widget.LinearLayout;

import java.io.InputStream;

public class DownloadImage extends AsyncTask<String, Void, Bitmap> {
    ImageView bmImage;
    LinearLayout btn_save,image_loading;

    public DownloadImage(ImageView bmImage, LinearLayout btn_save,LinearLayout image_loading) {
        this.bmImage = bmImage;
        this.btn_save = btn_save;
        this.image_loading = image_loading;
    }

    protected Bitmap doInBackground(String... urls) {
        String urldisplay = urls[0];
        Bitmap mIcon11 = null;
        try {
            InputStream in = new java.net.URL(urldisplay).openStream();
            mIcon11 = BitmapFactory.decodeStream(in);
        } catch (Exception e) {
            Log.e("Error", e.getMessage());
            e.printStackTrace();
        }
        return mIcon11;
    }

    protected void onPostExecute(Bitmap result) {
        bmImage.setImageBitmap(result);
        image_loading.setVisibility(View.GONE);
        btn_save.setClickable(true);

    }
}
