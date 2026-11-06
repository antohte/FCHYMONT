export type FixtureStatus = 'scheduled' | 'finished' | 'postponed' | 'cancelled';
export interface Fixture {
    outcome?: 'win' | 'draw' | 'loss' | null;
    id: number;
    opponent: string;
    date: string;
    time: string | null;
    competition: string;
    venue: string | null;
    home: boolean;
    status: FixtureStatus;
    clubScore: number | null;
    opponentScore: number | null;
    published?: boolean;
}
export const fixtureStatuses: Record<FixtureStatus, string> = {
    scheduled: 'À venir',
    finished: 'Terminé',
    postponed: 'Reporté',
    cancelled: 'Annulé',
};
