package com.earncash.rewardsapp.csm.model;

public class VisitModel {
    String id,title,link,coins,time;
    Boolean status;

    public Boolean getStatus() {
        return status;
    }

    public VisitModel(String id, String title, String link, String coins, String time, Boolean status) {
        this.id = id;
        this.title = title;
        this.link = link;
        this.coins = coins;
        this.time = time;
        this.status = status;
    }

    public String getId() {
        return id;
    }

    public String getTitle() {
        return title;
    }

    public String getLink() {
        return link;
    }

    public String getCoins() {
        return coins;
    }

    public String getTime() {
        return time;
    }
}
