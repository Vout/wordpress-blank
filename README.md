# Blank Wordpress starter theme for new projects
Simply clone or download the repository, run `npm install`, and `npm start` for development or `npm build` to run an production build

## Dev Dependencies

-  [@babel/core](https://www.npmjs.com/package/@babel/core)
-  [@babel/preset-env](https://www.npmjs.com/package/@babel/preset-env)
-  [babel-loader](https://www.npmjs.com/package/babel-loader)
-  [browser-sync](https://www.npmjs.com/package/browser-sync)
-  [browser-sync-webpack-plugin](https://www.npmjs.com/package/browser-sync-webpack-plugin)
-  [copy-webpack-plugin](https://www.npmjs.com/package/copy-webpack-plugin)
-  [css-loader](https://www.npmjs.com/package/css-loader)
-  [imagemin-webpack-plugin](https://www.npmjs.com/package/imagemin-webpack-plugin)
-  [mini-css-extract-plugin](https://www.npmjs.com/package/mini-css-extract-plugin)
-  [node-sass](https://www.npmjs.com/package/node-sass)
-  [optimize-css-assets-webpack-plugin](https://www.npmjs.com/package/optimize-css-assets-webpack-plugin)
-  [postcss-loader](https://www.npmjs.com/package/postcss-loader)
-  [purgecss-webpack-plugin](https://www.npmjs.com/package/purgecss-webpack-plugin)
-  [purgecss-whitelister](https://www.npmjs.com/package/purgecss-whitelister)
-  [sass-loader](https://www.npmjs.com/package/sass-loader)
-  [style-loader](https://www.npmjs.com/package/style-loader)
-  [stylelint](https://www.npmjs.com/package/stylelint)
-  [stylelint-config-rational-order](https://www.npmjs.com/package/stylelint-config-rational-order)
-  [stylelint-config-standard](https://www.npmjs.com/package/stylelint-config-standard)
-  [stylelint-order](https://www.npmjs.com/package/stylelint-order)
-  [stylelint-webpack-plugin](https://www.npmjs.com/package/stylelint-webpack-plugin)
-  [terser-webpack-plugin](https://www.npmjs.com/package/terser-webpack-plugin)
-  [webpack](https://www.npmjs.com/package/webpack)
-  [webpack-cli](https://www.npmjs.com/package/webpack-cli)
-  [webpackbar](https://www.npmjs.com/package/webpackbar)

## Dependencies

-  [Bootstrap](https://getbootstrap.com/)
-  [Popper.js](https://popper.js.org/)
-  [Sal.js](https://www.npmjs.com/package/sal.js)
- [Flickity](https://www.npmjs.com/package/flickity)

## Custom SCSS

General guidelines on the way SCSS must be written can be found here, https://codeguide.co/. For all SCSS that is "non standard Bootstrap" we write our SCSS in BEM style (http://getbem.com/introduction/).

To prevent to specific CSS but also keep the ability to write nested SCSS (while writing it with the BEM guidelines in mind) we write it as the example below:

    .card {
	    // .card__header
	    &__header {
			...
		}

		// .card__content
		&__content {
			...
		}

		// .card__footer
		&__footer {
			...
		}

		// .card--expanded
		&--expanded {
			...
		}
	}

Notice the comments before each nested item, because of these comments we can nest while writing our SCSS BEM style but also have the ability to search through our codebase and find specific classes like `.card__header`.
