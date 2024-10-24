class Solution(object):
    def smallerNumbersThanCurrent(self, nums):
        """
        :type nums: List[int]
        :rtype: List[int]
        """
        sorted_nums = sorted(nums)
        count_dict = {}
        result = []

        for i, num in enumerate(sorted_nums):
            if num not in count_dict:
                count_dict[num] = i

        for num in nums:
            result.append(count_dict[num])

        return result


