class Solution(object):
    def addSpaces(self, s, spaces):
        """
        :type s: str
        :type spaces: List[int]
        :rtype: str
        """
        result = []
        prev_idx = 0
        
        for space_idx in spaces:
            result.append(s[prev_idx:space_idx] + ' ')
            prev_idx = space_idx
        
        result.append(s[prev_idx:])
        
        return ''.join(result)
