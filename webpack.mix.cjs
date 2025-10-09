let mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
   .vue()
   .webpackConfig({
     resolve: {
       alias: {
         'pdfjs-dist$': 'pdfjs-dist/es5/build/pdf',
         'pdfjs-dist/build/pdf.worker.entry': 'pdfjs-dist/es5/build/pdf.worker.entry'
       }
     }
   });
