n,m=list(map(int,input().split()))
parent={i:i for i in range(1,n+1)} 
rank=[0]*(n+1)
max_num={i:i for i in range(1,n+1)} 
min_num={i:i for i in range(1,n+1)}
total_num={i:1 for i in range(1,n+1)}

def find(x):
    if parent[x]==x:
        return x
    parent[x]=find(parent[x])
    return parent[x]

def union(x,y):
    parentX=find(x)
    parentY=find(y)

    if parentX!=parentY:

        if rank[parentX]>rank[parentY]:
            parent[parentY]=parentX
            max_num[parentX]=max(max_num[parentX],max_num[parentY])
            min_num[parentX]=min(min_num[parentX],min_num[parentY])
            total_num[parentX]+=total_num[parentY]
        elif rank[parentX]<rank[parentY]:
            parent[parentX]=parentY
            max_num[parentY]=max(max_num[parentX],max_num[parentY])
            min_num[parentY]=min(min_num[parentX],min_num[parentY])
            total_num[parentY]+=total_num[parentX]
        else:
            parent[parentY]=parentX
            max_num[parentX]=max(max_num[parentX],max_num[parentY])
            min_num[parentX]=min(min_num[parentX],min_num[parentY])
            total_num[parentX]+=total_num[parentY]
            rank[parentX]+=1
for j in range(m):
    inputs=list(input().split())

    if inputs[0]=="union":
        union(int(inputs[1]),int(inputs[-1]))
    else:

        print(min_num[find(int(inputs[-1]))],max_num[find(int(inputs[-1]))],total_num[find(int(inputs[-1]))])


