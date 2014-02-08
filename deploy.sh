#!/bin/bash

git push fr master
cd public && compass compile && cd ..
scp ./public/stylesheets/app.css u-laravelio@ssh9.eu1.frbit.com:htdocs/public/stylesheets
