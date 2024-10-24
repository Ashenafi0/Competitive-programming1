# Definition for singly-linked list.
# class ListNode(object):
#     def __init__(self, val=0, next=None):
#         self.val = val
#         self.next = next
class Solution(object):
    def removeNthFromEnd(self, head, n):
        """
        :type head: ListNode
        :type n: int
        :rtype: ListNode
        """
        dummy=ListNode(0,head)
        tail=head
        le=0
        while tail:
            le+=1
            tail=tail.next
        tail=dummy
        curr=head
        for i in range(le-n):
            tail=curr
            curr=curr.next
        if curr.next:

            tail.next=curr.next
        else:
            tail.next=None
        
        return dummy.next
            



        
