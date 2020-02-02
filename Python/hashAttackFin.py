import random
import string
import time

start= time.time()

def charRep(inpInt):
      temp = "%012d" %inpInt 
      return "".join([keyBounds[int("".join([temp[v] for v in range(i*3,(i+1)*3)]))%len(keyBounds)] for i in range (4)])

def hashFunction(password):
      pwdHex=[]
      for i in range(8):
            pwdHex.append("".join(["%03d" %ord(password[v]) for v in range(i*4,(i+1)*4)]))
            
      initHex=[]
      for i in range(4):
            initHex.append("".join(["%03d" %ord("NewHashAlgorithm"[v]) for v in range(i*4,(i+1)*4)]))

      A,B,C,D=int(initHex[0]),int(initHex[1]),int(initHex[2]),int(initHex[3])

      for i in range (16):
            Ainit = A
            Cinit = C
            binA = bin(A)[2:]
            binB = bin(B)[2:]
            if (i%4==0):
                  combFun = (B&C)|(~B&D)
            elif (i%4==1):
                  combFun = B^C^D
            elif (i%4==2):
                  combFun = (B&C)|(B&D)|(C&D)
            elif (i%4==3):
                  combFun = B^C^D
            A = int(int('0b'+str(binA[5:]+binA[:5]),2)^int(combFun)^int(pwdHex[i%8]))
            B = int(Ainit)
            C = int('0b'+str(binB[18:]+binB[:18]),2)
            D = int(Cinit) 
            
      finalKey = charRep(A)+charRep(B)+charRep(C)+charRep(D)
      return finalKey


saltGenString = string.ascii_letters + string.digits
keyBounds= string.ascii_letters + string.digits + "[@_!#$%^&*+-()<>?/\|}{~]"
allHash=[]
for i in range(1000000):
      temp = ''.join(random.choice(saltGenString) for i in range(32))
      tempHash=hashFunction(temp)
      if (i%5000==0):
            print(i, end=" ")
      allHash.append(tempHash)
print("\nGenerated",i+1,"random hashes")
if (len(set(allHash))==len(allHash)):
      print("No Hash Keys were repeated")
print("Total Time : ", time.time()-start)
