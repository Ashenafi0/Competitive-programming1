t=int(input())

for _ in range(t):
    dic=defaultdict(int)

    s=input()

    for ch in s:
        dic[ch]+=1
    ans=0
    for val in dic.values():

        if val>=2:
            ans+=2
        else:
            ans+=val
    print(ans//2)