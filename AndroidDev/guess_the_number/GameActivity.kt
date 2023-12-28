package com.example.guessthenumber

import androidx.appcompat.app.AppCompatActivity
import android.os.Bundle
import android.util.Log
import android.view.TextureView
import android.view.View
import android.widget.TextView

class GameActivity : AppCompatActivity() {
    var begin: Int = 0
    var end: Int = 100
    var mean:Int = 0
    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_game)
        begin = intent.getIntExtra("begin", 0)
        end = intent.getIntExtra("end", 100)
        Log.d("mytag", "begin = " + begin)
        Log.d("mytag", "end = " + end)

        mean = (begin + end) / 2
        "Is your number less to $mean?".also { findViewById<TextView>(R.id.question).text = it }
    }

    fun onYesNoClick(view: View) {
        when (view.id) {
            R.id.yes -> {
                end = mean
                mean = (end + begin) / 2
                findViewById<TextView>(R.id.question).text = "Is your number less to $mean?"
            }
            R.id.no -> {
                begin = mean
                mean = (end + mean) / 2
                findViewById<TextView>(R.id.question).text = "Is your number less to $mean?"
            }
        }
        if (end - 1 == begin) {
            findViewById<TextView>(R.id.question).text = "Your number is $begin"
        }

    }


}