<script setup lang="ts">
import ClubFormField from '@/components/club/ClubFormField.vue';
import ClubSelect from '@/components/club/ClubSelect.vue';
import PlayerCard from '@/components/club/PlayerCard.vue';
import PlayerCardArtwork from '@/components/club/PlayerCardArtwork.vue';
import SelectionPitch from '@/components/club/SelectionPitch.vue';
import { Button } from '@/components/ui/button';
import type { PitchSlot, Placement } from '@/types/admin';
import type { PublicPlayer, SelectionEntry } from '@/types/player';
import { computed, nextTick, ref, watch } from 'vue';
const props = defineProps<{ players: PublicPlayer[]; slots: PitchSlot[]; modelValue: Placement[]; disabled?: boolean }>();
const emit = defineEmits<{ 'update:modelValue': [value: Placement[]] }>();
const root = ref<HTMLElement>();
const playerId = ref('');
const selectedId = ref<number>();
const announcement = ref('');
const selected = computed(() => props.modelValue.find((entry) => entry.player_id === selectedId.value));
const available = computed(() =>
    props.players
        .filter((player) => !props.modelValue.some((entry) => entry.player_id === player.id))
        .map((player) => ({ value: String(player.id), label: `${player.displayName} · ${player.positionLabel}` })),
);
const entries = computed<SelectionEntry[]>(() =>
    props.modelValue.flatMap((entry) => {
        const player = props.players.find((player) => player.id === entry.player_id);
        return player ? [{ player, bench: entry.bench, x: entry.x, y: entry.y }] : [];
    }),
);
const starters = computed(() => entries.value.filter((entry) => !entry.bench));
const bench = computed(() => entries.value.filter((entry) => entry.bench));
const occupant = (slot: PitchSlot) => props.modelValue.find((entry) => !entry.bench && entry.x === slot.x && entry.y === slot.y);
const freeSlot = () => props.slots.find((slot) => !occupant(slot));
const currentSlot = computed(
    () => props.slots.find((slot) => selected.value && !selected.value.bench && selected.value.x === slot.x && selected.value.y === slot.y)?.id ?? '',
);
const slotOptions = computed(() =>
    props.slots.map((slot) => {
        const entry = occupant(slot);
        const name = props.players.find((player) => player.id === entry?.player_id)?.displayName;
        return { value: slot.id, label: `${slot.label}${name ? ` · ${name}` : ' · libre'}` };
    }),
);
function add(isBench: boolean) {
    if (props.disabled) return;
    const player = props.players.find((player) => player.id === Number(playerId.value));
    const slot = freeSlot();
    if (!player || props.modelValue.some((entry) => entry.player_id === player.id) || (!isBench && !slot)) return;
    emit('update:modelValue', [
        ...props.modelValue,
        { player_id: player.id, bench: isBench, x: isBench ? null : slot!.x, y: isBench ? null : slot!.y },
    ]);
    selectedId.value = player.id;
    playerId.value = '';
    announcement.value = isBench
        ? `${player.displayName} ajouté aux remplaçants.`
        : `${player.displayName} ajouté à la ${slot!.label.toLocaleLowerCase('fr')}.`;
}
function place(slot: PitchSlot, id = selectedId.value) {
    if (props.disabled) return;
    const source = props.modelValue.find((entry) => entry.player_id === id);
    if (!source) return;
    const target = occupant(slot);
    if (target?.player_id === id) return;
    emit(
        'update:modelValue',
        props.modelValue.map((entry) => {
            if (entry.player_id === id) return { ...entry, bench: false, x: slot.x, y: slot.y };
            if (entry.player_id === target?.player_id) return { ...entry, bench: source.bench, x: source.x, y: source.y };
            return entry;
        }),
    );
    announcement.value = `${props.players.find((player) => player.id === id)?.displayName} : ${slot.label}.${target ? ' Les joueurs ont échangé leur place.' : ''}`;
}
function toggleBench() {
    if (!selected.value || props.disabled) return;
    if (selected.value.bench) {
        const slot = freeSlot();
        if (slot) place(slot);
    } else {
        emit(
            'update:modelValue',
            props.modelValue.map((entry) => (entry.player_id === selectedId.value ? { ...entry, bench: true, x: null, y: null } : entry)),
        );
    }
}
type Drag = {
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
    target?: string;
};
const drag = ref<Drag>();
const draggedPlayer = computed(() => props.players.find((player) => player.id === drag.value?.id));
let ignoreClickUntil = 0;
function pointerDown(event: PointerEvent) {
    if (props.disabled || event.button !== 0 || !event.isPrimary || drag.value) return;
    const item = (event.target as HTMLElement).closest<HTMLElement>('[data-player-id]');
    const card = item?.querySelector<HTMLElement>('.player-card');
    if (!item || !card) return;
    const id = Number(item.dataset.playerId);
    const rect = card.getBoundingClientRect();
    selectedId.value = id;
    drag.value = {
        id,
        pointer: event.pointerId,
        startX: event.clientX,
        startY: event.clientY,
        x: rect.left,
        y: rect.top,
        offsetX: event.clientX - rect.left,
        offsetY: event.clientY - rect.top,
        width: rect.width,
        active: false,
    };
    root.value?.setPointerCapture(event.pointerId);
}
function pointerMove(event: PointerEvent) {
    const state = drag.value;
    if (!state || state.pointer !== event.pointerId) return;
    if (!state.active && Math.hypot(event.clientX - state.startX, event.clientY - state.startY) < 5) return;
    event.preventDefault();
    state.active = true;
    state.x = event.clientX - state.offsetX;
    state.y = event.clientY - state.offsetY;
    const slots = Array.from(root.value!.querySelectorAll<HTMLElement>('[data-slot-id]'));
    const targets = slots
        .map((element) => ({ element, rect: element.getBoundingClientRect() }))
        .filter(
            ({ rect }) =>
                event.clientX >= rect.left - 12 &&
                event.clientX <= rect.right + 12 &&
                event.clientY >= rect.top - 12 &&
                event.clientY <= rect.bottom + 12,
        );
    targets.sort(
        (a, b) =>
            Math.hypot(event.clientX - (a.rect.left + a.rect.width / 2), event.clientY - (a.rect.top + a.rect.height / 2)) -
            Math.hypot(event.clientX - (b.rect.left + b.rect.width / 2), event.clientY - (b.rect.top + b.rect.height / 2)),
    );
    state.target = targets[0]?.element.dataset.slotId;
}
function endDrag(event?: PointerEvent, cancel = false) {
    const state = drag.value;
    if (!state || (event && event.pointerId !== state.pointer)) return;
    if (state.active) {
        ignoreClickUntil = performance.now() + 250;
        const slot = props.slots.find((slot) => slot.id === state.target);
        if (!cancel && slot) place(slot, state.id);
        else announcement.value = 'Déplacement annulé. Le joueur conserve sa place.';
    }
    drag.value = undefined;
    if (root.value?.hasPointerCapture(state.pointer)) root.value.releasePointerCapture(state.pointer);
    void nextTick(() => root.value?.querySelector<HTMLButtonElement>(`[data-player-id="${state.id}"] button`)?.focus({ preventScroll: true }));
}
function captureClick(event: MouseEvent) {
    if (performance.now() < ignoreClickUntil) {
        event.preventDefault();
        event.stopPropagation();
    }
}
watch(
    () => props.disabled,
    (disabled) => {
        if (disabled) endDrag(undefined, true);
    },
);
</script>
<template>
    <div
        ref="root"
        class="admin-selection-editor"
        :class="{ 'admin-selection-editor--dragging': drag?.active }"
        @pointerdown="pointerDown"
        @pointermove="pointerMove"
        @pointerup="endDrag($event)"
        @pointercancel="endDrag($event, true)"
        @lostpointercapture="endDrag($event, true)"
        @keydown.esc.prevent="endDrag(undefined, true)"
        @click.capture="captureClick"
        @dragstart.prevent
    >
        <p class="sr-only" role="status" aria-live="polite">{{ announcement }}</p>
        <div class="admin-composition">
            <div class="admin-composition-pitch">
                <SelectionPitch
                    :entries="starters"
                    :slots="slots"
                    editing
                    :selected-id="selectedId"
                    :opens-dialog="false"
                    :disabled="disabled"
                    :target-slot="drag?.target"
                    :dragging-id="drag?.active ? drag.id : undefined"
                    @select="(player) => (selectedId = player.id)"
                    @place="place"
                />
            </div>
            <aside id="composition-controls" class="admin-composition-controls">
                <h2>La composition</h2>
                <p>{{ starters.length }} / 11 titulaires · {{ bench.length }} remplaçants</p>
                <p class="admin-placement-help">
                    Maintenez une carte et déplacez-la vers une place. Sur une place occupée, les joueurs échangent leur position.
                </p>
                <fieldset :disabled="disabled" class="admin-fields">
                    <legend class="sr-only">Ajouter et placer les joueurs</legend>
                    <ClubFormField id="composition-player" label="Ajouter un joueur publié" v-slot="attrs"
                        ><ClubSelect v-bind="attrs" v-model="playerId" :options="available"
                    /></ClubFormField>
                    <div class="admin-actions">
                        <Button type="button" :disabled="!playerId || starters.length >= slots.length" @click="add(false)">Titulaire</Button>
                        <Button type="button" variant="outline" :disabled="!playerId" @click="add(true)">Remplaçant</Button>
                    </div>
                    <template v-if="selected">
                        <h3>{{ players.find((player) => player.id === selectedId)?.displayName }}</h3>
                        <ClubFormField id="composition-slot" label="Placer sur le terrain" v-slot="attrs"
                            ><ClubSelect
                                v-bind="attrs"
                                :model-value="currentSlot"
                                :options="slotOptions"
                                @update:model-value="
                                    (value) => {
                                        const slot = slots.find((slot) => slot.id === value);
                                        if (slot) place(slot);
                                    }
                                "
                        /></ClubFormField>
                        <Button type="button" variant="outline" :disabled="selected.bench && starters.length >= slots.length" @click="toggleBench">{{
                            selected.bench ? 'Passer titulaire' : 'Passer remplaçant'
                        }}</Button>
                        <Button
                            type="button"
                            variant="ghost"
                            @click="
                                emit(
                                    'update:modelValue',
                                    modelValue.filter((entry) => entry.player_id !== selectedId),
                                );
                                selectedId = undefined;
                            "
                            >Retirer de la composition</Button
                        >
                    </template>
                </fieldset>
            </aside>
        </div>
        <section v-if="bench.length" class="selection-bench">
            <h2>Remplaçants</h2>
            <ul class="admin-bench">
                <li
                    v-for="entry in bench"
                    :key="entry.player.id"
                    :data-player-id="entry.player.id"
                    :class="{ 'selection-player--dragging': drag?.active && drag.id === entry.player.id }"
                >
                    <PlayerCard
                        :player="entry.player"
                        :opens-dialog="false"
                        controls-id="composition-controls"
                        :action-label="`Sélectionner ${entry.player.displayName}`"
                        variant="pitch"
                        :selected="selectedId === entry.player.id"
                        @select="(player) => (selectedId = player.id)"
                    />
                </li>
            </ul>
        </section>
        <Teleport to="body">
            <div
                v-if="drag?.active && draggedPlayer"
                class="club-theme admin-card-tracking"
                aria-hidden="true"
                :style="{ width: `${drag.width}px`, transform: `translate3d(${drag.x}px, ${drag.y}px, 0)` }"
            >
                <PlayerCardArtwork :player="draggedPlayer" />
            </div>
        </Teleport>
    </div>
</template>
