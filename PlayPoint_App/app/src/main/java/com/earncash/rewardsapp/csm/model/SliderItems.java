package com.earncash.rewardsapp.csm.model;

public class SliderItems {
    String id,title,sub,image,url;

    public SliderItems(String id, String title, String sub, String image, String url) {
        this.id = id;
        this.title = title;
        this.sub = sub;
        this.image = image;
        this.url = url;
    }

    public String getId() {
        return id;
    }

    public String getTitle() {
        return title;
    }

    public String getSub() {
        return sub;
    }

    public String getImage() {
        return image;
    }

    public String getUrl() {
        return url;
    }
}
