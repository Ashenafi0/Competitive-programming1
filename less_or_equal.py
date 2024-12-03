n, k = map(int, input().split())
my_list = list(map(int, input().split()))
my_list.sort()

if k == 0:
    if my_list[0] > 1:
        print(1)
    else:
        print(-1)
else:
    if k == n or my_list[k - 1] != my_list[k]:
        print(my_list[k - 1])
    else:
        print(-1)
