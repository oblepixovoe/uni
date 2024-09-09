import matplotlib.pyplot as plt
import numpy as np
from skimage.measure import label, regionprops


image = plt.imread(r"symbols.png")
image = image.mean(2)
image = image > 0
labeled = label(image)
print(np.max(labeled))

def hasvline(arr):
  return 1. in arr.mean(0)

def recognize(prop):
  euler_number = prop.euler_number
  if euler_number == -1: #2 holes - 8 or B
    if hasvline(prop.image):
      return "B"
    else:
      return "8"
  elif euler_number == 0: # 1 hole - A or 0 or P or D
    if prop.image.mean(0)[0] == 1.0:
      if prop.eccentricity < 0.6:
        return "D"
      if prop.eccentricity > 0.6:
        return "P"

    if 1 in prop.image.mean(1):
      return "*"

    tmp = prop.image.copy()
    tmp[-1, :] = 1.0
    tmp_regions = regionprops(label(tmp))
    if tmp_regions[0].euler_number == -1.0:
      return "A"

    return "0"
  else: # no holes -  1 W X * - /
    if prop.image.mean() == 1.0:
      return "-"
    else: # 1 W X * /
      if hasvline(prop.image) and hasvline(prop.image.T):
        return "1"
      else:
        tmp = prop.image.copy()
        tmp[:, [0, -1]] = 1
        tmp[[0, -1], :] = 1
        tmp_labeled = label(tmp)
        tmp_props = regionprops(tmp_labeled)
        tmp_euler = tmp_props[0].euler_number
        if tmp_euler == -3:
          return "X"
        elif tmp_euler == -1:
          return "/"
        else:
          if prop.eccentricity > 0.5:
            return "W"
          else:
            return "*"
  return "_"

props = regionprops(labeled)
result = {}
for prop in props:
  symbol = recognize(prop)
  if symbol not in result:
    result[symbol] = 0
  result[symbol] += 1
print(result)
print((1 - result.get("_", 0) / np.max(labeled)) * 100)

plt.imshow(labeled)
plt.show()