//taking inputs
n, m = map(int, input().split())

base_candies = n // m

remainder = n % m

candies = [base_candies] * m

for i in range(remainder):
    candies[i] += 1

candies.reverse()


print(" ".join(map(str, candies)))