def reverse_string(s):
    if len(s) == 0:
        return ""
    else:
        return s[-1] + reverse_string(s[:-1])


print(reverse_string("tiger"))  # ������: "regit"
