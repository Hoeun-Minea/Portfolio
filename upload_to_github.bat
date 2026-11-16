@echo off
title Push Code to GitHub (Teacher Portfolio)
echo ========================================================
echo   UPLOAD CODE TO GITHUB: Hoeun-Minea/Portfolio
echo ========================================================
echo.
echo Performing git push...
git push -u origin main
echo.
if %errorlevel% equ 0 (
    echo ========================================================
    echo   SUCCESS! ALL FILES HAVE BEEN UPLOADED TO GITHUB!
    echo   Vercel is now deploying your portfolio automatically.
    echo ========================================================
) else (
    echo ========================================================
    echo   Push failed. Please check your GitHub login and retry.
    echo ========================================================
)
echo.
pause
