import smtplib
from email.mime.text import MIMEText
from email.utils import formataddr
import poplib

# base64解码
import base64

# 解码邮件信息
from email.parser import Parser

# 解析邮件主题
from email.header import decode_header

# 解析发件人详情，名称及地址
from email.utils import parseaddr

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


# send_mail('已收到附件，如需更改请再次提交', '附件已成功提交！')


def receive_mail():  # 此函数读取的最新一封邮件的元信息
    attachment_dir = "./files"

    user_account = 'mail@apricityx.top'
    password = '520520MCt'

    # 邮件服务器地址,以下为网易邮箱
    pop3_server = 'mail.apricityx.top'

    # 开始连接到服务器
    server = poplib.POP3(pop3_server)

    # 打开或者关闭调试信息，为打开，会在控制台打印客户端与服务器的交互信息
    server.set_debuglevel(1)

    # 打印POP3服务器的欢迎文字，验证是否正确连接到了邮件服务器
    print(server.getwelcome().decode('utf8'))

    # 开始进行身份验证
    server.user(user_account)
    server.pass_(password)

    # 返回邮件总数目和占用服务器的空间大小（字节数）， 通过stat()方法即可
    email_num, email_size = server.stat()
    print("消息的数量: {0}, 消息的总大小: {1}".format(email_num, email_size))

    # 使用list()返回所有邮件的编号，默认为字节类型的串
    rsp, msg_list, rsp_siz = server.list()
    print("服务器的响应: {0},\n消息列表： {1},\n返回消息的大小： {2}".format(rsp, msg_list, rsp_siz))

    print('邮件总数： {}'.format(len(msg_list)))

    # 下面单纯获取最新的一封邮件
    total_mail_numbers = len(msg_list)
    print('邮件列表：', msg_list)
    rsp, msglines, msgsiz = server.retr(len(msg_list))
    # print("服务器的响应: {0},\n原始邮件内容： {1},\n该封邮件所占字节大小： {2}".format(rsp, msglines, msgsiz))

    msg_content = b'\r\n'.join(msglines).decode('gbk')

    msg = Parser().parsestr(text=msg_content)
    server.close()
    return msg

    # 关闭与服务器的连接，释放资源


content_raw = receive_mail()


def parser_content(msg):
    content = msg.get_payload()

    # 文本信息
    content_charset = content[0].get_content_charset()  # 获取编码格式
    text = content[0].as_string().split('base64')[-1]
    text_content = base64.b64decode(text).decode(content_charset)  # base64解码

    # 添加了HTML代码的信息
    content_charset = content[1].get_content_charset()
    text = content[1].as_string().split('base64')[-1]
    html_content = base64.b64decode(text).decode(content_charset)

    print('文本信息: {0}\n添加了HTML代码的信息: {1}'.format(text_content, html_content))


parser_content(content_raw)
