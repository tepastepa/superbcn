export function initializeTimers() {
    function updateTimers() {
        document.querySelectorAll('.countdown-timer').forEach(timer => {
            const expiresAt = parseInt(timer.dataset.expires);
            const now = Math.floor(Date.now() / 1000);
            const likesCount = parseInt(timer.dataset.likes);

            // If post has enough likes
            if (likesCount >= 10) {
                timer.textContent = 'SAVED';
                return;
            }

            const timeLeft = expiresAt - now;

            // Handle expired posts
            if (timeLeft <= 0) {
                timer.textContent = '00:00:00';
                timer.closest('.countdown-timer-container').classList.add('bg-red-500', 'bg-opacity-20');
                return;
            }

            // Calculate time components
            const hours = String(Math.floor(timeLeft / 3600)).padStart(2, '0');
            const minutes = String(Math.floor((timeLeft % 3600) / 60)).padStart(2, '0');
            const seconds = String(Math.floor(timeLeft % 60)).padStart(2, '0');

            // Format display with colons only
            timer.textContent = `${hours}:${minutes}:${seconds}`;

            // Add warning class if less than 1 hour remains
            if (parseInt(hours) < 1) {
                timer.closest('.countdown-timer-container').classList.add('bg-yellow-500', 'bg-opacity-20');
            }
        });
    }

    // Clear any existing interval
    if (window.timerInterval) {
        clearInterval(window.timerInterval);
    }

    // Start new interval if we have timers
    const countdownElements = document.querySelectorAll('.countdown-timer');
    if (countdownElements.length > 0) {
        window.timerInterval = setInterval(updateTimers, 1000);
        updateTimers(); // Initial update
    }
} 