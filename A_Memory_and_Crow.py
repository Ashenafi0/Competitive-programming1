n=int(input())
mylist=list(map(int,input().split()))
ans=[]


for i in range(n-1):
    ans.append(mylist[i]+mylist[i+1])

ans.append(mylist[-1])

for i in range(n):
    print(ans[i],end=" ")
