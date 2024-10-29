t=int(input())

for _ in range(t):
    n=int(input())
    nums1=list(map(int,input().split()))
    nums2=list(map(int,input().split()))

    if max(nums1)>max(nums2):
        for i in range(n):
            if nums2[i]>nums1[i]:
                nums1[i],nums2[i]=nums2[i],nums1[i]
    else:
        for i in range(n):
            if nums1[i]>nums2[i]:
                nums2[i],nums1[i]=nums1[i],nums2[i]
    print(max(nums1)*max(nums2))