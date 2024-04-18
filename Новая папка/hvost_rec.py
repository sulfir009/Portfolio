# Задача 1: Реверс рядка
def reverse_string_tail(s, acc=""):
    if len(s) == 0:
        return acc
    else:
        return reverse_string_tail(s[1:], s[0] + acc)

# Задача 3: Числа Фібоначчі
def fibonacci_tail(n, a=0, b=1):
    if n == 0:
        return a
    elif n == 1:
        return b
    else:
        return fibonacci_tail(n-1, b, a+b)

# Задача 4: Підйом сходами
def climb_stairs_tail(n, a=1, b=1):
    if n == 0:
        return a
    else:
        return climb_stairs_tail(n-1, b, a+b)

# Задача 5: Піднесення до ступеня
def power_tail(x, n, acc=1):
    if n == 0:
        return acc
    elif n < 0:
        return power_tail(x, n+1, acc/x)
    else:
        return power_tail(x, n-1, acc*x)


