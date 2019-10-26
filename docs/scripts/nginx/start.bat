@echo off

start E:\nginx\nginx.exe
start E:\nginx\php\php-cgi.exe -b 127.0.0.1:9000 -c E:\nginx\php\php.ini

@echo "Starting nginx"
@echo .
@echo ..
@echo ...
ping 127.0.0.1 > NULL

exit