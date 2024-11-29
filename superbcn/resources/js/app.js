import './bootstrap';
import Alpine from 'alpinejs';
import { initializeTimers } from './timer';

window.Alpine = Alpine;
Alpine.start();

// Initialize timers when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    initializeTimers();
    
    // Like functionality
    document.querySelectorAll('.like-button').forEach(button => {
        button.addEventListener('click', async () => {
            const postId = button.dataset.postId;
            try {
                const response = await fetch(`/posts/${postId}/like`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                    },
                });
                const data = await response.json();
                
                // Update like count
                button.querySelector('.like-count').textContent = data.likes_count;
                
                // Toggle like button state
                if (data.liked) {
                    button.classList.add('text-red-500');
                    button.classList.remove('text-gray-600');
                } else {
                    button.classList.remove('text-red-500');
                    button.classList.add('text-gray-600');
                }
            } catch (error) {
                console.error('Error:', error);
            }
        });
    });
});

