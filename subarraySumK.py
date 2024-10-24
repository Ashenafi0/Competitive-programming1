class Solution(object):
    def subarraySum(self, nums, k):
        count=0
        prefixSum={0:1}
        curSum=0
        for n in nums:
            curSum+=n
            diff=curSum-k
            count+=prefixSum.get(diff,0)
            prefixSum[curSum]=1+prefixSum.get(curSum,0)
        return count
        
