package com.earncash.rewardsapp.csm.model;

public class GameModel {
    String title,image,game,screen,category;
    int time,coins,plays,id;

    public GameModel(String title, String image, String game, String screen, String category, int time, int coins, int plays, int id) {
        this.title = title;
        this.image = image;
        this.game = game;
        this.screen = screen;
        this.category = category;
        this.time = time;
        this.coins = coins;
        this.plays = plays;
        this.id = id;
    }

    public String getTitle() {
        return title;
    }

    public String getImage() {
        return image;
    }

    public String getGame() {
        return game;
    }

    public String getScreen() {
        return screen;
    }

    public String getCategory() {
        return category;
    }

    public int getTime() {
        return time;
    }

    public int getCoins() {
        return coins;
    }

    public int getPlays() {
        return plays;
    }

    public int getId() {
        return id;
    }
}
