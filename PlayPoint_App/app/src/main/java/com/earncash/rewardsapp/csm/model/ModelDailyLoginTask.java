package com.earncash.rewardsapp.csm.model;

public class ModelDailyLoginTask {
    String id,days,coins;
    int total_days;
    Boolean status;

    public Boolean getStatus() {
        return status;
    }

    public ModelDailyLoginTask(String id, String days, String coins, int total_days, Boolean status) {
        this.id = id;
        this.days = days;
        this.coins = coins;
        this.total_days = total_days;
        this.status = status;
    }

    public int getTotal_days() {
        return total_days;
    }

    public String getId() {
        return id;
    }

    public String getDays() {
        return days;
    }

    public String getCoins() {
        return coins;
    }


}
