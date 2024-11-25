class DataStream(object):

    def __init__(self, value, k):
     
        self.mylist = []   
        self.value = value
        self.k=k

    def consec(self, num):
        """
        :type num: int
        :rtype: bool
        """
        if len(self.mylist)<self.k:
            self.mylist.append(num)
        else:
            self.mylist.pop(0)
            self.mylist.append(num)
        if len(self.mylist) < self.k:
            return False
        
        
        return all(x == self.value for x in self.mylist)


        
         
        
        
       
