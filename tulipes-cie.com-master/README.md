Tulipes & Cie
=============

- Symfony 3.3
- PHP 7.1
- webpack 2 (ES2015)
- SASS

## Mise en production

Suivre [cette documentation](./Production.md)

## Commandes

Pour lister toutes les commandes disponibles :

```
$ make
```

## Front

Tous les fichiers front-end doivent être mis dans `/front`.

De fait, les fichiers JavaScript et CSS publics sont `web/assets/js/app.js` et `web/assets/css/app.css`.

Penser à créer et remplir le fichier `.env`:

```
cp .env.example .env
```

En dev :

```.env
APP_ENV=dev
```

En prod ou preprod :

```.env
APP_ENV=prod
```

### Lancer le watcher :

```
$ make watch
```

### Compiler les assets sans watcher :

```
$ make build
```

Les source-maps sont construites selon si `APP_ENV` a pour valeur `dev`.

## Twig

Toutes les vues doivent être ajoutées dans `app/Resources/views`.
