package com.earncash.rewardsapp.csm.model;

public class ModelOfferReward {
    String name,coins;

    public ModelOfferReward(String name, String coins) {
        this.name = name;
        this.coins = coins;
    }

    public String getName() {
        return name;
    }

    public String getCoins() {
        return coins;
    }
}
