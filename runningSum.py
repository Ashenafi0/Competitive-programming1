class Solution(object):
    def runningSum(self, nums):
        """
        :type nums: List[int]
        :rtype: List[int]
        """
        sum=0
        for num in range(len(nums)):
            sum+=nums[num]
            nums[num]=sum
        return nums
        
