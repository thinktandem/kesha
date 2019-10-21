## [Ke$ha](https://www.youtube.com/watch?v=hHUbLv4ThOo): Tandem's Spork of the Timber Starter Theme feat. [Bootstrap 4](https://getbootstrap.com/)

This site uses an atomic design type structure for it's SaSS.

**Setup**

```
cd path/of/child-theme
npm i
grunt
```

**CSS**

In the ```assets/style``` folder is where all the magic happens.  If you add files to the asset structure, don't forget to include them in the ```assets/style/main.scss``` file.

<<<<<<< HEAD
**JS**
=======
1. Make sure you have installed the plugin for the [Timber Library](https://wordpress.org/plugins/timber-library/) (and Advanced Custom Fields - they [play quite nicely](https://timber.github.io/docs/guides/acf-cookbook/#nav) together). 
2. Download the zip for this theme (or clone it) and move it to `wp-content/themes` in your WordPress installation. 
3. Rename the folder to something that makes sense for your website (generally no spaces and all lowercase). You could keep the name `timber-starter-theme` but the point of a starter theme is to make it your own!
4. Activate the theme in Appearance >  Themes.
5. Do your thing! And read [the docs](https://github.com/jarednova/timber/wiki).
>>>>>>> upstream/master

All the JS goes in the ```assets/js``` folder. If you add more JS files, remember to add them to the themeJs variable in Gruntfile.js.

