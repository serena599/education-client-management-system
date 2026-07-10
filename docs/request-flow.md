# Request Flow Notes

This project uses a legacy PHP request pattern rather than a framework such as Laravel.

## Standard Page Flow

```text
Browser request
-> root PHP page, for example index.php
-> layout/header.php
-> layout/header_script.php
-> config/config.php
-> config/connect.php
-> module classes from script/
-> page content from page/
-> layout/footer.php
```

The header files initialise the database connection, session user, navigation, shared module objects, and page layout.

## Ajax Modal Flow

The top navigation quick access modal is a useful example:

```text
User clicks Learner Quick Access
-> layout/js/nav_bar_script.js runs student_info_nav_bar()
-> modal title opens in JavaScript
-> Ajax POST goes to nav_bar_action.php
-> nav_bar_action.php includes page_action/nav_bar/nav_bar.php
-> PHP returns button HTML
-> JavaScript inserts the response into the modal body
```

This explains why changing the modal required two different files:

- Title: `layout/js/nav_bar_script.js`
- Body content: `page_action/nav_bar/nav_bar.php`

## Cache Busting

The navigation script is loaded with a version query string:

```html
layout/js/nav_bar_script.js?v=20260709
```

This forces the browser to request the updated JavaScript file after local development changes.
