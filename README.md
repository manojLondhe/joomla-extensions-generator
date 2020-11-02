# What does this do?

This lets you create a basic skeleton for a new

- Joomla plugin (Joomla 3.9.x)
- Joomla module (Joomla 3.9.x)
- Joomla views (Joomla 3.9.x) (MVC + table, language files as needed are generated)
  - backend list view (MVC)
  - backend form view (MVC + table)
  - frontend list view (MVC)
  - frontend form view (MVC)
- Joomla CLI script

Thus saving your precious time!

# Prerequisites:

Make sure you have `npm` installed globally

# Steps to use

1. `git clone` this repo

2. `cd` to newly cloned repo

3. Run `npm ci` or `npm install`

4. Run `plop` and start using (use `--force` for overrwriting output files)

5. Find output files generated in `output` directory in repo's root directory

# Assumptions for Joomla view generator:

1. It assumes you already have a component created
2. It assumes, for a new view, database table with following columns is already present

```
TABLE: `#__component_entity`
COLUMNS:
  `id` int(11) UNSIGNED NOT NULL,
  `ordering` int(11) NOT NULL,
  `state` tinyint(1) NOT NULL,
  `checked_out` int(11) NOT NULL,
  `checked_out_time` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
```

# Customizing

If you wish, you can change default copyright, licence by editng `plopfile.js` file
