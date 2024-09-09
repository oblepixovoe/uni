def offset(image):
    f = open(image, "r")
    lines = f.readlines()[2:]
    image = []
    for line in lines:
        image.append(list(map(int, line.split())))
    for y in range(0, len(image)):
        for x in range(0, len(image[y])):
            if image[y][x] == 1:
                return x, y


x1, y1 = offset("img1.txt")
x, y = offset("img2.txt")
print("Смещение по y:", y - y1, "Смещение по x:", x - x1)
