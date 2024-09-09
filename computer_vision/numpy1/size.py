def nominal(image, size):
    px = []
    for i in image:
        if 1 in i:
            px.append(i)
    if (len(px)) != 0:
        res = size / len(px)
    else:
        return 0
    return res


for i in range(1, 6):
    f = open(f"figure{i}.txt")
    size = float(f.readline())
    f.readline()
    image = []
    for line in f:
        image.append([int(x) for x in line.split()])
    print(nominal(image, size))
