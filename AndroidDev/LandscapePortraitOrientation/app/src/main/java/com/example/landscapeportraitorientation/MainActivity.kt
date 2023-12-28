package com.example.landscapeportraitorientation

import androidx.appcompat.app.AppCompatActivity
import android.os.Bundle
import android.view.View
import android.widget.AdapterView
import android.widget.ArrayAdapter
import android.widget.ImageView
import android.widget.Spinner
import android.widget.Toast

class MainActivity : AppCompatActivity(),AdapterView.OnItemSelectedListener {
    lateinit var adapter: ArrayAdapter<CharSequence>
    private lateinit var pics: IntArray
    private var currPic = 0

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_main)


        pics = intArrayOf(R.drawable.car1, R.drawable.car2, R.drawable.car3)


        adapter = ArrayAdapter.createFromResource(this, R.array.pictures, R.layout.item)
        val spinner = findViewById<Spinner>(R.id.pictures_list)
        spinner.adapter = adapter
        spinner.onItemSelectedListener = this
    }

    fun onChangePictureClick() {
        val iv = findViewById<ImageView>(R.id.picture)
        currPic = (currPic + 1) % 3
        iv.setImageResource(pics[currPic])

    }

    override fun onItemSelected(parent: AdapterView<*>?, view: View?, position: Int, id: Long) {
        Toast.makeText(this, "Выбран элемент: $position", Toast.LENGTH_SHORT).show()
        val iv = findViewById<ImageView>(R.id.picture)
        iv.setImageResource(pics[position])
        currPic = position
    }

    override fun onNothingSelected(parent: AdapterView<*>?) {
        Toast.makeText(this, "Элемент не выбран", Toast.LENGTH_SHORT).show()
        val iv = findViewById<ImageView>(R.id.picture)
        iv.setImageResource(R.drawable.squarecat)
    }
}