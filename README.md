## Simple RabbitMQ example

This example uses a simple queue.

To use it :

* git clone the repo
* composer install
* define CLOUDAMQP_URL url ( there is an example for localhost configuration )

Launch the worker : `php worker.php`

Launch the new_task to create a task in the queue : `php new_task.php`

If you want to launch several task use the bash script : `./bash numberOfTasks`

If you are on localhost, you can view several interesting metrics [here](localhost:15672)
