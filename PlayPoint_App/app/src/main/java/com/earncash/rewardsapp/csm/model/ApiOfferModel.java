package com.earncash.rewardsapp.csm.model;

public class ApiOfferModel {
    String id,title,steps,requirements,desc,click_url,icon,coins,cats,time,events;

    public ApiOfferModel(String id,String title, String steps, String requirements, String desc, String click_url, String icon, String coins, String cats, String time,String events) {
        this.id = id;
        this.title = title;
        this.steps = steps;
        this.requirements = requirements;
        this.desc = desc;
        this.click_url = click_url;
        this.icon = icon;
        this.coins = coins;
        this.cats = cats;
        this.time = time;
        this.events = events;
    }

    public String getEvents() {
        return events;
    }

    public String getTime() {
        return time;
    }

    public String getId() {
        return id;
    }

    public String getSteps() {
        return steps;
    }

    public String getRequirements() {
        return requirements;
    }

    public String getDesc() {
        return desc;
    }

    public String getClick_url() {
        return click_url;
    }

    public String getIcon() {
        return icon;
    }

    public String getCoins() {
        return coins;
    }

    public String getCats() {
        return cats;
    }

    public String getTitle() {
        return title;
    }
}

