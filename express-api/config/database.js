require("dotenv/config");
const { DB_HOST, DB_PORT, DB_USERNAME, DB_PASSWORD, DB_DATABASE } = process.env;

const Sequelize = require("sequelize");
const sequelize = new Sequelize({
  dialect: "mysql",
  host: DB_HOST,
  port: DB_PORT,
  username: DB_USERNAME,
  password: DB_PASSWORD,
  database: DB_DATABASE,
});

try {
  sequelize.authenticate().then(() => {
    console.log("Database connected");
  });
} catch (error) {
  console.log("Cannot connect database: ", error);
}

module.exports = sequelize;
