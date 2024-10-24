class UnionFind:

    def __init__(self,n):
        self.parent={i:i for i in range(1,n+1)}
        self.rank=[0]*(n+1)
        self.size=[]

    def find(self,x):

        if x==self.parent[x]:
            return x
        self.parent[x]=self.find(self.parent[x])
        return self.parent[x]

    def union(self,x,y):
        parentX=self.find(x)
        parentY=self.find(y)

        if parentX!=parentY:
            if self.rank[parentX]>self.rank[parentY]:
                self.parent[parentY]=parentX
            elif self.rank[parentX]<self.rank[parentY]:
                self.parent[parentX]=parentY
            else:
                self.parent[parentX]=parentY
                self.rank[parentY]+=1
        else:
            return True
n,m,k=list(map(int,input().split()))

edges=[]
for i in range(m):
    edges.append(list(map(int,input().split())))
opeartions=[]
for i in range(k):
    opeartions.append(list(input().split()))
ans=[]

uf=UnionFind(n)
for i in range(k-1,-1,-1):
    if opeartions[i][0]=="ask":
        ans.append(uf.find(int(opeartions[i][1]))==uf.find(int(opeartions[i][2])))
    else:
        uf.union(int(opeartions[i][1]),int(opeartions[i][2]))
for i in range(len(ans)-1,-1,-1):
    print("YES" if ans[i] else "NO")