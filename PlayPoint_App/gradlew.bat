package com.onechampion.fantasy_quiz.activity;


import android.content.Intent;
import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.view.View;
import android.widget.Button;
import android.widget.ProgressBar;
import android.widget.TextView;
import android.widget.Toast;

import com.android.volley.Request;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.onechampion.R;
import com.onechampion.fantasy_quiz.activity.fragment.adapter_or_model.QuestionItem;
import com.onechampion.helper.AppController;
import com.onechampion.helper.JsonRequest;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

import static com.onechampion.helper.AppController.hidepDialog;
import static com.onechampion.helper.AppController.showpDialog;
import static com.onechampion.helper.Constatnt.ACCESS_KEY;
import static com.onechampion.helper.Constatnt.ACCESS_Value;
import static com.onechampion.helper.Constatnt.API;
import static com.onechampion.helper.Constatnt.CRICKET_QUIZ_API;

public class Quiz_Play_Activity extends AppCompatActivity {

    TextView tv_question,question_no;
    Button bt_anwser1,bt_anwser2,bt_next;

    List<QuestionItem> questionItems;
    int currentQuestion = 0;
    String id;
    String  get_id,get_answer;
    ProgressBar progresBar;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_quiz__play_);
        Intent intent = getIntent();
        Bundle bundle = intent.getExtras();
        if(bundle != null){
            id = bundle.getString("tbl_team_id");

        }
        tv_question = findViewById(R.id.question);
        question_no = findViewById(R.id.question_no);
        bt_anwser1 = findViewById(R.id.answer1);
        bt_anwser2 = findViewById(R.id.answer2);
        progresBar = findViewById(R.id.progressBar);

        bt_next = findViewById(R.id.next);
        get_data();

        bt_anwser1.setOnClickListener(new View.OnClickListener() {
            