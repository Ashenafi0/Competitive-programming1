n=int(input())
s=input()

if n==1:
    print(s)
else:
    s=list(s)
    if n%2==0:
        l=(n//2)-1
        r=l

        ans=[""]*n
        ans[l]=s[0]
        l-=1
        r+=1
        status=False
        i=1
        while i<n:
            if status :
                ans[l]=s[i]
                l-=1
                status=not status
            else:
                ans[r]=s[i]
                r+=1
                status =not status
                
            i+=1
        print("".join(ans))
    else:
        l=((n+1)//2)-1
        r=l
        ans=[""]*n
        ans[l]=s[0]
        l-=1
        r+=1
        status=True
        i=1
        while i<n:
            if status :
                ans[l]=s[i]
                l-=1
                status=not status
            else:
                ans[r]=s[i]
                r+=1
                status =not status
                
            i+=1
        print("".join(ans))
