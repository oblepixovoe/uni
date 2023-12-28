package com.example.colortilesgame

import android.annotation.SuppressLint
import android.content.Context
import android.graphics.Canvas
import android.graphics.Color
import android.graphics.Paint
import android.view.MotionEvent
import android.view.View
import android.widget.Toast
import com.google.android.material.snackbar.Snackbar

class GameActivity(context: Context?) : View(context) {
    private val paintTiles = Paint()
    private var weightTiles = 0
    private var heightTiles = 0
    private var sizeRect = 4
    private var oneSide = 0
    private var twoSide = 0
    private val gamePad = 20
    private val untilPad = 2
    private val tilesCount = 2
    private var tilesPad = 3
    private var coordinateY = 0f
    private var coordinateX = 0f
    private var tiles = Array(tilesCount) {BooleanArray(tilesCount) {false} }

    @SuppressLint("ClickableViewAccessibility")
    override fun onTouchEvent(event: MotionEvent?): Boolean {
        coordinateX = (event?.x ?: 0) as Float
        coordinateY = (event?.y ?: 0) as Float
        changeTiles(tilesSize(coordinateY, coordinateX))
        return false
    }

    private fun colorTiles(canvas: Canvas?, p: Paint) {
        canvas?.apply {
            for (i in tiles.indices) {
                for (j in tiles[i].indices) {
                    if (tiles[i][j]) {
                        p.color = Color.parseColor("#fa9a00")
                    } else {
                        p.color = Color.parseColor("#0099cc")
                    }
                    drawRect(
                        gamePad + i * sizeRect.toFloat() + untilPad * i,
                        tilesPad + j * sizeRect.toFloat() + untilPad * j,
                        gamePad + (i + 1) * sizeRect.toFloat() + untilPad * i,
                        tilesPad + (j + 1) * sizeRect.toFloat() + untilPad * j, p)
                }
            }
        }
    }
    private fun tilesSize(Y: Float, X: Float) :Pair<Int, Int> {
        for (i in 0 until tilesCount) {
            for (j in 0 until tilesCount) {
                val left = gamePad + i * sizeRect.toFloat() + untilPad * i
                val top = tilesPad + j * sizeRect.toFloat() + untilPad * j
                val right = gamePad + (i + 1) * sizeRect.toFloat() + untilPad * i
                val bottom = tilesPad + (j + 1) * sizeRect.toFloat() + untilPad * j

                if (X in left..right && top <= Y && Y <= bottom) {
                    return Pair(i, j)
                }
            }
        }
        return Pair(-1, -1)
    }
    override fun onLayout(changed: Boolean, left: Int, top: Int, right: Int, bottom: Int) {
        super.onLayout(changed, left, top, right, bottom)
        weightTiles = right - left
        heightTiles = bottom - top
        oneSide = if (weightTiles < heightTiles) weightTiles else heightTiles
        twoSide = if (weightTiles > heightTiles) weightTiles else heightTiles
        sizeRect = (oneSide - gamePad *2 -  untilPad * (tilesCount - 1)) / tilesCount
        tilesPad = (twoSide - untilPad * (tilesCount - 1) - sizeRect * tilesCount) / 2
        for (i in 0 until tilesCount) {
            (0 until tilesCount).forEach { _ ->
            }
        }
    }
    private fun changeTiles(tile :Pair<Int, Int>) {
        if (tile.first == -1 || tile.second == -1)
            return
        for (i in 0 until tilesCount) {
            tiles[tile.first][i] = !tiles[tile.first][i]
            tiles[i][tile.second] = !tiles[i][tile.second]
        }
        tiles[tile.first][tile.second] = !tiles[tile.first][tile.second]
        invalidate()
    }

    override fun onDraw(canvas: Canvas) {
        paintTiles.color = Color.parseColor("#fa9a00")
        canvas?.apply {
            drawColor(Color.parseColor("#c499b8"))
        }
        colorTiles(canvas, paintTiles)

        if (checkVictory(this)) {
            val toast = Toast.makeText(context, "toasted notice win", Toast.LENGTH_LONG)
            toast.show() }
    }

    companion object {
        private fun checkVictory(gameActivity: GameActivity) : Boolean{
            val flag1 = gameActivity.tiles[0][0]
            for (i in gameActivity.tiles.indices) {
                for (j in gameActivity.tiles[i].indices) {
                    if (gameActivity.tiles[i][j] != flag1) {
                        return false
                    }
                }
            }
            return true
        }
    }
}
