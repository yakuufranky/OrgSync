@echo off
setlocal
cd /d "%~dp0"
where php >nul 2>nul
if errorlevel 1 (
  echo PHP was not found.
  echo Install XAMPP from https://www.apachefriends.org/ then use its Shell,
  echo or add PHP to your Windows PATH.
  echo.
  pause
  exit /b 1
)
start "OrgSync Website" http://127.0.0.1:8000/
php -S 127.0.0.1:8000 -t public
pause
