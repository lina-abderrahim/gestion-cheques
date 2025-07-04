<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des chèques</title>
    
    <!-- Chargement de Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        /* Correction pour les tableaux */
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            padding: 0.75rem;
            text-align: left;
            border: 1px solid #e2e8f0;
        }
        /* Assure que les tableaux sont responsives */
        .table-container {
            overflow-x: auto;
        }
    </style>
</head>
<body class="bg-gray-50">
    @include('partials.navbar')
    
    <main class="container mx-auto px-4 py-6">
        @yield('content')
    </main>
    
    @yield('scripts')
</body>
</html>