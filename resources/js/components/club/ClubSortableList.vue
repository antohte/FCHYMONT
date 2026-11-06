<script setup lang="ts">
import { Button } from '@/components/ui/button';
import type { ContentItem } from '@/types/content';
import { GripVertical } from 'lucide-vue-next';
import { computed, onBeforeUnmount, ref, watch } from 'vue';
const props = defineProps<{ items: ContentItem[]; disabled?: boolean; sortable?: boolean }>();
const emit = defineEmits<{ reorder: [ids: number[]] }>();
const ordered = ref([...props.items]);
watch(
    () => props.items,
    (items) => {
        if (!drag.value) ordered.value = [...items];
    },
);
const list = ref<HTMLElement>();
const drag = ref<{
    id: number;
    pointer: number;
    startX: number;
    startY: number;
    x: number;
    y: number;
    offsetX: number;
    offsetY: number;
    width: number;
    active: boolean;
    handle: HTMLElement;
} | null>(null);
const dragged = computed(() => ordered.value.find((item) => item.id === drag.value?.id));
let frame = 0;
function begin(event: PointerEvent, item: ContentItem) {
    if (props.disabled || !props.sortable || event.button !== 0) return;
    const handle = event.currentTarget as HTMLElement;
    const rect = handle.closest('li')!.getBoundingClientRect();
    drag.value = {
        id: item.id,
        pointer: event.pointerId,
        startX: event.clientX,
        startY: event.clientY,
        x: event.clientX,
        y: event.clientY,
        offsetX: event.clientX - rect.left,
        offsetY: event.clientY - rect.top,
        width: rect.width,
        active: false,
        handle: list.value!,
    };
    list.value!.setPointerCapture(event.pointerId);
}
function place() {
    const state = drag.value;
    if (!state?.active || !list.value) return;
    const rows = (Array.from(list.value.children) as HTMLElement[]).filter((row) => Number(row.dataset.sortId) !== state.id);
    const index = rows.findIndex((row) => state.y < row.getBoundingClientRect().top + row.getBoundingClientRect().height / 2);
    const target = index === -1 ? rows.length : index;
    const current = ordered.value.findIndex((item) => item.id === state.id);
    if (target !== current) {
        const next = [...ordered.value];
        const [item] = next.splice(current, 1);
        next.splice(target, 0, item);
        ordered.value = next;
    }
}
function scroll() {
    const state = drag.value;
    if (!state?.active) return;
    const step = state.y < 90 ? -12 : state.y > window.innerHeight - 90 ? 12 : 0;
    if (step) {
        window.scrollBy(0, step);
        place();
    }
    frame = requestAnimationFrame(scroll);
}
function move(event: PointerEvent) {
    const state = drag.value;
    if (!state || event.pointerId !== state.pointer) return;
    state.x = event.clientX;
    state.y = event.clientY;
    if (!state.active && Math.hypot(state.x - state.startX, state.y - state.startY) > 5) {
        state.active = true;
        frame = requestAnimationFrame(scroll);
    }
    if (state.active) {
        event.preventDefault();
        place();
    }
}
function finish(cancel = false) {
    const state = drag.value;
    if (!state) return;
    cancelAnimationFrame(frame);
    drag.value = null;
    if (state.handle.hasPointerCapture(state.pointer)) state.handle.releasePointerCapture(state.pointer);
    if (cancel) ordered.value = [...props.items];
    else if (state.active && ordered.value.some((item, index) => item.id !== props.items[index]?.id))
        emit(
            'reorder',
            ordered.value.map((item) => item.id),
        );
}
function keyboard(event: KeyboardEvent, index: number) {
    if (event.key === 'Escape') {
        finish(true);
        return;
    }
    if (props.disabled || !['ArrowUp', 'ArrowDown'].includes(event.key)) return;
    event.preventDefault();
    const target = index + (event.key === 'ArrowUp' ? -1 : 1);
    if (target < 0 || target >= ordered.value.length) return;
    const next = [...ordered.value];
    [next[index], next[target]] = [next[target], next[index]];
    ordered.value = next;
    emit(
        'reorder',
        next.map((item) => item.id),
    );
}
onBeforeUnmount(() => {
    cancelAnimationFrame(frame);
});
</script>
<template>
    <ul
        ref="list"
        class="admin-content-list"
        :aria-busy="disabled"
        @pointermove="move"
        @pointerup="finish()"
        @pointercancel="finish(true)"
        @lostpointercapture="finish(true)"
        @keydown.esc="finish(true)"
    >
        <li
            v-for="(item, index) in ordered"
            :key="item.id"
            :data-sort-id="item.id"
            class="admin-content-row"
            :class="{ 'admin-sortable-row--dragging': drag?.active && drag.id === item.id }"
        >
            <Button
                v-if="sortable"
                type="button"
                variant="ghost"
                size="icon"
                class="admin-sortable-handle"
                :disabled="disabled"
                :aria-label="`Déplacer ${item.data.title || item.data.name}. Flèches haut et bas pour réordonner.`"
                @pointerdown="begin($event, item)"
                @keydown="keyboard($event, index)"
                ><GripVertical class="size-5" aria-hidden="true"
            /></Button>
            <slot :item="item" />
        </li>
    </ul>
    <Teleport to="body"
        ><div
            v-if="drag?.active && dragged"
            class="club-theme admin-content-row admin-sortable-tracking"
            aria-hidden="true"
            inert
            :style="{ left: `${drag.x - drag.offsetX}px`, top: `${drag.y - drag.offsetY}px`, width: `${drag.width}px` }"
        >
            <GripVertical class="size-5 shrink-0" /><slot :item="dragged" /></div
    ></Teleport>
    <p class="sr-only" aria-live="polite">{{ drag?.active ? 'Déplacement en cours. Échap pour annuler.' : '' }}</p>
</template>
