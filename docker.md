Pour démarrer les services :

```shell
docker compose up -d --build
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
