
class Solution(object):
    def removeDuplicateLetters(self, s):
        last_occurrence = {char: i for i, char in enumerate(s)}
        stack = []
        seen = set()

        for i, char in enumerate(s):
            if char not in seen:
                while stack and char < stack[-1] and i < last_occurrence[stack[-1]]:
                    seen.discard(stack.pop())
                seen.add(char)
                stack.append(char)

        return ''.join(stack)
        
