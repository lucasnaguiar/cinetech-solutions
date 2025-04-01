export default interface Genre {
    id?: number;
    title: string;
    description?: string;
    genres?: [];
    release_date?: string;
    trailer_link?: string;
    duration?:string
};