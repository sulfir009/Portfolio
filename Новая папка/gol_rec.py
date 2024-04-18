# Задача 1: Реверс рядка
def reverse_string(s):
    if len(s) == 0:
        return s
    else:
        return reverse_string(s[1:]) + s[0]

# Задача 2: Змінити місцями вузли у зв’язаному списку
class Node:
    def __init__(self, val=0, next=None):
        self.val = val
        self.next = next

def swap_pairs(head):
    if not head or not head.next:
        return head
    else:
        new_head = head.next
        head.next = swap_pairs(new_head.next)
        new_head.next = head
        return new_head

# Задача 3: Числа Фібоначчі
def fibonacci(n):
    if n == 0:
        return 0
    elif n == 1:
        return 1
    else:
        return fibonacci(n-1) + fibonacci(n-2)

# Задача 4: Підйом сходами
def climb_stairs(n):
    if n <= 1:
        return 1
    else:
        return climb_stairs(n-1) + climb_stairs(n-2)

# Задача 5: Піднесення до ступеня
def power(x, n):
    if n == 0:
        return 1
    elif n < 0:
        return 1 / power(x, -n)
    else:
        return x * power(x, n-1)
