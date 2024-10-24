def kmp(p:str):
    ans=[0]*len(p)
    i,j=0,1

    while j<len(p):
        if p[i]==p[j]:
            ans[j]=ans[i]+1
            i+=1
            j+=1
        else:
            if i!=0:
                i-=1
            
            
        
