<script setup lang="ts">
import { ref, watch } from 'vue';

const props = defineProps<{ src: string | null; name: string }>();
const failed = ref(false);
watch(
    () => props.src,
    () => {
        failed.value = false;
    },
);
</script>

<template>
    <div class="player-portrait">
        <img v-if="src && !failed" :src="src" :alt="name" loading="lazy" @error="failed = true" />
        <svg v-else viewBox="0 0 200 220" role="img" aria-label="Portrait non renseigné">
            <circle cx="100" cy="68" r="36" fill="currentColor" opacity=".8" />
            <path d="M65 110 28 129 7 184l36 16 10-27v47h94v-47l10 27 36-16-21-55-37-19-15 18H80Z" fill="currentColor" />
            <path d="m80 128 20 18 20-18M100 147v73" fill="none" stroke="#14161b" stroke-width="4" />
            <path d="m57 117 16 103M143 117l-16 103" stroke="#e5092b" stroke-width="13" opacity=".7" />
        </svg>
    </div>
</template>
