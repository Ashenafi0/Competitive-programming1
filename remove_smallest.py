x= int(input())
for i in range(x):
    n=int(input())
    my_list=list(map(int,input().split()))
    my_list.sort()
    if len(my_list)==1:
        print('YES')
        
    t=0
    for y in range(n-1):
        if my_list[t+1]-my_list[t]==1 or my_list[t+1]-my_list[t]==0:
            my_list.remove(my_list[t])
            t-=1
        else:
            pass
        t+=1
        if len(my_list)==1:
            print('YES')
            break
    if len(my_list)!=1:
        print('NO')
        
