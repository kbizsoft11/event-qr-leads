# Event QR Leads System

A simple QR-based event lead capture system that allows visitors to scan a QR code at events or exhibitions and submit their contact details. 
Admins can manage events, view leads, filter data, and export to Excel.

---

## 🚀 Features

- Create events with details (name, description, date, location, image)
- Automatically generate QR code per event
- Public form for visitors to submit leads
- Admin dashboard
- View leads per event
- Filter leads by event
- Export leads to Excel
- Delete leads
- Event banner upload
- Pagination support

---

## 🏗 How It Works

1. Admin creates an event in the admin panel.
2. System automatically generates a QR code.
3. QR code points to the event form page.
4. Visitors scan QR and submit their details.
5. Leads are stored in the database.
6. Admin can view, filter, and export leads.

---

## 📂 Project Structure

For the Url configuration: config/app.php
For the Database configuration: config/database.php
TO create admin user need to run the script: config/create_admin.php