class Solution(object):
    def subarraysDivByK(self, nums, k):
        prefixSum={0:1}
        res=0
        curSum=0
        for n in nums:
            curSum+=n
            div=curSum%k
            res+=prefixSum.get(div,0)
            prefixSum[div]=1+prefixSum.get(div,0)
        return res
        
        
