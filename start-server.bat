@echo off
cd /d "%~dp0"
set "PATH=%ProgramFiles%\nodejs;%PATH%"
where npm >nul 2>nul
if errorlevel 1 (
  echo Node.js is not installed. Please install Node.js LTS from https://nodejs.org/ and try again.
  exit /b 1
)
npm install
npm start
