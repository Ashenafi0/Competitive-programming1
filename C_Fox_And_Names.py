from collections import defaultdict, deque

def find_alphabet_order(names):
    graph = defaultdict(list)
    in_degree = {chr(i): 0 for i in range(ord('a'), ord('z') + 1)}
    
    for i in range(len(names) - 1):
        name1, name2 = names[i], names[i + 1]
        min_length = min(len(name1), len(name2))
        found = False
        for j in range(min_length):
            if name1[j] != name2[j]:
                graph[name1[j]].append(name2[j])
                in_degree[name2[j]] += 1
                found = True
                break
        if not found and len(name1) > len(name2):
            return "Impossible"
    
    zero_in_degree = deque([char for char in in_degree if in_degree[char] == 0])
    topological_order = []
    
    while zero_in_degree:
        current = zero_in_degree.popleft()
        topological_order.append(current)
        for neighbor in graph[current]:
            in_degree[neighbor] -= 1
            if in_degree[neighbor] == 0:
                zero_in_degree.append(neighbor)
    
    if len(topological_order) != 26:
        return "Impossible"
    
    return ''.join(topological_order)

n = int(input())
names = [input().strip() for _ in range(n)]

print(find_alphabet_order(names))
