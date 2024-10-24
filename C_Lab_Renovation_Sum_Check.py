n=int(input())

mat=[]

for _ in range(n):
    mat.append(list(map(int,input().split())))
flag=True
i,j=0,0
while i<n and flag:
    j=0
    while j<n and flag:
        if mat[i][j]==1:
            j+=1
            continue
        else:
            num1=[]
            num2=[]
            for i1 in range(0,n):
                if i1==j:
                    continue
                num1.append(mat[i][i1])
            for j1 in range(0,n):
                if j1==i:
                    continue
                num2.append(mat[j1][j])
            for i1 in range(len(num1)):
                for j1 in range(len(num2)):
                    if num1[i1]+num2[j1]==mat[i][j]:
                        flag=False
                        

            
            if not flag:
                flag=True
            else:
                flag=False
                
            j+=1
    i+=1
if flag:
    print("Yes")
else:
    print("No")

