@echo off
:main
set jinchengshuliang=0
set jinchengshuliangxiaxian=2
for /f %%i in ('tasklist /nh^|findstr /i /s /e:"php-cgi.exe"') do set /a jinchengshuliang+=1

if %jinchengshuliang% lss %jinchengshuliangxiaxian% (   
goto youwenti
) else (
goto meiwenti
)  

:youwenti
echo Process lost, now add 5 processes
RunHiddenConsole.exe  php\php-cgi.exe -b 127.0.0.1:9000 -c php\php.ini
RunHiddenConsole.exe  php\php-cgi.exe -b 127.0.0.1:9000 -c php\php.ini
RunHiddenConsole.exe  php\php-cgi.exe -b 127.0.0.1:9000 -c php\php.ini
RunHiddenConsole.exe  php\php-cgi.exe -b 127.0.0.1:9000 -c php\php.ini
RunHiddenConsole.exe  php\php-cgi.exe -b 127.0.0.1:9000 -c php\php.ini
ping 127.1 -n 8
goto main

:meiwenti
echo In normal operation!
ping 127.1 -n 8
goto main