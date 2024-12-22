package com.earncash.rewardsapp.csm.model;

public class UserRewardHistoryModel {
    String image,package_name,coins_used,symbol,amount,date,status;

    public UserRewardHistoryModel(String image, String package_name, String coins_used, String symbol, String amount, String date, String status) {
        this.image = image;
        this.package_name = package_name;
        this.coins_used = coins_used;
        this.symbol = symbol;
        this.amount = amount;
        this.date = date;
        this.status = status;
    }

    public String getImage() {
        return image;
    }

    public String getPackage_name() {
        return package_name;
    }

    public String getCoins_used() {
        return coins_used;
    }

    public String getSymbol() {
        return symbol;
    }

    public String getAmount() {
        return amount;
    }

    public String getDate() {
        return date;
    }

    public String getStatus() {
        return status;
    }
}
