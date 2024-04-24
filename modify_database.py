import pandas as pd
import pymysql as mysql

data = pd.read_csv(r'test_data.csv', sep=',', header='infer', usecols=[0, 1]).values.tolist()


# print(data)


# 读取了所有学号和姓名的数据

class DB:
    f = open('database_passwd', 'r')
    passwd = f.readline()
    db = mysql.connect(host='pve.zwtsvx.xyz', port=1128, user='root', password=passwd)
    print("Database connected successfully.")
    cursor = db.cursor()

    def __init__(self):
        self.create_database()

    def create_database(self):
        self.cursor.execute("CREATE DATABASE IF NOT EXISTS autoemail")
        self.cursor.execute("USE autoemail")
        if (self.cursor.execute(
                "CREATE TABLE IF NOT EXISTS students (student_id LONG, name VARCHAR(255),passwd VARCHAR(255))")
        ):
            print("Database created successfully.")
        else:
            print("DB exist, Skip create database")
        return True

    def reset_db(self):
        self.cursor.execute("DROP DATABASE autoemail")
        self.create_database()
        print("Database reset successfully.")
        for i in data:
            self.cursor.execute("INSERT INTO students (student_id, name, passwd) VALUES (%s, %s, %s)",
                                (i[0], i[1], str(i[0])[-6:]))
        self.db.commit()
        print("Students table initialized successfully.")
        return True

    def create_course(self, homework_name, students):
        self.cursor.execute(
            "CREATE TABLE IF NOT EXISTS " + homework_name + " (student_id LONG,student_name VARCHAR(255), if_finish INT,submit_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP )")
        for student in students:
            self.cursor.execute(
                "INSERT INTO " + homework_name + " (student_id, student_name, if_finish) VALUES (%s, %s, %s)",
                (student[0], student[1], 0))
        self.db.commit()
        print("Table created successfully.")
        return True


database = DB()
# option = input("Choose an option: 1. Reset database 2. Create a course\n")
# if option == '1':
#     reset_or_not = input("Are you sure to reset the database? (Y/N)\n")
#     if reset_or_not == 'Y':
#         database.reset_db()
#     else:
#         print("Operation cancelled.")
# elif option == '2':
#     homework_name = input("Enter the name of the homework: ")
#     database.create_course(homework_name, data)

database.reset_db()