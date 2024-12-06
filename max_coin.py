class Solution(object):
    def maxCoins(self, piles):
        """
        :type piles: List[int]
        :rtype: int
        """
        piles.sort(reverse=True)  
        n = len(piles) // 3  
        coins = 0
        
        for i in range(n):
            coins += piles[2 * i + 1]  
        
        return coins
