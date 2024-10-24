class Solution(object):
    def reverse(self, x):
        INT32_MAX = 2**31 - 1
        INT32_MIN = -2**31

        reversed_str = str(x)[::-1].lstrip('0')

       
        if x < 0:
            reversed_str = '-' + reversed_str[:-1]

      
        if reversed_str == '':
            return 0

        reversed_int = int(reversed_str)

        if INT32_MIN <= reversed_int <= INT32_MAX:
            return reversed_int
        else:
            return 0
