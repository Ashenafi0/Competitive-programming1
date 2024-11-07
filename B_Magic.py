t=int(input())

for _ in range(t):
    k=int(input())
    w=(100-k)/100
    e=(k)/100
    

    for i in range(1,101):
        
        if ((w%i))==0 and (e%i)==0:
            print(i)
            break