'use strict';

const React         = require('react');
const ReactDOM      = require('react-dom');
const App           = require('./../components/app.js');
const File          = require('./../components/routes/file.js');
const routeChecks   = require('./../helpers/common-route-checks.js');

// Load php highlight mode
require('codemirror/mode/javascript/javascript');

module.exports = {
    path: '/{locale}/files/composer-json',
    preController: [routeChecks.ifTensideNotOkRedirectToInstall, routeChecks.ifUserNotLoggedInRedirectToLogin],
    controller: function(request, routing) {
        ReactDOM.render(<App routing={routing}><File apiEndpoint="/api/v1/composer.json" options={{ mode: {name: "javascript", json: true}, indentUnit: 4 }} /></App>, document.getElementById('app'));
    }
};



