import cv2
import numpy as np


LOWER_BLUE = np.array([90,  60, 50],  dtype=np.uint8)
UPPER_BLUE = np.array([140,255,255], dtype=np.uint8)

def get_mask(hsv, lower, upper):
    return cv2.inRange(hsv, lower, upper)

def biggest_contour(mask):
    cnts, _ = cv2.findContours(mask, cv2.RETR_EXTERNAL, cv2.CHAIN_APPROX_SIMPLE)
    if not cnts:
        return None
    return max(cnts, key=cv2.contourArea)

def is_valid_stamp(cnt, img_wh):
    h, w = img_wh
    area = cv2.contourArea(cnt)
    if area < 6_000 or area > (w*h)//3:
        return False

    per = cv2.arcLength(cnt, True)
    if per == 0:
        return False
    circ = 4 * np.pi * area / (per * per)   # схожесть с кругом
    if not (0.35 < circ < 1.2):
        return False

    x, y, cw, ch = cv2.boundingRect(cnt)
    aspect = cw / ch
    return 0.5 < aspect < 2.0               # лишний контур (линия) - не печать

def detect_stamps(path, show_steps=False):
    img = cv2.imread(path)
    if img is None:
        raise FileNotFoundError(path)
    h, w = img.shape[:2]

    # маска по цвету
    hsv  = cv2.cvtColor(img, cv2.COLOR_BGR2HSV)
    mask = get_mask(hsv, LOWER_BLUE, UPPER_BLUE)

    # морф. закрытие 
    kernel = cv2.getStructuringElement(cv2.MORPH_ELLIPSE, (15, 15))
    mask   = cv2.morphologyEx(mask, cv2.MORPH_CLOSE, kernel, iterations=2)

    cnts, _ = cv2.findContours(mask, cv2.RETR_EXTERNAL, cv2.CHAIN_APPROX_SIMPLE)

    centers = []
    for cnt in cnts:
        if not is_valid_stamp(cnt, (h, w)):
            continue
        x, y, cw, ch = cv2.boundingRect(cnt)
        centers.append(x + cw/2)    

        # Отрисовка
        if show_steps:
            cv2.drawContours(img, [cnt], -1, (0, 255, 0), 2)
            cv2.circle(img, (int(x+cw/2), int(y+ch/2)), 4, (0, 0, 255), -1)

    # Определение, на какой стороне печать
    left = right = False
    if len(centers) >= 2:
        left = right = True
    elif len(centers) == 1:
        if centers[0] < w/2:
            left = True
        else:
            right = True

    if show_steps:
        cv2.imshow("проверка", img)
        cv2.waitKey(0)
        cv2.destroyAllWindows()

    return left, right

files = ["task_02_1.jpg", 
         "task_02_2.jpg", 
         "task_02_3.jpg"]
for idx, fname in enumerate(files, 1):
      left, right = detect_stamps(fname, show_steps=True)
      print(f"Лист {idx}: слева – {left}, справа – {right}")


# Лист 1: слева – True, справа – True
# Лист 2: слева – True, справа – False
# Лист 3: слева – False, справа – True