const assert = require('node:assert/strict');

const { formatInputUang, parseInputUang } = require('../public/js/kasir.js');

assert.equal(formatInputUang('1000000'), '1.000.000');
assert.equal(parseInputUang('1.000.000'), 1000000);

console.log('format uang OK');
