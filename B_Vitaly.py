n=int(input())

nums=list(map(int,input().split()))

len_n=0
len_p=0
for num in nums:
    if num>0:
        len_p+=1
    elif num<0:
        len_n+=1

ans_1=[]
ans_2=[]
ans_3=[]
nums.sort()
if len_p==0:
    for i in range(n):
        if i==0:
            ans_1.append(nums[i])
        elif i<=2:
            ans_2.append(nums[i])
        else:
            ans_3.append(nums[i])
else:
    for i in range(n):
        if i==0:
            ans_1.append(nums[i])
        elif nums[i]<=0:
            ans_3.append(nums[i])
        else:
            ans_2.append(nums[i])

print(len(ans_1),end=" ")
for i in range(len(ans_1)):
    print(ans_1[i],end=" ")
print()
print(len(ans_2),end=" ")
for i in range(len(ans_2)):
    print(ans_2[i],end=" ")
print()
print(len(ans_3),end=" ")
for i in range(len(ans_3)):
    print(ans_3[i],end=" ")





        