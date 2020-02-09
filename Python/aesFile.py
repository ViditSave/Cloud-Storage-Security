import sys
import pyAesCrypt

bufferSize = 64 * 1024
password = sys.argv[4]

if (sys.argv[1]=="Encrypt"):
      fileLocation="..\\Uploads\\"+sys.argv[2]+"."+sys.argv[3]
      fileSave="..\\Uploads\\"+sys.argv[2]+".aes"
      pyAesCrypt.encryptFile(fileLocation, fileSave, password, bufferSize)
      print("Encrypted")

elif (sys.argv[1]=="Decrypt"):
      fileLocation="..\\Uploads\\"+sys.argv[2]+".aes"
      fileSave="..\\Uploads\\tempDecrypted\\"+sys.argv[2]+"."+sys.argv[3]
      pyAesCrypt.decryptFile(fileLocation, fileSave, password, bufferSize)
      print("Decrypted")
