document.addEventListener('DOMContentLoaded', function() {
    function updateCountdown() {
        document.querySelectorAll('.countdown-timer').forEach(timer => {
            const expiresTimestamp = parseInt(timer.dataset.expires);
            const now = Math.floor(Date.now() / 1000);
            const timeLeft = expiresTimestamp - now;

            if (timeLeft <= 0) {
                timer.innerHTML = 'Expired';
                timer.classList.add('text-red-500');
                return;
            }

            const hours = Math.floor(timeLeft / 3600);
            const minutes = Math.floor((timeLeft % 3600) / 60);
            const seconds = timeLeft % 60;

            timer.innerHTML = `${hours}h ${minutes}m ${seconds}s`;

            // Add color classes based on time remaining
            if (timeLeft < 3600) { // less than 1 hour
                timer.classList.remove('text-gray-600', 'text-yellow-500');
                timer.classList.add('text-red-500');
            } else if (timeLeft < 7200) { // less than 2 hours
                timer.classList.remove('text-gray-600', 'text-red-500');
                timer.classList.add('text-yellow-500');
            }
        });
    }

    // Update immediately and then every second
    updateCountdown();
    setInterval(updateCountdown, 1000);
}); 