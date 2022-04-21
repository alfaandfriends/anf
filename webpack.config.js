const path = require('path');
const Dotenv = require('dotenv-webpack');

module.exports = {
    devtool: "source-map",
    resolve: {
        alias: {
            '@': path.resolve('resources/js'),
        },
    },
    plugins: [
        new Dotenv({
            ignoreStub: true
        })
    ],
};
