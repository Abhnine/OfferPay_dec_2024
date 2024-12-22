package com.earncash.rewardsapp.csm.model;

public class StepModel {
    String step,text;

    public StepModel(String step, String text) {
        this.step = step;
        this.text = text;
    }

    public String getStep() {
        return step;
    }

    public String getText() {
        return text;
    }
}
