class Solution(object):
    def isPalindrome(self, s):
        """
        :type s: str
        :rtype: bool
        """
        def clean_string(input_str):
            cleaned_str = ""
            for char in input_str:
                if char.isalnum():
                    cleaned_str += char.lower()
            return cleaned_str
        
        cleaned_s = clean_string(s)
        return cleaned_s == cleaned_s[::-1]
