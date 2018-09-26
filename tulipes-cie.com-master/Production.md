Mise en production
=============

La production est sur un ovh mutualisé:

[tulipesc-caramia@ssh.cluster007.ovh.net](tulipesc-caramia@ssh.cluster007.ovh.net) et le dossier root est dans `~/site-2018/htdocs` qui pointé par [http://www.tulipes-cie.com](http://www.tulipes-cie.com)

Aucune connection vers l'exterieur n'est possible, il faut donc monter à la main les fichiers.

## Reperer la dernière mise en prod

La dernière mise en prod devrait être un tag git de la forme `MEP_$date`

```
$ git tag | grep MEP_
```

Devrait vous retrouner toutes les mises en prod, prennez la dernière.

## Lister les fichiers modifiés depuis

Ici seuls les fichiers versionnés par Git seront retournés:

```
$ git diff --name-only MEP_$date..master
```

Il faut bien sur remplacer `$date` par le premier résultat de la commande précédente.

Il vous suffit de monter un par un ces fichiers avec `scp`:

*Exemple pour app/Resources/translations/messages.en.yml*

```
scp app/Resources/translations/messages.en.yml tulipesc-caramia@ssh.cluster007.ovh.net:~/site-2018/htdocs/app/Resources/translations/messages.en.yml
```

- **Astuce**: Utiliser le multiligne de sublimeText pour generer la commande

- **Attention**: Certaines lignes (creation de dossier) ne fonctionneront pas il faudra les faire à la main en ssh

- **Attention**: Composer n'est pas présent, en cas d'ajout de paramètres il faudra les faire à la main en ssh

## Générer les assets de production

Modifier votre fichier `.env` à la racine du projet pour changer 

```
APP_ENV=prod
```

Puis lancer un

```
make watch
```

Puis on les monte en prod:

```
scp -r web/assets/* tulipesc-caramia@ssh.cluster007.ovh.net:~/site-2018/htdocs/web/assets
```

## Mise à jour des caches / données

Se connecter en ssh au serveur puis lancer

```
bin/console doctrine:schema:update --dump-sql
```

Vérifier que ça parait bon dans quel cas

```
bin/console doctrine:schema:update --force
```

Mettre à jour les assets (hard-copy)

```
bin/console assets:install
```

Vider le cache

```
bin/console ca:cl -e=prod
```

## Prier...

ça marche ? tant mieux ! Mais c'est pas finit.

## Mise à jour du git

Si tout est OK, il faut créer un nouveau tag git pour la MEP:

Bien sur il faut remplacer `$date` par la date du jour en YYYYMMDD

```
git commit --allow-empty -m "Mise en prod"
```

```
git tag -a MEP_$date -m "Mise en production: Rentrer le détail de la mise à jour..."
```

```
git push
```

**Et voilà !**