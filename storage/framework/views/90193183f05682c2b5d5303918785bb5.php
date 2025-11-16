

<?php $__env->startSection('content'); ?>
<div class="min-h-screen py-8 px-4 sm:px-6 lg:px-8 bg-gray-50">
    <div class="max-w-4xl mx-auto">
        <!-- Back button -->
        <div class="mb-6">
            <a href="<?php echo e(route('citizen.dashboard')); ?>" class="inline-flex items-center text-sm text-blue-600 hover:text-blue-800">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Retour au tableau de bord
            </a>
        </div>

        <!-- Incident Card -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden mb-8">
            <!-- Header with status -->
            <div class="px-6 py-5 border-b border-gray-200 flex flex-wrap justify-between items-center">
                <div>
                    <div class="flex items-center">
                        <?php
                            $statusColors = [
                                'En attente' => 'bg-yellow-100 text-yellow-800',
                                'En cours' => 'bg-blue-100 text-blue-800',
                                'Résolu' => 'bg-green-100 text-green-800',
                                'Rejeté' => 'bg-red-100 text-red-800'
                            ];
                            $statusColor = $statusColors[$incident->status->name] ?? 'bg-gray-100 text-gray-800';
                        ?>
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-medium <?php echo e($statusColor); ?>">
                            <?php echo e($incident->status->name); ?>

                        </span>
                        <span class="ml-2 text-sm text-gray-500">
                            Signalé <?php echo e($incident->created_at->diffForHumans()); ?>

                        </span>
                    </div>
                    <h1 class="mt-2 text-2xl font-bold text-gray-900"><?php echo e($incident->title); ?></h1>
                    <div class="mt-1 flex items-center text-sm text-gray-500">
                        <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                        </svg>
                        <?php echo e($incident->location); ?>

                    </div>
                    <?php if($incident->address_line1 || $incident->city || $incident->postal_code): ?>
                    <div class="mt-2 ml-1 pl-5 border-l-2 border-gray-200">
                        <?php if($incident->address_line1): ?>
                            <div class="text-sm text-gray-600"><?php echo e($incident->address_line1); ?></div>
                            <?php if($incident->address_line2): ?>
                                <div class="text-sm text-gray-600"><?php echo e($incident->address_line2); ?></div>
                            <?php endif; ?>
                        <?php endif; ?>
                        <div class="flex flex-wrap items-center text-sm text-gray-500 mt-1">
                            <?php if($incident->postal_code): ?>
                                <span><?php echo e($incident->postal_code); ?></span>
                            <?php endif; ?>
                            <?php if($incident->city): ?>
                                <?php if($incident->postal_code): ?>
                                    <span class="mx-1">•</span>
                                <?php endif; ?>
                                <span><?php echo e($incident->city); ?></span>
                            <?php endif; ?>
                            <?php if($incident->country && $incident->country !== 'Maroc'): ?>
                                <span class="mx-1">•</span>
                                <span><?php echo e($incident->country); ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="mt-4 sm:mt-0 flex space-x-3">
                    <div class="flex items-center space-x-1 bg-gray-50 px-3 py-1.5 rounded-full">
                        <button type="button" class="text-gray-500 hover:text-blue-600 focus:outline-none vote-btn" data-incident-id="<?php echo e($incident->id); ?>" data-vote-type="up">
                            <svg class="h-5 w-5" fill="<?php echo e($incident->userVote && $incident->userVote->type === 'up' ? 'currentColor' : 'none'); ?>" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                            </svg>
                        </button>
                        <span class="text-sm font-medium text-gray-900 vote-count"><?php echo e($incident->upVotes()->count() - $incident->downVotes()->count()); ?></span>
                        <button type="button" class="text-gray-500 hover:text-red-600 focus:outline-none vote-btn" data-incident-id="<?php echo e($incident->id); ?>" data-vote-type="down">
                            <svg class="h-5 w-5" fill="<?php echo e($incident->userVote && $incident->userVote->type === 'down' ? 'currentColor' : 'none'); ?>" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                    </div>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('update', $incident)): ?>
                        <a href="<?php echo e(route('citizen.incidents.edit', $incident)); ?>" class="inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <svg class="-ml-0.5 mr-1.5 h-4 w-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Modifier
                        </a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Incident Content -->
            <div class="px-6 py-5">
                <div class="prose max-w-none">
                    <p class="text-gray-700"><?php echo e($incident->description); ?></p>
                </div>

                <!-- Images Gallery -->
                <?php if($incident->images->count() > 0): ?>
                    <div class="mt-6">
                        <h3 class="text-sm font-medium text-gray-900 mb-3">Photos (<?php echo e($incident->images->count()); ?>)</h3>
                        <div class="grid grid-cols-2 gap-4 sm:grid-cols-3">
                            <?php $__currentLoopData = $incident->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="group relative rounded-lg overflow-hidden bg-gray-100 h-40">
                                    <img src="<?php echo e(Storage::url($image->path)); ?>" alt="Image <?php echo e($loop->iteration); ?>" class="w-full h-full object-cover">
                                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 transition-all duration-200 flex items-center justify-center opacity-0 group-hover:opacity-100">
                                        <button type="button" class="p-2 rounded-full bg-white bg-opacity-80 text-gray-800 hover:bg-opacity-100 focus:outline-none" onclick="openImageModal('<?php echo e(Storage::url($image->path)); ?>')">
                                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5v-4m0 4h-4m4 0l-5-5"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Map -->
                <div class="mt-8">
                    <h3 class="text-sm font-medium text-gray-900 mb-3">Localisation</h3>
                    <div id="incidentMap" class="h-64 w-full rounded-lg border border-gray-300"></div>
                    <p class="mt-2 text-sm text-gray-500"><?php echo e($incident->location); ?></p>
                </div>
            </div>

            <!-- Comments Section -->
            <div class="border-t border-gray-200 px-6 py-5">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Commentaires</h3>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                        <?php echo e($incident->comments->count()); ?> <?php echo e(Str::plural('commentaire', $incident->comments->count())); ?>

                    </span>
                </div>

                <!-- Comment Form -->
                <form action="<?php echo e(route('citizen.comments.store', $incident)); ?>" method="POST" class="mb-6" id="commentForm">
                    <?php echo csrf_field(); ?>
                    <div class="flex space-x-3">
                        <div class="flex-shrink-0">
                            <img class="h-10 w-10 rounded-full" src="<?php echo e(Auth::user()->avatar ? Storage::url(Auth::user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name)); ?>" alt="">
                        </div>
                        <div class="flex-1">
                            <div class="relative">
                                <textarea id="comment" name="content" rows="3" class="shadow-sm block w-full focus:ring-blue-500 focus:border-blue-500 sm:text-sm border border-gray-300 rounded-md p-3" placeholder="Ajouter un commentaire..." required></textarea>
                                <div class="mt-2 flex justify-end">
                                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        Commenter
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- Comments List -->
                <div class="space-y-6" id="commentsContainer">
                    <?php $__empty_1 = true; $__currentLoopData = $incident->comments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="flex space-x-3">
                            <div class="flex-shrink-0">
                                <img class="h-10 w-10 rounded-full" src="<?php echo e($comment->user->avatar ? Storage::url($comment->user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($comment->user->name)); ?>" alt="">
                            </div>
                            <div class="flex-1">
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <p class="text-sm font-medium text-gray-900"><?php echo e($comment->user->name); ?></p>
                                            <p class="text-xs text-gray-500"><?php echo e($comment->created_at->diffForHumans()); ?></p>
                                        </div>
                                    </div>
                                    <div class="mt-2 text-sm text-gray-700">
                                        <?php echo e($comment->content); ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <p class="text-sm text-gray-500 text-center py-4">Aucun commentaire pour le moment. Soyez le premier à commenter !</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Image Modal -->
<div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50 hidden">
    <div class="relative max-w-4xl w-full p-4">
        <button type="button" id="closeImageModal" class="absolute -top-10 right-0 text-white hover:text-gray-300 focus:outline-none">
            <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
        <img id="modalImage" src="" alt="" class="max-h-[80vh] max-w-full mx-auto">
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize map
        const map = L.map('incidentMap').setView([<?php echo e($incident->latitude); ?>, <?php echo e($incident->longitude); ?>], 16);
        
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);
        
        // Add marker
        L.marker([<?php echo e($incident->latitude); ?>, <?php echo e($incident->longitude); ?>])
            .addTo(map)
            .bindPopup('<?php echo e($incident->location); ?>')
            .openPopup();
        
        // Handle voting
        const voteButtons = document.querySelectorAll('.vote-btn');
        voteButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const incidentId = this.dataset.incidentId;
                const voteType = this.dataset.voteType;
                
                fetch(`/incidents/${incidentId}/vote`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({
                        type: voteType
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update vote count
                        document.querySelector('.vote-count').textContent = data.votes.up - data.votes.down;
                        
                        // Update button states
                        const upButton = document.querySelector('.vote-btn[data-vote-type="up"] svg');
                        const downButton = document.querySelector('.vote-btn[data-vote-type="down"] svg');
                        
                        if (data.user_vote === 'up') {
                            upButton.setAttribute('fill', 'currentColor');
                            downButton.setAttribute('fill', 'none');
                        } else if (data.user_vote === 'down') {
                            upButton.setAttribute('fill', 'none');
                            downButton.setAttribute('fill', 'currentColor');
                        } else {
                            upButton.setAttribute('fill', 'none');
                            downButton.setAttribute('fill', 'none');
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            });
        });
        
        // Handle comment form submission with AJAX
        const commentForm = document.getElementById('commentForm');
        if (commentForm) {
            commentForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const formData = new FormData(this);
                const url = this.getAttribute('action');
                
                fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Clear the textarea
                        document.getElementById('comment').value = '';
                        
                        // Create the new comment element
                        const commentsContainer = document.getElementById('commentsContainer');
                        const emptyMessage = commentsContainer.querySelector('.text-center');
                        
                        if (emptyMessage) {
                            commentsContainer.innerHTML = ''; // Remove the empty message
                        }
                        
                        const commentHtml = `
                            <div class="flex space-x-3">
                                <div class="flex-shrink-0">
                                    <img class="h-10 w-10 rounded-full" src="${data.comment.user.avatar ? '/storage/' + data.comment.user.avatar : 'https://ui-avatars.com/api/?name=' + encodeURIComponent(data.comment.user.name)}" alt="">
                                </div>
                                <div class="flex-1">
                                    <div class="bg-gray-50 p-4 rounded-lg">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <p class="text-sm font-medium text-gray-900">${data.comment.user.name}</p>
                                                <p class="text-xs text-gray-500">À l'instant</p>
                                            </div>
                                        </div>
                                        <div class="mt-2 text-sm text-gray-700">
                                            ${data.comment.content}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                        
                        // Add the new comment at the top
                        commentsContainer.insertAdjacentHTML('afterbegin', commentHtml);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            });
        }
    });
    
    // Image modal functions
    function openImageModal(imageSrc) {
        const modal = document.getElementById('imageModal');
        const modalImage = document.getElementById('modalImage');
        
        modalImage.src = imageSrc;
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
    
    function closeImageModal() {
        const modal = document.getElementById('imageModal');
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
    
    // Close modal when clicking the close button or outside the image
    document.getElementById('closeImageModal').addEventListener('click', closeImageModal);
    document.getElementById('imageModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeImageModal();
        }
    });
    
    // Close with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeImageModal();
        }
    });
</script>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
<style>
    #incidentMap {
        height: 300px;
        width: 100%;
    }
    .leaflet-popup-content-wrapper {
        border-radius: 0.5rem;
    }
    .leaflet-popup-content {
        margin: 0.75rem 1rem;
    }
</style>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\zerni\CascadeProjects\windsurf-project-8\SafeCity\resources\views/citizen/incidents/show.blade.php ENDPATH**/ ?>