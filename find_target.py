class Solution(object):
    def targetIndices(self, nums, target):
   
        my_list=[]
        nums.sort()
        for x in range(len(nums)):
            if nums[x]==target:
                my_list.append(x)
            else:
                pass
        return my_list
        
        


