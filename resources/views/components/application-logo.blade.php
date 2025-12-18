<svg viewBox="0 0 200 50" xmlns="http://www.w3.org/2000/svg" {{ $attributes }}>
    <defs>
        <linearGradient id="waterGradient" x1="0%" y1="0%" x2="100%" y2="100%">
            <stop offset="0%" style="stop-color:#0EA5E9;stop-opacity:1" />
            <stop offset="100%" style="stop-color:#06B6D4;stop-opacity:1" />
        </linearGradient>
    </defs>

    <!-- Water Drop -->
    <path d="M 20 35 C 20 35 12 25 12 18 C 12 11 16 8 20 8 C 24 8 28 11 28 18 C 28 25 20 35 20 35 Z"
          fill="url(#waterGradient)" opacity="0.9"/>

    <!-- Pulse Wave -->
    <path d="M 32 25 L 38 25 L 41 18 L 44 32 L 47 20 L 50 25 L 56 25"
          stroke="url(#waterGradient)" stroke-width="2.5" fill="none" stroke-linecap="round" stroke-linejoin="round"/>

    <!-- Text "AQUA PULSE" -->
    <text x="62" y="20" font-family="Arial, sans-serif" font-size="14" font-weight="bold" fill="#0F172A">
        AQUA
    </text>
    <text x="62" y="34" font-family="Arial, sans-serif" font-size="14" font-weight="bold" fill="#0EA5E9">
        PULSE
    </text>
</svg>
