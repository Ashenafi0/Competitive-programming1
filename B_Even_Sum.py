t=int(input())

for _ in range(t):
    n=int(input())
    nums=list(map(int,input().split()))

    no_odd=0

    for num in nums:
        if num%2!=0:
            no_odd+=1
        
    if no_odd%2==0:
        print(0)
    else:
        aE=[]
        aO=[]
        for num in nums:
            
            if num%2!=0:
                aO.append(num)
            else:
                aE.append(num)

        oprationO=float("inf")

        for num in aO:
            temp=0
            while num%2!=0:
                num//=2
                temp+=1
            oprationO=min(temp,oprationO)
        
        operationE=float("inf")

        for num in aE:
            temp=0

            while num%2==0:
                num//=2
                temp+=1
            operationE=min(operationE,temp)
        if operationE>oprationO:
            print(oprationO)
        else:
            print(operationE)
        

            