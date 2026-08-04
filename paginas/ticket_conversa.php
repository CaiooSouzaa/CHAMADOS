<?php
session_start();

require_once __DIR__ . '/../codigos_php/listarUsuario.php';
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conversa do Ticket - Gestão de Chamados</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-color: #f8fafc;
            --card-bg: #ffffff;
            --text-primary: #0f172a;
            --text-secondary: #64748b;
            --border-color: #e2e8f0;
            --primary: #2563eb;
            --primary-hover: #1d4ed8;
            --primary-light: #eff6ff;
            --primary-glow: rgba(37, 99, 235, 0.15);
            --success: #22c55e;
            --warning: #f59e0b;
            --danger: #ef4444;
            --danger-bg: #fef2f2;
            --danger-text: #991b1b;
            --sidebar-width: 260px;
            --ease-out: cubic-bezier(0.22, 1, 0.36, 1);
            --ease-bounce: cubic-bezier(0.34, 1.56, 0.64, 1);
            --ease-smooth: cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-color);
            color: var(--text-primary);
            display: flex;
            min-height: 100vh;
        }

        /* ===== SIDEBAR ===== */
        .sidebar {
            width: var(--sidebar-width);
            background: linear-gradient(180deg, #1e293b 0%, #0f172a 100%);
            color: #fff;
            position: fixed;
            left: 0;
            top: 0;
            height: 100vh;
            display: flex;
            flex-direction: column;
            z-index: 100;
            overflow: hidden;
            border-right: 1px solid rgba(255, 255, 255, 0.04);
        }

        .sidebar-header {
            padding: 24px 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        .sidebar-logo {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--primary), #7c3aed);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.4);
        }

        .sidebar-logo svg {
            width: 22px;
            height: 22px;
        }

        .sidebar-title {
            font-weight: 700;
            font-size: 1.05rem;
            white-space: nowrap;
            letter-spacing: -0.02em;
        }

        .sidebar-nav {
            flex: 1;
            padding: 16px 12px;
            overflow-y: auto;
        }

        .nav-section {
            margin-bottom: 8px;
        }

        .nav-section-title {
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #94a3b8;
            padding: 12px 16px 8px;
            white-space: nowrap;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 16px;
            border-radius: 10px;
            color: #cbd5e1;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            margin-bottom: 2px;
            position: relative;
            white-space: nowrap;
        }

        .nav-item:hover {
            background: rgba(255, 255, 255, 0.06);
            color: #fff;
        }

        .nav-item.active {
            background: linear-gradient(135deg, var(--primary), #3b82f6);
            color: #fff;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.35);
        }

        .nav-item svg {
            width: 20px;
            height: 20px;
            flex-shrink: 0;
        }

        .sidebar-footer {
            padding: 16px;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
        }

        .user-card {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.05);
            transition: background 0.2s;
        }

        .user-card:hover {
            background: rgba(255, 255, 255, 0.08);
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), #7c3aed);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-weight: 700;
            font-size: 0.9rem;
            flex-shrink: 0;
        }

        .user-info {
            overflow: hidden;
        }

        .user-name {
            font-weight: 600;
            font-size: 0.88rem;
            color: #fff;
            white-space: nowrap;
        }

        .user-role {
            font-size: 0.75rem;
            color: #94a3b8;
            white-space: nowrap;
        }

        .admin-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            background: rgba(34, 197, 94, 0.15);
            color: #4ade80;
            padding: 2px 8px;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 600;
            margin-top: 4px;
        }

        /* ===== MAIN CONTENT ===== */
        .main-content {
            margin-left: var(--sidebar-width);
            flex: 1;
            display: flex;
            flex-direction: column;
            min-width: 0;
            height: 100vh;
            overflow: hidden;
        }

        .topbar {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border-color);
            padding: 0 32px;
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 50;
            flex-shrink: 0;
        }

        .breadcrumb {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.82rem;
            color: var(--text-secondary);
        }

        .breadcrumb a {
            color: var(--text-secondary);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.2s;
            padding: 4px 8px;
            border-radius: 6px;
        }

        .breadcrumb a:hover {
            color: var(--primary);
            background: var(--primary-light);
        }

        .breadcrumb svg {
            opacity: 0.5;
        }

        .breadcrumb span:last-child {
            color: var(--text-primary);
            font-weight: 600;
            padding: 4px 8px;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .topbar-btn {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            border: none;
            background: transparent;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: var(--text-secondary);
            transition: all 0.2s;
            position: relative;
        }

        .topbar-btn:hover {
            background: var(--bg-color);
            color: var(--text-primary);
        }

        .topbar-btn .notification-dot {
            position: absolute;
            top: 8px;
            right: 8px;
            width: 8px;
            height: 8px;
            background: var(--danger);
            border-radius: 50%;
            border: 2px solid #fff;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
                transform: scale(1)
            }

            50% {
                opacity: 0.7;
                transform: scale(1.1)
            }
        }

        .content-area {
            padding: 24px 32px 32px;
            flex: 1;
            display: flex;
            justify-content: center;
            overflow: hidden;
            min-height: 0;
        }

        /* ===== TICKET CONTAINER ===== */
        .ticket-container {
            width: 100%;
            max-width: 860px;
            display: flex;
            flex-direction: column;
            gap: 16px;
            height: 100%;
            min-height: 0;
        }

        /* Ticket Header Card */
        .ticket-header-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 20px 24px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02), 0 10px 40px -10px rgba(0, 0, 0, 0.06);
            opacity: 0;
            transform: translateY(20px);
            flex-shrink: 0;
        }

        .ticket-header-card.loaded {
            opacity: 1;
            transform: translateY(0);
            transition: opacity 0.6s var(--ease-out), transform 0.6s var(--ease-out);
        }

        .ticket-header-top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 14px;
        }

        .ticket-title-area h1 {
            font-size: 1.15rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 6px;
            letter-spacing: -0.01em;
        }

        .ticket-meta {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
            font-size: 0.8rem;
            color: var(--text-secondary);
        }

        .ticket-meta span {
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .ticket-meta .dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--text-secondary);
        }

        .ticket-actions {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-shrink: 0;
        }

        .btn-transfer {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            font-size: 0.82rem;
            font-weight: 600;
            color: var(--primary);
            background: var(--primary-light);
            border: 1.5px solid rgba(37, 99, 235, 0.15);
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.2s;
            font-family: inherit;
        }

        .btn-transfer:hover {
            background: var(--primary);
            color: #fff;
            border-color: var(--primary);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
        }

        .badge-status {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.78rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .badge-status.aberto {
            background: #fef3c7;
            color: #92400e;
        }

        .badge-status.andamento {
            background: #dbeafe;
            color: #1e40af;
        }

        .badge-status.fechado {
            background: #dcfce7;
            color: #166534;
        }

        .ticket-participants {
            display: flex;
            align-items: center;
            gap: 16px;
            padding-top: 14px;
            border-top: 1px solid var(--border-color);
            flex-wrap: wrap;
        }

        .participant {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .participant-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), #7c3aed);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-weight: 700;
            font-size: 0.8rem;
        }

        .participant-avatar.resp {
            background: linear-gradient(135deg, var(--success), #16a34a);
        }

        .participant-info {
            display: flex;
            flex-direction: column;
        }

        .participant-label {
            font-size: 0.7rem;
            color: var(--text-secondary);
            font-weight: 500;
        }

        .participant-name {
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--text-primary);
        }

        /* ===== MESSAGES AREA ===== */
        .messages-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 24px 28px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02), 0 10px 40px -10px rgba(0, 0, 0, 0.06);
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 20px;
            opacity: 0;
            transform: translateY(20px);
            overflow-y: auto;
            min-height: 0;
            scrollbar-width: thin;
            scrollbar-color: #cbd5e1 transparent;
        }

        .messages-card::-webkit-scrollbar {
            width: 6px;
        }

        .messages-card::-webkit-scrollbar-track {
            background: transparent;
        }

        .messages-card::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        .messages-card::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        .messages-card.loaded {
            opacity: 1;
            transform: translateY(0);
            transition: opacity 0.6s var(--ease-out) 0.1s, transform 0.6s var(--ease-out) 0.1s;
        }

        .message-item {
            display: flex;
            gap: 14px;
            animation: fadeInUp 0.4s var(--ease-out) forwards;
            flex-shrink: 0;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .message-item.sent {
            flex-direction: row-reverse;
        }

        .message-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), #7c3aed);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-weight: 700;
            font-size: 0.85rem;
            flex-shrink: 0;
            margin-top: 2px;
        }

        .message-item.sent .message-avatar {
            background: linear-gradient(135deg, var(--success), #16a34a);
        }

        .message-bubble {
            max-width: 70%;
            background: #f1f5f9;
            border-radius: 14px;
            border-bottom-left-radius: 4px;
            padding: 14px 18px;
            position: relative;
        }

        .message-item.sent .message-bubble {
            background: var(--primary-light);
            border-bottom-left-radius: 14px;
            border-bottom-right-radius: 4px;
        }

        .message-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 6px;
        }

        .message-author {
            font-weight: 700;
            font-size: 0.85rem;
            color: var(--text-primary);
        }

        .message-time {
            font-size: 0.72rem;
            color: var(--text-secondary);
            white-space: nowrap;
        }

        .message-text {
            font-size: 0.9rem;
            line-height: 1.6;
            color: var(--text-primary);
            word-wrap: break-word;
        }

        .message-attachments {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 12px;
        }

        .attachment-chip {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 12px;
            background: #fff;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-size: 0.8rem;
            color: var(--text-secondary);
            text-decoration: none;
            transition: all 0.2s;
        }

        .attachment-chip:hover {
            border-color: var(--primary);
            color: var(--primary);
            background: var(--primary-light);
        }

        .attachment-chip svg {
            flex-shrink: 0;
        }

        /* ===== REPLY AREA ===== */
        .reply-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 20px 24px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02), 0 10px 40px -10px rgba(0, 0, 0, 0.06);
            opacity: 0;
            transform: translateY(20px);
            flex-shrink: 0;
        }

        .reply-card.loaded {
            opacity: 1;
            transform: translateY(0);
            transition: opacity 0.6s var(--ease-out) 0.2s, transform 0.6s var(--ease-out) 0.2s;
        }

        .reply-header {
            font-size: 0.9rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .reply-textarea-wrapper {
            position: relative;
            margin-bottom: 12px;
        }

        .reply-textarea {
            width: 100%;
            min-height: 100px;
            max-height: 180px;
            padding: 14px 16px;
            font-family: 'Inter', sans-serif;
            font-size: 0.93rem;
            line-height: 1.6;
            border: 1.5px solid var(--border-color);
            border-radius: 12px;
            outline: none;
            background: #fafafa;
            color: var(--text-primary);
            resize: vertical;
            transition: all 0.25s var(--ease-smooth);
        }

        .reply-textarea:focus {
            border-color: var(--primary);
            background: #ffffff;
            box-shadow: 0 0 0 4px var(--primary-glow);
        }

        .reply-textarea::placeholder {
            color: #94a3b8;
        }

        .reply-actions {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap;
        }

        .reply-left {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .attach-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 9px 14px;
            font-size: 0.82rem;
            font-weight: 600;
            color: var(--text-secondary);
            background: transparent;
            border: 1.5px dashed var(--border-color);
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.2s;
            font-family: inherit;
        }

        .attach-btn:hover {
            border-color: var(--primary);
            color: var(--primary);
            background: var(--primary-light);
        }

        .file-input {
            display: none;
        }

        .file-list {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-bottom: 10px;
        }

        .file-tag {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 10px;
            background: var(--primary-light);
            color: var(--primary);
            border-radius: 8px;
            font-size: 0.78rem;
            font-weight: 600;
        }

        .file-tag button {
            background: none;
            border: none;
            color: var(--primary);
            cursor: pointer;
            font-size: 1rem;
            line-height: 1;
            padding: 0;
            width: 16px;
            height: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-submit {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 11px 26px;
            font-size: 0.93rem;
            font-weight: 700;
            color: #ffffff;
            background: linear-gradient(135deg, var(--primary), #4f46e5);
            border: none;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s var(--ease-smooth);
            position: relative;
            overflow: hidden;
            font-family: inherit;
            box-shadow: 0 4px 16px rgba(37, 99, 235, 0.25);
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 28px rgba(37, 99, 235, 0.35);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        .btn-submit:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            transform: none;
        }

        /* ===== DIVIDER ===== */
        .messages-divider {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 4px 0;
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: 0.06em;
            flex-shrink: 0;
        }

        .messages-divider::before,
        .messages-divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border-color);
        }

        /* ===== MODAL TRANSFERIR ===== */
        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.5);
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 200;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s, visibility 0.3s;
        }

        .modal-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .modal-box {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            padding: 32px;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 24px 60px -12px rgba(0, 0, 0, 0.2);
            transform: scale(0.92) translateY(10px);
            transition: transform 0.35s var(--ease-bounce);
        }

        .modal-overlay.active .modal-box {
            transform: scale(1) translateY(0);
        }

        .modal-icon {
            width: 56px;
            height: 56px;
            border-radius: 16px;
            background: linear-gradient(135deg, var(--warning), #fbbf24);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            box-shadow: 0 8px 24px rgba(245, 158, 11, 0.25);
        }

        .modal-icon svg {
            width: 28px;
            height: 28px;
            color: #fff;
        }

        .modal-title {
            font-size: 1.15rem;
            font-weight: 800;
            color: var(--text-primary);
            text-align: center;
            margin-bottom: 6px;
        }

        .modal-text {
            font-size: 0.85rem;
            color: var(--text-secondary);
            text-align: center;
            margin-bottom: 24px;
            line-height: 1.5;
        }

        .modal-form-group {
            margin-bottom: 20px;
        }

        .modal-form-group label {
            display: block;
            font-size: 0.82rem;
            font-weight: 600;
            margin-bottom: 8px;
            color: var(--text-primary);
        }

        .modal-select-wrapper {
            position: relative;
        }

        .modal-select-wrapper select {
            width: 100%;
            padding: 12px 44px 12px 16px;
            font-size: 0.9rem;
            font-family: 'Inter', sans-serif;
            border: 1.5px solid var(--border-color);
            border-radius: 12px;
            outline: none;
            background: #fafafa;
            color: var(--text-primary);
            cursor: pointer;
            appearance: none;
            -webkit-appearance: none;
            transition: all 0.2s;
        }

        .modal-select-wrapper select:focus {
            border-color: var(--primary);
            background: #fff;
            box-shadow: 0 0 0 4px var(--primary-glow);
        }

        .modal-select-arrow {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-secondary);
            pointer-events: none;
        }

        .modal-actions {
            display: flex;
            gap: 10px;
        }

        .modal-actions button {
            flex: 1;
            padding: 12px;
            font-size: 0.9rem;
            font-weight: 700;
            border-radius: 12px;
            cursor: pointer;
            font-family: inherit;
            transition: all 0.2s;
            border: none;
        }

        .modal-btn-cancel {
            background: #f1f5f9;
            color: var(--text-secondary);
        }

        .modal-btn-cancel:hover {
            background: #e2e8f0;
            color: var(--text-primary);
        }

        .modal-btn-confirm {
            background: linear-gradient(135deg, var(--warning), #fbbf24);
            color: #fff;
            box-shadow: 0 4px 14px rgba(245, 158, 11, 0.3);
        }

        .modal-btn-confirm:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(245, 158, 11, 0.4);
        }

        @media (max-width: 1024px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .main-content {
                margin-left: 0;
            }
        }

        @media (max-width: 640px) {
            .content-area {
                padding: 16px;
            }

            .ticket-header-card,
            .messages-card,
            .reply-card {
                padding: 16px;
                border-radius: 14px;
            }

            .message-bubble {
                max-width: 85%;
            }

            .ticket-header-top {
                flex-direction: column;
            }

            .ticket-actions {
                width: 100%;
            }

            .btn-transfer {
                width: 100%;
                justify-content: center;
            }

            .reply-actions {
                flex-direction: column;
                align-items: stretch;
            }

            .reply-left {
                justify-content: center;
            }

            .btn-submit {
                width: 100%;
                justify-content: center;
            }

            .modal-box {
                margin: 20px;
                padding: 24px;
            }
        }
    </style>
</head>

<body>

    <!-- SIDEBAR -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="sidebar-logo">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4" />
                    <polyline points="10 17 15 12 10 7" />
                    <line x1="15" y1="12" x2="3" y2="12" />
                </svg>
            </div>
            <span class="sidebar-title">Gestão de Chamados</span>
        </div>

        <nav class="sidebar-nav">
            <div class="nav-section">
                <div class="nav-section-title">Chamados</div>
                <a href="../paginas/paginaInicial_administrador.php" class="nav-item">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                        <polyline points="9 22 9 12 15 12 15 22" />
                    </svg>
                    Dashboard
                </a>
                <a href="#" class="nav-item active">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                        <polyline points="14 2 14 8 20 8" />
                        <line x1="16" y1="13" x2="8" y2="13" />
                        <line x1="16" y1="17" x2="8" y2="17" />
                    </svg>
                    Listar Chamados
                </a>
                <a href="../paginas/chamados.php" class="nav-item">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="12" y1="5" x2="12" y2="19" />
                        <line x1="5" y1="12" x2="19" y2="12" />
                    </svg>
                    Novo Chamado
                </a>
            </div>

            <div class="nav-section">
                <div class="nav-section-title">Usuários</div>
                <a href="#" class="nav-item">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                        <circle cx="9" cy="7" r="4" />
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                        <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                    </svg>
                    Listar Usuários
                </a>
                <a href="cadastroUsuario.php" class="nav-item">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="12" y1="5" x2="12" y2="19" />
                        <line x1="5" y1="12" x2="19" y2="12" />
                    </svg>
                    Novo Usuário
                </a>
            </div>
        </nav>

        <div class="sidebar-footer">
            <div class="user-card">
                <div class="user-avatar">
                    <?php echo isset($_SESSION['nome_usuario']) ? substr($_SESSION['nome_usuario'], 0, 1) : 'U'; ?>
                </div>
                <div class="user-info">
                    <div class="user-name">
                        <?php echo isset($_SESSION['nome_usuario']) ? htmlspecialchars($_SESSION['nome_usuario']) : 'Usuário'; ?>
                    </div>
                    <div class="user-role">
                        <span class="admin-badge">
                            <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                                <polyline points="20 6 9 17 4 12" />
                            </svg>
                            <?php echo isset($_SESSION['papel_usuario']) ? htmlspecialchars($_SESSION['papel_usuario']) : 'Usuário'; ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </aside>

    <!-- MAIN CONTENT -->
    <div class="main-content">
        <!-- TOPBAR -->
        <header class="topbar">
            <div class="breadcrumb">
                <a href="paginaInicial_administrador.php">Home</a>
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="9 18 15 12 9 6" />
                </svg>
                <a href="#">Chamados</a>
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="9 18 15 12 9 6" />
                </svg>
                <span>Ticket #1042</span>
            </div>
            <div class="topbar-right">
                <button class="topbar-btn" title="Notificações">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9" />
                        <path d="M13.73 21a2 2 0 0 1-3.46 0" />
                    </svg>
                    <span class="notification-dot"></span>
                </button>
                <a href="sair.php" style="text-decoration:none;">
                    <button type="button" class="topbar-btn" title="Sair">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                            <polyline points="16 17 21 12 16 7" />
                            <line x1="21" y1="12" x2="9" y2="12" />
                        </svg>
                    </button>
                </a>
            </div>
        </header>

        <!-- CONTENT AREA -->
        <div class="content-area">
            <div class="ticket-container">

                <!-- TICKET HEADER -->
                <div class="ticket-header-card" id="ticketHeader">
                    <div class="ticket-header-top">
                        <div class="ticket-title-area">
                            <h1>Erro ao acessar o sistema de vendas no período noturno</h1>
                            <div class="ticket-meta">
                                <span>
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                                        <line x1="16" y1="2" x2="16" y2="6" />
                                        <line x1="8" y1="2" x2="8" y2="6" />
                                        <line x1="3" y1="10" x2="21" y2="10" />
                                    </svg>
                                    Aberto em 28/07/2026 às 14:30
                                </span>
                                <span class="dot"></span>
                                <span>
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                                    </svg>
                                    Categoria: Infraestrutura e TI
                                </span>
                            </div>
                        </div>
                        <div class="ticket-actions">
                            <button type="button" class="btn-transfer" onclick="abrirModalTransferir()">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                    <polyline points="17 1 21 5 17 9" />
                                    <path d="M3 11V9a4 4 0 0 1 4-4h14" />
                                    <polyline points="7 23 3 19 7 15" />
                                    <path d="M21 13v2a4 4 0 0 1-4 4H3" />
                                </svg>
                                Transferir
                            </button>
                            <span class="badge-status andamento">
                                <span style="width:6px;height:6px;border-radius:50%;background:currentColor;display:inline-block;"></span>
                                Em Andamento
                            </span>
                        </div>
                    </div>

                    <div class="ticket-participants">
                        <div class="participant">
                            <div class="participant-avatar">C</div>
                            <div class="participant-info">
                                <span class="participant-label">Solicitante</span>
                                <span class="participant-name">Caio Silva</span>
                            </div>
                        </div>
                        <div class="participant">
                            <div class="participant-avatar resp">M</div>
                            <div class="participant-info">
                                <span class="participant-label">Responsável</span>
                                <span class="participant-name">Maria Oliveira</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- MESSAGES THREAD (COM SCROLL INTERNO) -->
                <div class="messages-card" id="messagesCard">

                    <!-- Mensagem recebida (solicitante) -->
                    <div class="message-item">
                        <div class="message-avatar">C</div>
                        <div class="message-bubble">
                            <div class="message-header">
                                <span class="message-author">Caio Silva</span>
                                <span class="message-time">28/07/2026 14:30</span>
                            </div>
                            <div class="message-text">
                                Olá, estou tentando acessar o sistema de vendas após as 18h e aparece uma tela de erro 500. Já limpei o cache e tentei em outro navegador, mas o problema persiste. Preciso de ajuda urgente pois tenho relatórios para entregar amanhã.
                            </div>
                        </div>
                    </div>

                    <!-- Mensagem enviada (atendente) -->
                    <div class="message-item sent">
                        <div class="message-avatar">M</div>
                        <div class="message-bubble">
                            <div class="message-header">
                                <span class="message-author">Maria Oliveira</span>
                                <span class="message-time">28/07/2026 15:12</span>
                            </div>
                            <div class="message-text">
                                Olá Caio, obrigado pelo contato. Estou verificando o servidor de aplicação. Poderia me informar se o erro aparece logo na tela de login ou após digitar suas credenciais?
                            </div>
                        </div>
                    </div>

                    <!-- Mensagem recebida (solicitante) -->
                    <div class="message-item">
                        <div class="message-avatar">C</div>
                        <div class="message-bubble">
                            <div class="message-header">
                                <span class="message-author">Caio Silva</span>
                                <span class="message-time">28/07/2026 15:45</span>
                            </div>
                            <div class="message-text">
                                Após digitar as credenciais. A tela de login carrega normalmente, mas quando clico em "Entrar" aparece o erro.
                            </div>
                            <div class="message-attachments">
                                <a href="#" class="attachment-chip">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M21.44 11.05l-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 0 1-2.83-2.83l8.49-8.48" />
                                    </svg>
                                    erro_tela.png
                                </a>
                                <a href="#" class="attachment-chip">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                        <polyline points="14 2 14 8 20 8" />
                                    </svg>
                                    logs_navegador.txt
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="messages-divider">Hoje</div>

                    <!-- Mensagem enviada (atendente) -->
                    <div class="message-item sent">
                        <div class="message-avatar">M</div>
                        <div class="message-bubble">
                            <div class="message-header">
                                <span class="message-author">Maria Oliveira</span>
                                <span class="message-time">29/07/2026 09:20</span>
                            </div>
                            <div class="message-text">
                                Identificamos o problema. Houve uma atualização no serviço de autenticação que causou incompatibilidade com sessões iniciadas após as 18h. Já aplicamos a correção. Poderia testar o acesso e confirmar se está funcionando?
                            </div>
                        </div>
                    </div>

                    <!-- Mensagem recebida (solicitante) -->
                    <div class="message-item">
                        <div class="message-avatar">C</div>
                        <div class="message-bubble">
                            <div class="message-header">
                                <span class="message-author">Caio Silva</span>
                                <span class="message-time">29/07/2026 10:05</span>
                            </div>
                            <div class="message-text">
                                Funcionou! Consegui acessar normalmente agora. Muito obrigado pela agilidade.
                            </div>
                        </div>
                    </div>

                    <!-- Mensagem enviada (atendente) -->
                    <div class="message-item sent">
                        <div class="message-avatar">M</div>
                        <div class="message-bubble">
                            <div class="message-header">
                                <span class="message-author">Maria Oliveira</span>
                                <span class="message-time">29/07/2026 10:12</span>
                            </div>
                            <div class="message-text">
                                Perfeito! Qualquer outro problema é só chamar. Vou manter o chamado aberto por mais 24h caso precise de algo mais.
                            </div>
                        </div>
                    </div>

                </div>

                <!-- REPLY AREA -->
                <div class="reply-card" id="replyCard">
                    <div class="reply-header">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z" />
                        </svg>
                        Responder
                    </div>

                    <form action="../codigos_php/enviarMensagem.php" method="post" enctype="multipart/form-data" id="replyForm">
                        <input type="hidden" name="id_chamado" value="1042">

                        <div class="file-list" id="fileList"></div>

                        <div class="reply-textarea-wrapper">
                            <textarea
                                class="reply-textarea"
                                name="mensagem"
                                placeholder="Digite sua resposta aqui..."
                                required></textarea>
                        </div>

                        <div class="reply-actions">
                            <div class="reply-left">
                                <button type="button" class="attach-btn" onclick="document.getElementById('fileInput').click()">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M21.44 11.05l-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 0 1-2.83-2.83l8.49-8.48" />
                                    </svg>
                                    Anexar arquivos
                                </button>
                                <input
                                    type="file"
                                    id="fileInput"
                                    class="file-input"
                                    name="anexos[]"
                                    multiple
                                    accept=".jpg,.jpeg,.png,.gif,.pdf,.doc,.docx,.xls,.xlsx,.txt,.zip,.rar"
                                    onchange="handleFiles(this)">
                            </div>
                            <button type="submit" class="btn-submit" id="btnEnviar">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                    <line x1="22" y1="2" x2="11" y2="13" />
                                    <polygon points="22 2 15 22 11 13 2 9 22 2" />
                                </svg>
                                Enviar resposta
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <!-- MODAL TRANSFERIR CHAMADO -->
    <div class="modal-overlay" id="modalTransferir">
        <div class="modal-box">
            <div class="modal-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="17 1 21 5 17 9" />
                    <path d="M3 11V9a4 4 0 0 1 4-4h14" />
                    <polyline points="7 23 3 19 7 15" />
                    <path d="M21 13v2a4 4 0 0 1-4 4H3" />
                </svg>
            </div>
            <h3 class="modal-title">Transferir Chamado</h3>
            <p class="modal-text">Selecione o funcionário que será o novo responsável por este chamado.</p>


            <form action="../codigos_php/transferirConversa.php" method="post" id="formTransferir">
                <input type="hidden" name="id_chamado" value="227">
                <input type="hidden" name="acao" value="encaminhar">

                <div class="modal-form-group">
                    <label for="novo_responsavel">Novo Responsável</label>
                    <div class="modal-select-wrapper">

                        <select id="novo_responsavel" name="novo_responsavel" required>
                            <option value="" disabled selected>Selecione um funcionário</option>
                            <?php if (isset($_SESSION['papel_usuario']) && ($_SESSION['papel_usuario'] == 'Administrador' || $_SESSION['papel_usuario'] == 'usuario')): ?>
                                <?php foreach ($resultado_usuarios as $usuarios): ?>
                                    <option value="<?php echo htmlspecialchars($usuarios['id_usuario']); ?>">
                                        <?php echo htmlspecialchars($usuarios['nome_usuario']); ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <option value="" disabled>Nenhum colaborador disponivel</option>
                            <?php endif; ?>
                        </select>

                        <span class="modal-select-arrow">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="6 9 12 15 18 9" />
                            </svg>
                        </span>
                    </div>
                </div>
                <div class="modal-actions">
                    <button type="button" class="modal-btn-cancel" onclick="fecharModalTransferir()">Cancelar</button>
                    <button type="submit" class="modal-btn-confirm">Confirmar Transferência</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Animações de entrada
        const delays = [{
                id: 'ticketHeader',
                delay: 100
            },
            {
                id: 'messagesCard',
                delay: 250
            },
            {
                id: 'replyCard',
                delay: 400
            }
        ];

        delays.forEach(item => {
            setTimeout(() => {
                const el = document.getElementById(item.id);
                if (el) el.classList.add('loaded');
            }, item.delay);
        });

        // Scroll automático para a última mensagem
        window.addEventListener('load', () => {
            const messagesCard = document.getElementById('messagesCard');
            if (messagesCard) {
                messagesCard.scrollTop = messagesCard.scrollHeight;
            }
        });

        // Modal Transferir
        function abrirModalTransferir() {
            document.getElementById('modalTransferir').classList.add('active');
        }

        function fecharModalTransferir() {
            document.getElementById('modalTransferir').classList.remove('active');
        }

        document.getElementById('modalTransferir').addEventListener('click', function(e) {
            if (e.target === this) fecharModalTransferir();
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') fecharModalTransferir();
        });

        // Gerenciamento de anexos
        let selectedFiles = [];

        function handleFiles(input) {
            const newFiles = Array.from(input.files);
            newFiles.forEach(file => {
                if (!selectedFiles.some(f => f.name === file.name && f.size === file.size)) {
                    selectedFiles.push(file);
                }
            });
            renderFileList();
        }

        function renderFileList() {
            const fileList = document.getElementById('fileList');
            fileList.innerHTML = '';
            selectedFiles.forEach((file, index) => {
                const tag = document.createElement('div');
                tag.className = 'file-tag';
                tag.innerHTML = `
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z" />
                        <polyline points="13 2 13 9 20 9" />
                    </svg>
                    ${file.name}
                    <button type="button" onclick="removeFile(${index})" title="Remover">×</button>
                `;
                fileList.appendChild(tag);
            });
            updateFileInput();
        }

        function removeFile(index) {
            selectedFiles.splice(index, 1);
            renderFileList();
        }

        function updateFileInput() {
            const input = document.getElementById('fileInput');
            const dataTransfer = new DataTransfer();
            selectedFiles.forEach(file => dataTransfer.items.add(file));
            input.files = dataTransfer.files;
        }

        // Loading no submit
        document.getElementById('replyForm').addEventListener('submit', function(e) {
            const btn = document.getElementById('btnEnviar');
            btn.disabled = true;
            btn.innerHTML = `
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="animation: spin 0.8s linear infinite;">
                    <path d="M21 12a9 9 0 1 1-6.22-8.56" />
                </svg>
                Enviando...
            `;
        });
    </script>
</body>

</html>