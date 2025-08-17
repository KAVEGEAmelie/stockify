<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Tableau de Bord') - Stockify</title>
    <meta name="description" content="Stockify - Système professionnel de gestion de stock et d'inventaire">
    <meta name="keywords" content="stock, inventaire, gestion, warehouse, stockify">
    <meta name="author" content="Stockify">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicons -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">

    <!-- Web App Manifest -->
    <link rel="manifest" href="{{ asset('manifest.json') }}">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- NOTRE UNIQUE FICHIER DE STYLE PROFESSIONNEL -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    {{-- <style>
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            overflow: hidden;
            min-width: 320px;
        }

        /* Navbar fixe en haut */
        .navbar-fixed {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1030;
            height: 60px;
            background-color: #ffffff;
            border-bottom: 1px solid #dee2e6;
            box-shadow: 0 2px 4px rgba(0,0,0,.04);
        }

        /* Sidebar fixe à gauche avec en-tête et pied fixes */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: 280px;
            background-color: #343a40;
            color: white;
            z-index: 1020;
            display: flex;
            flex-direction: column;
            overflow: hidden; /* Empêche le scroll de toute la sidebar */
        }

        /* En-tête fixe de la sidebar */
        .sidebar-header-fixed {
            flex-shrink: 0;
            background-color: #343a40;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            position: relative;
            z-index: 1;
            min-height: 80px; /* Hauteur minimale pour l'en-tête */
        }

        /* Contenu défilable de la sidebar */
        .sidebar-content {
            flex: 1;
            overflow-y: auto;
            overflow-x: hidden;
            scrollbar-width: thin;
            scrollbar-color: rgba(255,255,255,0.3) transparent;
            min-height: 0; /* Important pour que flex fonctionne correctement */
        }

        /* Personnalisation de la scrollbar pour Webkit */
        .sidebar-content::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar-content::-webkit-scrollbar-track {
            background: transparent;
        }

        .sidebar-content::-webkit-scrollbar-thumb {
            background-color: rgba(255,255,255,0.3);
            border-radius: 3px;
        }

        .sidebar-content::-webkit-scrollbar-thumb:hover {
            background-color: rgba(255,255,255,0.5);
        }

        /* Pied fixe de la sidebar */
        .sidebar-footer-fixed {
            flex-shrink: 0;
            background-color: #343a40;
            border-top: 1px solid rgba(255,255,255,0.1);
            position: relative;
            z-index: 1;
            min-height: 70px; /* Hauteur minimale pour le pied */
        }

        .sidebar .nav-link {
            color: rgba(255,255,255,.75);
            padding: 0.75rem 1rem;
            border-radius: 0.375rem;
            margin-bottom: 0.25rem;
        }

        .sidebar .nav-link:hover {
            color: white;
            background-color: rgba(255,255,255,.1);
        }

        .sidebar .nav-link.active {
            color: white;
            background-color: #0d6efd;
        }

        .sidebar-header {
            color: #adb5bd;
            font-size: 0.875rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 0.75rem 1rem 0.25rem;
        }

        /* Contenu principal avec scroll */
        .main-content {
            position: fixed;
            top: 0;
            left: 280px;
            right: 0;
            bottom: 0;
            overflow-y: auto;
            padding: 2rem;
            background-color: #f8f9fa;
        }

        /* Footer fixe en bas */
        .footer-fixed {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            height: 40px;
            background-color: #343a40;
            color: #ffffff;
            z-index: 1030;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.875rem;
        }

        /* Responsive pour mobile */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease-in-out;
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                left: 0;
            }

            .mobile-toggle {
                display: block !important;
            }
        }

        .mobile-toggle {
            display: none;
        }
    </style> --}}

</head>
<body>
    <div id="wrapper">
        <!-- Bouton mobile pour afficher la sidebar -->
        <button class="btn btn-primary position-fixed d-md-none sidebar-mobile-toggle" 
                type="button" 
                id="sidebar-mobile-toggle" 
                style="top: 1rem; left: 1rem; z-index: 1100;">
            <i class="bi bi-list"></i>
        </button>

        <!-- Sidebar fixe à gauche -->
        @include('partials._sidebar')

        <!-- Contenu principal scrollable -->
        <main class="main-content">
            @yield('content')
        </main>

        <!-- Footer fixe en bas -->
        <footer class="footer-fixed">
            <span class="text-muted">© {{ date('Y') }} Stockify - Système de Gestion de Stock</span>
        </footer>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Script pour mobile sidebar toggle -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const sidebar = document.querySelector('.sidebar');
            const sidebarToggle = document.getElementById('sidebar-toggle');
            const sidebarMobileToggle = document.getElementById('sidebar-mobile-toggle');
            const wrapper = document.getElementById('wrapper');

            // Toggle depuis la sidebar (fermer)
            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', function() {
                    wrapper.classList.toggle('sidebar-toggled');
                });
            }

            // Toggle depuis le bouton mobile (ouvrir)
            if (sidebarMobileToggle) {
                sidebarMobileToggle.addEventListener('click', function() {
                    wrapper.classList.toggle('sidebar-toggled');
                });
            }
        });
    </script>
</body>
</html>
