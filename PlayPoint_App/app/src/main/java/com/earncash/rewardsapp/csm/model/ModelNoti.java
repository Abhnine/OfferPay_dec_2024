package com.earncash.rewardsapp.csm.model;

public class ModelNoti {
    String id,title,sub,date;

    public ModelNoti(String id, String title, String sub, String date) {
        this.id = id;
        this.title = title;
        this.sub = sub;
        this.date = date;
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

    public String getDate() {
        return date;
    }
}
