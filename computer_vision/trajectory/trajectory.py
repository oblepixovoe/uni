import numpy as np
import matplotlib.pyplot as plt
from skimage.measure import label, regionprops


frst = []
scnd = []
for i in range(99):
    f = np.load("out/" + f"h_{i + 1}.npy")
    labeled = label(f)
    regions = regionprops(labeled)
    if len(regions) == 2:
        regions.sort(key=lambda x: x.area, reverse=True)
        sorted_fig = regions
        frst.append(regions[0].centroid)
        scnd.append(regions[1].centroid)

frst = np.array(frst)
scnd = np.array(scnd)

plt.plot(frst[:, 1], frst[:, 0])
plt.plot(scnd[:, 1], scnd[:, 0])

plt.show()
