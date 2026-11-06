export interface ContentField {
    key: string;
    label: string;
    required: boolean;
    type: string;
}
export type ContentEntry = Record<string, string>;
export interface ContactDetails {
    address?: string;
    entries?: ContentEntry[];
    contact1_name?: string;
    contact1_phone?: string;
    contact2_name?: string;
    contact2_phone?: string;
}
export interface ContentItem {
    id: number;
    data: Record<string, string | string[] | ContentEntry[] | null>;
    is_published: boolean;
    sort_order: number;
}
