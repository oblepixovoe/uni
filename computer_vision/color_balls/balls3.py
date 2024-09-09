import cv2
import random
import numpy as np

cv2.namedWindow("guess subsequence", cv2.WINDOW_NORMAL)

cam = cv2.VideoCapture(0)

color_str = ['blue', 'yellow', 'red']

yellow_lower = np.array([20, 160, 170])
yellow_upper = np.array([30, 255, 255])

red_lower = np.array([170, 100, 90])
red_upper = np.array([255, 255, 255])

blue_lower = np.array([80, 230, 100])
blue_upper = np.array([150, 255, 170])

x_start = 0
y_start = 0
random.shuffle(color_str)


def contours(hsv, lower, upper):
    mask = cv2.inRange(hsv, lower, upper)
    contours = cv2.findContours(mask, cv2.RETR_EXTERNAL, cv2.CHAIN_APPROX_SIMPLE)
    return contours


while cam.isOpened():
    _, frame = cam.read()
    frame = cv2.GaussianBlur(frame, (21, 21), 0)
    hsv = cv2.cvtColor(frame, cv2.COLOR_BGR2HSV)

    contours_r, _ = contours(hsv, red_lower, red_upper)
    contours_b, _ = contours(hsv, blue_lower, blue_upper)
    contours_y, _ = contours(hsv, yellow_lower, yellow_upper)

    subsequence = {}

    if len(contours_r) > 0:
        c = max(contours_r, key=cv2.contourArea)
        (x, y), radius = cv2.minEnclosingCircle(c)
        if radius > 20:
            cv2.circle(frame, (int(x), int(y)), int(radius), (0, 255, 255), 0)
            color = "red"
            subsequence[color] = x

    if len(contours_b) > 0:
        c = max(contours_b, key=cv2.contourArea)
        (x, y), radius = cv2.minEnclosingCircle(c)
        if radius > 20:
            cv2.circle(frame, (int(x), int(y)), int(radius), (0, 255, 255), 0)
            color = "blue"
            subsequence[color] = x

    if len(contours_y) > 0:
        c = max(contours_y, key=cv2.contourArea)
        (x, y), radiusy = cv2.minEnclosingCircle(c)
        if radiusy > 20:
            cv2.circle(frame, (int(x), int(y)), int(radiusy), (0, 255, 255), 0)
            color = "yellow"
            subsequence[color] = x

    sorted_subsequence = sorted(subsequence, key=subsequence.get)

    if len(sorted_subsequence) == 1:
        x_start = x
        y_start = y

    count = 0

    for i in range(0, len(sorted_subsequence)):
        if sorted_subsequence[i] == color_str[i]:
            count += 1

    if count == 3:
        cv2.putText(frame, f"Отгадал!", (10, 30), cv2.FONT_HERSHEY_COMPLEX, 0.7, (0, 0, 0))
    else:
        cv2.putText(frame, f"Попробуйте отгадать последовательность", (10, 30), cv2.FONT_HERSHEY_COMPLEX, 0.7, (0, 0, 0))

    cv2.imshow("Image", frame)
    key = cv2.waitKey(50)
    if key == ord('q'):
        break

cv2.destroyAllWindows()