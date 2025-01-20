class Solution(object):
    def judgeSquareSum(self, c):
        numberlist=[i**2 for i in range(int(c**0.5)+1)]
        l,r=0,len(numberlist)-1
        while l<=r:
            cursum=numberlist[l]+numberlist[r]
            if cursum < c:
                l+=1
            elif cursum > c:
                r-=1
            else:
                return True
        return False
       
       
