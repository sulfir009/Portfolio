def pow(x, n):
    if n == 0:
        return 1
    elif n < 0:
        return 1 / pow(x, -n)
    elif n % 2 == 0:
        half_pow = pow(x, n // 2)
        return half_pow * half_pow
    else:
        return x * pow(x, n - 1)


print(pow(2.0, 10))  # Виведе: 1024.0
print(pow(2.1, 3))   # Виведе: 9.261
