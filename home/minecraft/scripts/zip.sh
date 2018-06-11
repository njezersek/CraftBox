#!/bin/bash
# A world compression script
zip -r /var/www/html/worlds/export-$1.zip ../saves/$1 ../saves/$1_nether ../saves/$1_the_end
