import math
import matplotlib.pyplot as plt
import numpy as np

x = np.linspace(-5, 5, 1000)
y = []
for x_i in x:
    y.append(x_i ** 2 - 1)

plt.axis([-5, 5, -2, 26])
plt.plot(x,y)
plt.title("$f(x)=x^{2}-1$")
plt.xlabel('x')
plt.ylabel('y')
plt.grid()
plt.axhline(linewidth=2)
plt.axvline(linewidth=2)
plt.show()
