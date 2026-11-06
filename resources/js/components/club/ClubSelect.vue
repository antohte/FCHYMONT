<script setup lang="ts">
import { Check, ChevronDown } from 'lucide-vue-next';
import {
    SelectContent,
    SelectItem,
    SelectItemIndicator,
    SelectItemText,
    SelectPortal,
    SelectRoot,
    SelectTrigger,
    SelectValue,
    SelectViewport,
} from 'radix-vue';
defineProps<{ modelValue: string; id: string; options: { value: string; label: string }[]; invalid?: boolean; describedby?: string }>();
defineEmits<{ 'update:modelValue': [value: string] }>();
</script>
<template>
    <SelectRoot :model-value="modelValue" @update:model-value="$emit('update:modelValue', $event)"
        ><SelectTrigger :id="id" class="club-select" :aria-invalid="invalid || undefined" :aria-describedby="describedby"
            ><SelectValue /><ChevronDown :size="16" aria-hidden="true" /></SelectTrigger
        ><SelectPortal
            ><SelectContent class="club-select-content" position="popper" :side-offset="6"
                ><SelectViewport
                    ><SelectItem v-for="option in options" :key="option.value" :value="option.value" class="club-select-item"
                        ><SelectItemText>{{ option.label }}</SelectItemText
                        ><SelectItemIndicator
                            ><Check :size="16" aria-hidden="true" /></SelectItemIndicator></SelectItem></SelectViewport></SelectContent></SelectPortal
    ></SelectRoot>
</template>
