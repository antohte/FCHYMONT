export interface ClubNews {
    id: string;
    title: string;
    day: string;
    month: string;
    category: string;
    excerpt: string;
    paragraphs: string[];
    photo?: string;
    score?: string;
    opponent?: string;
}
