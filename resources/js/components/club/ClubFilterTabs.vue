<script setup lang="ts">
import { Button } from '@/components/ui/button';
defineProps<{ modelValue: string; label: string; options: { value: string; label: string }[] }>();
defineEmits<{ 'update:modelValue': [value: string] }>();
</script>
<template>
    <div class="calendar-filters" role="group" :aria-label="label">
        <Button
            v-for="option in options"
            :key="option.value"
            variant="ghost"
            :aria-pressed="modelValue === option.value"
            @click="$emit('update:modelValue', option.value)"
            >{{ option.label }}</Button
        >
    </div>
</template>
