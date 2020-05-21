## About Project
This is REST- API for managing your diet:
- CRUD- dishes for multiple usage
- CRUD- meals to write daily detailed reports and reviewing them via different filters.
- When user got created and personal parameters such as age/weight/height/... specified, user can access the proposition for calories-daily-intake (the frontend side will be able to track it down in convenient ui-ux- design)  

There are 2 types of users:
- Admin: when new dish is proposed (created), they get marked as non-verified - this's where the admin-role is used, because verifying different dishes automatically are barely impossible for small web-project without any additional api's from other sources.
- User: can propose new dishes (with obligation to include calories/(proteins/fats/carbohydrates)/images/...), can add dishes he'd eaten, can access his personal calories-plan (with convenient formulas's-system to include more then one formula)

### Will be added in future
- Mailing users each evening about food-intake-summary.
- Proposals for proteins/fats/carbohydrates for building healthy menu
- Ability to make menu for day/week/month
- Front-end-side built on React with usage of famous libs, for example, for building graphs.

## Installed packages
- spatie/larave-permission - for roles/permissions
- jzonta/faker-restaurant - for populating food
- "dingo/api" - for simplifying rest- api building-process
- "lucadegasperi/oauth2-server-laravel" - OAuth2

## Install
- setup .env, run migrations, ...
- run "composer update"

## Documentation
- https://documenter.getpostman.com/view/10907272/Szt7Aqqr
