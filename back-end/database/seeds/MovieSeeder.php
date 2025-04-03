<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class MovieSeeder extends AbstractSeed
{
    public function run(): void
    {
        if ($this->hasData()) {
            echo 'A tabela movies já contém dados. Seed não será executado.' . PHP_EOL;
            return;
        }
        $movies = [
            [
                'title' => 'O Último Herói',
                'slug' => 'o-ultimo-heroi',
                'description' => 'Um homem comum descobre poderes extraordinários quando sua cidade é ameaçada por forças sombrias.',
                'cover' => 'movie.svg',
                'trailer_link' => 'https://youtu.be/abcd1234',
                'release_date' => '2023-05-15',
                'duration' => 125,
                // Ação
            ],
            [
                'title' => 'A Jornada Mística',
                'slug' => 'a-jornada-mistica',
                'description' => 'Um grupo de aventureiros parte em busca de um artefato lendário em terras desconhecidas.',
                'cover' => 'movie.svg',
                'trailer_link' => 'https://youtu.be/efgh5678',
                'release_date' => '2022-11-20',
                'duration' => 138,
                // Aventura
            ],
            [
                'title' => 'Risos à Meia-Noite',
                'slug' => 'risos-a-meia-noite',
                'description' => 'Comédia sobre um grupo de amigos que se envolve em situações hilárias durante uma noite inesquecível.',
                'cover' => 'movie.svg',
                'trailer_link' => 'https://youtu.be/ijkl9012',
                'release_date' => '2023-02-10',
                'duration' => 98,
                // Comédia
            ],
            [
                'title' => 'Laços Inquebráveis',
                'slug' => 'lacos-inquebraveis',
                'description' => 'Drama emocionante sobre uma família que supera adversidades através do amor e da união.',
                'cover' => 'movie.svg',
                'trailer_link' => 'https://youtu.be/mnop3456',
                'release_date' => '2023-01-05',
                'duration' => 112,
                // Drama
            ],
            [
                'title' => 'Galáxia Perdida',
                'slug' => 'galaxia-perdida',
                'description' => 'Exploradores espaciais descobrem uma civilização avançada em um planeta distante.',
                'cover' => 'movie.svg',
                'trailer_link' => 'https://youtu.be/qrst7890',
                'release_date' => '2023-07-22',
                'duration' => 145,
                // Ficção Científica
            ],
            [
                'title' => 'O Chamado das Sombras',
                'slug' => 'o-chamado-das-sombras',
                'description' => 'Um grupo de jovens desvenda um mistério sobrenatural em uma casa abandonada.',
                'cover' => 'movie.svg',
                'trailer_link' => 'https://youtu.be/uvwx1234',
                'release_date' => '2023-10-31',
                'duration' => 105,
                // Terror
            ],
            [
                'title' => 'Amor em Paris',
                'slug' => 'amor-em-paris',
                'description' => 'História romântica sobre dois estranhos que se encontram na cidade do amor.',
                'cover' => 'movie.svg',
                'trailer_link' => 'https://youtu.be/yzab5678',
                'release_date' => '2023-02-14',
                'duration' => 118,
                // Romance
            ],
            [
                'title' => 'Mundo Animado',
                'slug' => 'mundo-animado',
                'description' => 'Animação que segue as aventuras de criaturas mágicas em um reino colorido.',
                'cover' => 'movie.svg',
                'trailer_link' => 'https://youtu.be/cdef9012',
                'release_date' => '2023-06-15',
                'duration' => 96,
                // Animação
            ],
            [
                'title' => 'Segredos Ocultos',
                'slug' => 'segredos-ocultos',
                'description' => 'Thriller psicológico sobre um detetive que investiga uma série de crimes aparentemente desconexos.',
                'cover' => 'movie.svg',
                'trailer_link' => 'https://youtu.be/ghij3456',
                'release_date' => '2023-04-05',
                'duration' => 132,
                // Suspense
            ],
            [
                'title' => 'Reino Encantado',
                'slug' => 'reino-encantado',
                'description' => 'Fantasia épica sobre uma jornada para salvar um reino mágico da destruição.',
                'cover' => 'movie.svg',
                'trailer_link' => 'https://youtu.be/klmn7890',
                'release_date' => '2023-08-18',
                'duration' => 152,
                // Fantasia
            ],
            // Mais 15 filmes
            [
                'title' => 'Velocidade Máxima',
                'slug' => 'velocidade-maxima',
                'description' => 'Perseguições alucinantes em uma corrida ilegal que atravessa o país.',
                'cover' => 'movie.svg',
                'trailer_link' => 'https://youtu.be/opqr1234',
                'release_date' => '2023-03-12',
                'duration' => 108,
            ],
            [
                'title' => 'Tesouro do Deserto',
                'slug' => 'tesouro-do-deserto',
                'description' => 'Aventureiros enfrentam perigos extremos em busca de um tesouro lendário.',
                'cover' => 'movie.svg',
                'trailer_link' => 'https://youtu.be/stuv5678',
                'release_date' => '2022-12-08',
                'duration' => 121,
            ],
            [
                'title' => 'Confusão na Festa',
                'slug' => 'confusao-na-festa',
                'description' => 'Comédia sobre um casamento que vira um caos total por uma série de mal-entendidos.',
                'cover' => 'movie.svg',
                'trailer_link' => 'https://youtu.be/wxyz9012',
                'release_date' => '2023-01-20',
                'duration' => 95,
            ],
            [
                'title' => 'Vidas Cruzadas',
                'slug' => 'vidas-cruzadas',
                'description' => 'Drama que mostra como as vidas de cinco estranhos se entrelaçam de formas inesperadas.',
                'cover' => 'movie.svg',
                'trailer_link' => 'https://youtu.be/abcd3456',
                'release_date' => '2023-05-30',
                'duration' => 127,
            ],
            [
                'title' => 'Inteligência Artificial',
                'slug' => 'inteligencia-artificial',
                'description' => 'Um cientista cria uma IA que desenvolve consciência própria, com consequências imprevisíveis.',
                'cover' => 'movie.svg',
                'trailer_link' => 'https://youtu.be/efgh7890',
                'release_date' => '2023-09-14',
                'duration' => 142,
            ],
            [
                'title' => 'A Maldição',
                'slug' => 'a-maldicao',
                'description' => 'Terror sobrenatural sobre uma família assombrada por uma entidade ancestral.',
                'cover' => 'movie.svg',
                'trailer_link' => 'https://youtu.be/ijkl1234',
                'release_date' => '2023-10-13',
                'duration' => 115,
            ],
            [
                'title' => 'Destino de Amor',
                'slug' => 'destino-de-amor',
                'description' => 'Romance sobre duas pessoas separadas pelo destino que se reencontram anos depois.',
                'cover' => 'movie.svg',
                'trailer_link' => 'https://youtu.be/mnop5678',
                'release_date' => '2023-02-28',
                'duration' => 124,
            ],
            [
                'title' => 'Aventuras no Espaço',
                'slug' => 'aventuras-no-espaco',
                'description' => 'Animação sobre um jovem astronauta que viaja pelo sistema solar com seu robô companheiro.',
                'cover' => 'movie.svg',
                'trailer_link' => 'https://youtu.be/qrst9012',
                'release_date' => '2023-07-07',
                'duration' => 89,
            ],
            [
                'title' => 'Jogo de Mentiras',
                'slug' => 'jogo-de-mentiras',
                'description' => 'Suspense sobre um jogo de xadrez entre um detetive e um assassino onde nada é o que parece.',
                'cover' => 'movie.svg',
                'trailer_link' => 'https://youtu.be/uvwx3456',
                'release_date' => '2023-04-22',
                'duration' => 136,
            ],
            [
                'title' => 'O Portal Mágico',
                'slug' => 'o-portal-magico',
                'description' => 'Fantasia sobre crianças que descobrem um portal para um mundo paralelo cheio de criaturas mágicas.',
                'cover' => 'movie.svg',
                'trailer_link' => 'https://youtu.be/yzab7890',
                'release_date' => '2023-08-05',
                'duration' => 102,
            ],
            [
                'title' => 'Missão Explosiva',
                'slug' => 'missao-explosiva',
                'description' => 'Agente secreto precisa impedir um ataque terrorista em uma missão cheia de ação.',
                'cover' => 'movie.svg',
                'trailer_link' => 'https://youtu.be/cdef1234',
                'release_date' => '2023-03-25',
                'duration' => 118,
            ],
            [
                'title' => 'A Montanha Proibida',
                'slug' => 'a-montanha-proibida',
                'description' => 'Aventureiros escalam uma montanha lendária onde muitos desapareceram misteriosamente.',
                'cover' => 'movie.svg',
                'trailer_link' => 'https://youtu.be/ghij5678',
                'release_date' => '2023-06-10',
                'duration' => 131,
            ],
            [
                'title' => 'Férias em Apuros',
                'slug' => 'ferias-em-apuros',
                'description' => 'Comédia sobre uma família cujas férias perfeitas viram um desastre hilário.',
                'cover' => 'movie.svg',
                'trailer_link' => 'https://youtu.be/klmn9012',
                'release_date' => '2023-05-05',
                'duration' => 97,
            ],
            [
                'title' => 'Segunda Chance',
                'slug' => 'segunda-chance',
                'description' => 'Drama sobre um ex-presidiário que tenta reconstruir sua vida e reconquistar sua família.',
                'cover' => 'movie.svg',
                'trailer_link' => 'https://youtu.be/opqr3456',
                'release_date' => '2023-09-28',
                'duration' => 142,
            ],
            [
                'title' => 'Colônia Lunar',
                'slug' => 'colonia-lunar',
                'description' => 'Ficção científica sobre os primeiros colonos humanos na Lua enfrentando uma crise inesperada.',
                'cover' => 'movie.svg',
                'trailer_link' => 'https://youtu.be/stuv7890',
                'release_date' => '2023-11-17',
                'duration' => 148,
            ]
        ];

        $this->table('movies')->insert($movies)->save();
    }

    protected function hasData(): bool
    {
        $count = $this->getAdapter()->fetchRow('SELECT COUNT(*) as count FROM movies')['count'];
        return $count > 0;
    }
}
