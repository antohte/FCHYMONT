<script setup lang="ts">
import { Label } from '@/components/ui/label';
defineProps<{ id: string; label: string; error?: string }>();
</script>
<template>
    <div class="club-form-field">
        <Label :for="id">{{ label }}</Label
        ><slot :id="id" :invalid="!!error" :describedby="error ? `${id}-error` : undefined" />
        <p v-if="error" :id="`${id}-error`" class="club-form-error" role="alert">{{ error }}</p>
    </div>
</template>
