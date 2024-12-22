package com.earncash.rewardsapp.csm.model;

public class TransItems {
    String from,date,amount;
    Integer type;

    public String getFrom() {
        return from;
    }

    public String getDate() {
        return date;
    }

    public String getAmount() {
        return amount;
    }

    public Integer getType() {
        return type;
    }

    public TransItems(String from, String date, String amount, Integer type) {
        this.from = from;
        this.date = date;
        this.amount = amount;
        this.type = type;
    }
}
