import numpy as np
import matplotlib.pyplot as plt
from skimage.measure import label, regionprops
from skimage import color


image = plt.imread(r"balls_and_rects.png")

hsv = color.rgb2hsv(image)
binary = hsv[:,:,0].copy()
binary[binary > 0] = 1

labeled = label(binary)
regions = regionprops(labeled)

colors = []
balls = []
rect = []


for reg in regions:
    cy, cx = reg.centroid
    colors.append(hsv[int(cy), int(cx), 0])
colors = sorted(colors)

for reg in regions:
    cy, cx = reg.centroid
    if reg.area == (reg.image.shape[0] * reg.image.shape[1]):
        rect.append(reg)
    else:
        balls.append(reg)

def colorss(colors):
    groups = [[colors[0]],]
    delta = np.mean(np.diff(colors))
    for i in range(1, len(colors)):
        previous = colors[i-1]
        current = colors[i]
        if current - previous > delta:
            groups.append([])
        groups[-1].append(current)
    return groups

cballs = []
crectan = []
for reg in regions:
    cy, cx = reg.centroid
    col = hsv[int(cy), int(cx)][0]
    if reg in balls:
        cballs.append(col)
    else:
        crectan.append(col)

result_c = {}
result_r = {}

for grp in colorss(sorted(cballs)):
    result_c[len(grp)] = [np.mean(grp)]
for grp in colorss(sorted(crectan)):
    result_r[len(grp)] = [np.mean(grp)]

a_R = [*result_r.keys()]
b_R = [*result_r.values()]

a_C = [*result_c.keys()]
b_C = [*result_c.values()]

print('Всего объектов:', labeled.max())
print('Круги:', len(balls))
print('По цветам:', *a_C, *b_C)
print('Прямоугольники:', len(rect))
print('По цветам:', *a_R,*b_R)

plt.imshow(labeled)
plt.show()