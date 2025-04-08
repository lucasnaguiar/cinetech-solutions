export default interface Movie {
    id?: number | null;
    title: string | null;
    genres: number[] | null;
    trailer_link: string | null;
    release_date: string | null; // ISO format (YYYY-MM-DD)
    duration: number | null; // Alterado de string para number
    description: string | null;
    cover?: File | null;
};