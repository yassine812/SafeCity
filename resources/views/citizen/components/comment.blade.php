<div class="comment mb-4 p-3 border rounded" id="comment-{{ $comment->id }}">
    <div class="d-flex justify-content-between align-items-start">
        <div class="d-flex align-items-center">
            <img src="{{ $comment->user->avatar ?? asset('images/default-avatar.png') }}" 
                 alt="{{ $comment->user->name }}" 
                 class="rounded-circle me-2" 
                 width="40" 
                 height="40">
            <div>
                <h6 class="mb-0">{{ $comment->user->name }}</h6>
                <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
            </div>
        </div>
        @if(auth()->id() === $comment->user_id)
            <div class="dropdown">
                <button class="btn btn-link text-muted p-0" type="button" id="commentMenu{{ $comment->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-ellipsis-v"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="commentMenu{{ $comment->id }}">
                    <li><a class="dropdown-item edit-comment" href="#" data-comment-id="{{ $comment->id }}">Edit</a></li>
                    <li><a class="dropdown-item text-danger delete-comment" href="#" data-comment-id="{{ $comment->id }}">Delete</a></li>
                </ul>
            </div>
        @endif
    </div>
    <div class="mt-2 comment-content">
        {!! nl2br(e($comment->content)) !!}
    </div>
    <div class="comment-actions mt-2">
        <button class="btn btn-sm btn-link text-muted p-0 me-2 like-comment" data-comment-id="{{ $comment->id }}">
            <i class="far fa-thumbs-up"></i> Like
        </button>
        <button class="btn btn-sm btn-link text-muted p-0 reply-comment" data-comment-id="{{ $comment->id }}">
            Reply
        </button>
    </div>
</div>
