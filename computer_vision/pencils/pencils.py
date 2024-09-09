import numpy as np
import matplotlib.pyplot as plt
from skimage.measure import label, regionprops
from skimage.morphology import binary_closing

images = 12

pencils = []

for i in range(1, images + 1):
    pen = 0
    image = plt.imread(f"images/img ({i}).jpg")

    binary = np.mean(image, 2)
    binary[binary > 128] = 0
    binary[binary != 0] = 1

    closed = binary_closing(binary)
    labeled = label(closed)

    regions = regionprops(labeled)

    min_object_area = 200000

    for region in regions:
        if region.area > min_object_area:
            if round(region.eccentricity, 2) == 1.0:
                pencils.append(region)
                pen += 1
    print(f"В картинке № {i}: {pen} карандаша")

print(f"Всего карандашей: {len(pencils)}")