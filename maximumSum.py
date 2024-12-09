class Solution(object):
    def maxSumRangeQuery(self, nums, requests):
        Mode=10**9 +7
        req=[0]*len(nums)
        res=0
        prefix=0
        for re in requests:
            start,end=re
            req[start]+=1
            if end+1 <len(nums):
                req[end+1]-=1
        for i in range(len(nums)):
            prefix+=req[i]

            req[i]=prefix
        req.sort()
        nums.sort()
        for i in range(len(nums)):
            res=(res+req[i]*nums[i])%Mode
        return res
        

        

        
        
