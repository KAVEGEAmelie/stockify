<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Stockify - @yield('title', 'Gestion de Stock')</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
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
        
        /* Sidebar fixe à gauche */
        .sidebar {
            position: fixed;
            top: 60px;
            left: 0;
            bottom: 60px;
            width: 280px;
            background-color: #343a40;
            color: white;
            overflow-y: auto;
            z-index: 1020;
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
            top: 60px;
            left: 280px;
            right: 0;
            bottom: 60px;
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
            height: 60px;
            background-color: #343a40;
            color: white;
            z-index: 1030;
            display: flex;
            align-items: center;
            justify-content: center;
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
    </style>

</head>
<body>
    <!-- Navbar fixe en haut -->
    <nav class="navbar navbar-expand-lg navbar-fixed">
        <div class="container-fluid">
            <span class="navbar-brand mb-0 h1">
                <i class="bi bi-box-seam-fill text-primary me-2"></i>
                Stockify - Gestion de Stock
            </span>
            
            <!-- Bouton mobile pour toggle sidebar -->
            <button class="btn btn-outline-secondary mobile-toggle" type="button" onclick="toggleSidebar()">
                <i class="bi bi-list"></i>
            </button>
            
            <div class="navbar-nav ms-auto">
                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle me-1"></i> Utilisateur
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i> Profil</a></li>
                        <li><a class="dropdown-item" href="#"><i class="bi bi-gear me-2"></i> Paramètres</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#"><i class="bi bi-box-arrow-right me-2"></i> Déconnexion</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- Sidebar fixe à gauche -->
    @include('partials._sidebar')

    <!-- Contenu principal scrollable -->
    <main class="main-content">
        @yield('content')
    </main>

    <!-- Footer fixe en bas -->
    <footer class="footer-fixed">
        <div class="container-fluid">
            <span class="text-muted">© {{ date('Y') }} Stockify - Système de Gestion de Stock</span>
        </div>
    </footer>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Script pour mobile sidebar toggle -->
    <script>
        function toggleSidebar() {
            const sidebar = document.querySelector('.sidebar');
            sidebar.classList.toggle('show');
        }
    </script>
</body>
</html>
