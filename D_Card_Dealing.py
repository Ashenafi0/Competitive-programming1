t=int(input())

for _ in range(t):
    num=int(input())

    h=1
    b=0
    num-=1
    count=2
    alt=0
    while num >0:
        if  alt<2:
            if num-count>=0:
                b+=count
                num-=count
            else:
                b+=num
                num-=num

            count+=1
            alt+=1
        else:
            if num-count>=0:
                h+=count
                num-=count
            else:
                h+=num
                num-=num

            count+=1
            alt+=1
        if alt==4:
            alt=0
        
    print(h,b)

        
        
        


