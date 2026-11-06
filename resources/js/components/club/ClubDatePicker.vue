<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { CalendarDays, ChevronLeft, ChevronRight } from 'lucide-vue-next';
import { computed, nextTick, ref, watch } from 'vue';
const props = defineProps<{ id: string; modelValue: string; invalid?: boolean; describedby?: string }>();
const emit = defineEmits<{ 'update:modelValue': [value: string] }>();
const open = ref(false);
const today = new Date();
const month = ref(new Date(today.getFullYear(), today.getMonth(), 1));
watch(open, (value) => {
    if (value && props.modelValue) {
        const selected = new Date(props.modelValue + 'T12:00:00');
        if (!Number.isNaN(selected.getTime())) month.value = new Date(selected.getFullYear(), selected.getMonth(), 1);
    }
});
const title = computed(() => month.value.toLocaleDateString('fr-FR', { month: 'long', year: 'numeric' }));
const label = computed(() =>
    props.modelValue
        ? new Date(props.modelValue + 'T12:00:00').toLocaleDateString('fr-FR', { day: 'numeric', month: 'long', year: 'numeric' })
        : 'Choisir une date',
);
const days = computed(() => {
    const offset = (month.value.getDay() + 6) % 7;
    return Array.from({ length: offset + new Date(month.value.getFullYear(), month.value.getMonth() + 1, 0).getDate() }, (_, i) =>
        i < offset ? null : i - offset + 1,
    );
});
function move(delta: number) {
    month.value = new Date(month.value.getFullYear(), month.value.getMonth() + delta, 1);
}
function date(day: number) {
    return `${month.value.getFullYear()}-${String(month.value.getMonth() + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
}
function choose(day: number) {
    emit('update:modelValue', date(day));
    open.value = false;
    nextTick(() => document.getElementById(props.id)?.focus());
}
</script>
<template>
    <div class="admin-datepicker" @keydown.esc.stop.prevent="open = false">
        <Button
            :id="id"
            type="button"
            variant="outline"
            class="admin-datepicker__trigger"
            :aria-expanded="open"
            :aria-controls="id + '-calendar'"
            :aria-invalid="invalid"
            :aria-describedby="describedby"
            @click="open = !open"
            ><CalendarDays class="size-4" aria-hidden="true" />{{ label }}</Button
        >
        <div v-if="open" :id="id + '-calendar'" class="admin-datepicker__calendar" role="group" aria-label="Choisir la date de l’article">
            <div class="admin-datepicker__heading">
                <Button type="button" variant="ghost" size="icon" aria-label="Mois précédent" @click="move(-1)"><ChevronLeft class="size-4" /></Button
                ><strong aria-live="polite">{{ title }}</strong
                ><Button type="button" variant="ghost" size="icon" aria-label="Mois suivant" @click="move(1)"><ChevronRight class="size-4" /></Button>
            </div>
            <div class="admin-datepicker__grid">
                <span v-for="day in ['Lu', 'Ma', 'Me', 'Je', 'Ve', 'Sa', 'Di']" :key="day" class="admin-datepicker__weekday">{{ day }}</span
                ><template v-for="(day, index) in days" :key="index"
                    ><Button
                        v-if="day"
                        type="button"
                        :variant="modelValue === date(day) ? 'default' : 'ghost'"
                        :aria-label="new Date(date(day) + 'T12:00:00').toLocaleDateString('fr-FR', { dateStyle: 'full' })"
                        :aria-pressed="modelValue === date(day)"
                        @click="choose(day)"
                        >{{ day }}</Button
                    ><span v-else
                /></template>
            </div>
        </div>
    </div>
</template>
