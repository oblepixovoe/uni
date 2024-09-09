import matplotlib.pyplot as plt
import numpy as np
from skimage.measure import label


image = np.load('ps.npy.txt')

labeled = label(image)
labels, figures = np.unique(labeled, return_counts=True)

variants, counts = np.unique(figures[1:], return_counts=True)
variant_count_dict = dict(zip(variants, counts))
for i, (value, count) in enumerate(variant_count_dict.items(), 1):
    print(f"Объект {i} встречается {count} раз")

print("Общее количество объектов: ", labels[-1])
plt.imshow(image)
plt.show()