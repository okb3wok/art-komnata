# 🧐 About

The website for Design Studio ARTKOMHATA. Project workflow is based on [webpack](https://webpack.js.org/).
Admin panel is based on [AdminLTE v4.0](https://adminlte.io/AdminLTE)  

## Getting started

Install packages with npm (originally v9.1.2, nodeJS v19.0.0):

```sh
npm install
```

## Available Scripts

In the project directory, you can run:

### `npm run dev`

For development using webpack-dev-server. Open [http://localhost:9000](http://localhost:9000) to view it in your browser.
The page will reload when you make changes.

### `npm run build`

Builds the app for production to the `dist` folder. The build is minified js and css.


## Project structure


```text
├─┬ src                  - Source folder
│ ├── adminka            - Admin panel
│ ├── js                 - JavaScript files
│ ├── php                - PHP files
│ ├── scss               - SСSS files
│ ├── static             - Static files
│ ├── templates          - Twig templates
│ └── js                 - JavaScript files
├── webpack.config.js    - Webpack configuration
└── package.json         - info
```

