<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giphy Integration API - Local Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-900 text-slate-100 min-h-screen flex flex-col justify-between font-sans">

    <header class="border-b border-slate-800 bg-slate-900/50 backdrop-blur py-6">
        <div class="max-w-5xl mx-auto px-6 flex justify-between items-center">
            <div class="flex items-center space-x-3">
                <span class="text-2xl font-black tracking-wider text-indigo-400">GIPHY</span>
                <span class="px-2 py-0.5 text-xs font-semibold bg-indigo-500/20 text-indigo-300 rounded border border-indigo-500/30">API v1.0</span>
            </div>
            <div class="text-sm text-slate-400 flex items-center space-x-4">
                <div>
                    Environment: <span class="text-emerald-400 font-mono">local</span>
                </div>
                <div class="flex items-center space-x-2 border-l border-slate-700 pl-4">
                    <a href="/api/documentation" class="inline-flex items-center space-x-1.5 px-3 py-1 bg-gradient-to-r from-amber-500 to-orange-600 hover:from-amber-600 hover:to-orange-700 text-slate-900 font-bold text-xs rounded-lg transition-all shadow-lg shadow-orange-500/10">
                        <span>🚀</span>
                        <span>Ver Swagger UI</span>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <main class="max-w-5xl mx-auto px-6 py-12 flex-grow w-full">
        <div class="bg-slate-800/40 border border-slate-800 rounded-2xl p-8 mb-8">
            <h1 class="text-3xl font-bold text-white mb-2">¡Entorno local corriendo con éxito! 🚀</h1>
            <p class="text-slate-400 max-w-2xl">
                Esta es la raíz del servicio de integración con Giphy. Al tratarse de una API REST protegida por <span class="text-indigo-400 font-semibold">Laravel Passport (OAuth2)</span>, los endpoints principales deben ser consumidos mediante un cliente HTTP como Postman.
            </p>
        </div>

        <h2 class="text-xl font-bold text-white mb-6 flex items-center space-x-2">
            <span>🔌</span> <span>Endpoints de la Aplicación</span>
        </h2>

        <div class="grid md:grid-cols-2 gap-6">
            
            <div class="bg-slate-800/70 border border-slate-700/50 rounded-xl p-6 shadow-xl">
                <span class="text-xs font-bold uppercase tracking-widest text-amber-400">Autenticación</span>
                <h3 class="text-lg font-bold text-white mt-1 mb-4">Gestión de Acceso</h3>
                
                <div class="space-y-4">
                    <div>
                        <div class="flex items-center space-x-2 font-mono text-sm mb-1">
                            <span class="bg-emerald-500/10 text-emerald-400 px-2 py-0.5 rounded text-xs font-bold">POST</span>
                            <span class="text-slate-300">/api/v1/user/create</span>
                        </div>
                        <p class="text-xs text-slate-400">Registra un nuevo usuario en la base de datos local para pruebas.</p>
                    </div>
                    
                    <div>
                        <div class="flex items-center space-x-2 font-mono text-sm mb-1">
                            <span class="bg-emerald-500/10 text-emerald-400 px-2 py-0.5 rounded text-xs font-bold">POST</span>
                            <span class="text-slate-300">/oauth/token</span>
                        </div>
                        <p class="text-xs text-slate-400">Solicita un Access Token (Bearer) usando las credenciales del usuario.</p>
                    </div>
                </div>
            </div>

            <div class="bg-slate-800/70 border border-slate-700/50 rounded-xl p-6 shadow-xl">
                <span class="text-xs font-bold uppercase tracking-widest text-indigo-400">Integración Giphy</span>
                <h3 class="text-lg font-bold text-white mt-1 mb-4">Endpoints Protegidos</h3>
                
                <div class="space-y-4">
                    <div>
                        <div class="flex items-center space-x-2 font-mono text-sm mb-1">
                            <span class="bg-blue-500/10 text-blue-400 px-2 py-0.5 rounded text-xs font-bold">GET</span>
                            <span class="text-slate-300">/api/v1/gifs/search</span>
                        </div>
                        <p class="text-xs text-slate-400">Busca GIFs en la API externa. Requiere parámetro query (?query=...).</p>
                    </div>
                    
                    <div>
                        <div class="flex items-center space-x-2 font-mono text-sm mb-1">
                            <span class="bg-blue-500/10 text-blue-400 px-2 py-0.5 rounded text-xs font-bold">GET</span>
                            <span class="text-slate-300">/api/v1/gifs/{id}</span>
                        </div>
                        <p class="text-xs text-slate-400">Recupera la información detallada de un GIF específico por su ID único.</p>
                    </div>
                </div>
            </div>

        </div>

        <div class="mt-8 bg-slate-900/40 border border-slate-800 rounded-xl p-6">
            <h3 class="text-sm font-bold text-white uppercase tracking-wider mb-3">💡 Pasos para probar en Postman:</h3>
            <ol class="list-decimal list-inside space-y-2 text-sm text-slate-400">
                <li>Ejecutá el endpoint de <code class="text-slate-200 bg-slate-800 px-1 py-0.5 rounded font-mono">user/create</code> pasándole nombre, email y contraseña.</li>
                <li>Pedí tu token en <code class="text-slate-200 bg-slate-800 px-1 py-0.5 rounded font-mono">/oauth/token</code> con el flujo Password Grant.</li>
                <li>Copiá el <code class="text-indigo-400 font-mono">access_token</code> de la respuesta.</li>
                <li>Configurá tu pestaña de Postman en la pestaña <strong class="text-slate-200">Authorization</strong> como <strong class="text-slate-200">Bearer Token</strong>, pegalo y consumí los endpoints de Giphy.</li>
            </ol>
        </div>
    </main>

    <footer class="border-t border-slate-800 bg-slate-950/20 py-4 text-center text-xs text-slate-500">
        Giphy API Client Infrastructure — {{ date('Y') }}
    </footer>

</body>
</html>
