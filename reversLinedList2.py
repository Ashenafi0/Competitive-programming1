# Definition for singly-linked list.
# class ListNode(object):
#     def __init__(self, val=0, next=None):
#         self.val = val
#         self.next = next
class Solution(object):
    def reverseBetween(self, head, left, right):
        """
        :type head: ListNode
        :type left: int
        :type right: int
        :rtype: ListNode
        """
        dummy=ListNode(0,head)
        leftPrev,curr=dummy,head
        for x in range(left-1):
            leftPrev,curr=curr,curr.next
        prev=None
        for i in range(right-left + 1):
            tempnxt=curr.next
            curr.next=prev
            prev=curr
            curr=tempnxt
        leftPrev.next.next=curr
        leftPrev.next=prev
        return dummy.next
        

        
            
            

            

            
        
            

        
