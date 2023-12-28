package com.example.guessthenumber

import android.content.Intent
import androidx.appcompat.app.AppCompatActivity
import android.os.Bundle
import android.view.View
import android.widget.EditText

class MainActivity : AppCompatActivity() {
    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_main)
    }
    fun onGuessClick(view: View) {

        val intent = Intent(this, GameActivity::class.java)
        intent.putExtra("begin",findViewById<EditText>(R.id.begin).text)
        intent.putExtra("end",findViewById<EditText>(R.id.end).text)
        startActivity(intent)

    }
}