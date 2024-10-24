from collections import defaultdict
n,k=list(map(int,input().split(" ")))

count=0
dic=defaultdict(int)

nums=list(input().split(" "))

for num in nums:
    count_4=num.count("4")
    count_7=num.count("7")
    total=count_4+count_7
    
    if total<=k:
        count+=1
print(count)