#!/bin/bash
for i in {1..100}
do
   time php artisan forum:flood 1000
done
