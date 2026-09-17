@echo off
cd /d "%~dp0"
echo Starting Maha Construction Laravel development server...
echo URL: http://localhost:8000
C:\xampp\php\php.exe artisan serve --host=127.0.0.1 --port=8000
pause
