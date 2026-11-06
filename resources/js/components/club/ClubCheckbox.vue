<script setup lang="ts">
import { Checkbox } from '@/components/ui/checkbox';
import { Label } from '@/components/ui/label';
defineProps<{ id: string; label: string; error?: string }>();
const model = defineModel<boolean>({ required: true });
</script>
<template>
    <div>
        <div class="flex items-center gap-2 pt-2">
            <Checkbox
                :id="id"
                :checked="model"
                :aria-invalid="!!error || undefined"
                :aria-describedby="error ? `${id}-error` : undefined"
                @update:checked="model = $event === true"
            />
            <Label :for="id" class="cursor-pointer text-sm font-normal">{{ label }}</Label>
        </div>
        <p v-if="error" :id="`${id}-error`" class="club-form-error" role="alert">{{ error }}</p>
    </div>
</template>
