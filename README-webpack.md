# Webpack

****

Webpack nous permet de gérer et de regrouper différents éléments statiques js | css | images | fonts | videos et autres. Il permet de diviser en petits fichiers modulaires nos applications. Il va les assembler et/ou regrouper certains en fonction des dépendances. Par exemple, si plusieurs modules chargent une librairie caroussel, cette libraire sera extraite dans un fichier séparé pour être chargé ensuite par les modules qui en dépendent.

Dans le cadre du starterkit, nous avons webpack.dev.js et webpack.prod.js qui appellent webpack.base et webpack.config.

Ils sont appelés dans le package.json lors que l'on lance `yarn run dev|prod`
```
"scripts": {
    "prod": "NODE_ENV=production webpack --config webpack/webpack.prod.js",
    "dev": "NODE_ENV=development webpack --watch --config webpack/webpack.dev.js"
},
```

## Configuration

webpack/webpack.config.js et webpack/webpack.base.js

```
entry: {
    app: ['./assets/scss/app.scss', './assets/js/app.js'],
    admin: ['./chemin/custom/feuille.scss', './chemin/custom/fichier.js'],
},
```

l'objet entry est surement le plus important paramètre. webpack va générer autant de fichiers qu'il y a d'entrées. ici dans le cas ci dessus nous aurons app.css / app.js / admin.css / admin.js en sortie.
si on voulait concaténer plusieurs scripts, on ajouterait plusieurs js au tableau
```
entry: {
    ra2023: ['./assets/scss/ra2023.scss',
    './assets/js/modules/flipped-card.js',
    './assets/js/modules/hero-video.js',
    './assets/js/modules/ra2023-container.js',
    './assets/js/modules/slider-by-your-side.js',
    './assets/js/modules/slider-rse.js',
    './assets/js/polyfill/arrayFind.js',
    './assets/js/polyfill/dataset.js',
    './assets/js/polyfill/arrayFrom.js'],
},
```
l'objet output permet de paramètrer l'emplacement où il seront générés

```
output: {
    path: path.join(__dirname, './../web/wp-content/themes', config.theme_name, 'assets'),
    filename: config.output_filename,
    publicPath: config.assets_publicPath,
    chunkFilename: () => './js/chunks/[contenthash].js',
    clean: true, 
},
```

path : le chemin vers le répertoire de sortie

filename : son petit nom (pour laisser le nom de la config on utilise [name])

publicPath : l'url qui sera générée dans le fichier final dans celui qui sera compilé

chunkFilename : chemin et nom des chunks relatif au repo output.path

clean : vide le repertoire output.path


## Loaders

Chaque type de fichier demande un loader spécifique.
Pour nous js est transpilé avec babel mais on pourrait utiliser typescrpit avec ts-loader.

```
{
    test: /\.js$/,
    use: {
        loader: 'babel-loader',
        options: {
            presets: ['@babel/preset-env'],
            plugins: ['@babel/plugin-syntax-dynamic-import'],
        },
    },
},
```

Pour chaque type, on teste l'extension puis suit une config.
La config est spécifique à chaque loader.
Dans le cadre de js, on ajoutera autant de plugins que d'utilisation avancée de concepts (méthodes privées, éléments statiques...). Pour le starterkit avec Conditionner (qui load à la volée les chunks en front), nous avons besoin des imports dynamiques.
La liste des plugins est dispo ici : https://babeljs.io/docs/babel-preset-env


## Plugins

Les plugins fournissent des fonctionnalités supplémentaires et des options de personnalisation pour le processus de regroupement de Webpack. Ils peuvent effectuer des tâches d'optimisation du code, de gestion des ressources, de configuration de l'environnement, et de découpage du code en morceaux. Il existe une vaste gamme de plugins disponibles pour répondre à différents besoins et améliorer votre processus de construction.








