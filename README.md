# DB1Os

This repository is destined to show a personal proposal to solve the "DB1 Operational System Problem" for 
application to the "PHP Plêno Developer" position. The document with enunciates for development is [here](https://github.com/carlosbarretoeng/DB1OsProblem/blob/main/questions.pdf)

## 1. SQL Question.

Using SQL-92 standard one of the possible answers is below. To remove the second 'sum' function it's possible to rename the first occurrence of that with a valid name like "numHours" and order by this alias. To keep the question text I choose this way to return the values most close as needed.

``` mysql
select
    name as "Project Name",
    coalesce(sum(hours), 0) as "# Hours"
from projects
    left join projects_efforts on projects_efforts.project_id = projects.id
group by projects.id
order by sum(hours);
```

## 2. DB1 Operational System Memory Issues.

The main goal is to locate a position in a bidimensional array and replace the element with another one following 
some rules.

I used the approach based on computer vision adjacent elements that find the central pixel, and then north, east, 
south, and west pixels. This technique is used in computer vision to filter image noises and homogenize colors in a 
picture.

### The code & How to run

I used a Docker-Compose file to create a development environment. You can find how to install Docker and Docker-Compose 
[here](https://docs.docker.com/get-docker/) and [here](https://docs.docker.com/compose/install/), respectively.

I've developed some Classes to make a proof of concept. I know it is a little bit over than needed, but my focus is the
tests and for this, I needed more functional structures. The source codes are in `src/` folder.

To run the code, please, follow this steps:

1. Clone the repository
> $ git clone https://github.com/carlosbarretoeng/DB1OsProblem.git

2. Install compose packages
> $ docker-compose run composer install

3. Regenerate autoload.php
> $ docker-compose run composer -- dump

4. Run PHPUnit tests
> $ docker-compose run phpunit

## Thanks a lot

For every kind of doubt or issue, I'm here to clarify. Thanks again.