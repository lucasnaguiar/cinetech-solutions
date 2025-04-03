export default interface Movie {
    id?: number|null;
    title?: string;
    description?: string;
    genres?: Number[]|Genre[];
    cover?: File|null|string;
    coverPreview?: URL;
    release_date?: string;
    trailer_link?: string;
    duration?:Number|null
};