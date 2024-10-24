class Solution(object):
    def evalRPN(self, tokens):
        """
        :type tokens: List[str]
        :rtype: int
        """
        stack=[]
        for op in tokens:
            if op=='+':
                stack.append(stack.pop() + stack.pop())
            elif op=='-':
                a,b=stack.pop(),stack.pop()
                stack.append(b-a)
            elif op=='*':
                stack.append(stack.pop() * stack.pop())
            elif op=='/':
                a,b=stack.pop(),stack.pop()
                stack.append(int(float(b)/a))
            
            else:
                stack.append(int(op))
        return stack[0]
