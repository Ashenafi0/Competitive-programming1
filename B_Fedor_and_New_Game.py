n,m,k=list(map(int,input().split()))
inputs=[]
for _ in range(m+1):
    inputs.append(int(input()))

fedor=inputs[m]
friends=0
for i in range(m):

    count=0
    for j in range(21):
        if (fedor&(1<<j))!= (inputs[i]&(1<<j)):
            count+=1
    if count<=k:
        friends+=1
print(friends)

   


