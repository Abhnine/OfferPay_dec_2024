package com.earncash.rewardsapp.csm.luckywheel.model;

public class LuckyItem {
    public String secondaryText;
    public int icon;
    public int color;
    public int[] chance;
    public int price;
    public int bColor;
    public int textColor;

    public LuckyItem(String secondaryText, int icon, int color, int[] chance, int price,int bColor,int textColor) {
        this.secondaryText = secondaryText;
        this.icon = icon;
        this.color = color;
        this.chance = chance;
        this.price = price;
        this.bColor = bColor;
        this.textColor = textColor;
    }
}
