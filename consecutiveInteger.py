class DataStream(object):

    def __init__(self, value, k):
        self.q=deque()
        self.value=value
        self.k=k
        self.counter=0
        
        

    def consec(self, num):
        self.q.append(num)
        if num!=self.value:
            self.counter+=1
        if len(self.q)==self.k:
            if self.counter!=0:
                popped=self.q.popleft()
                if popped!=self.value:
                    self.counter-=1
                return False
            else:
                self.q.popleft()
                return True
                

        return False

        
        


