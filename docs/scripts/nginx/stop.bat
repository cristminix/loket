@echo off
@echo "Stoping nginx"
taskkill /f /im nginx.exe
taskkill /f /im php-cgi.exe
