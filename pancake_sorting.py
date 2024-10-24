class Solution(object):
    def pancakeSort(self, arr):
        """
        :type arr: List[int]
        :rtype: List[int]
        """
        result = []
        
        def flip(k):
            arr[:k] = arr[:k][::-1]
            result.append(k)
        
        def find_max_index(end):
            max_val = float('-inf')
            max_index = -1
            for i in range(end + 1):
                if arr[i] > max_val:
                    max_val = arr[i]
                    max_index = i
            return max_index
        
        n = len(arr)
        while n > 1:
            max_index = find_max_index(n - 1)
            if max_index != n - 1:
                if max_index != 0:
                    flip(max_index + 1)
                flip(n)
            n -= 1
        
        return result


