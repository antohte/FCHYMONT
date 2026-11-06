<script setup lang="ts">
withDefaults(defineProps<{ compact?: boolean }>(), { compact: false });
</script>
<template>
    <span class="club-brand" :class="{ 'club-brand--compact': compact }">
        <img src="/images/club-logo.png" alt="" width="526" height="526" class="club-brand__crest" />
        <span class="club-brand__name">FC Hymont<span v-if="!compact">Football Club</span></span>
    </span>
</template>
