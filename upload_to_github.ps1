Write-Host "========================================================" -ForegroundColor Cyan
Write-Host "  UPLOAD CODE TO GITHUB: Hoeun-Minea/Portfolio" -ForegroundColor Cyan
Write-Host "========================================================" -ForegroundColor Cyan
Write-Host ""
git push -u origin main
if ($LASTEXITCODE -eq 0) {
    Write-Host ""
    Write-Host "SUCCESS! All files uploaded to GitHub successfully!" -ForegroundColor Green
    Write-Host "Vercel is now deploying your portfolio automatically." -ForegroundColor Green
} else {
    Write-Host ""
    Write-Host "Push failed. Please check your GitHub authorization." -ForegroundColor Red
}
Write-Host ""
Read-Host "Press Enter to exit..."
