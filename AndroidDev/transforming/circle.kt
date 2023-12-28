class Circle(var x: Int, var y: Int, var radius: Int) : Movable, Figure(0), Transforming {
    override fun move(dx: Int, dy: Int) {
        x += dx; y += dy
    }

    override fun area(): Float {
        return (Math.PI * radius * radius).toFloat()
    }

    override fun resize(zoom: Int) {
        radius *= zoom
    }

    override fun rotate(direction: RotateDirection, centX: Int, centY: Int) {
        val dx = x - centX
        val dy = y - centY
        val newDx = if (direction == RotateDirection.Clockwise) dy else -dy
        val newDy = if (direction == RotateDirection.Clockwise) -dx else dx

        x = centX + newDx
        y = centY + newDy
    }
}