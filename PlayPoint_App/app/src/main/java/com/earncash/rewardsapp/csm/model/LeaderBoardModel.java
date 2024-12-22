package com.earncash.rewardsapp.csm.model;

public class LeaderBoardModel {
    String name,coins,level,rank,profile;

    public LeaderBoardModel(String name, String coins, String level, String rank, String profile) {
        this.name = name;
        this.coins = coins;
        this.level = level;
        this.rank = rank;
        this.profile = profile;
    }

    public String getName() {
        return name;
    }

    public String getCoins() {
        return coins;
    }

    public String getLevel() {
        return level;
    }

    public String getRank() {
        return rank;
    }

    public String getProfile() {
        return profile;
    }
}
