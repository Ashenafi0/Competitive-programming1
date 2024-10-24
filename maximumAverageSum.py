class Solution(object):
    def findMaxAverage(self, nums, k):
        l=0
        total=0
        res=float("-inf")
        for r in range(len(nums)):
            total+=nums[r]
            if (r-l+1)==k:
                res=max(res,float(total)/k)
                total-=nums[l]
                l+=1
        return res

        
        
