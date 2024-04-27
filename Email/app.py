import smtplib
from email.mime.text import MIMEText
from email.utils import formataddr
import poplib
import os
# base64解码
import base64
import time
# 解码邮件信息
from email.parser import Parser

# 解析邮件主题
from email.header import decode_header

# 解析发件人详情，名称及地址
from email.utils import parseaddr

# 此处为示例地址，可以填写为自己的邮件服务器地址
# 邮件服务器地址
server_address = 'mail.apricityx.top'
# 邮件服务器端口
server_port = 587
# 发件人邮箱
user = 'mail@apricityx.top'
# 发件人邮箱密码
user_password = '520520MCt'
# 附件存储路径
path = '/var/www/html/homeworksubmit'


# 如果是import进来的，不执行以下代码
def send_mail(recipient_address, text, subject):
    msg = MIMEText(text, 'plain', 'utf-8')
    blacklist = ['mailer-daemon', 'postmaster', 'abuse']
    if 'mailer-daemon' in recipient_address:
        print("\033[0;31;1m不回复自动邮件\033[0m")
        return
    for obj in blacklist:
        if obj in recipient_address:
            print("\033[0;31;1m不回复黑名单邮件\033[0m")
            return
    msg['From'] = formataddr(("邮件收发系统", user))  # 括号里的对应发件人邮箱昵称、发件人邮箱账号
    msg['To'] = formataddr((recipient_address, recipient_address))  # 括号里的对应收件人邮箱昵称、收件人邮箱账号
    msg['Subject'] = subject  # 邮件的主题，也可以说是标题
    # 发送加密邮件
    server = smtplib.SMTP(server_address, server_port)  # 发件人邮箱中的SMTP服务器
    server.login(user, user_password)  # 括号中对应的是发件人邮箱账号、邮箱密码
    server.sendmail(user, [recipient_address, ], msg.as_string())  # 括号中对应的是发件人邮箱账号、收件人邮箱账号、发送邮件
    print("\033[0;33;1m邮件发送成功！\033[0m")
    server.quit()  # 关闭连接


# send_mail('已收到附件，如需更改请再次提交', '附件已成功提交！')

def save_files():
    last_read_mail = ''


def receive_mail():  # 此函数读取的最新一封邮件的元信息
    debug = False
    try:
        # 读取上次读取的邮件
        with open('last_read_mail.txt', 'r') as f:
            last_read_mail = f.read()
        if_last_read_mail_exist = True
        if not bool(last_read_mail):  # 如果上次读取的邮件为空
            print('已检测到文件，但上次读取的邮件为空')
            last_read_mail = ''
            if_last_read_mail_exist = False
    except FileNotFoundError:
        print('未找到上次读取的邮件')
        last_read_mail = ''
        if_last_read_mail_exist = False
    user_account = 'mail@apricityx.top'
    password = '520520MCt'

    # 邮件服务器地址
    pop3_server = 'mail.apricityx.top'

    # 开始连接到服务器
    server = poplib.POP3(pop3_server)

    # 打开或者关闭调试信息，为打开，会在控制台打印客户端与服务器的交互信息
    server.set_debuglevel(0)

    # 打印POP3服务器的欢迎文字，验证是否正确连接到了邮件服务器
    # print(server.getwelcome().decode('utf8'))

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
    total_mail_numbers = len(msg_list)
    # print('邮件列表：', msg_list)
    msgs = []
    # 将mail_list转向
    # 如果没有mail，则退出
    if len(msg_list) == 0:
        print('没有邮件')
        server.quit()
        return
    mail_list = msg_list[::-1]
    print('上次读取的邮件编号：', last_read_mail)
    for index, mail in enumerate(mail_list):
        print('正在读取第{}封邮件'.format(index))
        print('读取邮件{}'.format(mail))
        if str(mail) == last_read_mail:
            print("\033[0;33;1m已读邮件已找到，共找到{}封未读邮件\033[0m".format(index))
            # 如果last_read_mail不存在，则新建文件
            with open('last_read_mail.txt', 'w') as f:
                f.write(str(mail_list[0]))
            break
        rsp, msglines, msgsiz = server.retr(total_mail_numbers - index)  # 更改括号里面的数字可以更换读取的文件序号
        # print("服务器的响应: {0},\n原始邮件内容： {1},\n该封邮件所占字节大小： {2}".format(rsp, msglines, msgsiz))
        try:
            msg_content = b'\r\n'.join(msglines).decode('gbk')
        except UnicodeError:
            try:
                print("\033[0;31;1m解码失败，尝试utf-8解码\033[0m")
                msg_content = b'\r\n'.join(msglines).decode('utf-8')
            except UnicodeError:
                try:
                    print("\033[0;31;1m解码失败，尝试gb18030解码\033[0m")
                    msg_content = b'\r\n'.join(msglines).decode('gb18030')
                except UnicodeError:
                    print("\033[0;31;1m解码失败，尝试iso-8859-1解码\033[0m")
                    msg_content = b'\r\n'.join(msglines).decode('iso-8859-1')
        msg = Parser().parsestr(text=msg_content)
        msgs.append(msg)
        result, name = get_attachments(msg)
        recipient_address = msg.get('From').split('<')[-1].split('>')[0]
        print('邮件发送者：', recipient_address)
        if result:
            print("\033[0;33;1m附件下载成功！尝试发送反馈邮件\033[0m")
            if not debug:
                send_mail(recipient_address, '已收到附件，如需更改请再次提交，已提交的附件名：{}'.format(name),
                          '附件已成功提交！')
        else:
            print("\033[0;33;1m未找到附件，尝试发送反馈邮件\033[0m")
            if not debug:
                send_mail(recipient_address, '未找到附件，请将文件附在邮件中重新提交', '未找到附件，请重新提交！')
        if index == len(mail_list) - 1:
            print("\033[0;33;1m已读邮件未找到，共找到{}封未读邮件\033[0m".format(total_mail_numbers))
            with open('last_read_mail.txt', 'w') as f:
                f.write(str(mail_list[0]))
            print('已写入最新邮件的编号')
            break
    server.close()
    print(msgs)
    return msgs

    # 关闭与服务器的连接，释放资源


def parser_content(msg):  # 此函数实现了获取邮件内容(正文)
    content = msg.get_payload()

    # 文本信息
    content_charset = content[0].get_content_charset()  # 获取编码格式
    text = content[0].as_string().split('base64')[-1]
    text_content = base64.b64decode(text).decode(content_charset)  # base64解码

    # 添加了HTML代码的信息
    content_charset = content[1].get_content_charset()
    text = content[1].as_string().split('base64')[-1]
    html_content = base64.b64decode(text).decode(content_charset)

    # print('文本信息: {0}\n添加了HTML代码的信息: {1}'.format(text_content, html_content))
    return text_content


def get_attachments(msg):  # 实现一个功能：获取邮件附件并返回是否获取成功
    ifOK = False
    filename = ''
    for part in msg.walk():
        if part.get_content_maintype() == 'multipart':  # 这里是为了跳过附件中的邮件内容
            # print('未找到附件')
            continue
        if part.get('Content-Disposition') is None:  # 这里是为了跳过没有附件的内容
            # print('未找到附件')
            continue
        filename = part.get_filename()
        # filename为=?gb18030?B?Myw0sODNrNGnLnR4dA==?=这种形式，需要解码
        if filename is not None:
            h = decode_header(filename)
            filename = h[0][0]
            code = h[0][1]
            if code is not None:
                filename = filename.decode(code)
        if filename is not None:
            print('找到附件,文件名为:', filename)
            ifOK = True
        # 若不存在目录则创建
        global path
        if not os.path.exists(path):
            os.mkdir(path)
        attachment_dir = path
        if bool(filename):
            filepath = os.path.join(attachment_dir, filename)
            with open(filepath, 'wb') as f:
                f.write(part.get_payload(decode=True))
    return [ifOK, filename]


if __name__ == '__main__':
    while 1:
        receive_mail()
        time.sleep(20)
else:
    print('variables imported successfully!')
