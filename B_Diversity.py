s=input()
k=int(input())
s=list(s)


if len(s)<k:
    print("impossible")
else:
    myset=set(s)
    if len(myset)>=k:
        print(0)
    else:
        print(k-len(myset))
