n = int(input())
lst = list(map(int,input().split()))
count = 0

for i in lst:
    if i%2 == 0:
        count += 1
    else:
        count -= 1

if abs(count) == n:
    lst = list(map(str,lst))
    print(" ".join(lst))
else:
    lst = list(map(str,sorted(lst)))
    print(" ".join(lst))
