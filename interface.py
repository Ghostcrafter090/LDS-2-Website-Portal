# Importing Libraries
import serial
import time
import datetime
from datetime import datetime
import os

def getSerialPort():
    writeLog("Searching for devices...")
    check = 0
    n = 0
    while check == 0:
        timeout = 0
        try:
            test = serial.Serial(port='com' + str(n), baudrate=2000000, timeout=.1)
        except:
            # print("Checking new device COM" + str(n))
            timeout = 11000
        while timeout < 10000:
            value = ard_read(test)
            if str(value) != "b\'\'":
                if str(value).find('Standard') != -1:
                    check = 1
                    timeout = 11000
            timeout = timeout + 1
        n = n + 1
        if n > 100:
            check = 2
    out = -1
    if check == 1:
        out = n - 1
        writeLog("Device detected on COM port COM" + str(out) + "!")
    return out

def connectArduino():
    comNumber = -1
    while comNumber == -1:
        comNumber = getSerialPort()
        if comNumber == -1:
            writeLog("Connection Faliure. Device not detected.")
            time.sleep(10)
            writeLog("checking again...")
    return serial.Serial(port='COM' + str(comNumber), baudrate=2000000, timeout=.1)

def ard_write(x):
    global arduino
    arduino.write(bytes(x, 'utf-8'))

def ard_read(arduinon):
    data = arduinon.readline()
    return data

def getDate():
    sequence = str(datetime.now()).replace(" ", ";").replace(":", "-").replace(".", "-")
    list = sequence
    return list

def writeLog(value):
    global arduino
    print(getDate() + "  ;;;  " + str(value))
    file = open("C:\\inetpub\\lightningdata\\weather\\lightning\\log-" + (getDate().split(";"))[0] + ".txt", "a+")
    cont = "\n" + getDate() + "  ;;;  " + str(value)
    file.write(cont)
    file.close()

arduino = connectArduino()
dangerget = 1000000
    
def main():

    global arduino
    global dangerget

    print((getDate().split(";"))[0])

    tic = 0
    ticn = 0
    varn = ""
    value = b''
    
    while True:
        # num = input("Enter a number: ") # Taking input from user
        tic = tic + 1
        if tic > 1000:
            num = "\nreturn dangerLevel,,,,,,,,"
            value = ard_write(num)
        value = ard_read(arduino)
        file = open("C:\\inetpub\\lightningdata\\command.txt", "r")
        cont = str(file.read())
        file.close()
        try:
            if int((cont.split(";"))[1]) == 0:
                num = "\n" + (cont.split(";"))[0] + ","
                ard_write(num)
                ticn = -1
                contn = (cont.split(";"))[0] + ";1" 
                print(num)
                file = open("C:\\inetpub\\lightningdata\\command.txt", "w")
                file.write(contn)
                file.close()
                varn = ""
        except Exception as E:
            print(str(E))
        if ticn < 21:
            ticn = ticn + 1
            if ticn < 20:
                varn = varn + " <br></br> " + str(value)
            if ticn == 20:
                file = open("C:\\inetpub\\lightningdata\\commandout.txt", "w")
                file.write(varn)
                file.close()
                file = open("C:\\inetpub\\lightningdata\\commandn.txt", "w")
                file.write("1")
                file.close()
        if (str(value).split(";"))[0] == "b\'dangerLevel value":
            dangerget = 1000000
            # print("hi")
            file = open("C:\\inetpub\\lightningdata\\danger.txt", "w")
            file.write((str(value).split(";"))[1])
            file.close()
            print(str(value)) # printing the value
            tic = 0
        dangerget = dangerget - 1
        if dangerget < 0:
            arduino = connectArduino()
        if (str(value).split(";"))[0] == "b\'Strike Detected! reading of":
            file = open("C:\\inetpub\\lightningdata\\weather\\lightning\\log-" + (getDate().split(";"))[0] + ".txt", "a+")
            cont = "\n" + getDate() + "  ;;;  " + str(value)
            file.write(cont)
            file.close()
            # print("hi")
            print(str(value)) # printing the value
        if str(value) != "b\'\'":
            if str(value) != "b'\n'":
                if str(value) != "b'\r\n'":
                    print(str(value))
            
main()