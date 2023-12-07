/**
 * TODO 9:
 * - Import semua method FruitController
 * - Refactor variable ke ES6 Variable.
 * - Gunakan Destructing Object
 */

const { index, store, update, destroy } = require('./controllers/FruitController');

const main = () => {
  index();
  store("Pisang");
  update(0, "Kelapa");
  destroy(0);
};

main();