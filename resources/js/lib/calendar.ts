export function civilDate(value: string) {
    return new Date(`${value}T12:00:00Z`);
}
export function formatMatchDate(value: string, options: Intl.DateTimeFormatOptions = { day: 'numeric', month: 'long', year: 'numeric' }) {
    return new Intl.DateTimeFormat('fr-FR', { ...options, timeZone: 'UTC' }).format(civilDate(value));
}
export function shiftMonth(month: string, offset: number) {
    const date = civilDate(`${month}-01`);
    date.setUTCMonth(date.getUTCMonth() + offset);
    return date.toISOString().slice(0, 7);
}
export function monthDays(month: string): (string | null)[] {
    const first = civilDate(`${month}-01`);
    const offset = (first.getUTCDay() + 6) % 7;
    const end = new Date(Date.UTC(first.getUTCFullYear(), first.getUTCMonth() + 1, 0)).getUTCDate();
    const cells: (string | null)[] = Array(offset).fill(null);
    for (let day = 1; day <= end; day++) cells.push(`${month}-${String(day).padStart(2, '0')}`);
    while (cells.length % 7) cells.push(null);
    return cells;
}
