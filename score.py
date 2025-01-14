class Solution(object):
    def scoreOfParentheses(self,s):
        stack = []
        current_score = 0

        for char in s:
            if char == '(':
                stack.append(current_score)
                current_score = 0
            else:
                prev_score = stack.pop()
                current_score = prev_score + max(2 * current_score, 1)

        return current_score
