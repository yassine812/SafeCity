<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SafeCity — Tableau de bord Citoyen</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <style>
        :root {
            --grad-start: #b6e0ff;
            --grad-end: #f3b8d8;
            --card-bg: #ffffff;
            --accent: #ff7fbf;
            --muted: #94a3b8;
            --input: #e8f2fb;
            --sidebar-bg: #1e293b;
            --sidebar-text: #f8fafc;
            --sidebar-hover: #334155;
        }

        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            overflow: hidden;
        }

        .sidebar {
            width: 280px;
            background-color: var(--sidebar-bg);
            color: var(--sidebar-text);
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            transition: all 0.3s;
            z-index: 1000;
        }

        .main-content {
            flex: 1;
            margin-left: 280px;
            height: 100vh;
            overflow-y: auto;
            background: linear-gradient(120deg, var(--grad-start), var(--grad-end));
            padding: 1.5rem;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 0.75rem 1.5rem;
            color: var(--sidebar-text);
            border-radius: 0.375rem;
            margin: 0.25rem 1rem;
            transition: all 0.2s;
        }

        .nav-link:hover {
            background-color: var(--sidebar-hover);
            color: white;
        }

        .nav-link i {
            width: 24px;
            margin-right: 0.75rem;
            text-align: center;
        }

        .nav-link.active {
            background-color: var(--accent);
            color: white;
            font-weight: 500;
        }

        .user-profile {
            padding: 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .dashboard-card {
            background: var(--card-bg);
            border-radius: 16px;
            padding: 2rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            margin-bottom: 1.5rem;
        }

        .feed-card {
            background: white;
            border-radius: 12px;
            padding: 1.25rem;
            margin-bottom: 1rem;
            border: 1px solid rgba(0, 0, 0, 0.05);
            transition: all 0.2s ease;
        }

        .feed-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            
            .sidebar.mobile-show {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0;
            }
            
            .mobile-menu-btn {
                display: block !important;
            }
        }

        .status-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: capitalize;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--accent), #ff5ca1);
            color: white;
            font-weight: 600;
            padding: 10px 24px;
            border-radius: 50px;
            transition: all 0.2s ease;
            border: none;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px -5px rgba(255, 127, 191, 0.5);
        }

        .title {
            font-size: 32px;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 10px;
        }

        .subtitle {
            color: var(--muted);
            margin-bottom: 30px;
            font-size: 16px;
        }

        .comment-section {
            position: relative;
            z-index: 50;
            pointer-events: auto !important;
        }

        .send-btn {
            cursor: pointer;
            z-index: 9999;
            pointer-events: auto;
        }
    </style>
</head>

<body>
    <!-- Mobile menu button -->
    <button class="mobile-menu-btn fixed top-4 left-4 z-50 p-2 rounded-md bg-white shadow-md lg:hidden" onclick="toggleSidebar()">
        <i class="fas fa-bars text-gray-800"></i>
    </button>

    <!-- Sidebar -->
    <div class="sidebar bg-slate-800 text-slate-100 shadow-lg" id="sidebar">
        <div class="p-6">
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-2xl font-bold">
                    <span class="bg-gradient-to-r from-pink-300 to-pink-400 bg-clip-text text-transparent">SafeCity</span>
                </h2>
                <button class="lg:hidden text-pink-200 hover:text-white" onclick="toggleSidebar()">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>
            
            <nav class="space-y-2">
                <a href="{{ route('citizen.dashboard') }}" class="flex items-center px-4 py-3 bg-gradient-to-r from-pink-500/20 to-pink-600/30 text-white rounded-lg border-l-4 border-pink-400 shadow-md">
                    <div class="w-6 h-6 flex items-center justify-center mr-3 rounded-full bg-pink-400/30">
                        <i class="fas fa-home text-pink-100 text-sm"></i>
                    </div>
                    <span class="font-semibold text-white">Tableau de bord</span>
                    <span class="ml-auto w-2 h-2 bg-pink-400 rounded-full animate-pulse"></span>
                </a>
                
                <a href="{{ route('citizen.incidents.index') }}" class="flex items-center px-4 py-3 text-pink-100 hover:bg-pink-900/30 rounded-lg transition-all duration-200 group">
                    <div class="w-6 h-6 flex items-center justify-center mr-3 rounded-full bg-pink-900/30 group-hover:bg-pink-500/30 transition-colors">
                        <i class="fas fa-exclamation-triangle text-pink-300 text-sm"></i>
                    </div>
                    <span class="font-medium">Mes signalements</span>
                </a>
                
                <a href="{{ route('citizen.incidents.create') }}" class="flex items-center px-4 py-3 text-pink-100 hover:bg-pink-900/30 rounded-lg transition-all duration-200 group">
                    <div class="w-6 h-6 flex items-center justify-center mr-3 rounded-full bg-pink-900/30 group-hover:bg-pink-500/30 transition-colors">
                        <i class="fas fa-plus-circle text-pink-300 text-sm"></i>
                    </div>
                    <span class="font-medium">Nouveau signalement</span>
                    <span class="ml-auto px-2 py-0.5 text-xs font-medium bg-pink-500/20 text-pink-300 rounded-full">Nouveau</span>
                </a>
                
                <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-3 text-pink-100 hover:bg-pink-900/30 rounded-lg transition-all duration-200 group">
                    <div class="w-6 h-6 flex items-center justify-center mr-3 rounded-full bg-pink-900/30 group-hover:bg-pink-500/30 transition-colors">
                        <i class="fas fa-user text-pink-300 text-sm"></i>
                    </div>
                    <span class="font-medium">Mon Profil</span>
                </a>
                
                <div class="pt-4 mt-4 border-t border-pink-900/30">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center px-4 py-3 text-pink-200 hover:text-white" onclick="toggleSidebar()">
                            <div class="w-6 h-6 flex items-center justify-center mr-3 rounded-full bg-pink-900/30 group-hover:bg-pink-500/30 transition-colors">
                                <i class="fas fa-sign-out-alt text-pink-300 text-sm"></i>
                            </div>
                            <span class="font-medium">Déconnexion</span>
                        </button>
                    </form>
                </div>
            </nav>
            
            <!-- User info at bottom -->
            <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-pink-900/30 bg-gradient-to-t from-pink-900/30 to-transparent backdrop-blur-sm">
                <div class="flex items-center">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-pink-400 to-pink-500 shadow-md flex items-center justify-center text-white font-bold">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-white">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-pink-200/80">Compte Citoyen</p>
                    </div>
                    <div class="ml-auto">
                        <div class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <div class="main-content">
        <!-- MAIN CONTENT -->
        <div class="dashboard-card">
            <!-- HEADER -->
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h1 class="title">Bienvenue, {{ auth()->user()->name }}</h1>
                    <p class="subtitle">Restez informé des incidents dans votre quartier</p>
                </div>
                <a href="{{ route('citizen.incidents.create') }}" class="btn-primary">
                    + Signaler un incident
                </a>
            </div>

            <!-- Incident Feed Section -->
            <div class="mt-8">
                <h2 class="text-xl font-semibold text-gray-800 mb-6">Derniers signalements</h2>
                <div class="space-y-6">
                    @forelse($incidents as $incident)
                    <!-- Enhanced Post Card with Vote + Comment -->
                    <div class="bg-white rounded-2xl shadow-lg overflow-visible border border-pink-50 hover:shadow-2xl transition-all duration-300" id="post-{{ $incident->id }}">
                        <!-- Header -->
                        <div class="p-5 flex items-center">
                            <div class="w-12 h-12 rounded-full bg-gradient-to-br from-pink-400 to-pink-500 flex items-center justify-center text-white font-semibold shadow-md">
                                {{ strtoupper(substr($incident->user->name, 0, 1)) }}
                            </div>
                            <div class="ml-4">
                                <h3 class="font-semibold text-gray-900 text-sm">{{ $incident->user->name }}</h3>
                                <div class="flex items-center text-xs text-gray-500">
                                    <span>{{ $incident->created_at->diffForHumans() }}</span>
                                    <span class="mx-1">•</span>
                                    <i class="fas fa-map-marker-alt text-pink-400"></i>
                                </div>
                            </div>
                            <div class="ml-auto">
                                @php
                                    // Always show 'En attente' status for all posts
                                    $statusSlug = 'en_attente';
                                    $statusName = 'En attente';
                                    $statusClass = 'bg-yellow-100 text-yellow-800';
                                    
                                    // Only show actual status if it's not 'nouveau' and not empty
                                    if (!empty($incident->status)) {
                                        $dbStatusSlug = strtolower($incident->status->slug ?? $incident->status);
                                        if ($dbStatusSlug !== 'nouveau' && $dbStatusSlug !== 'en_attente') {
                                            $statusSlug = $dbStatusSlug;
                                            $statusName = $incident->status->name ?? $incident->status;
                                            $statusClass = [
                                                'en_cours' => 'bg-blue-100 text-blue-800',
                                                'resolu' => 'bg-green-100 text-green-800',
                                                'ferme' => 'bg-gray-100 text-gray-800'
                                            ][$dbStatusSlug] ?? 'bg-gray-100 text-gray-800';
                                        }
                                    }
                                @endphp
                                <span class="px-3 py-1 rounded-full text-xs font-medium {{ $statusClass }} shadow-sm">
                                    {{ ucwords(str_replace('_', ' ', $statusName)) }}
                                </span>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="px-5 pb-4">
                            <h2 class="text-lg font-semibold text-gray-900 mb-2">{{ $incident->title }}</h2>
                            <p class="text-gray-700 text-sm leading-relaxed">{{ $incident->description }}</p>
                        </div>

                        <!-- Location -->
                        @php
                            $address1 = $incident->address_line1;
                            $address2 = $incident->address_line2;
                            $city = $incident->city;
                            $postalCode = $incident->postal_code;
                        @endphp
                        @if($address1 || $address2 || $city || $postalCode)
                        <div class="px-5 pb-4">
                            <div class="flex items-start text-sm">
                                <i class="fas fa-map-marker-alt mt-1 mr-2 text-pink-500"></i>
                                <div class="space-y-1">
                                    @if($address1)
                                        <div class="font-medium text-gray-900">{{ $address1 }}</div>
                                        @if($address2)
                                            <div class="text-gray-700">{{ $address2 }}</div>
                                        @endif
                                    @endif
                                    @if($city || $postalCode)
                                    <div class="flex flex-wrap items-center gap-x-3 text-gray-600 mt-1">
                                        @if($city)
                                            <span class="inline-flex items-center">
                                                <i class="fas fa-city mr-1 text-pink-400"></i>
                                                {{ $city }}
                                            </span>
                                        @endif
                                        @if($postalCode)
                                            <span class="inline-flex items-center">
                                                <i class="fas fa-mailbox mr-1 text-pink-400"></i>
                                                {{ $postalCode }}
                                            </span>
                                        @endif
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Media Section -->
                        @if($incident->images->isNotEmpty())
                        <div class="grid grid-cols-{{ $incident->images->count() > 1 ? '2' : '1' }} gap-1">
                            @foreach($incident->images->take(4) as $image)
                            <div class="relative group">
                                <img src="{{ asset('storage/'.$image->path) }}" class="w-full h-56 object-cover group-hover:brightness-75 transition" />
                                @if($loop->last && $incident->images->count() > 4)
                                <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center text-white text-xl font-bold">
                                    +{{ $incident->images->count() - 4 }}
                                </div>
                                @endif
                            </div>
                            @endforeach
                        </div>
                        @endif

                        <!-- Vote & Comment Buttons -->
                        <div class="flex justify-around items-center py-3 border-t bg-gray-50 text-sm text-gray-600">
                            <!-- Vote Button -->
                            <button onclick="vote({{ $incident->id }})" id="vote-btn-{{ $incident->id }}" class="flex items-center space-x-1 hover:text-pink-500 transition">
                                <i class="far fa-thumbs-up"></i>
                                <span id="votes-count-{{ $incident->id }}">{{ $incident->votes_count ?? 0 }}</span>
                            </button>

                            <!-- Toggle Comments -->
                            <button onclick="toggleComments({{ $incident->id }})" class="flex items-center space-x-1 hover:text-pink-500 transition">
                                <i class="far fa-comment"></i><span>Commentaires</span>
                            </button>
                        </div>

                        <!-- Comment Section -->
                        <div id="comments-{{ $incident->id }}" 
                             class="comment-section hidden border-t bg-gray-50 p-4"
                             style="position: relative; z-index: 9999;">
                            <!-- Comment Input -->
                            <div class="flex items-center mb-4" style="position: relative; z-index: 99999;">
                                <input id="comment-input-{{ $incident->id }}" type="text" placeholder="Écrire un commentaire..." class="flex-1 bg-white border border-gray-200 rounded-full px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-pink-300" style="position: relative; z-index: 99999;">
                                <button type="button" 
                                        onclick="event.stopPropagation(); event.preventDefault(); sendComment({{ $incident->id }});"
                                        class="ml-2 text-pink-500 hover:text-pink-600"
                                        style="position: relative; z-index: 999999; cursor: pointer;">
                                    <i class="far fa-paper-plane"></i>
                                </button>
                            </div>

                            <!-- Comments List -->
                            <div id="comment-list-{{ $incident->id }}" class="space-y-3">
                                @foreach($incident->comments as $comment)
                                <div class="bg-white p-3 rounded-lg shadow-sm text-sm">
                                    <span class="font-semibold">{{ $comment->user->name }}</span>
                                    <p class="text-gray-700">{{ $comment->content }}</p>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @empty
                        <div class="text-center py-12 bg-white rounded-lg shadow">
                            <i class="fas fa-inbox text-4xl text-gray-300 mb-3"></i>
                            <p class="text-gray-500">Aucun incident signalé pour le moment</p>
                            <a href="{{ route('citizen.incidents.create') }}" class="mt-4 inline-block btn-primary">
                                Signaler un incident
                            </a>
                        </div>
                    @endforelse
                </div>
                
                <!-- Load More Button -->
                @if($incidents->hasMorePages())
                    <div class="mt-6 text-center">
                        <button class="px-6 py-2 bg-gray-100 text-gray-700 rounded-full text-sm font-medium hover:bg-gray-200 transition-colors">
                            Voir plus de signalements
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        // Toggle sidebar on mobile
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('mobile-show');
        }

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const menuBtn = document.querySelector('.mobile-menu-btn');
            const isClickInsideSidebar = sidebar.contains(event.target);
            const isClickOnMenuBtn = menuBtn.contains(event.target);
            
            if (!isClickInsideSidebar && !isClickOnMenuBtn && window.innerWidth <= 768) {
                sidebar.classList.remove('mobile-show');
            }
        });

        // Update active link based on current URL
        document.addEventListener('DOMContentLoaded', function() {
            const currentPath = window.location.pathname;
            const navLinks = document.querySelectorAll('.nav-link');
            
            navLinks.forEach(link => {
                if (link.getAttribute('href') === currentPath) {
                    link.classList.add('active');
                } else {
                    link.classList.remove('active');
                }
            });
        });

        // Toggle comments section
        function toggleComments(id) {
            document.getElementById('comments-' + id).classList.toggle('hidden');
        }

        // Handle voting
        function vote(id) {
            fetch('/citizen/incidents/' + id + '/vote', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    const voteBtn = document.getElementById('vote-btn-' + id);
                    const votesCount = document.getElementById('votes-count-' + id);
                    votesCount.innerText = data.votes_count;
                    
                    // Toggle active state
                    if (data.has_voted) {
                        voteBtn.classList.add('text-pink-500');
                        voteBtn.classList.remove('text-gray-600');
                    } else {
                        voteBtn.classList.remove('text-pink-500');
                        voteBtn.classList.add('text-gray-600');
                    }
                }
            })
            .catch(error => console.error('Error:', error));
        }

        // Handle sending comments
        function sendComment(id) {
            const input = document.getElementById('comment-input-' + id);
            const content = input.value.trim();
            
            if (!content) return;

            fetch('/citizen/incidents/' + id + '/comment', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ content })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const commentList = document.getElementById('comment-list-' + id);
                    const newComment = document.createElement('div');
                    newComment.className = 'bg-white p-3 rounded-lg shadow-sm text-sm';
                    newComment.innerHTML = `
                        <span class="font-semibold">${data.comment.user_name}</span>
                        <p class="text-gray-700">${data.comment.content}</p>
                        <div class="text-xs text-gray-400 mt-1">À l'instant</div>
                    `;
                    
                    // Add the new comment at the top of the list
                    commentList.insertBefore(newComment, commentList.firstChild);
                    
                    // Clear the input
                    input.value = '';
                    
                    // Show a success message or update UI as needed
                    if (commentList.children.length === 1) {
                        // If this was the first comment, ensure the comments section is visible
                        document.getElementById('comments-' + id).classList.remove('hidden');
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Une erreur est survenue lors de l\'envoi du commentaire.');
            });
        }
    </script>
    <style>
    @foreach($incidents as $incident)
    #comments-{{ $incident->id }} {
        position: relative;
        z-index: 9999;
    }
    #comments-{{ $incident->id }} * {
        position: relative;
        pointer-events: auto !important;
    }
    #comments-{{ $incident->id }} button,
    #comments-{{ $incident->id }} input {
        position: relative !important;
        z-index: 999999 !important;
    }
    @endforeach
    </style>
</body>
</html>