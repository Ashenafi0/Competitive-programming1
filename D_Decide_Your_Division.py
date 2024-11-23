query = int(input())

for _ in range(query):
    number = int(input())
    moves = 0

    for num in [2, 3, 5]:

        while number % num == 0:
            number //= num

            if num == 2:
                moves += 1

            elif num == 3:
                moves += 2

            elif num == 5:
                moves += 3

    print(moves if number == 1 else -1)