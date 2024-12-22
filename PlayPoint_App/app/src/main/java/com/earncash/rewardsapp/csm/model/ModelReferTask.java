package com.earncash.rewardsapp.csm.model;

public class ModelReferTask {
    String id,title;
    int refers,coins,total_ref,status;

    public ModelReferTask(String id, String title, int refers, int coins, int total_ref, int status) {
        this.id = id;
        this.title = title;
        this.refers = refers;
        this.coins = coins;
        this.total_ref = total_ref;
        this.status = status;
    }

    public String getId() {
        return id;
    }

    public String getTitle() {
        return title;
    }

    public int getRefers() {
        return refers;
    }

    public int getCoins() {
        return coins;
    }

    public int getTotal_ref() {
        return total_ref;
    }

    public int getStatus() {
        return status;
    }
}
