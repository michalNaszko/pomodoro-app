import pandas as pd
import datetime as dt
import mysql.connector
import random
from mysql.connector import Error


def create_connection(host_name, user_name, user_password, db):
    connection = None
    try:
        connection = mysql.connector.connect(
            host=host_name,
            user=user_name,
            passwd=user_password,
            database=db
        )
        print("Connection to MySQL DB successful")
    except Error as e:
        print(f"The error '{e}' occurred")

    return connection


def generate_time (max_value=10, dateList=None):
    
    if dateList == None:
        end_date = dt.datetime.now()
        last_month = end_date.month-1 if end_date.month > 1 else 12
        start_date = str(end_date.year) + '-' + str(last_month) + '-' + '01'
        dateList = pd.date_range(start=start_date, end=end_date).map(lambda d: str(d).split()[0]).tolist()
        for i in range(0, int(len(dateList) * 0.15)):
            del dateList[random.randrange(len(dateList))]

    work_time = {}

    for date in dateList:
        minuts = random.randrange(60)
        minuts = str(minuts) if minuts > 9 else '0' + str(minuts)
        time = '0' + str(random.randrange(max_value)) + ':' + minuts + ':00'
        work_time[date] = time

    return work_time    


try:
    file_read = open("/run/secrets/db_root_password", "r")
    password = file_read.read().rstrip()
    print("\nFile opened!")
    file_read.close()

    cnx = create_connection("db", 
                            "root", 
                            password, 
                            "pomodoro")

    cursor = cnx.cursor()

    query = ("DELETE FROM `WorkTime`")
    cursor.execute(query)

    query = ("DELETE FROM `BreakTime`")
    cursor.execute(query)

    query = ("SELECT id, login FROM Users")
    cursor.execute(query)
    users = cursor.fetchall()

    add_workTime = ("INSERT INTO `WorkTime` "
                    "(User_id, Date, Time) "
                    "VALUES (%(id)s, %(date)s, %(time)s)")

    add_breakTime = ("INSERT INTO `BreakTime` "
                    "(User_id, Date, Time) "
                    "VALUES (%(id)s, %(date)s, %(time)s)")

    for user in users:
        work_time_dic = generate_time()
        for (d, t) in work_time_dic.items():
            cursor.execute(add_workTime, {'id': str(user[0]), 'date': d, 'time': t})
        
        work_time_dic = generate_time(5, list(work_time_dic.keys()))
        for (d, t) in work_time_dic.items():
            cursor.execute(add_breakTime, {'id': str(user[0]), 'date': d, 'time': t})

    cnx.commit()

    cursor.close()
    cnx.close()
except:
    print("\nSomething go wrong!")
