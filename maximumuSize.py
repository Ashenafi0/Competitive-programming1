class Solution(object):
    def minSubArrayLen(self, target, nums):
        res=float("inf")
        total=0
        l=0
        r=0
        while r<len(nums):
            total+=nums[r]
            while total>=target:
                res=min(res,r-l+1)
                total-=nums[l]
                l+=1
            r+=1
        return 0 if res==float("inf") else res
