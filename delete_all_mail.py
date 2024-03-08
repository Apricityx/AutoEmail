import poplib
# base64解码
# 解码邮件信息
from email.parser import Parser

from app import server_address
from app import user
from app import user_password

server_port = 110
print("已导入:", server_address, server_port, user, user_password)
# 解析邮件主题
# 此脚本实现pop3协议删除所有邮件
# 解析发件人详情，名称及地址

# 连接到POP3服务器:
server = poplib.POP3(server_address, server_port)
# 身份认证:
server.user(user)
server.pass_(user_password)
# stat()返回邮件数量和占用空间:
print('Messages: %s. Size: %s' % server.stat())
# list()返回所有邮件的编号:
resp, mails, octets = server.list()
# 可以查看返回的列表类似[b'1 82923', b'2 2184', ...]
print(mails)
# 获取最新一封邮件, 注意索引号从1开始:
index = len(mails)
# retr()获取指定邮件的内容,索引号从1开始:
# 用红色文字警告用户
print('\033[0;31;1m是否删除所有邮件\033[0m', '\033[0;31;1m邮件总数：', index, '\033[0m', '\033[0;31;1m(Y/N)\033[0m')
while True:
    check = input()
    if check == 'N':
        print('取消删除邮件')
        server.quit()
        exit()
    elif check == 'Y':
        print('开始删除邮件')
        break
    else:
        print('输入错误，请重新输入')
for i in range(index, 0, -1):
    resp, lines, octets = server.retr(i)
    # lines存储了邮件的原始文本的每一行,
    # 可以获得整个邮件的原始文本:
    try:
        msg_content = b'\r\n'.join(lines).decode('utf-8')
    except UnicodeDecodeError:
        try:
            print('解码失败，尝试gbk解码')
            msg_content = b'\r\n'.join(lines).decode('gbk')
        except UnicodeDecodeError:
            try:
                print('解码失败，尝试gb18030解码')
                msg_content = b'\r\n'.join(lines).decode('gb18030')
            except UnicodeDecodeError:
                print('解码失败，尝试iso-8859-1解码')
                msg_content = b'\r\n'.join(lines).decode('iso-8859-1')
    # 稍后解析出邮件:
    msg = Parser().parsestr(msg_content)
    # 可以根据邮件索引号直接从服务器删除邮件:
    server.dele(i)
    print('删除邮件成功')
print('完全删除邮件！')
# 删除文件last_read_mail.txt
with open('last_read_mail.txt', 'w') as f:
    f.write('')
server.quit()
