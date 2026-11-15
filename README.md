# ប្រព័ន្ធគ្រប់គ្រងឯកសារ និង Portfolio ឌីជីថលសម្រាប់គ្រូបង្រៀន
### Teacher Digital Document & Portfolio Management Web Application

ប្រព័ន្ធនេះត្រូវបានបង្កើតឡើងសម្រាប់លោកគ្រូ-អ្នកគ្រូ ដើម្បីផ្ទុក និងគ្រប់គ្រងឯកសាររដ្ឋបាល កម្មវិធីសិក្សា កិច្ចតែងការបង្រៀន ស្លាយ និងស្នាដៃវិជ្ជាជីវៈ (Portfolio) សម្រាប់ទុកជាភ័ស្តុតាងការងារ និងដាក់ពាក្យស្នើសុំការងារផ្សេងៗ។

---

## 🛠 បច្ចេកវិទ្យាដែលប្រើប្រាស់ (Tech Stack)
- **Backend:** Laravel (PHP 8.2+)
- **Frontend:** Blade Templates, Vanilla JavaScript, Tailwind CSS, FontAwesome Icons
- **Typography:** Khmer Fonts (`Khmer OS Muol Light`, `Khmer OS Siemreap`, Google Fonts)
- **Database:** MySQL / SQLite
- **Deployment Ready:** Vercel (Serverless PHP)

---

## 🚀 របៀបតម្លើង និងដំណើរការលើម៉ាស៊ីនផ្ទាល់ខ្លួន (Local Setup)

### ១. ដំឡើង Composer Packages
```bash
composer install
```

### ២. បង្កើតឯកសារ `.env`
ចម្លងឯកសារ `.env.example` ទៅជា `.env`:
```bash
cp .env.example .env
php artisan key:generate
```

### ៣. បង្កើតតារាង Database និង Seed ទិន្នន័យ
```bash
php artisan migrate --seed
```

### ៤. បង្កើត Storage Symlink
```bash
php artisan storage:link
```

### ៥. បើកដំណើរការ Local Server
```bash
php artisan serve
```
បើកកម្មវិធីរុករក (Browser) ទៅកាន់ `http://127.0.0.1:8000`។

---

## ☁️ ការដាក់ឱ្យដំណើរការលើ Vercel (Deploy to Vercel)

គម្រោងនេះបានរៀបចំឯកសារ `vercel.json` និង `api/index.php` រួចជាស្រេចសម្រាប់ដំណើរការលើ Vercel Serverless Functions។

### ជំហាន Deploy:
1. Push កូដទៅកាន់ GitHub repository របស់អ្នក (`https://github.com/Hoeun-Minea/Portfolio.git`)។
2. ចូលទៅកាន់ [vercel.com](https://vercel.com) រួចចុច **"Add New Project"**។
3. ជ្រើសរើសយក Repository `Portfolio` ពី GitHub របស់អ្នក។
4. នៅក្នុងផ្ទាំង **Environment Variables** លើ Vercel សូមបន្ថែមតម្លៃដូចខាងក្រោម៖
   - `APP_NAME` : `Teacher Portfolio`
   - `APP_ENV` : `production`
   - `APP_KEY` : *(យកតម្លៃចេញពីឯកសារ `.env` របស់អ្នក)*
   - `APP_DEBUG` : `false`
   - `APP_URL` : *(URL របស់ Vercel ក្រោយ Deploy)*
   - `DB_CONNECTION` : `mysql` *(ឬសេវាកម្ម Cloud Database ដូចជា PlanetScale, TiDB, Supabase, Neon)*
   - `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD` : *(ព័ត៌មាន Database របស់អ្នក)*
5. ចុចប៊ូតុង **Deploy** ជាការស្រេច!

---

## 👤 អ្នកអភិវឌ្ឍន៍
- **គម្រោង:** Teacher Digital Portfolio Hub
- **GitHub:** [https://github.com/Hoeun-Minea/Portfolio.git](https://github.com/Hoeun-Minea/Portfolio.git)
