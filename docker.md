Pour démarrer les services :

```shell
docker compose up -d --build
```

En local, `docker-compose.override.yml` monte le code Laravel (`app/`, `resources/`, `routes/`, `config/`, etc.) dans le conteneur.
Les modifications Blade/PHP sont donc visibles après un simple refresh du navigateur.
Un rebuild n'est utile que si vous changez le `Dockerfile`, les dépendances Composer/NPM, ou un asset buildé.

Si vous modifiez `resources/css` ou `resources/js`, lancez aussi :

```shell
npm run dev
```

Urls d'accès :

  - Laravel : http://localhost:8080
  - phpMyAdmin : http://localhost:8081
  - MySQL : 127.0.0.1:3307

Pour arrêter les services :

```shell
 docker compose down
 ```

Repartir de zéro avec réimport complet de la base :

```shell
docker compose down -v
```

Pour exécuter des commandes :
```shell
docker compose exec app sh [ou bash]
```
