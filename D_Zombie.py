from collections import defaultdict
n,m=list(map(int,input().split()))

graph=defaultdict(list)
edge_c=defaultdict(int)

for _ in range(m):
    u,v=list(map(int,input().split()))
    edge_c[u]+=1
    edge_c[v]+=1


    graph[u].append(v)
    graph[v].append(u)

seen=set()
def dfs(node):
    if graph[node]==[]:
        return 0

    seen.add(node)

    max_d=0
    for neigh in graph[node]:
        if neigh not in seen:
            max_d=max(max_d,dfs(neigh)+1)
    
    return max_d
root=1
min_edge=float("inf")

for i in range(1,n+1):
    if edge_c[i]<min_edge:
        root=i
        min_edge=edge_c[i]


ans=dfs(root)
print(ans)


