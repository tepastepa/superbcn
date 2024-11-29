@php
    $expiresAt = $post->created_at->addHours(24)->timestamp;
    $currentTime = now()->timestamp;
@endphp

<div class="text-sm text-gray-500" 
     data-expires="{{ $expiresAt }}"
     data-current="{{ $currentTime }}">
    <!-- We'll update this via JS -->
</div> 