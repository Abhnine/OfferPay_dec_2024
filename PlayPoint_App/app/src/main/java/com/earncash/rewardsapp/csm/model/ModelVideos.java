package com.earncash.rewardsapp.csm.model;

import org.json.JSONObject;

public class ModelVideos {
    String id,name,image,net_id;
    JSONObject ids;

    Boolean status;

    public String getNet_id() {
        return net_id;
    }

    public ModelVideos(String id, String name, String image, JSONObject ids, Boolean status, String net_id) {
        this.id = id;
        this.name = name;
        this.image = image;
        this.ids = ids;
        this.status = status;
        this.net_id = net_id;
    }

    public String getId() {
        return id;
    }

    public String getName() {
        return name;
    }

    public String getImage() {
        return image;
    }

    public JSONObject getIds() {
        return ids;
    }

    public Boolean getStatus() {
        return status;
    }
}
