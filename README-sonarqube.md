# Setup Sonarqube en local  

****

## Docker

Sonarqube va fonctionner avec deux containers supplémentaires : sonarqcube et une base postgres

Sonarcube sera accessible à l'adresse http://localhost:9000

**Lancer docker par la commande habituelle**

```
.docker/run.sh
```

Une fois les containers en place se rendre à l'adresse http://localhost:9000

Sonarqube va vous demander de vous logger. Par défaut les log / pass sont **admin / admin**. Sonarqube va vous demander de changer le password au premier log.


## Paramètrage du scan

Une fois loggé, il faut créer un projet : 

- on choisit le setup **Manually**
- on renseigne les deux champs **Project display name** / **Project key**
- le **Projet key** est à copier dans la variable d'environnement **SONAR_KEY** (.docker/.env) 
- Sonarqube nous demande ensuite comment on veut analyser le code : on choisit **Locally**
- Sonarqube va générer un token d'accès pour notre projet : cliquer sur **Generate**
- **Attention** le token ne sera visible qu'à ce moment. **Le copier immédiatement dans la variable d'environnement SONAR_TOKEN (.docker/.env)**
- Valider en cliquant sur **Continue**

A partir de ce moment, Sonarqube est opérationnel.

Lancer le script du scan
```
.docker/scripts/sonar-scan.sh 
```

Il faudra peut être allouer plus de mémoire à Docker, à voir en fonction de vos config


## Configuration du scan

Il est possble d'affiner l'analyse en éditant le fichier **.docker/sonarqube/sonar-project.properties**

Vous avez la possibilité de cibler :
- les repertoires : sonar.sources
- les fichiers : sonar.inclusions

et d'exclure certains sous répertoires : sonar.exclusions
(Attention à garder le /** en fin de chaine)

Une fois le scan effetué, la page du projet sur localhost:9000 est rafraichie et on peut consulter le rapport
