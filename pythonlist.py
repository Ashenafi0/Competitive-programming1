if __name__ == '__main__':
    N = int(input())
    my_list = []

    for _ in range(N):
        command = input().split()

        if command[0] == 'insert':
            i = int(command[1])
            e = int(command[2])
            my_list.insert(i, e)
        elif command[0] == 'print':
            print(my_list)
        elif command[0] == 'remove':
            e = int(command[1])
            my_list.remove(e)
        elif command[0] == 'append':
            e = int(command[1])
            my_list.append(e)
        elif command[0] == 'sort':
            my_list.sort()
        elif command[0] == 'pop':
            my_list.pop()
        elif command[0] == 'reverse':
            my_list.reverse()
