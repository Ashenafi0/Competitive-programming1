class NumMatrix(object):

    def __init__(self, matrix):
        """
        :type matrix: List[List[int]]
        """
        row,col=len(matrix),len(matrix[0])
        self.matrix=[[0]*(col + 1) for x in range(row + 1)]
        for i in range(row):
            prefix=0
            for j in range(col):
                prefix +=matrix[i][j]
                above=self.matrix[i][j+1]
                self.matrix[i+1][j+1]=prefix + above
    def sumRegion(self, row1, col1, row2, col2):
        """
        :type row1: int
        :type col1: int
        :type row2: int
        :type col2: int
        :rtype: int
        """
        row1,row2,col1,col2=row1 + 1,row2 + 1,col1 + 1,col2 + 1
        bottomR=self.matrix[row2][col2]
        aboveA=self.matrix[row1 -1][col2]
        leftA=self.matrix[row2][col1 -1]
        upperLA=self.matrix[row1 -1][col1 -1]
        return bottomR - aboveA-leftA +upperLA
        


