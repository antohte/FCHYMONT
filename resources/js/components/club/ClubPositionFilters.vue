<script setup lang="ts">
import { Button } from '@/components/ui/button';
import type { PlayerPositionOption } from '@/types/player';

defineProps<{ active: string; options: (PlayerPositionOption & { count: number })[] }>();
const emit = defineEmits<{ change: [value: string] }>();
</script>

<template>
    <div class="club-position-filters" role="group" aria-label="Filtrer par poste">
        <Button
            v-for="option in options"
            :key="option.value"
            type="button"
            variant="ghost"
            class="club-position-filter"
            :aria-pressed="active === option.value"
            @click="emit('change', option.value)"
        >
            {{ option.label }}<span>{{ option.count }}</span>
        </Button>
    </div>
</template>
