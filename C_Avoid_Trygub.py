t=int(input())

for _ in range(t):
    n=int(input())
    s=input()

    s=list(s)

    i,j=0,len(s)-1
    while i<j:
        if s[j]=="b":
            s[i],s[j]=s[j],s[i]
            i+=1
            j+=1
        j-=1
    print("".join(s))
      
