<script setup lang="ts">
import { Input } from '@/components/ui/input';
import { Search } from 'lucide-vue-next';

defineProps<{ id: string; label: string; placeholder?: string }>();
const model = defineModel<string>({ required: true });
</script>

<template>
    <div class="club-search-field">
        <label :for="id" class="sr-only">{{ label }}</label>
        <Search aria-hidden="true" />
        <Input :id="id" v-model="model" type="search" :placeholder="placeholder ?? label" autocomplete="off" />
    </div>
</template>
