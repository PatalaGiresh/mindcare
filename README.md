# MindCare — Mental Health & Therapy Platform

MindCare is a modern, comprehensive mental health platform designed to connect patients with therapists, track emotional well-being, and facilitate seamless therapy sessions. Built with Laravel and a focus on premium user experience.

## ✨ Key Features

### 👤 For Patients
- **Mood Tracker:** Daily emotional logging with visual history and analytics.
- **Therapist Discovery:** Browse qualified therapists by specialty and ratings.
- **Session Booking:** Secure booking flow with status tracking (Pending, Confirmed, Completed).
- **Messaging System:** Direct communication with your assigned therapist.
- **Resource Library:** Access to mental health articles and crisis support information.

### 🩺 For Therapists
- **Session Management:** Intuitive dashboard to confirm, reject, or manage therapy sessions.
- **Virtual Integration:** Easily share Google Meet or Zoom links with patients.
- **Patient Overview:** Quick access to patient session history and basic info.
- **Performance Stats:** Track completed sessions and active patient counts.

### 🌐 Global Features
- **Multi-language Support:** Full localization in **English** and **Hindi**.
- **Premium UI:** Custom-built design system with smooth animations, dark mode support, and responsive layouts.
- **Admin Dashboard:** Total platform oversight including user management and system stats.

## 🛠 Tech Stack
- **Backend:** Laravel 11
- **Frontend:** Blade, Vanilla CSS (Design Tokens System), minimal JavaScript.
- **Database:** MySQL
- **Localization:** Laravel Lang (EN, HI)

## 🚀 Quick Start

### 1. Prerequisites
- PHP 8.2+
- Composer
- Node.js & NPM
- MySQL

### 2. Installation
```bash
# Clone the repository
git clone https://github.com/PatalaGiresh/mindcare.git

# Install dependencies
composer install
npm install

# Setup environment
cp .env.example .env
php artisan key:generate

# Migration & Seeding
php artisan migrate --seed
```

### 3. Run Locally
```bash
php artisan serve
npm run dev
```

## 🎨 Design Principles
MindCare follows a **Nature-Inspired Aesthetic** using:
- **Teal & Lavender Palette:** For a calming, professional atmosphere.
- **Glassmorphism:** Subtle background blurs and elevations.
- **Motion Design:** CSS-only animations for a lightweight, premium feel.

## 📄 License
The MindCare platform is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
