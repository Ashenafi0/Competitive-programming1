t= int(input())

aait={1,2,3,4}
aastu={5,6,7}
astu={8,9}

for _ in range(t):
    u,v=list(map(int,input().split()))
    if u in aait and v in aait:
        print("Yes")
    elif u in aastu and v in aastu:
        print("Yes")
    elif u in astu and v in astu:
        print("Yes")
    else:
        print("No")