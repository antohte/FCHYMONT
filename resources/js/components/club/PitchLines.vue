<script setup lang="ts">
defineProps<{ stretch?: boolean }>();
</script>

<template>
    <svg
        class="pitch-lines"
        viewBox="0 0 600 800"
        :preserveAspectRatio="stretch ? 'none' : undefined"
        fill="none"
        aria-hidden="true"
        focusable="false"
    >
        <path class="pitch-lines__grass" d="M0 0h600v800H0z" />
        <g stroke="currentColor" stroke-width="2">
            <path d="M30 30h540v740H30zM30 400h540" />
            <circle cx="300" cy="400" r="78" />
            <circle cx="300" cy="400" r="3" fill="currentColor" />
            <path d="M160 30v130h280V30M230 30v50h140V30M160 770V640h280v130M230 770v-50h140v50" />
            <path d="M240 160a78 78 0 0 0 120 0M240 640a78 78 0 0 1 120 0" />
            <circle cx="300" cy="120" r="3" fill="currentColor" />
            <circle cx="300" cy="680" r="3" fill="currentColor" />
        </g>
    </svg>
</template>
