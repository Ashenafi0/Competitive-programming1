class NumArray(object):

    def __init__(self, nums):
        """
        :type nums: List[int]
        """
        self.nums=[0]*(len(nums)+1)
        for i in range(len(nums)):
            self.nums[i + 1]=self.nums[i] + nums[i]
        

    def sumRange(self, left, right):
        """
        :type left: int
        :type right: int
        :rtype: int
        """
        return self.nums[right + 1]-self.nums[left]
          
       
           
        


