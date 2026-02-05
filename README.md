# Riverside Guesthouse CMS (Laravel 12)

A Blade-only, CMS-driven guesthouse marketing site with an admin panel, enquiries inbox, OTA redirect support, and direct booking foundations.

## Requirements

- PHP 8.2+
- MySQL 8+
- Composer
- Node.js 18+

## Local Setup

1. Install dependencies

```bash
composer install
npm install
```

2. Configure environment

```bash
cp .env.example .env
php artisan key:generate
```

3. Configure database in `.env` and run migrations + seeders

```bash
php artisan migrate
php artisan db:seed
```

4. Storage symlink for uploads

```bash
php artisan storage:link
```

5. Build assets

```bash
npm run build
```

6. Start the server

```bash
php artisan serve
```

### Default Admin Login

- Email: `admin@riversideguesthouse.co.za`
- Password: `password123`

## CMS Overview

### Settings

Admin: `Admin > Settings`

Edit site name, logo, favicon, contact details, booking mode, OTA links, SEO defaults, GA4/GTM IDs, and policies.

### Pages & Sections

Admin: `Admin > Pages`

Each page (home/about/rates/policies/contact/booking) is made of sections. Add, edit, and reorder sections. Each section uses a Blade partial in `resources/views/public/sections/`.

### Rooms

Admin: `Admin > Rooms`

Create rooms, upload images, assign amenities, and set pricing.

### Gallery

Admin: `Admin > Gallery`

Create categories and upload images.

### Rates, Attractions, Testimonials

Admin modules provide CRUD for each.

### Enquiries + OTA Bookings

- Enquiries: `Admin > Enquiries`
- OTA Bookings: `Admin > OTA Bookings`

Export CSV for reporting.

### Blog

Admin: `Admin > Blog` and `Admin > Blog Categories`

## Booking Modes

Configure in Settings:

- `OTA_REDIRECT`: Book Now buttons go to Booking.com/Airbnb URLs.
- `DIRECT_BOOKING`: Shows internal booking form.
- `HYBRID`: Shows both direct and OTA CTAs.

OTA booking references can be logged via the Booking page.

## Deployment Notes (Shared Hosting)

1. Point your domain to the `public/` directory.
2. Upload files and run:

```bash
php artisan migrate --force
php artisan db:seed --force
php artisan storage:link
```

3. Set `APP_ENV=production`, `APP_DEBUG=false`.
4. Configure mail settings in `.env` (SMTP recommended).
5. Build front-end assets locally and upload `public/build`.

## How to Update Content (Mini Guide)

1. **Edit text/sections**
   - Go to `Admin > Pages`
   - Click `Edit` on a page
   - Add or edit sections and adjust the order

2. **Update images**
   - Rooms: `Admin > Rooms` and upload images
   - Gallery: `Admin > Gallery` and upload images

3. **Edit rates/policies**
   - Rates: `Admin > Rates`
   - Policies: Edit the Policies page section content

4. **Change booking mode**
   - Go to `Admin > Settings` and set `booking_mode`

5. **Manage enquiries**
   - Review and update status in `Admin > Enquiries`

## Notes

- All uploads use the `public` disk. Ensure `storage:link` is set.
- Enquiry emails go to the site email configured in Settings.
- Internal analytics are captured via the `analytics_events` table.
- Auth is implemented with a lightweight login controller and Blade view. If you prefer Laravel Breeze, you can install it and swap in the Breeze auth routes/views.
- Payment gateways are stubbed. Configure your provider credentials in `.env` and extend the gateway classes in `app/Services/Payments` for live payments.
