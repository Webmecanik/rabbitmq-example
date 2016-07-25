#!/bin/bash

for ((i=1; i<=$1; i++)); do
  uuid=`pwgen 13 1`
  php new_task.php ${uuid}
done
