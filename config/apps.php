<?php

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| Publisher and apps
|--------------------------------------------------------------------------
|
| Everything the site knows about the apps lives here: adding an app is a
| new entry below plus its content in resources/content/{slug}/ and its
| images in public/images/apps/{slug}/.
|
| Store URLs stay null until the app is live: the page then shows
| "coming soon" instead of a store badge.
|
*/

return [

    'publisher' => [
        'name' => 'Jacob Delcroix',
        'email' => env('PUBLISHER_EMAIL', 'delcroix.jacob@gmail.com'),
    ],

    /*
    | Lines served at /app-ads.txt (IAB). One per ad network seller account.
    | AdMob: Apps > app-ads.txt shows the exact line for the account.
    */
    'app_ads' => [
        'google.com, pub-4373645067445165, DIRECT, f08c47fec0942fa0',
    ],

    'apps' => [

        'atout-tarot' => [
            'name' => 'Atout Tarot',
            'accent' => '#252F66',
            'accent_soft' => '#C9962F',
            'platforms' => ['ios', 'android'],
            'stores' => [
                'ios' => env('ATOUT_TAROT_APP_STORE_URL'),
                'android' => env('ATOUT_TAROT_PLAY_STORE_URL'),
            ],
            'has_ads' => true,
            'screenshots' => 0,
            'tagline' => [
                'fr' => 'La feuille de marque du tarot, sans carnet ni stylo.',
                'en' => 'The French Tarot score sheet, without pen and paper.',
            ],
            'summary' => [
                'fr' => 'Saisissez la donne, Atout Tarot calcule les points de chaque joueur selon les règles de la FFT. De 3 à 5 joueurs par donne, jusqu\'à 10 à la table.',
                'en' => 'Enter the hand and Atout Tarot works out every player\'s points by the official French rules. 3 to 5 players per hand, up to 10 at the table.',
            ],
            'features' => [
                'fr' => [
                    ['Une donne en quelques touches', 'Preneur, contrat, roi appelé, bouts et points : c\'est tout. Petit au bout et poignées restent repliés jusqu\'à ce que vous en ayez besoin.'],
                    ['Le calcul selon la FFT', 'Petite, Garde, Garde sans, Garde contre, points à faire selon les bouts, demi-points arrondis comme vous le voulez.'],
                    ['De 3 à 10 joueurs', 'L\'app indique qui donne et qui passe son tour à chaque donne. Quelqu\'un arrive en cours de partie ? Ajoutez-le.'],
                    ['Une feuille de score lisible', 'Totaux cumulés, leader en évidence, et une erreur se corrige en deux touches : tout est recalculé.'],
                    ['Statistiques et titres', 'Le Boss, le Kamikaze, la Donne du siècle… Chaque partie a ses héros, et ses victimes.'],
                    ['Hors ligne et sans compte', 'Vos parties restent sur votre téléphone. Mode sombre, en français et en anglais.'],
                ],
                'en' => [
                    ['A hand in a few taps', 'Taker, contract, called king, oudlers and points: that\'s it. Petit au bout and handfuls stay tucked away until you need them.'],
                    ['Scored by the official rules', 'Small, Guard, Guard without, Guard against, points needed by oudlers, half points rounded your way.'],
                    ['3 to 10 players', 'The app shows who deals and who sits out each hand. Someone joins mid-game? Add them.'],
                    ['A clear score sheet', 'Running totals, leader highlighted, and a mistake takes two taps to fix: everything is recalculated.'],
                    ['Stats and titles', 'The Boss, the Kamikaze, the Hand of the Century… Every game has its heroes, and its victims.'],
                    ['Offline, no account', 'Your games stay on your phone. Dark mode, in English and French.'],
                ],
            ],
            'note' => [
                'fr' => 'Gratuite avec publicité, jamais pendant la saisie d\'une donne ni sur la feuille de score. Premium (achat unique) retire la publicité et débloque la courbe des scores, la carte image du résultat et les statistiques entre amis.',
                'en' => 'Free with ads, never while you enter a hand or on the score sheet. Premium (one-time purchase) removes ads and unlocks the score chart, the result image card and stats between friends.',
            ],
        ],

        'hooparo' => [
            'name' => 'Hooparo',
            'accent' => '#0A1F47',
            'accent_soft' => '#FF7019',
            'platforms' => ['ios'],
            'stores' => [
                'ios' => env('HOOPARO_APP_STORE_URL'),
                'android' => null,
            ],
            'has_ads' => false,
            'screenshots' => 4,
            'tagline' => [
                'fr' => 'Les stats de vos matchs de basket, depuis le banc.',
                'en' => 'Your basketball game stats, right from the bench.',
            ],
            'summary' => [
                'fr' => 'Suivez chaque tir, rebond et passe décisive pendant le match, et retrouvez la feuille de stats complète de vos joueurs dès le coup de sifflet final. Sur iPhone et iPad.',
                'en' => 'Track every shot, rebound and assist during the game, and get your players\' full stat sheet the moment the final buzzer sounds. On iPhone and iPad.',
            ],
            'features' => [
                'fr' => [
                    ['Pendant le match', 'Tirs réussis et manqués, rebonds, passes, interceptions, contres, balles perdues et fautes, avec chrono, périodes et temps morts.'],
                    ['Changements rapides', 'Cinq de départ et changements en deux touches. Temps de jeu et +/- calculés automatiquement.'],
                    ['Après le match', 'Box score de l\'équipe, fiche détaillée de chaque joueur et graphiques du match.'],
                    ['Vos équipes', 'Joueurs avec photo et numéro de maillot, pour toutes vos équipes.'],
                    ['iPhone et iPad', 'Vos équipes et matchs synchronisés via votre iCloud, même sans réseau au fond du gymnase.'],
                    ['Aucune donnée collectée', 'Pas de compte, pas de pub, pas de traceur.'],
                ],
                'en' => [
                    ['During the game', 'Made and missed shots, rebounds, assists, steals, blocks, turnovers and fouls, with game clock, periods and timeouts.'],
                    ['Quick substitutions', 'Starting lineup and subs in two taps. Minutes and +/- computed for you.'],
                    ['After the game', 'Team box score, detailed stats for every player and game charts.'],
                    ['Your teams', 'Players with photo and jersey number, for all your teams.'],
                    ['iPhone and iPad', 'Teams and games synced through your iCloud, even offline deep inside the gym.'],
                    ['No data collected', 'No account, no ads, no trackers.'],
                ],
            ],
            'note' => [
                'fr' => 'Pensée pour les coachs, assistants et parents.',
                'en' => 'Built for coaches, assistants and parents.',
            ],
        ],

    ],

];
