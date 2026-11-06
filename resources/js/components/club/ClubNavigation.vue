<script setup lang="ts">
import { clubNavigation } from '@/lib/club-navigation';
import { Link } from '@inertiajs/vue3';
defineProps<{ active: string; mobile?: boolean }>();
defineEmits<{ navigate: [] }>();
</script>
<template>
    <nav :aria-label="mobile ? 'Navigation mobile' : 'Navigation principale'" class="club-navigation" :class="{ 'club-navigation--mobile': mobile }">
        <Link
            v-for="item in clubNavigation"
            :key="item.route"
            :href="route(item.route)"
            :aria-current="active === item.route ? 'page' : undefined"
            @click="$emit('navigate')"
        >
            {{ item.label }}
        </Link>
    </nav>
</template>
