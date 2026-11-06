export interface PublicPlayer {
    id: number;
    displayName: string;
    firstName: string | null;
    lastName: string | null;
    age: number | null;
    position: string;
    positionLabel: string;
    positionCode: string;
    number: number | null;
    photoUrl: string | null;
    statistics?: { label: string; value: number }[];
}

export interface SelectionEntry {
    player: PublicPlayer;
    bench: boolean;
    x: number | null;
    y: number | null;
}

export interface PlayerPositionOption {
    value: string;
    label: string;
}
