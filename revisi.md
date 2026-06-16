# SYSTEM SPECIFICATION & PROMPT BLUEPRINT: SMART PRESENSI GURU

This document serves as a comprehensive system specification for an AI Developer to understand and build a School Attendance Web Application. The system integrates on-site QR Code Scanning with a Remote Self-Service Leave Management system for Teachers.

---

## 🤖 1. SYSTEM PROMPT FOR AI DEVELOPER (Context Initialization)
*Paste this prompt to another AI to jumpstart development:*
> "You are an expert full-stack web developer specializing in Laravel. Build a School Attendance System for Teachers with 3 Roles (Admin, Teacher, Principal). The system must handle on-site QR Code scanning via webcam (decoding encrypted NIP/IDs) and cross-reference it with a remote self-service leave application table to prevent double-logging and handle absences automatically. Follow the database schema and business rules provided below."

---

## 📊 2. SYSTEM ARCHITECTURE & USER ROLES

The application segregates permissions using Role-Based Access Control (RBAC) via middleware:

### A. ADMIN (Technical Operator)
*   **Data Master:** CRUD operations for Teacher accounts (Generates random unique tokens and credentials).
*   **Card Issuer:** Triggers front-end layout rendering with QR Codes (encapsulating the encrypted Teacher ID) for physical PVC ID Card printing.
*   **System Overrides:** Manages manual corrections for unforeseen technical glitches.

### B. TEACHER (The Subject)
*   **On-Site Check-In:** Presents physical QR ID Card to the on-site camera terminal.
*   **Remote Self-Service:** Logs into the mobile-responsive web app from home to submit Leave Requests (Sakit, Izin, Cuti, Dinas Luar) and uploads PDF/JPEG evidence.

### C. PRINCIPAL / KEPSEK (The Decision Maker)
*   **Approval Dashboard:** Reviews pending Leave Requests from Teachers, executing either `Approve` or `Reject`.
*   **Live Monitoring:** Observes real-time check-in feeds and analytics graphs.
*   **Reporting:** Exports monthly consolidated attendance sheets to PDF/Excel formats.

---

## 🗂️ 3. CORE DATABASE RELATIONSHIPS (Minimalist Schema)

### `guru` (Master Table)
*   `id_guru` (PK, BigInt)
*   `nip` (String, Unique)
*   `nama_guru` (String)
*   `password` (Hash)
*   `token_qr` (String, Unique - *Encrypted value embedded inside the QR Code*)

### `pengajuan_izin` (Transaction Leave Table)
*   `id_izin` (PK, BigInt)
*   `id_guru` (FK -> `guru.id_guru`)
*   `jenis_izin` (Enum: 'Sakit', 'Izin', 'Cuti', 'Dinas Luar')
*   `tanggal_mulai` (Date)
*   `tanggal_selesai` (Date)
*   `bukti_dokumen` (String - FilePath)
*   `status_persetujuan` (Enum: 'Pending', 'Disetujui', 'Ditolak')

### `presensi_harian` (Consolidated Attendance Log)
*   `id_presensi` (PK, BigInt)
*   `tanggal` (Date)
*   `id_guru` (FK -> `guru.id_guru`)
*   `jam_masuk` (Time, Nullable)
*   `status` (Enum: 'Belum Hadir', 'Hadir', 'Sakit', 'Izin', 'Cuti', 'Dinas Luar', 'Alfa')
*   `metode_input` (Enum: 'Scan Alat', 'Form Web', 'Sistem Otomatis')

---

## 🔄 4. CORE LOGICAL WORKFLOWS (Business Rules)

### Workflow A: The Link Between Pre-emptive Leave & On-Site Scanning