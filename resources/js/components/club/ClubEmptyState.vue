<script setup lang="ts">
import { Button } from '@/components/ui/button';
defineProps<{ title: string; description: string; resettable?: boolean }>();
defineEmits<{ reset: [] }>();
</script>

<template>
    <div class="club-empty-state">
        <h2>{{ title }}</h2>
        <p>{{ description }}</p>
        <Button v-if="resettable" type="button" variant="outline" @click="$emit('reset')">Réinitialiser les filtres</Button>
    </div>
</template>
