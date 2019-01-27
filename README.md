## TEAMS

#### Assignment

Backend task
The goal is to create a simple REST API using either Laravel or Lumen. The task is time boxed to 4 hours.
Preparations and notes
* Setup a GIT repo
* Make regular commits with proper messages during development
* Write tests for everything you do

Implement as much as you can within 4 hours in prioritized order:
* CRUD functionality for a “user” and a “team” entity
* A user can be assigned to multiple teams
* Set a user as team owner
* Assign different roles to users
* Validate input
* List what teams the users belongs to.

The user should have a name and email property, the team should have a title.
Please also write a short summary of why you decided to make the app in the way you did 
and where you chose to put your focus. What would you have done if you had more time? 
What was easy, what was hard?

#### Set-up
I chose to use Lumen, because it was a very small RESTFUL API.
The underlying technologies are NGINX, MySQL (MariaDB), Git Flow and its coded on PHPStorm.
_(I like to use commandline for git, where I use iTerm, but there are some excellent plugins inside PHPStorm)_

#### Tasks
###### CRUD functionality for a “user” and a “team” entity
*CRUD user*
* store    POST:    `//users` 
* update   PUT:     `//users/{user_id}`
* delete   DELETE:  `//users/{user_id}`
* show     GET:     `//users/{user_id}`
* index    GET:     `//users`

*CRUD team*
* store    POST:    `//teams` 
* update   PUT:     `//teams/{team_id}`
* delete   DELETE:  `//teams/{team_id}`
* show     GET:     `//teams/{team_id}`
* index    GET:     `//teams`

###### A user can be assigned to multiple teams
During store or update you can provide an array of `team_ids`

###### Set a user as team owner
During update or create(store) you can provide `owner_id`

###### Assign different roles to users
During update or create(store) you can provide `role_id`

###### Validate Input
All Restful API endpoint use Laravel/Lumen's validation class to validate input.

###### List what teams the users belongs to
added helper endpoint `/users/{user_id}/teams`

#### Comments
Because I used almost entirely Lumens built in functions, Eloquent etc... then there was not any of those functions to test
so instead i did unit-testing on the RESTFUL API endpoints.