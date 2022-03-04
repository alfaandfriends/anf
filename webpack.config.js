const path = require('path');

module.exports = {
    devtool: "source-map",
    resolve: {
        alias: {
            '@': path.resolve('resources/js'),
        },
    },
};
