# WordPress Tweet Archive Importer

Import your Twitter archive into a WordPress.

## importer.php

It generates a mySQL insert query.

Then use phpMyAdmin or mysql terminal to query into your database.

## category.php

Used to update the posts not in X categories. This is necessary because right after you do the mySQL insert the posts will not have category assigned.

Use this script to assign a category to those posts by looking at posts not in certain categories.

## Configuration

Set the values at the begining of the file.

## What it does not import

- No media
- No lists
- No likes
- No DM's

## Potential risks

- It could time out due PHP configuration if you're archive is too big

## Disclaimer

It works with a Twitter Archive generated as **August 8th 2018.**

Can't guarantee it will work after that.

## Contribution

PR's are welcome!