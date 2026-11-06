<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Link } from '@inertiajs/vue3';
withDefaults(defineProps<{ href: string; variant?: 'primary' | 'secondary' }>(), { variant: 'primary' });
</script>
<template>
    <Button as-child size="lg" :variant="variant === 'primary' ? 'default' : 'outline'" class="club-action" :class="`club-action--${variant}`">
        <Link :href="href"><slot /></Link>
    </Button>
</template>
