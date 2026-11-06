import type { PublicPlayer } from '@/types/player';
export interface PitchSlot {
    id: string;
    label: string;
    x: number;
    y: number;
}
export interface AdminPlayer extends PublicPlayer {
    birthDate: string | null;
    published: boolean;
    showGoals: boolean;
    showSaves: boolean;
    goals: number | null;
    saves: number | null;
}
export type Placement = {
    player_id: number;
    bench: boolean;
    x: number | null;
    y: number | null;
};
