@props(['text' => 'Custom', 'bgColor' => '#EAE0C8', 'textColor' => '#3D3B30'])

<svg width="80" height="80" xmlns="http://www.w3.org/2000/svg" style="border-radius: 8px;">
    <rect width="100%" height="100%" fill="{{ $bgColor }}" />
    <text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle" fill="{{ $textColor }}" font-size="12" font-family="Montserrat, sans-serif" font-weight="bold">
        {{ strtoupper($text) }}
    </text>
</svg>
