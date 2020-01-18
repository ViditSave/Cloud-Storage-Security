import sys
import pyAesCrypt

bufferSize = 64 * 1024
password = "newpassword"
fileLocation="..\\Uploads\\"+sys.argv[2]+"."+sys.argv[3]
fileSave="..\\Uploads\\"+sys.argv[2]+".aes"
if (sys.argv[1]=="Encrypt"):
      pyAesCrypt.encryptFile(fileLocation, fileSave, password, bufferSize)
      print("Encrypted")
'''
else:
      pyAesCrypt.decryptFile("aes\data.txt.aes", "aes\dataout.txt", password, bufferSize)
      print("Decrypted")
'''
