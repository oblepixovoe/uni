import cv2
import random

colors = {
    'b': {'lower': (90, 150, 120), 'upper': (115, 255, 255), 'color': (255, 0, 0)},
    'r': {'lower': (0, 100, 140), 'upper': (12, 255, 255), 'color': (0, 0, 255)},
    'g': {'lower': (60, 100, 100), 'upper': (80, 255, 255), 'color': (0, 255, 0)},
    'y': {'lower': (25, 100, 100), 'upper': (33, 255, 255), 'color': (0, 255, 255)}
}


def find_ball(frame, hsv, lower, upper, color):
    mask = cv2.inRange(hsv, lower, upper)
    mask = cv2.dilate(mask, None, iterations=2)
    cnts = cv2.findContours(mask.copy(), cv2.RETR_EXTERNAL, cv2.CHAIN_APPROX_SIMPLE)[-2]
    if len(cnts) > 0:
        c = max(cnts, key=cv2.contourArea)
        (x, y), r = cv2.minEnclosingCircle(c)
        m = cv2.moments(c)
        center = int(m["m10"] / m["m00"]), int(m["m01"] / m["m00"])
        if r > 10:
            cv2.circle(frame, (int(x), int(y)), int(r), color, 2)
            cv2.circle(frame, (int(x), int(y)), 5, color, 2)
            return int(x), int(y), int(r), center
    return None, None, None, None


capture = cv2.VideoCapture(0)

cv2.namedWindow("Camera")

order = 'bygr'
order = ''.join(random.sample(order, len(order)))

while capture.isOpened():
    ret, frame = capture.read()
    frame = cv2.GaussianBlur(frame, (21, 21), 0)
    hsv = cv2.cvtColor(frame, cv2.COLOR_BGR2HSV)

    balls = {}
    for color_name, params in colors.items():
        x, y, r, c = find_ball(frame, hsv, params['lower'], params['upper'], params['color'])
        balls[color_name] = {'x': x, 'y': y, 'r': r, 'center': c}

    if all(balls[color]['x'] is not None for color in order):
        x_values = [balls[color]['center'][0] for color in order]
        y_values = [balls[color]['center'][1] for color in order]
        if x_values[2] < x_values[0] < x_values[1] and y_values == sorted(y_values):
            cv2.putText(frame, f"Отгадал!", (10, 30), cv2.FONT_HERSHEY_COMPLEX, 0.7, (0, 0, 0))
        else:
            cv2.putText(frame, f"Неверно", (10, 30), cv2.FONT_HERSHEY_COMPLEX, 0.7, (0, 0, 0))
    else:
        cv2.putText(frame, f"Попробуйте отгадать последовательность", (10, 30), cv2.FONT_HERSHEY_COMPLEX, 0.7, (0, 0, 0))

    cv2.imshow("Camera", frame)
    key = cv2.waitKey(1)
    if key == ord("q"):
        break

capture.release()
cv2.destroyAllWindows()