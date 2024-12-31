class Solution(object):
    def removeDuplicates(self, nums):
        """
        :type nums: List[int]
        :rtype: int
        """
        i=0
        j=1
        if len(nums)==1:
            return len(nums)
        while j<len(nums):
            while nums[i]==nums[j]:
                nums.remove(nums[j])
                if len(nums)==j:
                    return len(nums)
            i+=1
            j+=1
        return (len(nums))


      
            
        
        

