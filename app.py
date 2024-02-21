import smtplib
from email.mime.text import MIMEText
from email.utils import formataddr

server_address = 'mail.apricityx.top'
server_port = 25
user = 'mail@apricityx.top'
user_password = '520520MCt'
recipient_address = 'apricityx@qq.com'


def send_mail(text, subject):
    msg = MIMEText(text, 'plain', 'utf-8')
    msg['From'] = formataddr(("软工中外3,4班邮件收发系统", user))  # 括号里的对应发件人邮箱昵称、发件人邮箱账号
    msg['To'] = formataddr((recipient_address, recipient_address))  # 括号里的对应收件人邮箱昵称、收件人邮箱账号
    msg['Subject'] = subject  # 邮件的主题，也可以说是标题
    # 发送非加密邮件
    server = smtplib.SMTP(server_address, server_port)  # 发件人邮箱中的SMTP服务器，端口是25
    server.login(user, user_password)  # 括号中对应的是发件人邮箱账号、邮箱密码
    server.sendmail(user, [recipient_address, ], msg.as_string())  # 括号中对应的是发件人邮箱账号、收件人邮箱账号、发送邮件
    server.quit()  # 关闭连接


send_mail('已收到附件，如需更改请再次提交', '附件已成功提交！')


def receive_mail():
    attachment_dir = "./files"
