<script setup lang="ts">
import { cn } from '@/lib/utils';
import type { HTMLAttributes } from 'vue';
const props = defineProps<{ modelValue?: string; class?: HTMLAttributes['class'] }>();
defineEmits<{ 'update:modelValue': [value: string] }>();
</script>
<template><textarea :value="modelValue" :class="cn('flex min-h-24 w-full rounded-md border border-input bg-background px-3 py-2 text-base ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 md:text-sm', props.class)" @input="$emit('update:modelValue', ($event.target as HTMLTextAreaElement).value)" /></template>
