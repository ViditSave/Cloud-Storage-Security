import sys
import random
import string

saltGenString = string.ascii_letters + string.digits
salt = ''.join(random.choice(saltGenString) for i in range(16))

password = sys.argv[1] + '0'*(16-len(sys.argv[1]))+salt

pwdHex=[]
temp=''
c=0
for i in password:
      temp+=str(ord(i)).zfill(3)
      c+=1
      if (c==4):
            pwdHex.append(temp)
            temp=''
            c=0

initialRound="NewHashAlgorithm"
initHex=[]
temp=''
c=0
for i in initialRound:
      temp+=str(ord(i)).zfill(3)
      c+=1
      if (c==4):
            initHex.append(temp)
            temp=''
            c=0
      

A,B,C,D=int(initHex[0]),int(initHex[1]),int(initHex[2]),int(initHex[3])

for i in range (8):
      
      Ainit = A
      Cinit = C
      funct = ""
      if (i%4==0):
            funct = str((B&C)|(~B&D)).zfill(12)
      elif (i%4==1):
            funct = str(B^C^D).zfill(12)
      elif (i%4==2):
            funct = str((B&C)|(B&D)|(C&D)).zfill(12)
      elif (i%4==3):
            funct = str(B^C^D).zfill(12)
      Atemp = bin(A)[2:]
      Atemp = str(eval('0b'+str(Atemp[5:]+Atemp[:5]))).zfill(12)

      Rtemp = str(int(Atemp)^int(funct)).zfill(12)

      Btemp = bin(B)[2:]
      Btemp = str(eval('0b'+str(Btemp[13:]+Btemp[:13]))).zfill(12)

      A = int(str(int(pwdHex[i])^int(Rtemp)).zfill(12))
      B = int(Ainit)
      C = int(Btemp)
      D = int(Cinit)

keyBounds= string.ascii_letters + string.digits + "[@_!#$%^&*+-()<>?/\|}{~:]"
def prop (P):
      P=str(P).zfill(12)
      tempList=[]
      c=0
      temp=""
      for i in P:
            temp+=i
            c+=1
            if (c==3):
                  tempList.append(keyBounds[int(temp)%len(keyBounds)])
                  temp=''
                  c=0
      return "".join(tempList)

finalKey = prop(A)+prop(B)+prop(C)+prop(D)
print(finalKey,salt)
