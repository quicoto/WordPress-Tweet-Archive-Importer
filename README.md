# WordPress Tweet Archive Importer

Import your Twitter archive into a WordPress.

## importer.php

It generates a mySQL insert query.

Then use phpMyAdmin or mysql terminal to query into your database.

## category.php

Used to update the posts not in X categories. This is necessary because right after you do the mySQL insert the posts will not have category assigned.

Use this script to assign a category to those posts by looking at posts not in certain categories.

**There's a small issue** where the more times you execute it the longer it takes. My guess is the queries take longer to search?
I suppose we should create mySQL queries instead of using the WordPress function to call the database. For my case, 30K results (in batches of 500) in the end took about 80 seconds each batch. Way to much but well, it works.

## Configuration

Set the values at the begining of the file.

## What it does not do

- No media
- No lists
- No likes
- No DM's

It will output a mySQL query for the wp_posts table.

## Potential risks

It could timeout due mySQL configuration if you're query is too big (100K inserts? it really depends on the server).

Always backup your database before executing queries!

## Disclaimer

It works with a Twitter Archive generated as **August 8th 2018.**

Can't guarantee it will work after that.

## Contribution

PR's are welcome!
