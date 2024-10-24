class Solution(object):
    def carPooling(self, trips, capacity):
        trips.sort(key=lambda x:x[1])
        
        minHeap=[]
        curPass=0
        for t in trips:
            numPass,start,end=t
            while minHeap and minHeap[0][0]<=start:
                curPass-=minHeap[0][1]
                heapq.heappop(minHeap)
            curPass+=numPass
            if curPass>capacity:
                return False
            heapq.heappush(minHeap,[end,numPass])
        return True
        
        
