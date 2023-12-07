/**
 * TODO 3:
 * - Import fruits dari data/fruits.js
 * - Refactor variable ke ES6 Variable.
 */

const fruits = require('../models/Fruits');

// TODO 4: Buat method index
const index = () => {
  console.log("Method index - Menampilkan Buah");
  fruits.forEach(fruit => console.log(`- ${fruit}`));
};

// TODO 5: Buat method store
const store = newFruit => {
  console.log(`Method store - Menambahkan Buah ${newFruit}`);
  fruits.push(newFruit);
  fruits.forEach(fruit => console.log(`- ${fruit}`));
};

// TODO 6: Buat method update
const update = (position, name) => {
  console.log(`Method update - Update data ${position} menjadi ${name}`);
  fruits[position] = name;
  fruits.forEach(fruit => console.log(`- ${fruit}`));
};

// TODO 7: Buat method destroy
const destroy = position => {
  console.log(`Method destroy - Menghapus data ${position}`);
  fruits.splice(position, 1);
  fruits.forEach(fruit => console.log(`- ${fruit}`));
};

/**
 * TODO 8: Export semua method
 */
module.exports = { index, store, update, destroy };
