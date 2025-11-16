document.addEventListener('DOMContentLoaded', function() {
    // Handle comment submission
    const commentForm = document.getElementById('comment-form');
    if (commentForm) {
        commentForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(commentForm);
            const submitButton = commentForm.querySelector('button[type="submit"]');
            const originalButtonText = submitButton.innerHTML;
            
            // Show loading state
            submitButton.disabled = true;
            submitButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Posting...';
            
            fetch(commentForm.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Clear the form
                    commentForm.reset();
                    
                    // Add the new comment to the list
                    const commentsContainer = document.querySelector('.comments-list');
                    if (commentsContainer) {
                        // If it's the first comment, remove the "No comments" message if it exists
                        const noCommentsMessage = commentsContainer.querySelector('.no-comments');
                        if (noCommentsMessage) {
                            noCommentsMessage.remove();
                        }
                        
                        // Add the new comment at the top
                        commentsContainer.insertAdjacentHTML('afterbegin', data.html);
                        
                        // Scroll to the new comment
                        const newComment = document.getElementById(`comment-${data.comment.id}`);
                        if (newComment) {
                            newComment.scrollIntoView({ behavior: 'smooth' });
                            newComment.classList.add('highlight');
                            setTimeout(() => {
                                newComment.classList.remove('highlight');
                            }, 2000);
                        }
                    }
                    
                    // Show success message
                    showAlert('Comment added successfully!', 'success');
                } else {
                    throw new Error(data.message || 'Failed to post comment');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert(error.message || 'An error occurred while posting your comment', 'danger');
            })
            .finally(() => {
                // Reset button state
                submitButton.disabled = false;
                submitButton.innerHTML = originalButtonText;
            });
        });
    }
    
    // Handle voting
    document.querySelectorAll('.vote-button').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            const incidentId = this.dataset.incidentId;
            const voteType = this.dataset.voteType;
            const url = `/citizen/incidents/${incidentId}/vote`;
            
            // Disable all vote buttons during request
            const voteButtons = document.querySelectorAll(`.vote-button[data-incident-id="${incidentId}"]`);
            voteButtons.forEach(btn => {
                btn.disabled = true;
            });
            
            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ type: voteType })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update vote count
                    const voteCountElement = document.querySelector(`.vote-count[data-incident-id="${incidentId}"]`);
                    if (voteCountElement) {
                        voteCountElement.textContent = data.voteCount;
                    }
                    
                    // Update button states
                    const upvoteButton = document.querySelector(`.vote-button[data-incident-id="${incidentId}"][data-vote-type="up"]`);
                    const downvoteButton = document.querySelector(`.vote-button[data-incident-id="${incidentId}"][data-vote-type="down"]`);
                    
                    if (upvoteButton && downvoteButton) {
                        if (data.userVote === 'up') {
                            upvoteButton.classList.add('active');
                            downvoteButton.classList.remove('active');
                        } else if (data.userVote === 'down') {
                            upvoteButton.classList.remove('active');
                            downvoteButton.classList.add('active');
                        } else {
                            upvoteButton.classList.remove('active');
                            downvoteButton.classList.remove('active');
                        }
                    }
                } else {
                    throw new Error(data.message || 'Failed to process vote');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert(error.message || 'An error occurred while processing your vote', 'danger');
            })
            .finally(() => {
                // Re-enable vote buttons
                voteButtons.forEach(btn => {
                    btn.disabled = false;
                });
            });
        });
    });
    
    // Helper function to show alerts
    function showAlert(message, type = 'info') {
        // Check if an alert already exists and remove it
        const existingAlert = document.querySelector('.alert-dismissible');
        if (existingAlert) {
            existingAlert.remove();
        }
        
        const alertHtml = `
            <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `;
        
        // Add the alert to the top of the content
        const content = document.querySelector('.container.mt-4');
        if (content) {
            content.insertAdjacentHTML('afterbegin', alertHtml);
            
            // Auto-dismiss after 5 seconds
            setTimeout(() => {
                const alert = document.querySelector('.alert-dismissible');
                if (alert) {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }
            }, 5000);
        }
    }
});
