'use strict';
const path = require('path');

module.exports = function (plop) {
	// Plugin generator
	plop.setGenerator('Create a plugin', {
		description: 'Lets you create a Joomla plugin',
		prompts: [
			{
				type: 'input',
				name: 'pluginType',
				default: 'system',
				message: 'What is your plugin type (eg: content / system / user) ?',
				validate: function (value) {
					if ((/.+/).test(value)) { return true; }
					return 'plugin type is required';
				}
			},
			{
				type: 'input',
				name: 'pluginName',
				message: 'What is your plugin name?',
				validate: function (value) {
					if ((/.+/).test(value)) { return true; }
					return 'plugin name is required';
				}
			},
			{
				type: 'input',
				name: 'version',
				message: 'What is your plugin version?',
				default: '1.0.0',
				validate: function (value) {
					if ((/.+/).test(value)) {
						return true;
					}
				}
			},
			{
				type: 'input',
				name: 'creationDate',
				message: 'What is your plugin creation date?',
				default: new Date().toLocaleDateString('en-GB', { day: 'numeric', month: 'short', year: 'numeric' }),
				validate: function (value) {
					if ((/.+/).test(value)) {
						return true;
					}
				}
			},
			{
				type: 'input',
				name: 'author',
				message: 'What is your plugin author name?',
				default: 'Techjoomla',
				validate: function (value) {
					if ((/.+/).test(value)) {
						return true;
					}
				}
			},
			{
				type: 'input',
				name: 'authorEmail',
				message: 'What is your plugin author email?',
				default: 'contact@techjoomla.com',
				validate: function (value) {
					if ((/.+/).test(value)) {
						return true;
					}
				}
			},
			{
				type: 'input',
				name: 'authorUrl',
				message: 'What is your plugin author Url?',
				default: 'https:/techjoomla.com',
				validate: function (value) {
					if ((/.+/).test(value)) {
						return true;
					}
				}
			},
			{
				type: 'input',
				name: 'copyright',
				message: 'What is your copyright?',
				default: 'Copyright (C) 2009 - 2019 Techjoomla. All rights reserved.',
				validate: function (value) {
					if ((/.+/).test(value)) {
						return true;
					}
				}
			},
			{
				type: 'input',
				name: 'licence',
				message: 'What is your plugin licence?',
				default: 'http:/www.gnu.org/licenses/gpl-2.0.html GNU/GPL',
				validate: function (value) {
					if ((/.+/).test(value)) {
						return true;
					}
				}
			},
		],

		actions: function(data) {
			var actions = [
				{
					type: 'add',
					path: 'output/plugins/{{ lowerCase pluginName }}/{{ lowerCase pluginName }}.php',
					templateFile: 'templates/plugin/plugin.php',
					abortOnFail: true
				},
				{
					type: 'add',
					path: 'output/plugins/{{ lowerCase pluginName }}/{{ lowerCase pluginName }}.xml',
					templateFile: 'templates/plugin/plugin.xml',
					abortOnFail: true
				},
				{
					type: 'add',
					path: 'output/plugins/{{ lowerCase pluginName }}/index.html',
					templateFile: 'templates/plugin/index.html',
					abortOnFail: true
				},
				{
					type: 'add',
					path: 'output/plugins/{{ lowerCase pluginName }}/language/en-GB/en-GB.plg_{{ lowerCase pluginType }}_{{ lowerCase pluginName }}.ini',
					templateFile: 'templates/plugin/language/en-GB/en-GB.plg_plugintype_pluginname.ini',
					abortOnFail: true
				},
				{
					type: 'add',
					path: 'output/plugins/{{ lowerCase pluginName }}/language/en-GB/en-GB.plg_{{ lowerCase pluginType }}_{{ lowerCase pluginName }}.sys.ini',
					templateFile: 'templates/plugin/language/en-GB/en-GB.plg_plugintype_pluginname.sys.ini',
					abortOnFail: true
				}
			];

			return actions;
		}
	});

	// Module generator
	plop.setGenerator('Create a module', {
		description: 'Lets you create a Joomla module',
		prompts: [
			{
				type: 'input',
				name: 'moduleName',
				message: 'What is your module name?',
				validate: function (value) {
					if ((/.+/).test(value)) { return true; }
					return 'module name is required';
				}
			},
			{
				type: 'input',
				name: 'version',
				message: 'What is your module version?',
				default: '1.0.0',
				validate: function (value) {
					if ((/.+/).test(value)) {
						return true;
					}
				}
			},
			{
				type: 'input',
				name: 'creationDate',
				message: "What is your module's creation date?",
				default: new Date().toLocaleDateString('en-GB', { day: 'numeric', month: 'short', year: 'numeric' }),
				validate: function (value) {
					if ((/.+/).test(value)) {
						return true;
					}
				}
			},
			{
				type: 'input',
				name: 'author',
				message: 'What is your module author name?',
				default: 'Techjoomla',
				validate: function (value) {
					if ((/.+/).test(value)) {
						return true;
					}
				}
			},
			{
				type: 'input',
				name: 'authorEmail',
				message: 'What is your module author email?',
				default: 'contact@techjoomla.com',
				validate: function (value) {
					if ((/.+/).test(value)) {
						return true;
					}
				}
			},
			{
				type: 'input',
				name: 'authorUrl',
				message: 'What is your module author Url?',
				default: 'https:/techjoomla.com',
				validate: function (value) {
					if ((/.+/).test(value)) {
						return true;
					}
				}
			},
			{
				type: 'input',
				name: 'copyright',
				message: 'What is your copyright?',
				default: 'Copyright (C) 2009 - 2019 Techjoomla. All rights reserved.',
				validate: function (value) {
					if ((/.+/).test(value)) {
						return true;
					}
				}
			},
			{
				type: 'input',
				name: 'licence',
				message: 'What is your module licence?',
				default: 'http:/www.gnu.org/licenses/gpl-2.0.html GNU/GPL',
				validate: function (value) {
					if ((/.+/).test(value)) {
						return true;
					}
				}
			},
		],

		actions: function(data) {
			var actions = [
				{
					type: 'add',
					path: 'output/modules/{{ lowerCase moduleName }}/mod_{{ lowerCase moduleName }}.php',
					templateFile: 'templates/module/mod_modulename.php',
					abortOnFail: true
				},
				{
					type: 'add',
					path: 'output/modules/{{ lowerCase moduleName }}/mod_{{ lowerCase moduleName }}.xml',
					templateFile: 'templates/module/mod_modulename.xml',
					abortOnFail: true
				},
				{
					type: 'add',
					path: 'output/modules/{{ lowerCase moduleName }}/helper.php',
					templateFile: 'templates/module/helper.php',
					abortOnFail: true
				},
				{
					type: 'add',
					path: 'output/modules/{{ lowerCase moduleName }}/index.html',
					templateFile: 'templates/module/index.html',
					abortOnFail: true
				},
				{
					type: 'add',
					path: 'output/modules/{{ lowerCase moduleName }}/tmpl/default.php',
					templateFile: 'templates/module/tmpl/default.php',
					abortOnFail: true
				},
				{
					type: 'add',
					path: 'output/modules/{{ lowerCase moduleName }}/tmpl/index.html',
					templateFile: 'templates/module/tmpl/index.html',
					abortOnFail: true
				},
				{
					type: 'add',
					path: 'output/modules/{{ lowerCase moduleName }}/language/en-GB/en-GB.mod_{{ lowerCase moduleName }}.ini',
					templateFile: 'templates/module/language/en-GB/en-GB.mod_modulename.ini',
					abortOnFail: true
				},
				{
					type: 'add',
					path: 'output/modules/{{ lowerCase moduleName }}/language/en-GB/en-GB.mod_{{ lowerCase moduleName }}.sys.ini',
					templateFile: 'templates/module/language/en-GB/en-GB.mod_modulename.sys.ini',
					abortOnFail: true
				}
			];

			return actions;
		}
	});

	// Component generator
	plop.setGenerator('Create MVC skeleton for a view', {
		description: 'Lets you create MVC skeleton for view - model, controller, view',
		prompts: [
			{
				type: 'input',
				name: 'componentName',
				message: 'What is your component name (skipping `com_` part eg: users)?',
				validate: function (value) {
					if ((/.+/).test(value)) { return true; }
					return 'component name is required';
				}
			},
			{
				type: 'list',
				name: 'viewType',
				message: 'What type of view you want to build?',
				choices: ['list', 'form', 'details'],
				validate: function (value) {
					if ((/.+/).test(value)) { return true; }
					return 'view type is required';
				}
			},
			{
				type: 'input',
				name: 'viewName',
				message: 'What is your view name (eg: records( list) / recordform (form)/ record (details))?',
				validate: function (value) {
					if ((/.+/).test(value)) { return true; }
					return 'view name is required';
				}
			},
			{
				type: 'input',
				name: 'entityName',
				message: 'What is your entity name (eg: student / record / product)?',
				validate: function (value) {
					if ((/.+/).test(value)) { return true; }
					return 'entity name is required';
				}
			},
			{
				type: 'input',
				name: 'tableName',
				message: 'What is your table name without table prefix (eg: table_name)?',
				validate: function (value) {
					if ((/.+/).test(value)) { return true; }
					return 'table name is required';
				}
			},
			{
				type: 'input',
				name: 'sortingColumn',
				message: 'What is default sorting column?',
				default: 'id',
				validate: function (value) {
					if ((/.+/).test(value)) { return true; }
					return 'sorting column is required';
				}
			},
			{
				type: 'input',
				name: 'sortingDirection',
				message: 'What is default sorting direction?',
				default: 'desc',
				validate: function (value) {
					if ((/.+/).test(value)) { return true; }
					return 'sorting direction is required';
				}
			},
			{
				type: 'input',
				name: 'version',
				message: 'What is your component version?',
				default: '__DEPLOY_VERSION__',
				validate: function (value) {
					if ((/.+/).test(value)) {
						return true;
					}
				}
			},
			{
				type: 'input',
				name: 'copyright',
				message: 'What is your copyright?',
				default: 'Copyright (C) 2009 - 2019 Techjoomla. All rights reserved.',
				validate: function (value) {
					if ((/.+/).test(value)) {
						return true;
					}
				}
			},
			{
				type: 'input',
				name: 'licence',
				message: 'What is your module licence?',
				default: 'http:/www.gnu.org/licenses/gpl-2.0.html GNU/GPL',
				validate: function (value) {
					if ((/.+/).test(value)) {
						return true;
					}
				}
			},
		],

		actions: function(data) {
			var actions = [];
			var action = {};

			switch (data.viewType)
			{
				case 'list':
					action = {
						type: 'add',
						path: 'output/components/{{ lowerCase componentName }}/components/{{ lowerCase componentName }}/models/{{ lowerCase viewName }}.php',
						templateFile: 'templates/component/site/models/list.php',
						abortOnFail: true
					};

					actions.push(action);
				break;

				case 'form':
					// Add model
					action = {
						type: 'add',
						path: 'output/components/{{ lowerCase componentName }}/components/com_{{ lowerCase componentName }}/models/{{ lowerCase viewName }}.php',
						templateFile: 'templates/component/site/models/form.php',
						abortOnFail: true
					};

					actions.push(action);

					// Add form.xml
					action = {
						type: 'add',
						path: 'output/components/{{ lowerCase componentName }}/components/com_{{ lowerCase componentName }}/models/forms/{{ lowerCase viewName }}.xml',
						templateFile: 'templates/component/site/models/forms/form.xml',
						abortOnFail: true
					};

					actions.push(action);

					// View
					action = {
						type: 'add',
						path: 'output/components/{{ lowerCase componentName }}/components/com_{{ lowerCase componentName }}/views/{{ lowerCase viewName }}/view.html.php',
						templateFile: 'templates/component/site/views/form/view.html.php',
						abortOnFail: true
					};

					actions.push(action);

					// View - tmpl
					action = {
						type: 'add',
						path: 'output/components/{{ lowerCase componentName }}/components/com_{{ lowerCase componentName }}/views/{{ lowerCase viewName }}/tmpl/default.php',
						templateFile: 'templates/component/site/views/form/tmpl/default.php',
						abortOnFail: true
					};

					actions.push(action);

					// Add controller
					action = {
						type: 'add',
						path: 'output/components/{{ lowerCase componentName }}/components/com_{{ lowerCase componentName }}/controllers/{{ lowerCase viewName }}.php',
						templateFile: 'templates/component/site/controllers/form.php',
						abortOnFail: true
					};

					actions.push(action);

					// Lang. file for form
					action = {
						type: 'add',
						path: 'output/components/{{ lowerCase componentName }}/languages/en-GB/en-GB.{{ lowerCase viewName }}.ini',
						templateFile: 'templates/component/languages/site/en-GB/en-GB.form.ini',
						abortOnFail: true
					};

					actions.push(action);
				break;

				default:
			}

			return actions;
		}
	});
};
