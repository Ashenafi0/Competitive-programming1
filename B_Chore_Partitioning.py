n,a,b=list(map(int,input().split(" ")))
nums=list(map(int,input().split(" ")))
nums.sort()


p,v=0,0

for i in range(-1,-a-1,-1):
    if i==-a:
        p=nums[i]
        break

for i in range(0,b):
    if i==b-1:
        v=nums[i]
        break
if p==v:
    print(0)
else:
    print(p-v)