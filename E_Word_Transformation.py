from collections import defaultdict
t=int(input())

for _ in range(t):

    s,t=input().split(" ")
    if s==t:
        print("YES")
       
    elif len(t)>len(s):
        print("NO")
    else:
        dicS=defaultdict(int)
        dicT=defaultdict(int)
        for ch in s:
            dicS[ch]+=1
        for ch in t:
            dicT[ch]+=1
        
        i,j=0,0
        while i<len(t) and j<len(s):
            while j<len(s) and s[j]!=t[i]:
                dicS[s[j]]-=1
                j+=1
            if j>=len(s):
                break
            if dicS[s[j]]==dicT[t[i]]:
                dicS[s[j]]-=1
                dicT[t[i]]-=1
                i+=1
                j+=1
            elif dicS[s[j]]<dicT[t[i]]:
                break
            else:
                
                dicS[s[j]]-=1
                j+=1
            
        if i>=len(t):
            print("YES")
            
        else:
            print("NO")
