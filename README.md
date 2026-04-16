# 🧅 OnionTrade Pro

<div align="center">

![OnionTrade Pro Logo](public/brand/oniontrade-icon-128.png)

### **Professional Market Intelligence & Price Arbitrage Platform**
*The definitive tool for tracking and analyzing agricultural market trends.*

[![Laravel Version](https://img.shields.io/badge/Laravel-11.x-F05340?style=for-the-badge&logo=laravel)](https://laravel.com)
[![PHP Version](https://img.shields.io/badge/PHP-8.3-777BB4?style=for-the-badge&logo=php)](https://php.net)
[![TailwindCSS](https://img.shields.io/badge/Tailwind-CSS-38B2AC?style=for-the-badge&logo=tailwind-css)](https://tailwindcss.com)
[![License](https://img.shields.io/badge/License-MIT-green?style=for-the-badge)](LICENSE)
[![Status](https://img.shields.io/badge/Status-Production--Ready-success?style=for-the-badge)]()

</div>

---

## 🚀 Project Overview
**OnionTrade Pro** is a production-ready intelligence platform built to bridge the information gap in agricultural trading. By providing real-time price recording, multi-market comparisons, and predictive analytics, it empowers traders and field agents to make data-backed arbitrage decisions.

> [!TIP]
> **Arbitrage Insight:** Use the **Compare** module to visualize price disparities across different regional divisions in real-time.

---

## ✨ Core Features

| Feature | Description | Status |
| :--- | :--- | :---: |
| **📊 Smart Dashboard** | Real-time tickers for average prices and market trend indicators. | ✅ |
| **🏪 Market Intelligence** | Comprehensive market profiles with secure PDF document management. | ✅ |
| **💰 Price Dynamics** | Granular price recording with date-range filtering and historical analysis. | ✅ |
| **📈 Trend Analytics** | Visualized price trajectories and forecast-oriented insight cards. | ✅ |
| **👥 Agent Management** | Role-based member assignment for specialized regional coverage. | ✅ |

---

## 🛠 Tech Stack

- **Backend:** **Laravel 11** (Utilizing PHP 8.3 features like Readonly properties and Typed constants)
- **Frontend:** **Tailwind CSS** & **Alpine.js** for a reactive, low-overhead UI
- **Build System:** **Vite 8** for lightning-fast asset compilation
- **Architecture:** Repository-style Controller logic with Eager Loading (SQL optimization)
- **Security:** Full CSRF protection, secure file hashing, and middleware-guarded routes

---
## 📡 API-style Endpoint Table

Route list converted into a clean table with:
- Method
- URI
- Route name
- Controller action
- Access (Auth/Guest)

| Method | URI | Route Name | Controller Action | Access |
| :---: | :--- | :--- | :--- | :---: |
| GET | `/` | `dashboard` | `DashboardController@index` | Auth |
| GET | `/analytics` | `analytics.index` | `AnalyticsController@index` | Auth |
| GET | `/compare` | `compare.index` | `CompareController@index` | Auth |
| GET | `/documents/download/{id}` | `documents.download` | `MarketController@downloadDocument` | Auth |
| DELETE | `/documents/{id}` | `documents.destroy` | `MarketController@destroyDocument` | Auth |
| GET | `/forgot-password` | `password.request` | `AuthController@showForgotPassword` | Guest |
| POST | `/forgot-password` | `password.email` | `AuthController@sendResetLink` | Guest |
| GET | `/login` | `login` | `AuthController@showLogin` | Guest |
| POST | `/login` | `login.post` | `AuthController@login` | Guest |
| POST | `/logout` | `logout` | `AuthController@logout` | Auth |
| GET | `/markets` | `markets.index` | `MarketController@index` | Auth |
| POST | `/markets` | `markets.store` | `MarketController@store` | Auth |
| GET | `/markets/create` | `markets.create` | `MarketController@create` | Auth |
| GET | `/markets/{market}` | `markets.show` | `MarketController@show` | Auth |
| PUT | `/markets/{market}` | `markets.update` | `MarketController@update` | Auth |
| DELETE | `/markets/{market}` | `markets.destroy` | `MarketController@destroy` | Auth |
| POST | `/markets/{market}/documents` | `markets.documents.store` | `MarketController@storeDocument` | Auth |
| GET | `/markets/{market}/edit` | `markets.edit` | `MarketController@edit` | Auth |
| GET | `/members` | `members.index` | `MemberController@index` | Auth |
| POST | `/members` | `members.store` | `MemberController@store` | Auth |
| GET | `/members/create` | `members.create` | `MemberController@create` | Auth |
| PUT/PATCH | `/members/{member}` | `members.update` | `MemberController@update` | Auth |
| DELETE | `/members/{member}` | `members.destroy` | `MemberController@destroy` | Auth |
| GET | `/members/{member}/edit` | `members.edit` | `MemberController@edit` | Auth |
| GET | `/plans` | `plans` | `Closure (web.php)` | Auth |
| GET | `/prices` | `prices.index` | `PriceController@index` | Auth |
| POST | `/prices` | `prices.store` | `PriceController@store` | Auth |
| GET | `/prices/create` | `prices.create` | `PriceController@create` | Auth |
| PUT/PATCH | `/prices/{price}` | `prices.update` | `PriceController@update` | Auth |
| DELETE | `/prices/{price}` | `prices.destroy` | `PriceController@destroy` | Auth |
| GET | `/prices/{price}/edit` | `prices.edit` | `PriceController@edit` | Auth |
| GET | `/register` | `register` | `AuthController@showRegister` | Guest |
| POST | `/register` | `register.post` | `AuthController@register` | Guest |
| POST | `/reset-password` | `password.update` | `AuthController@resetPassword` | Guest |
| GET | `/reset-password/{token}` | `password.reset` | `AuthController@showResetPassword` | Guest |
| GET | `/settings` | `settings` | `Closure (web.php)` | Auth |

---

## 🖼️ Screenshots (New UI)

### Dashboard
![Dashboard](docs/screenshots/01-dashboard.png)

### Login
![Login](docs/screenshots/02-login.png)

### Markets
![Markets](docs/screenshots/03-markets.png)

### Prices
![Prices](docs/screenshots/04-prices.png)

### Compare
![Compare](docs/screenshots/05-compare.png)

### Analytics
![Analytics](docs/screenshots/06-analytics.png)

---
## ⚙️ Setup & Installation

Follow these steps to get your local development environment running:

1. **Clone & Dependencies**
   ```bash
   git clone <your-repo-url>
   cd onion-trading-app
   composer install && npm install
   ```

2. **Environment Configuration**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   *Note: Update your `.env` with your local database credentials.*

3. **Database & Storage**
   ```bash
   php artisan migrate
   php artisan storage:link
   ```

4. **Launch**
   ```bash
   npm run build
   php artisan serve
   ```

---

## 👨‍💻 About the Developer

I am **Pial Mahmud**, a Full-Stack Software Engineer and Social Activist. I hold a **BSc in Computer Science and Engineering** from **Daffodil International University**. My work focuses on building digital solutions that solve real-world economic and environmental challenges.

### 🏛️ Leadership & Impact
- **Convener:** Private University Students Alliance Goalundo (**PUSAG**).
- **Activist:** **Ekoj Jagorone**, leading environmental conservation and river protection initiatives.

---
### 📬 Connect With Me

[![GitHub](https://img.shields.io/badge/GitHub-181717?style=flat-square&logo=github&logoColor=white)](https://github.com/mahmudpial)
[![LinkedIn](https://img.shields.io/badge/LinkedIn-0A66C2?style=flat-square&logo=linkedin&logoColor=white)](https://linkedin.com/in/pialmahmud)
[![Portfolio](https://img.shields.io/badge/Portfolio-000000?style=flat-square&logo=vercel&logoColor=white)](https://portfolio-and-blog-app-fontend.vercel.app/)

---
<div align="center">
  Developed with focus and precision by <b>Pial Mahmud</b>
</div>
