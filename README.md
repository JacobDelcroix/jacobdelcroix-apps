# Jacob Delcroix — Apps

Le site de l'éditeur : une landing page pour toutes les apps, une page par app, et les pages que les
stores et la pub demandent (confidentialité, support, mentions légales, `app-ads.txt`).

Laravel 13, Blade et Tailwind 4, sans base de données. Le français est à la racine, l'anglais sous `/en`.

## URLs

| Page | Français | Anglais |
|---|---|---|
| Accueil | `/` | `/en` |
| App | `/{app}` | `/en/{app}` |
| Confidentialité | `/{app}/confidentialite` | `/en/{app}/privacy` |
| Support | `/{app}/support` | `/en/{app}/support` |
| Mentions légales | `/mentions-legales` | `/en/legal-notice` |

Plus, à la racine :
- `/app-ads.txt` : lu par AdMob, il doit être à la racine du domaine déclaré comme site du
  développeur sur les stores.
- `/apps.json?except={app}` : la liste « Nos autres apps » des apps. Seules les apps qui ont un lien
  de store y figurent. À mettre dans `BRAND_OTHER_APPS_URL`.
- `/sitemap.xml`.

## Ajouter une app

1. Une entrée dans `config/apps.php` : nom, couleurs, plateformes, textes FR/EN, pub ou non.
2. Ses textes dans `resources/content/{slug}/` : `privacy.fr.md`, `privacy.en.md`, `support.fr.md`,
   `support.en.md`. `{email}` et `{publisher}` y sont remplacés.
3. Ses images dans `public/images/apps/{slug}/` : `icon.png` (512 px) et, si besoin, des captures
   `fr-1.jpg`, `en-1.jpg`… (leur nombre va dans `screenshots`).
4. Une fois l'app publiée, ses liens de store dans l'env (`ATOUT_TAROT_APP_STORE_URL`,
   `ATOUT_TAROT_PLAY_STORE_URL`, `HOOPARO_APP_STORE_URL`) : les badges remplacent « Bientôt ».

## En local

Herd sert le dossier : <http://jacobdelcroix-apps.test>.

```bash
composer install && npm install && npm run build
php artisan test --compact
```

## Mise en ligne (Laravel Cloud)

1. Laravel Cloud → New application → ce dépôt GitHub, branche `main`.
2. Build : `composer install --no-dev` puis `npm ci && npm run build` (réglage par défaut).
3. Variables : `APP_KEY`, `APP_URL` (le domaine final), `APP_ENV=production`, `APP_DEBUG=false`,
   et les liens de store quand ils existent. Pas de base de données : laisser `DB_CONNECTION=sqlite`.
4. Domaine : le domaine `*.laravel.cloud` suffit pour commencer. Il devient le « site du
   développeur » dans App Store Connect, Play Console et AdMob. Changer de domaine plus tard oblige
   à le mettre à jour dans les trois.
