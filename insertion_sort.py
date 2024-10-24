#!/bin/python3

import math
import os
import random
import re
import sys

#
# Complete the 'insertionSort1' function below.
#
# The function accepts following parameters:
#  1. INTEGER n
#  2. INTEGER_ARRAY arr
#

def insertionSort1(n, arr):
    # Write your code here
    to_be_sorted=arr[n-1]
    x=n-2
    while x>=0 and arr[x]>to_be_sorted:
        arr[x+1]=arr[x]
        x-=1
        print(' '.join(map(str,arr)))
    arr[x+1]=to_be_sorted
    print(' '.join(map(str,arr)))

if __name__ == '__main__':
    n = int(input().strip())

    arr = list(map(int, input().rstrip().split()))

    insertionSort1(n, arr)
