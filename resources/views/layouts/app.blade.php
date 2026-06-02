<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CaterConnect | Cebu Marketplace</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&family=Inter:wght@300;400;600;700&family=Playfair+Display:ital,wght@1,400;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    
    <style>
        :root {
            --primary-orange: #FF7A00;
            --orange-light: #ff9f2f;
            --deep-charcoal: #1a1a1a;
            --light-gray: #f5f5f5;
            --border-gray: #e0e0e0;
            --success-green: #27ae60;
            --error-red: #e74c3c;
            --warning-orange: #f39c12;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            overflow-x: hidden;
        }

        body { 
            background: linear-gradient(135deg, #f9f7f2 0%, #faf8f5 100%);
            font-family: 'Inter', sans-serif; 
            color: #333;
        }

        /* ===== ANIMATIONS ===== */
        @keyframes slideInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes fadeInLeft {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes pulseNotification {
            0%, 100% {
                box-shadow: 0 0 0 0 rgba(255, 122, 0, 0.7);
            }
            50% {
                box-shadow: 0 0 0 8px rgba(255, 122, 0, 0);
            }
        }

        @keyframes bounce {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-10px);
            }
        }

        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.1);
            }
        }

        /* ===== NAVBAR STYLING ===== */
        .navbar {
            background: white !important;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            padding: 12px 40px !important;
            z-index: 1030;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
            animation: slideInDown 0.6s ease-out;
            height: 75px;
            display: flex;
            align-items: center;
        }

        .text-logo {
            font-family: 'Montserrat', sans-serif;
            font-weight: 900;
            font-size: 1.35rem;
            letter-spacing: 0.5px;
            color: var(--deep-charcoal);
            text-decoration: none;
            display: flex;
            align-items: center;
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
            position: relative;
            white-space: nowrap;
            margin: 0;
            padding: 0;
        }

        .text-logo:hover {
            transform: scale(1.05);
            color: var(--deep-charcoal);
            text-decoration: none;
        }

        .text-logo span { 
            color: var(--primary-orange);
            font-weight: 900;
        }

        .navbar-brand {
            padding: 0;
            margin-right: 2rem;
            flex-shrink: 0;
        }

        .navbar-nav {
            gap: 2rem;
            align-items: center;
        }

        .nav-link {
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.95rem;
            letter-spacing: 0.3px;
            color: var(--deep-charcoal) !important;
            padding: 12px 16px !important;
            position: relative;
            transition: all 0.3s ease;
            white-space: nowrap;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--primary-orange);
            transition: width 0.3s ease;
        }

        .nav-link:hover {
            color: var(--primary-orange) !important;
        }

        .nav-link:hover::after {
            width: 100%;
        }

        .nav-link.active {
            color: var(--primary-orange) !important;
        }

        .nav-link.active::after {
            width: 100%;
        }

        /* ===== BUTTONS STYLING ===== */
        .btn-get-started {
            background: linear-gradient(135deg, var(--primary-orange), var(--orange-light));
            border: none;
            color: white;
            font-weight: 800;
            font-size: 0.9rem;
            letter-spacing: 0.6px;
            padding: 0.9rem 1.8rem !important;
            border-radius: 12px;
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
            position: relative;
            overflow: hidden;
            box-shadow: 0 8px 24px rgba(255, 122, 0, 0.35);
            white-space: nowrap;
            text-transform: uppercase;
            display: inline-flex;
            align-items: center;
            gap: 0.6rem;
        }

        .btn-get-started::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s;
        }

        .btn-get-started:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 32px rgba(255, 122, 0, 0.4);
            color: white !important;
            text-decoration: none;
        }

        .btn-get-started:hover::before {
            left: 100%;
        }

        /* ===== NOTIFICATION BADGE ===== */
        .navbar-notification {
            position: relative;
        }

        .notification-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background: var(--error-red);
            color: white;
            font-size: 0.6rem;
            font-weight: 800;
            padding: 4px 6px;
            border-radius: 50%;
            min-width: 18px;
            text-align: center;
            animation: pulseNotification 2s infinite;
            box-shadow: 0 0 0 1px white;
        }

        .notification-bell-icon {
            transition: all 0.3s ease;
            color: var(--deep-charcoal);
            font-size: 1.3rem;
        }

        .navbar-notification:hover .notification-bell-icon {
            color: var(--primary-orange);
            transform: rotate(15deg) scale(1.1);
        }

        /* ===== NOTIFICATION DROPDOWN ===== */
        .notification-dropdown {
            width: 380px;
            border: none;
            border-radius: 16px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
            animation: fadeInUp 0.3s ease-out;
            overflow: hidden;
        }

        .notification-dropdown-header {
            background: var(--deep-charcoal);
            color: white;
            padding: 14px 16px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-radius: 16px 16px 0 0;
            flex-wrap: wrap;
            gap: 10px;
        }

        .notification-dropdown-header h6 {
            font-family: 'Montserrat', sans-serif;
            font-weight: 800;
            font-size: 1rem;
            margin-bottom: 0;
        }

        .mark-all-read {
            background: var(--primary-orange);
            color: white;
            padding: 5px 10px;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-block;
            white-space: nowrap;
        }

        .mark-all-read:hover {
            background: var(--orange-light);
            transform: scale(1.05);
        }

        .notification-item {
            padding: 14px 16px;
            border-bottom: 1px solid var(--light-gray);
            transition: all 0.2s ease;
            position: relative;
            display: block;
            text-decoration: none;
            color: inherit;
        }

        .notification-item:last-child {
            border-bottom: none;
        }

        .notification-item.unread {
            background: linear-gradient(90deg, rgba(255, 122, 0, 0.05), transparent);
            border-left: 4px solid var(--primary-orange);
            padding-left: 12px;
        }

        .notification-item:hover {
            background: var(--light-gray);
            padding-left: 20px;
        }

        .notification-item-title {
            font-weight: 700;
            font-size: 0.9rem;
            color: var(--deep-charcoal);
            margin-bottom: 4px;
        }

        .notification-item-message {
            font-size: 0.85rem;
            color: #666;
            margin-bottom: 6px;
            line-height: 1.4;
        }

        .notification-item-time {
            font-size: 0.75rem;
            color: #999;
            font-style: italic;
        }

        .notification-unread-dot {
            display: inline-block;
            width: 8px;
            height: 8px;
            background: var(--primary-orange);
            border-radius: 50%;
            animation: bounce 0.6s ease-in-out infinite;
            margin-left: 8px;
            flex-shrink: 0;
        }

        .notification-empty {
            padding: 30px 16px;
            text-align: center;
            color: #999;
        }

        .notification-empty i {
            font-size: 2rem;
            margin-bottom: 10px;
            opacity: 0.5;
        }

        /* ===== USER PROFILE DROPDOWN ===== */
        .user-avatar {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, var(--primary-orange), var(--orange-light));
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 900;
            font-size: 1.25rem;
            flex-shrink: 0;
            box-shadow: 0 4px 14px rgba(255, 122, 0, 0.2);
            border: 2px solid rgba(255, 122, 0, 0.1);
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            cursor: pointer;
            transition: all 0.3s ease;
            padding: 6px 12px;
            border-radius: 12px;
        }

        .user-profile:hover {
            background: rgba(255, 122, 0, 0.08);
        }

        .user-profile-info {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            justify-content: center;
        }

        .user-profile-name {
            font-family: 'Montserrat', sans-serif;
            font-weight: 800;
            font-size: 0.95rem;
            color: var(--deep-charcoal);
            margin: 0;
            line-height: 1.2;
        }

        .user-profile-role {
            font-size: 0.75rem;
            color: #888;
            font-weight: 600;
            margin: 0;
            text-transform: capitalize;
        }

        .profile-dropdown-toggle {
            color: #ccc;
            font-size: 0.8rem;
            transition: all 0.3s ease;
        }

        .user-profile:hover .profile-dropdown-toggle {
            color: var(--primary-orange);
        }

        .dropdown-menu {
            border: none;
            border-radius: 14px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
            padding: 6px 0;
            animation: fadeInUp 0.3s ease-out;
            margin-top: 8px !important;
            min-width: 220px;
        }

        .dropdown-item {
            padding: 0.75rem 1.25rem;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.2s ease;
            color: var(--deep-charcoal);
            white-space: nowrap;
        }

        .dropdown-item:hover {
            background: var(--light-gray);
            color: var(--primary-orange);
            padding-left: 1.5rem;
        }

        .dropdown-divider {
            margin: 6px 0;
            opacity: 0.1;
        }

        .dropdown-item.logout {
            color: var(--error-red);
        }

        .dropdown-item.logout:hover {
            background: rgba(231, 76, 60, 0.1);
        }

        /* ===== MOBILE MENU - CREATIVE DESIGN ===== */

        /* Side Panel Menu */
        .mobile-menu-panel {
            position: fixed;
            top: 75px;
            left: -100%;
            width: 100%;
            max-width: 380px;
            height: calc(100vh - 75px);
            background: linear-gradient(135deg, #ffffff 0%, #fafafa 100%);
            box-shadow: 4px 0 30px rgba(0, 0, 0, 0.15);
            transition: left 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            z-index: 1000;
            overflow-y: auto;
            border-radius: 0 20px 20px 0;
            animation: slideInLeft 0.4s ease-out;
        }

        .mobile-menu-panel.active {
            left: 0;
        }

        .mobile-menu-overlay {
            position: fixed;
            top: 75px;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0);
            transition: background 0.4s ease;
            opacity: 0;
            pointer-events: none;
            z-index: 999;
        }

        .mobile-menu-overlay.active {
            background: rgba(0, 0, 0, 0.4);
            opacity: 1;
            pointer-events: auto;
        }

        /* Menu Header */
        .mobile-menu-header {
            background: linear-gradient(135deg, var(--primary-orange) 0%, #ff8f1a 100%);
            padding: 28px 20px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .mobile-menu-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }

        .mobile-menu-header::after {
            content: '';
            position: absolute;
            bottom: -30%;
            left: -10%;
            width: 150px;
            height: 150px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 50%;
        }

        .mobile-menu-title {
            font-family: 'Montserrat', sans-serif;
            font-weight: 900;
            font-size: 1.4rem;
            color: white;
            margin-bottom: 8px;
            letter-spacing: -0.5px;
            position: relative;
            z-index: 1;
        }

        .mobile-menu-subtitle {
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.9);
            font-weight: 600;
            position: relative;
            z-index: 1;
        }

        /* Navigation Items */
        .mobile-nav-section {
            padding: 28px 0;
        }

        .mobile-nav-label {
            font-family: 'Montserrat', sans-serif;
            font-weight: 800;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: #999;
            padding: 0 20px 12px;
            margin-bottom: 12px;
            border-bottom: 2px solid rgba(255, 122, 0, 0.1);
        }

        .mobile-nav-item {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 16px 20px;
            color: var(--deep-charcoal);
            text-decoration: none;
            font-weight: 700;
            font-size: 1rem;
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
            position: relative;
            margin: 6px 12px;
            border-radius: 14px;
            animation: fadeInLeft 0.5s ease-out backwards;
            border: none;
            background: transparent;
            cursor: pointer;
            width: calc(100% - 24px);
            text-align: left;
        }

        .mobile-nav-item:nth-child(1) { animation-delay: 0.1s; }
        .mobile-nav-item:nth-child(2) { animation-delay: 0.15s; }
        .mobile-nav-item:nth-child(3) { animation-delay: 0.2s; }
        .mobile-nav-item:nth-child(4) { animation-delay: 0.25s; }

        .mobile-nav-item::before {
            content: '';
            position: absolute;
            left: 20px;
            width: 8px;
            height: 8px;
            background: var(--primary-orange);
            border-radius: 50%;
            opacity: 0;
            transition: all 0.3s ease;
        }

        .mobile-nav-item:hover {
            background: linear-gradient(135deg, rgba(255, 122, 0, 0.1), rgba(255, 159, 47, 0.08));
            color: var(--primary-orange);
            transform: translateX(8px);
            padding-left: 28px;
        }

        .mobile-nav-item:hover::before {
            opacity: 1;
        }

        .mobile-nav-icon {
            font-size: 1.3rem;
            color: var(--primary-orange);
            transition: all 0.3s ease;
            flex-shrink: 0;
        }

        .mobile-nav-item:hover .mobile-nav-icon {
            transform: scale(1.2) rotate(10deg);
        }

        .mobile-nav-text {
            flex-grow: 1;
        }

        .mobile-nav-badge {
            background: var(--primary-orange);
            color: white;
            font-size: 0.75rem;
            font-weight: 800;
            padding: 4px 8px;
            border-radius: 20px;
            min-width: 22px;
            text-align: center;
            animation: pulse 2s ease-in-out infinite;
        }

        /* Divider */
        .mobile-menu-divider {
            margin: 20px 12px;
            height: 1px;
            background: linear-gradient(90deg, transparent, #ddd, transparent);
        }

        /* Auth Section */
        .mobile-auth-section {
            padding: 20px;
            margin-top: auto;
        }

        .mobile-login-btn {
            width: 100%;
            padding: 14px 20px;
            background: white;
            border: 2px solid var(--primary-orange);
            color: var(--primary-orange);
            border-radius: 12px;
            font-weight: 800;
            font-size: 0.95rem;
            text-decoration: none;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-bottom: 10px;
        }

        .mobile-login-btn:hover {
            background: var(--primary-orange);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(255, 122, 0, 0.3);
        }

        .mobile-signup-btn {
            width: 100%;
            padding: 14px 20px;
            background: linear-gradient(135deg, var(--primary-orange), var(--orange-light));
            color: white;
            border: none;
            border-radius: 12px;
            font-weight: 800;
            font-size: 0.95rem;
            text-decoration: none;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            box-shadow: 0 8px 24px rgba(255, 122, 0, 0.35);
        }

        .mobile-signup-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 32px rgba(255, 122, 0, 0.4);
            color: white;
            text-decoration: none;
        }

        /* User Profile in Menu */
        .mobile-user-profile {
            background: linear-gradient(135deg, rgba(255, 122, 0, 0.08), rgba(255, 159, 47, 0.05));
            padding: 16px 20px;
            border-radius: 14px;
            margin: 20px 12px;
            display: flex;
            align-items: center;
            gap: 12px;
            border: 1px solid rgba(255, 122, 0, 0.15);
            animation: fadeInLeft 0.5s ease-out 0.3s backwards;
        }

        .mobile-user-avatar {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, var(--primary-orange), var(--orange-light));
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 900;
            font-size: 1.2rem;
            flex-shrink: 0;
            box-shadow: 0 4px 14px rgba(255, 122, 0, 0.2);
        }

        .mobile-user-info h6 {
            font-family: 'Montserrat', sans-serif;
            font-weight: 800;
            font-size: 0.95rem;
            color: var(--deep-charcoal);
            margin-bottom: 2px;
        }

        .mobile-user-role {
            font-size: 0.75rem;
            color: #888;
            font-weight: 600;
            text-transform: capitalize;
        }

        /* Close Button */
        .mobile-menu-close {
            position: absolute;
            top: 20px;
            right: 20px;
            background: white;
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            z-index: 10;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .mobile-menu-close:hover {
            background: var(--primary-orange);
            transform: rotate(90deg) scale(1.1);
        }

        .mobile-menu-close:hover i {
            color: white;
        }

        .mobile-menu-close i {
            font-size: 1.2rem;
            color: var(--deep-charcoal);
            transition: all 0.3s ease;
        }

        /* ===== ALERTS & MESSAGES (COMPACT) ===== */
        .alert {
            border: none;
            border-left: 4px solid;
            border-radius: 12px;
            padding: 10px 14px;
            animation: fadeInUp 0.4s ease-out;
            font-weight: 500;
            font-size: 0.8rem;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
            margin-top: 1rem;
        }

        .alert-danger {
            background: #fef2f2;
            border-color: var(--error-red);
            color: #c5453f;
        }

        .alert-danger .btn-close {
            opacity: 0.5;
            padding: 0.3rem;
        }

        .alert-danger .btn-close:hover {
            opacity: 0.75;
        }

        .alert ul {
            margin-bottom: 0;
            padding-left: 16px;
            margin-top: 0.3rem;
        }

        .alert li {
            margin-bottom: 2px;
            font-size: 0.75rem;
            line-height: 1.3;
        }

        .alert li:last-child {
            margin-bottom: 0;
        }

        .alert h6 {
            font-size: 0.85rem;
            margin-bottom: 0.3rem;
            font-weight: 700;
        }

        .alert i {
            font-size: 1.1rem;
        }

        /* ===== SUCCESS TOAST (COMPACT) ===== */
        .toast-container {
            z-index: 2000;
        }

        .toast {
            background: linear-gradient(135deg, var(--deep-charcoal), #2c2c2c) !important;
            border: none;
            border-radius: 10px;
            padding: 10px 12px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.25);
            animation: slideInRight 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            backdrop-filter: blur(10px);
            width: auto;
            max-width: 340px;
        }

        .toast-body {
            font-weight: 600;
            font-size: 0.75rem;
            color: white;
            padding: 0;
            display: flex;
            align-items: flex-start;
            gap: 8px;
            line-height: 1.4;
        }

        .toast-body i {
            font-size: 0.9rem;
            animation: bounce 0.6s ease-in-out;
            flex-shrink: 0;
            margin-top: 2px;
            color: var(--primary-orange);
        }

        .toast-body > div {
            display: flex;
            flex-direction: column;
            gap: 1px;
        }

        .toast-body p {
            margin: 0;
            font-size: 0.75rem;
            font-weight: 700;
        }

        .toast-body small {
            font-size: 0.65rem;
            opacity: 0.8;
            font-weight: 500;
            color: rgba(255, 255, 255, 0.9);
        }

        .toast .btn-close-white {
            opacity: 0.6;
            transition: opacity 0.3s ease;
            padding: 0;
            width: auto;
            height: auto;
            font-size: 0.7rem;
            flex-shrink: 0;
        }

        .toast .btn-close-white:hover {
            opacity: 1;
        }

        /* ===== MAIN CONTENT ===== */
        main {
            animation: fadeInUp 0.6s ease-out 0.2s backwards;
        }

        .container {
            max-width: 1200px;
        }

        /* ===== DASHBOARD COMPATIBILITY ===== */
        /* Ensure dashboards display properly */
        .dashboard-container {
            width: 100%;
            margin: 0;
            padding: 0;
        }

        .row.g-3 {
            width: 100%;
            margin: 0;
        }

        /* ===== FOOTER ===== */
        footer {
            background: linear-gradient(135deg, var(--deep-charcoal) 0%, #252525 100%);
            color: white;
            padding: 30px 0 15px;
            letter-spacing: 0.5px;
            border-top: 3px solid var(--primary-orange);
        }

        .footer-logo {
            font-family: 'Montserrat', sans-serif;
            font-weight: 900;
            font-size: 1.2rem;
            color: #ffffff;
            margin-bottom: 10px;
        }

        .footer-logo span {
            color: var(--primary-orange);
        }

        footer h6 {
            color: #ffffff;
            font-weight: 800;
            letter-spacing: 0.5px;
            margin-bottom: 12px;
            font-size: 1rem;
        }

        footer a {
            color: rgba(255, 255, 255, 0.85);
            text-decoration: none;
            transition: all 0.3s ease;
            font-weight: 500;
            display: inline-block;
        }

        footer a:hover {
            color: var(--primary-orange);
            padding-left: 8px;
        }

        footer p {
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 6px;
            font-weight: 500;
            font-size: 0.9rem;
        }

        footer .small {
            color: rgba(255, 255, 255, 0.85);
            font-weight: 500;
            font-size: 0.85rem;
        }

        footer li {
            margin-bottom: 6px;
            font-size: 0.9rem;
        }

        footer li:last-child {
            margin-bottom: 0;
        }

        footer hr {
            border-color: rgba(255, 122, 0, 0.2);
            margin: 20px 0;
        }

        .footer-copyright {
            color: rgba(255, 255, 255, 0.9) !important;
            font-weight: 500;
            font-size: 0.85rem;
            margin-bottom: 0 !important;
        }

        /* ===== RESPONSIVE DESIGN ===== */
        @media (max-width: 1199px) {
            .navbar {
                padding: 10px 30px !important;
                height: 70px;
            }

            .text-logo {
                font-size: 1.25rem;
            }

            .nav-link {
                font-size: 0.85rem;
                padding: 10px 14px !important;
            }

            .navbar-nav {
                gap: 1.5rem;
            }

            .user-avatar {
                width: 45px;
                height: 45px;
                font-size: 1.1rem;
            }

            body {
                padding-top: 70px;
            }

            .mobile-menu-panel {
                top: 70px;
            }

            .mobile-menu-overlay {
                top: 70px;
            }
        }

        @media (max-width: 991px) {
            .navbar {
                height: 65px;
                padding: 8px 20px !important;
            }

            .navbar-collapse {
                display: none !important;
            }

            .navbar-nav {
                gap: 1rem;
            }

            .nav-link {
                padding: 0.5rem 0 !important;
                font-size: 0.8rem;
            }

            .btn-get-started {
                width: 100%;
                margin-top: 0.5rem;
            }

            .user-profile-info {
                display: none;
            }

            .user-avatar {
                width: 40px;
                height: 40px;
                font-size: 1rem;
            }

            body {
                padding-top: 65px;
            }

            .mobile-menu-panel {
                top: 65px;
                max-width: 320px;
            }

            .mobile-menu-overlay {
                top: 65px;
            }

            .notification-dropdown {
                width: 90vw;
                left: auto !important;
                right: 0 !important;
            }

            .navbar-toggler {
                display: block !important;
            }
        }

        @media (max-width: 768px) {
            .navbar {
                height: 60px;
                padding: 8px 16px !important;
            }

            .text-logo {
                font-size: 1.1rem;
            }

            .navbar-brand {
                margin-right: 0.5rem;
            }

            .nav-link {
                font-size: 0.75rem;
                padding: 0.4rem 0.6rem !important;
            }

            .navbar-nav {
                gap: 0.8rem;
            }

            .navbar-toggler {
                padding: 0.2rem 0.4rem;
            }

            .notification-dropdown {
                width: 95vw;
                left: auto !important;
                right: 0 !important;
            }

            .alert {
                padding: 8px 12px;
                font-size: 0.75rem;
            }

            .alert h6 {
                font-size: 0.8rem;
            }

            .alert ul {
                margin-top: 0.2rem;
                padding-left: 14px;
            }

            .toast {
                width: 95vw;
                margin: 0 auto;
                max-width: 95vw;
            }

            body {
                padding-top: 60px;
            }

            .mobile-menu-panel {
                top: 60px;
                max-width: 280px;
            }

            .mobile-menu-overlay {
                top: 60px;
            }

            .mobile-menu-header {
                padding: 24px 16px;
            }

            .mobile-menu-title {
                font-size: 1.2rem;
            }

            .mobile-nav-item {
                padding: 14px 16px;
                font-size: 0.9rem;
                margin: 4px 8px;
            }
        }

        @media (max-width: 576px) {
            .navbar {
                height: 55px;
                padding: 6px 12px !important;
            }

            .text-logo {
                font-size: 1rem;
            }

            .nav-link {
                font-size: 0.65rem;
                padding: 0.35rem 0.5rem !important;
            }

            .navbar-nav {
                gap: 0.5rem;
            }

            .navbar-toggler {
                padding: 0.2rem 0.3rem;
            }

            .notification-dropdown {
                width: 98vw;
                left: auto !important;
                right: 0 !important;
            }

            .btn-get-started {
                font-size: 0.75rem;
                padding: 0.7rem 1rem !important;
            }

            .user-avatar {
                width: 36px;
                height: 36px;
                font-size: 0.9rem;
            }

            .toast {
                width: 98vw;
                padding: 8px 10px;
                max-width: 98vw;
            }

            .toast-body {
                font-size: 0.7rem;
            }

            .toast-body i {
                font-size: 0.8rem;
            }

            body {
                padding-top: 0 !important; }
            }

            .mobile-menu-panel {
                top: 55px;
                max-width: 260px;
            }

            .mobile-menu-overlay {
                top: 55px;
            }

            .mobile-menu-header {
                padding: 20px 14px;
            }

            .mobile-menu-title {
                font-size: 1.1rem;
            }

            .mobile-auth-section {
                padding: 16px;
            }

            .mobile-login-btn,
            .mobile-signup-btn {
                padding: 12px 16px;
                font-size: 0.85rem;
            }
        }

        /* ===== ACCESSIBILITY ===== */
        .nav-link:focus,
        .btn-get-started:focus {
            outline: 2px solid var(--primary-orange);
            outline-offset: 2px;
        }

        .dropdown-item:focus {
            outline: none;
            background: var(--light-gray);
        }

        /* ===== SMOOTH SCROLLING ===== */
        html {
            scroll-behavior: smooth;
        }

        /* ===== NAVBAR TOGGLER ===== */
        .navbar-toggler {
            border: none;
            box-shadow: none;
            padding: 0.25rem 0.5rem;
            font-size: 1.3rem;
            color: var(--deep-charcoal);
            transition: all 0.3s ease;
        }

        .navbar-toggler:hover {
            color: var(--primary-orange);
        }

        .navbar-toggler:focus {
            box-shadow: none;
            outline: 2px solid var(--primary-orange);
            outline-offset: 2px;
        }
    </style>
</head>
<body>

    <!-- ===== NAVBAR ===== -->
     @if(request()->is('/'))
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container-fluid px-lg-5">
            <!-- Logo -->
            <a class="navbar-brand text-logo" href="{{ url('/') }}">
                CATER<span>CONNECT</span>
            </a>
            
            <!-- Mobile Toggle -->
            <button class="navbar-toggler" type="button" id="mobileMenuToggle" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <i class="bi bi-list"></i>
            </button>

            <!-- Navbar Content (Desktop Only) -->
            <div class="collapse navbar-collapse" id="navbarNav" style="display: none;">
                <ul class="navbar-nav mx-auto">
    <li class="nav-item"><a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">Home</a></li>
    <li class="nav-item"><a class="nav-link {{ request()->is('caterers') ? 'active' : '' }}" href="{{ url('/caterers') }}">Browse Caterers</a></li>
    <li class="nav-item"><a class="nav-link" href="{{ url('/') }}#featuredCaterers">Featured</a></li>
    <li class="nav-item"><a class="nav-link" href="{{ url('/') }}#how-it-works">How It Works</a></li>
</ul>

                <ul class="navbar-nav align-items-center gap-3">
                    @guest
                        <!-- Guest User - Login Link -->
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}" style="text-transform: none; font-weight: 700;">
                                <i class="bi bi-box-arrow-in-right me-1"></i> Login
                            </a>
                        </li>

                        <!-- Get Started Button -->
                        <li class="nav-item">
                            <a class="btn btn-get-started" href="{{ route('register') }}">
                                <i class="bi bi-rocket"></i> GET STARTED
                            </a>
                        </li>
                    @else
                        <!-- Authenticated User - Notification Bell -->
                        <li class="nav-item navbar-notification">
                            <a class="nav-link position-relative p-0" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" title="Notifications">
                                <i class="bi bi-bell-fill notification-bell-icon"></i>
                                @if(auth()->user()->unreadNotifications->count() > 0)
                                    <span class="notification-badge">
                                        {{ auth()->user()->unreadNotifications->count() }}
                                    </span>
                                @endif
                            </a>

                            <!-- Notification Dropdown -->
                            <div class="dropdown-menu dropdown-menu-end notification-dropdown p-0 mt-3">
                                <!-- Header -->
                                <div class="notification-dropdown-header">
                                    <h6>📢 Notifications</h6>
                                    @if(auth()->user()->unreadNotifications->count() > 0)
                                        <a href="{{ route('notifications.markAllRead') }}" class="mark-all-read">
                                            Mark read
                                        </a>
                                    @endif
                                </div>

                                <!-- Notification Items -->
                                <div style="max-height: 400px; overflow-y: auto;">
                                    @forelse(auth()->user()->notifications as $notification)
                                        <a class="notification-item {{ $notification->read_at ? '' : 'unread' }}" href="{{ $notification->data['url'] ?? '#' }}">
                                            <div class="d-flex align-items-start justify-content-between">
                                                <div class="flex-grow-1" style="min-width: 0;">
                                                    <p class="notification-item-title">
                                                        {{ $notification->data['title'] ?? 'Notification' }}
                                                    </p>
                                                    <p class="notification-item-message">
                                                        {{ $notification->data['message'] ?? '' }}
                                                    </p>
                                                    <p class="notification-item-time">
                                                        {{ $notification->created_at->diffForHumans() }}
                                                    </p>
                                                </div>
                                                @if(!$notification->read_at)
                                                    <span class="notification-unread-dot ms-2"></span>
                                                @endif
                                            </div>
                                        </a>
                                    @empty
                                        <div class="notification-empty">
                                            <i class="bi bi-inbox"></i>
                                            <p class="small">No notifications yet.</p>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </li>

                        <!-- User Profile Dropdown -->
                        <li class="nav-item dropdown">
                            <div class="user-profile dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false" title="User Menu" style="cursor: pointer;">
                                <div class="user-avatar">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                                <div class="user-profile-info">
                                    <p class="user-profile-name">{{ Auth::user()->name }}</p>
                                    <p class="user-profile-role">{{ Auth::user()->role ?? 'User' }}</p>
                                </div>
                                <i class="bi bi-chevron-down profile-dropdown-toggle"></i>
                            </div>

                            <!-- User Dropdown Menu -->
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="{{ url('/dashboard') }}">
                                        <i class="bi bi-speedometer2 me-2"></i> Dashboard
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ url('/profile') }}">
                                        <i class="bi bi-person-lines-fill me-2"></i> Profile
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ url('/settings') }}">
                                        <i class="bi bi-gear me-2"></i> Settings
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST" class="m-0">
                                        @csrf
                                        <button type="submit" class="dropdown-item logout">
                                            <i class="bi bi-box-arrow-right me-2"></i> Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
    @endif

    <!-- ===== MOBILE MENU PANEL ===== -->
    <div class="mobile-menu-panel" id="mobileMenuPanel">
        <!-- Header with close button -->
        <div class="mobile-menu-header">
            <button class="mobile-menu-close" id="mobileMenuClose">
                <i class="bi bi-x-lg"></i>
            </button>
            <h5 class="mobile-menu-title">CaterConnect</h5>
            <p class="mobile-menu-subtitle">Find Your Perfect Caterer</p>
        </div>

        <!-- Navigation Links -->
        <div class="mobile-nav-section">
            <div class="mobile-nav-label">Navigation</div>
            <a href="{{ url('/caterers') }}" class="mobile-nav-item" onclick="closeMobileMenu()">
    <i class="bi bi-search mobile-nav-icon"></i>
    <span class="mobile-nav-text">Browse Caterers</span>
</a>
<a href="{{ url('/') }}#featuredCaterers" class="mobile-nav-item" onclick="closeMobileMenu()">
    <i class="bi bi-star-fill mobile-nav-icon"></i>
    <span class="mobile-nav-text">Featured</span>
</a>
<a href="{{ url('/') }}#how-it-works" class="mobile-nav-item" onclick="closeMobileMenu()">
    <i class="bi bi-info-circle-fill mobile-nav-icon"></i>
    <span class="mobile-nav-text">How It Works</span>
</a>
@auth
<a href="{{ url('/dashboard') }}" class="mobile-nav-item" onclick="closeMobileMenu()">
    <i class="bi bi-speedometer2 mobile-nav-icon"></i>
    <span class="mobile-nav-text">Dashboard</span>
</a>
@endauth
        </div>

        <!-- Divider -->
        <div class="mobile-menu-divider"></div>

        @guest
            <!-- Guest User Section -->
            <div class="mobile-auth-section">
                <div class="mobile-nav-label">Get Started</div>
                <a href="{{ route('login') }}" class="mobile-login-btn" onclick="closeMobileMenu()">
                    <i class="bi bi-box-arrow-in-right"></i>
                    Login
                </a>
                <a href="{{ route('register') }}" class="mobile-signup-btn" onclick="closeMobileMenu()">
                    <i class="bi bi-rocket-fill"></i>
                    Sign Up
                </a>
            </div>
        @else
            <!-- Authenticated User Section -->
            
            <!-- User Profile Card -->
            <div class="mobile-user-profile">
                <div class="mobile-user-avatar">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div class="mobile-user-info">
                    <h6>{{ Auth::user()->name }}</h6>
                    <p class="mobile-user-role">{{ Auth::user()->role ?? 'User' }}</p>
                </div>
            </div>

            <!-- User Navigation -->
            <div class="mobile-nav-section">
                <div class="mobile-nav-label">Account</div>
                <a href="{{ url('/dashboard') }}" class="mobile-nav-item" onclick="closeMobileMenu()">
                    <i class="bi bi-speedometer2 mobile-nav-icon"></i>
                    <span class="mobile-nav-text">Dashboard</span>
                </a>
                <a href="{{ url('/profile') }}" class="mobile-nav-item" onclick="closeMobileMenu()">
                    <i class="bi bi-person-circle mobile-nav-icon"></i>
                    <span class="mobile-nav-text">Profile</span>
                </a>
                <a href="{{ url('/settings') }}" class="mobile-nav-item" onclick="closeMobileMenu()">
                    <i class="bi bi-gear mobile-nav-icon"></i>
                    <span class="mobile-nav-text">Settings</span>
                </a>
                <button class="mobile-nav-item" onclick="closeMobileMenu(); handleNotifications();">
                    <i class="bi bi-bell-fill mobile-nav-icon"></i>
                    <span class="mobile-nav-text">Notifications</span>
                    @if(auth()->user()->unreadNotifications->count() > 0)
                        <span class="mobile-nav-badge">
                            {{ auth()->user()->unreadNotifications->count() }}
                        </span>
                    @endif
                </button>
            </div>

            <!-- Logout Section -->
            <div class="mobile-auth-section">
                <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                    @csrf
                    <button type="submit" class="mobile-nav-item w-100" style="text-align: left; border: none; background: transparent; margin: 6px 12px;">
                        <i class="bi bi-box-arrow-right mobile-nav-icon" style="color: var(--error-red);"></i>
                        <span class="mobile-nav-text" style="color: var(--error-red);">Logout</span>
                    </button>
                </form>
            </div>
        @endguest
    </div>

    <!-- Mobile Menu Overlay -->
    <div class="mobile-menu-overlay" id="mobileMenuOverlay"></div>

    <!-- ===== ERROR ALERTS (COMPACT) ===== -->
    <div class="container">
        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <div class="d-flex align-items-start">
                    <i class="bi bi-exclamation-triangle-fill me-2" style="flex-shrink: 0;"></i>
                    <div class="flex-grow-1">
                        <h6 class="fw-bold mb-1">Oops! Something went wrong</h6>
                        <ul class="small mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    </div>

    <!-- ===== MAIN CONTENT ===== -->
    <main>
        @yield('content')
    </main>

    <!-- ===== SUCCESS TOAST (COMPACT) ===== -->
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="successToast" class="toast align-items-center border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-body">
                <i class="bi bi-check-circle-fill"></i>
                <div>
                    <p class="mb-0">Success!</p>
                    <small id="successMessage">{{ session('success') }}</small>
                </div>
            </div>
            <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>

    <!-- ===== FOOTER ===== -->
    <footer>
        <div class="container">
            <div class="row py-3">
                <!-- About Section -->
                <div class="col-md-4 mb-3 mb-md-0">
                    <div class="footer-logo">CATER<span>CONNECT</span></div>
                    <p class="small">Your trusted Cebuano catering marketplace for unforgettable events.</p>
                </div>

                <!-- Quick Links -->
<div class="col-md-4 mb-3 mb-md-0">
    <h6 class="fw-bold">Quick Links</h6>
    <ul class="list-unstyled small">
        <li><a href="{{ url('/') }}"><i class="bi bi-house-fill me-1" style="color:var(--primary-orange);"></i> Home</a></li>
        <li><a href="{{ url('/caterers') }}"><i class="bi bi-search me-1" style="color:var(--primary-orange);"></i> Browse Caterers</a></li>
        <li><a href="{{ url('/') }}#featuredCaterers"><i class="bi bi-star-fill me-1" style="color:var(--primary-orange);"></i> Featured Caterers</a></li>
        <li><a href="{{ url('/') }}#how-it-works"><i class="bi bi-info-circle-fill me-1" style="color:var(--primary-orange);"></i> How It Works</a></li>
        <li><a href="{{ route('register') }}"><i class="bi bi-rocket-fill me-1" style="color:var(--primary-orange);"></i> Get Started</a></li>
        @auth
            <li><a href="{{ url('/dashboard') }}"><i class="bi bi-speedometer2 me-1" style="color:var(--primary-orange);"></i> Dashboard</a></li>
        @endauth
    </ul>
</div>

                <!-- Legal -->
                <div class="col-md-4">
                    <h6 class="fw-bold">Legal</h6>
                    <ul class="list-unstyled small">
                        <li><a href="{{ route('privacy') }}"><i class="bi bi-shield-lock-fill me-1" style="color:var(--primary-orange);"></i> Privacy Policy</a></li>
                        <li><a href="{{ route('terms') }}"><i class="bi bi-file-earmark-text-fill me-1" style="color:var(--primary-orange);"></i> Terms of Service</a></li>
                    </ul>
                </div>
            </div>

            <!-- Divider -->
            <hr class="my-2">

            <!-- Copyright -->
            <div class="text-center small footer-copyright">
                <p>&copy; 2026 CaterConnect. All rights reserved. Made with <i class="bi bi-heart-fill" style="color: var(--primary-orange);"></i> in Cebu.</p>
            </div>
        </div>
    </footer>

    <!-- ===== SCRIPTS ===== -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Mobile Menu Functions
        const mobileMenuPanel = document.getElementById('mobileMenuPanel');
        const mobileMenuOverlay = document.getElementById('mobileMenuOverlay');
        const mobileMenuToggle = document.getElementById('mobileMenuToggle');
        const mobileMenuClose = document.getElementById('mobileMenuClose');

        // Open menu
        mobileMenuToggle?.addEventListener('click', function(e) {
            e.stopPropagation();
            openMobileMenu();
        });

        // Close menu
        mobileMenuClose?.addEventListener('click', closeMobileMenu);
        mobileMenuOverlay?.addEventListener('click', closeMobileMenu);

        function openMobileMenu() {
            mobileMenuPanel.classList.add('active');
            mobileMenuOverlay.classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeMobileMenu() {
            mobileMenuPanel.classList.remove('active');
            mobileMenuOverlay.classList.remove('active');
            document.body.style.overflow = 'auto';
        }

        function handleNotifications() {
            // Handle notification button click
            console.log('Notifications clicked');
        }

        // Close menu on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeMobileMenu();
            }
        });

        // Close menu on window resize
        window.addEventListener('resize', function() {
            if (window.innerWidth > 991) {
                closeMobileMenu();
            }
        });

        // Show success toast if message exists
        @if(session('success'))
            document.addEventListener('DOMContentLoaded', function () {
                const toastEl = document.getElementById('successToast');
                if (toastEl) {
                    const toast = new bootstrap.Toast(toastEl, { delay: 4000 });
                    toast.show();

                    toastEl.addEventListener('hidden.bs.toast', function () {
                        toastEl.style.display = 'none';
                    });
                }
            });
        @endif

        // Smooth navigation updates
        document.addEventListener('DOMContentLoaded', function() {
            const navLinks = document.querySelectorAll('.nav-link');
            const currentPath = window.location.pathname;

            navLinks.forEach(link => {
                const href = link.getAttribute('href');
                if (href && currentPath.includes(href) && href !== '/') {
                    link.classList.add('active');
                }
            });
        });

        // Enhanced dropdown animations
        document.querySelectorAll('[data-bs-toggle="dropdown"]').forEach(dropdown => {
            dropdown.addEventListener('shown.bs.dropdown', function() {
                const menu = this.nextElementSibling;
                if (menu) {
                    menu.style.animation = 'fadeInUp 0.3s ease-out';
                }
            });
        });
    </script>
</body>
</html>